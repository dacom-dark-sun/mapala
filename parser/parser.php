<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set ("UTC");
define ("MAIN_DIR", dirname(__FILE__));
include ( MAIN_DIR . '/mysql.php');
include (MAIN_DIR . "/config.php");
include (MAIN_DIR . "/classSimpleImage.php");

$parser = new Parser();

do{
    $parser->init();
}while(1);

class Parser{
    
public function init(){
    global $config;
    global $looking_for_tag;
    global $db;    

    $looking_for_tag= "ru--golos";    

    $db = new SafeMysql(array('user' => $config['dbuser'], 'pass' => $config['dbpassword'],'db' => $config['dbname'], 'charset' => 'utf8mb4'));


    $num_in_sql = $this->get_num_current_block_from_sql();
    $num_in_blockchain = $this -> get_num_current_block();

    echo ("START from block # " . $num_in_sql .", " .  $config['blockchain']['name'] . "blockchain");    
    

               for ($num_in_sql; $num_in_sql<$num_in_blockchain; $num_in_sql++){
                    $transactions = $this->get_content_from_block($num_in_sql);
                    if (empty($transactions)){
                        $db->query("UPDATE current_blocks SET id= " . $num_in_sql . " WHERE blockchain = '" . $config['blockchain']['name'] . "'");
                        continue;
                  }
              foreach ($transactions as $tr){
                 foreach ($tr['operations'] as $action){

                    if ($action[0] == "vote") { 
                        $answer_upvote = $this->add_vote_to_sql($action[1]['permlink'], $action[1]['author']);
                        $answer_voters = $this->update_voters_in_sql($action[1]['permlink'], $action[1]['voter']);
                        echo ("block #" . $num_in_sql . ", action: VOTE" .  $answer_upvote ." \n"); 
                    }


                    else if ($action[0]== "account_create"){

                       $answer = $this->add_account_to_sql($action[1]);
                       echo ("block #" . $num_in_sql . ", action: NEW ACCOUNT, username= " .  $answer ." \n"); 

                   }

                     else if ($action[0]== "comment"){
                        $json = $this->convert_json($action[1]['json_metadata']);
                        $answer = $this->validate_tags($json);

                        if ($answer === true) {

                                if ($action[1]['parent_author'] == '') {   //check parent author - '', that mean it is article

                                    $answer = $this->add_article_to_sql($action[1], $json);
                                    $this->download_images($action[1]['permlink'], $json['image'][0]);  //загружаем только первую картинку
                                    echo ("block #" . $num_in_sql . ", action: ART, " . $answer . " \n");

                                    } else { //if not '' - that mean it is reply
                                    $answer = $this->add_replie_to_sql($action[1], $json);
                                    echo ("block #" . $num_in_sql . ', action: REPLY, ' . $answer . " \n");

                                }
                            } else {
                                echo ("block #" . $num_in_sql . ", action: Art or Reply, permlink =" . $action[1]['permlink'] . ", " . $answer . " \n");
                            }
                        }


                 }

              }
            $db->query("UPDATE current_blocks SET id= " . $num_in_sql . " WHERE blockchain= '" . $config['blockchain']['name'] . "'");
            echo 'block #' . $num_in_sql . " \n";
            }   
}     
 



     private function get_num_current_block() {
        global $config; 
         
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_state",[""]], "id": 2}';
        $cmd = "curl -s --data" . " " . "'" . $param . "'" . " " . $config['blockchain']['node'];
        
        $out = shell_exec($cmd);  
         
        
        $out = json_decode($out, true);
        $result= $out['result']['props']['head_block_number'];
        
        return $result;
        
    }
    
    
    
    private function get_num_current_block_from_sql(){
         global $db;
         global $config;
         
         if ($config['blockchain']['start_block'] == 'current') {
            return $max_id = $db->getOne("SELECT MAX(id) FROM current_blocks WHERE blockchain = ?s", $config['blockchain']['name']);
        } else {
            return $config['blockchain']['start_block'];
        }
    }
    
    
    private function get_content_from_block($block = null){
        global $config;
        
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_block",[' . $block . ']], "id": 4}';
        $cmd = "curl -s --data" . " " . "'" . $param . "'" . " " . $config['blockchain']['node'];
        $out = shell_exec($cmd);  
        $out = json_decode($out, true);
        if (isset($out['result']['transactions']))
            $result = $out['result']['transactions'];
        else $result = null;
        return $result;
        
    }
    
    
    
    private function get_full_content($author, $permlink){
        global $config;
        
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_content",["' . $author . '", "' . $permlink . '"]], "id": 4}';
        $cmd = "curl -s --data" . " " . "'" . $param . "'" . " " . $config['blockchain']['node'];
 
        $out = shell_exec($cmd);  
        
        $out = json_decode($out, true);
        $result = $out['result']; //Отливливать ошибки здесь
        return $result;
        
        
    }
    
    
    
    
   private function add_article_to_sql($data_part, $json){
        global $db;
        global $looking_for_tag;
        global $config;
        $blockchain = $config['blockchain'];
        
        $full_content = $this->get_full_content($data_part['author'], $data_part['permlink']);
        
        $data['author']=              $full_content['author'];
        $data['permlink']=            $full_content['permlink'];
        $data['title']=               mb_convert_encoding($full_content['title'], 'UTF-8');
        $data['body']=                mb_convert_encoding($full_content['body'], 'UTF-8');
        $data['meta']=                $full_content['json_metadata'];
        $data['created_at']=          $full_content['created'];
        $data['updated_at']=          $full_content['last_update'];
        $data['total_pending_payout_value']=  $full_content['total_pending_payout_value'];
        $data['meta']=                $full_content['json_metadata'];
        $data['parent_permlink'] =    $full_content['parent_permlink'];
        $data['blockchain']=          $blockchain['name'];
        $data['currency'] =           $blockchain['currency'];
        
        if (is_array($json['tags'])){ //soft-validate metadata and cleaning from empty elements
        $json['tags'] = $this->cleaning_tags($json['tags']);
        /*
         * Here we check tag for exist and replace them with language encoding
         */
        $data['country']=             (array_key_exists('1', $json['tags'])? self::convert_tag_before_save($json['tags'][1]) :  json_encode([]));
        $data['city']=                (array_key_exists('2', $json['tags'])? self::convert_tag_before_save($json['tags'][2]) :  json_encode([]));
        $data['category']=            (array_key_exists('3', $json['tags'])? self::convert_tag_before_save($json['tags'][3]) :  json_encode([]));      
        $data['sub_category']=        (array_key_exists('4', $json['tags'])? self::convert_tag_before_save($json['tags'][4]) :  json_encode([]));        
        }
        
        $data['votes']=               0;
        $data['replies']=             0;
        $data['voters'] =             json_encode([]);
     
        $exist_art = $db->getRow('SELECT * FROM art WHERE permlink=?s', $data['permlink']);
       
        if (is_null($exist_art)) {
            
          $db->query("INSERT INTO art SET ?u", $data);
          if(array_key_exists('0', $json['tags'])&&($json['tags'][0] != $looking_for_tag)){
              $this->update_category($data['country'], $data['city'], $data['category'], $data['sub_category']);
          }
              return ("article by " . $data['author'] . "category: " . $json['tags'][0] . ", permlink: " . $data['permlink'] . " ADDED");
                
            
        } else {
            
            $db->query("UPDATE art SET ?u WHERE permlink=?s", $data, $data['permlink']);
            return ("article by " . $data['author'] . "category: " . $json['tags'][0] . ", permlink: " . $data['permlink'] .  " UPDATED");
     
        }
     
    }
    
    
    
     private function add_replie_to_sql($data_part, $json){
         global $db;
         global $config;
         $blockchain = $config['blockchain'];
         
        $full_content = $this->get_full_content($data_part['author'], $data_part['permlink']);
        $data['author']=              $full_content['author'];
        $data['permlink']=            $full_content['permlink'];
        $data['title']=               mb_convert_encoding($full_content['title'], 'UTF-8');
        $data['body']=                mb_convert_encoding($full_content['body'], 'UTF-8');
        $data['meta']=                $full_content['json_metadata'];
        $data['created_at']=          $full_content['created'];
        $data['updated_at']=          $full_content['last_update'];
        $data['title']=               $full_content['title'];
        $data['total_pending_payout_value'] =  $full_content['total_pending_payout_value'];
        $data['meta']=                $full_content['json_metadata'];
        $data['parent_permlink'] =    $full_content['parent_permlink'];
        $data['blockchain']=          $blockchain['name'];
        $data['currency'] =           $blockchain['currency'];
        $data['votes']=               0;
        $data['replies']=             0;
        $data['level'] =              1;
        $data['status'] =             1;
        $data['voters'] =             json_encode([]);
        $data['entity'] =             $config['entity'];
        
        $root_article =               $this->get_root_article_from_permlink($data['permlink']);
        $data['relatedTo'] =          $config['relatedTo'] . $root_article;
        
        
        $exist_art = $db->getRow('SELECT * FROM comment WHERE permlink=?s', $data['permlink']);
        
        if (is_null($exist_art)) {
            
            $db->query("INSERT INTO comment SET ?u", $data);
            $answer_update = $this->update_replies_count($root_article);
           
            return ("article by: " . $data['author'] . " , category: " . $json['tags'][0] . ", permlink: " . $data['permlink'] . " ADDED");
 
        } else {
           
            $db->query("UPDATE comment SET ?u WHERE permlink=?s", $data, $data['permlink']);
            
            return ("article by: " . $data['author'] . " , category: " . $json['tags'][0] . ", permlink: " . $data['permlink'] . " UPDATED");
        }
        
        
        
    }
    
    
   private function add_account_to_sql($data){
        global $db;
        $data_part['username'] = $data['new_account_name'];
        $db->query("INSERT INTO users_raw SET ?u", $data_part);
        
        return ($data['new_account_name']);
    }
    
    
    
   private function convert_json($data){
         $json = json_decode($data,true);
        
         return $json;
        
    }
    
    public function cleaning_tags(&$tags){
        foreach ($tags as $id => $t){       //cleaning 
            if (($t=="")||(empty($t))){
                unset($tags[$id]);
            }
        }
        return $tags;
        
    }
    
    private function convert_tag_before_save($tag){
        global $config;
        $tag_old = $tag;
        if ($config['blockchain']['name'] == 'golos'){
           if (($tag == ' ')||($tag == '')) return 'null';
            sscanf($tag, "%4s%s", $tr_key, $tag);
            if ($tr_key == "ru--"){
        
            $tag = mb_strtolower($tag);
            $rus = array('щ',     'ш', 'ч',  'ц',  'й',  'ё',  'э',  'ю',  'я',  'х',  'ж',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ъ', 'ы', 'ь');
            $eng = array('shch', 'sh', 'ch', 'cz', 'ij', 'yo', 'ye', 'yu', 'ya', 'kh', 'zh', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'xx', 'y', 'x');
            $tag = str_replace($eng, $rus, $tag);
            return  $tag;
            
           } 
           
        }
           return mb_strtolower($tag_old);
           
    }
        
        
    
    
    public function get_root_article_from_permlink($permlink){
       $re = '/^.+-re-.+?-(.+)-\d+.+/m';
       preg_match_all($re, $permlink, $main_link);
       if (empty($main_link[1])){
           $re = '/re-.+?-(.+)-\d+.+/m';
           preg_match_all($re, $permlink, $main_link);
           
       }
       return $main_link[1][0];
        
    }
    
    
    
    
   private function update_replies_count($root_link){
        global $db;
        global $config;
      
        $db->query("UPDATE art SET replies=replies + 1 WHERE permlink=?s AND blockchain=?s", $root_link, $config['blockchain']['node']);
        
        return "Comment count for article success updated";
                       
            
    }    
    
    
   
    
    
   private function add_vote_to_sql($permlink, $author){
        global $db;
        global $config;
        $table = $this->art_or_comment($permlink);

            if ($table != 'NULL'){
                $full_content = $this->get_full_content($author, $permlink, $config['blockchain']['node']);
                $db->query("UPDATE ?n SET votes=votes+1, total_pending_payout_value=?s  WHERE permlink=?s", $table, $full_content['total_pending_payout_value'],$permlink);
           
                return ", permlink = " . $permlink . ", author = " . $author;
            }
            else {
                return (", WARNING! VOTE parsed, but parent article not exist. Requere full re-parse blockchain. ");
            }
                       
            
        }
        
        
    
         
         
   private function validate_tags($json){
       global $looking_for_tag;
       
        if (is_array($json)&&(isset($json['tags'][0]))){
            if (is_array($json['tags'])) {
                if (array_key_exists('0', $json['tags'])){
                    if ($json['tags'][0] != $looking_for_tag) { //CHANGE TO == !!!! THAT MEAN WE LOOKING FOR ONE TAG. For test mode it is !=
                
                        return true; 
                
                    } else {
                    
                        return "tags not contains keyword";
                    
                    }
                
                }else{
                    return "wrong key in tag array";
                
                }
        
            }else {
                return "tags is not array";
            
            }
        }else{
           return "tags not setted";
        }
  }
         
    
    
  
  //Функция обновления голосующих людей в за комментарии и посты
  
   private function update_voters_in_sql($permlink, $author){
        global $db;
        $table = $this->art_or_comment($permlink);
            
        if ($table !== 'NULL'){
        
            $subject = $db->getRow('SELECT * FROM ?n WHERE permlink=?s', $table, $permlink);
            $subject_voters = $this->convert_json($subject['voters']);
            $subject_voters[] = $author;
            $subject_voters = json_encode($subject_voters);
                
            $db->query("UPDATE ?n SET voters=?s WHERE permlink=?s", $table, $subject_voters, $permlink);
            return "VOTERS has been changed successfull";
        
            
        }else {
                return ("VOTERS parsed, but parent article for add VOTE not exist. Requere full re-parse blockchain. \n");
              }
            
    }
        
    //Функция проверки принадлежности материала к категории или статье
   
   private function art_or_comment($permlink){
        global $db;
        
        $exist_art = $db->getRow('SELECT * FROM art WHERE permlink=?s', $permlink);
        
        if (is_null($exist_art)) {
            $exist_comment = $db->getRow('SELECT * FROM comment WHERE permlink=?s', $permlink);
            if (!is_null($exist_art)) {
                return 'comment';
            } else {
                return 'NULL';
            }
        } else {
                    return 'art';
            }
    }
    
    /*
     * Функия update_category добавляет в базу данных структурированный json, который используется для построения дерева тегов
     */
    
    public function update_category($country, $city, $category, $sub_category){
        
        global $db;
        global $config;
        $blockchain = $config['blockchain']['name'];    
        if ($country == '[]'){
            $country = 'null';
        }
        if ($city == '[]'){
            $city = 'null';
        }
        if ($category == '[]'){
            $category = 'null';
        }
        if ($sub_category == '[]'){
            $sub_category = 'null';
        }
        
        
           $exist_category = $db->getRow('SELECT * FROM category WHERE country=?s AND blockchain=?s', $country, $blockchain);
           //Проверяем на существование рут-категории (страны)
            if ($exist_category == NULL){
                 
               $data['country'] = $country;
               $data['country_json'] = json_encode(['id' => $country, 'parent' => '#', 'text'=> $country], JSON_UNESCAPED_UNICODE);    
               $data['city_json'] = json_encode(['0' => ['id' => $country . '+' . $city, 'parent' => $country, 'text' => $city]], JSON_UNESCAPED_UNICODE);
               $data['category_json'] = json_encode(['0'=>['id' => $country . '+' . $city . "+" . $category, 'parent' => $country . "+" . $city, 'text' => $category]], JSON_UNESCAPED_UNICODE);
               $data['sub_category_json'] = json_encode(['0'=>['id' => $country . '+' . $city . "+" . $category . "+" . $sub_category, 'parent' => $country . "+" . $city . "+" . $category, 'text' => $sub_category]], JSON_UNESCAPED_UNICODE);
               $data['blockchain'] = $blockchain;
                $db->query("INSERT INTO category SET ?u", $data);
           
            } else {
                $data['city_json'] = json_decode($exist_category['city_json'], true); //декодируем существующую запись
                $data['category_json'] = json_decode($exist_category['category_json'], true); //декодируем существующую запись
                $data['sub_category_json'] = json_decode($exist_category['sub_category_json'], true); 
                
                
                
                $need_update = $this->need_update($data['city_json'], $city); 
                //проверяем старые элементы  в базе на наличие нового элемента
                
                if ($need_update == true){
                    //если надо обновляться - добавляем один элемент со связями, конвертируем его в json и записываем     
                         $data['city_json'][] = ['id' => $country . '+' . $city, 'parent' => $country, 'text' => $city];
                         $data['city_json'] = json_encode($data['city_json'], JSON_UNESCAPED_UNICODE);
                         $db->query("UPDATE category SET city_json=?s WHERE country=?s AND blockchain=?s", $data['city_json'], $country, $blockchain);
                }
                
                
                
                
                 
                $need_update = $this->need_update($data['category_json'], $category); 
                //проверяем старые элементы  в базе на наличие нового элемента
                
                if ($need_update == true){
                    //если надо обновляться - добавляем один элемент со связями, конвертируем его в json и записываем     
                         $data['category_json'][] = ['id' => $country . '+' . $city . "+" . $category, 'parent' => $country . "+" . $city, 'text' => $category];
                         $data['category_json'] = json_encode($data['category_json'], JSON_UNESCAPED_UNICODE);
                         $db->query("UPDATE category SET category_json=?s WHERE country=?s AND city=?s AND blockchain=?s", $data['category_json'], $country, $city, $blockchain);
                }
                
                
                $need_update = $this->need_update($data['sub_category_json'], $sub_category);
                
                
                if ($need_update == true){
                                     
                        $data['sub_category_json'][] = ['id' => $country . '+' . $city . "+" . $category . "+" . $sub_category, 'parent' => $country . "+" . $city . "+" . $category, 'text' => $sub_category];
                        $data['sub_category_json'] = json_encode($data['sub_category_json'], JSON_UNESCAPED_UNICODE);
                        $db->query("UPDATE category SET sub_category_json=?s WHERE country=?s AND city=?s AND blockchain=?s", $data['sub_category_json'], $country, $city, $blockchain);
                          
                }
            }

    }
        
    


private function need_update($data, $category){
    
    $need_update = true;
        foreach ($data as $d){ 
            if ($d['text'] == $category){
                 $need_update = false;
                 break;
            }   
        }
    return $need_update;
    
}



public function download_images($permlink, $image_link){
   try{

            $image = new SimpleImage();
            $filename = basename($image_link); 
            $path = '../storage/web/thumbs/' . $permlink . '-' . $filename;

            file_put_contents($path, file_get_contents($image_link));

            $image->load('../storage/web/thumbs/' . $permlink . '-' . $filename);
            $image->resizeToWidth(120);
            $image->save('../storage/web/thumbs/' . $permlink . '-' . $filename);

        } catch (Exception $e) {
          
        }
    }




}