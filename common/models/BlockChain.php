<?php

namespace common\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\StringHelper;
use Yii;
use yii\base\Model;
use common\models\Countries;
use common\models\Cities;
use common\models\CryptoGraphy;
use DateTime;

define('ENCRYPTION_KEY', env('ENCRYPTION_KEY'));

/**
 * ContactForm is the model behind the contact form.
 */
class BlockChain extends Model
{
   public $parentAuthor;
   public $parentPermlink;
   public $broadcast = true;
   public $permlink;
   public $title;
   public $body;
   public $metadata;
   public $blockchain;
      
   
   
   
   static function tag_to_eng($str, $without_ru = null){
       
    $str = mb_strtolower($str);
    $rus = array('щ','ш','ч','ц','й','ё','э','ю','я','х','ж','а','б','в','г','д','е','з','и','к','л','м','н','о','п','р','с','т','у','ф','ъ','ы','ь');
    $eng = array('shch','sh','ch','cz','ij','yo','ye','yu','ya','kh','zh','a','b','v','g','d','e','z','i','k','l','m','n','o','p','r','s','t','u','f','xx','y','x');
    $translated = str_replace($rus, $eng, $str);
    
    if (BlockChain::get_blockchain_from_locale() == 'golos'){
        if ($without_ru){
            
            $return = $translated;
        
            
        } else {
            $return = 'ru--' . $translated;
        }
    } else {
        $return = $translated;
    }
    
    return $return;
      
   }
   
    
    
    
   static function construct_im_mapala($model){
             /*public $title; //title
            public $contacts; //tag
            public $country;  //tag
            public $city;     //tag
            public $languages; //json
            public $body;     //body
            public $not_traveler = 1;    //living in this place
            public $date_until_leave;
            public $coordinates;
               * 
              */
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //im-mapala
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
            
             $json['contacts'] = strtolower($model->contacts);
             $json['languages'] =  explode(", ", $model->languages);
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::convert_city_to_lang($model->city);
             $json['tags'][3] = Blockchain::tag_to_eng(\Yii::t('frontend', 'People'));
             $json['not_traveler'] = $model->not_traveler;
             $json['date_until_leave'] = $model ->date_until_leave;
             $json['coordinates'] = ($model->coordinates == "40.7324319,-73.82480777777776" ? "" : $model->coordinates);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $json['app'] = 'mapala';
             $arr = Art::get_array_links_and_images($model->body);
           
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             
             $bl_model['metadata'] = $json;
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
      
    }
    
    
   static function construct_homestay($model){
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
             
             $json['contacts'] = mb_strtolower($model->contacts);
             $json['cost'] = $model->cost;
            
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::convert_city_to_lang($model->city);
             $json['tags'][3] = Blockchain::tag_to_eng(\Yii::t('frontend', 'Homestay'));
             $json['tags'][4] = BlockChain::free_on_different_lang($model->free);
             $json['coordinates'] = ($model->coordinates == "40.7324319,-73.82480777777776" ? "" : $model->coordinates);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $arr = Art::get_array_links_and_images($model->body);
             $json['app'] = 'mapala';
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
    }
    
    
    
    
   static function construct_knowledge($model){
/*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::convert_city_to_lang($model->city);
             $json['tags'][3] = Blockchain::tag_to_eng(\Yii::t('frontend', 'Knowledge'));
             $json['tags'][4] = BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = ($model->coordinates == "40.7324319,-73.82480777777776" ? "" : $model->coordinates);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $arr = Art::get_array_links_and_images($model->body);
             $json['app'] = 'mapala';
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             
             
             $json['sign'] = BlockChain::mc_encrypt($json, ENCRYPTION_KEY);
             
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
    }
    
    
    
   static function construct_places($model){
           /*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
            
             $json['tags'][2] = Blockchain::tag_to_eng(\Yii::t('frontend', 'Places'));
             $json['tags'][3] = BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = ($model->coordinates == "40.7324319,-73.82480777777776" ? "" : $model->coordinates);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $arr = Art::get_array_links_and_images($model->body);
             $json['app'] = 'mapala';
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             
             $json['sign'] = BlockChain::mc_encrypt($json, ENCRYPTION_KEY);
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    
    
   static function construct_blogs($model){
/*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::tag_to_eng(Yii::t('frontend','Blogs'));
             $json['tags'][3] =  BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = ($model->coordinates == "40.7324319,-73.82480777777776" ? "" : $model->coordinates);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $arr = Art::get_array_links_and_images($model->body);
             $json['app'] = 'mapala';
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             
             $json['sign'] = BlockChain::mc_encrypt($json, ENCRYPTION_KEY);
             
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    
    
   static function construct_news($model){
           /*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'mapala'; //
             if ($model->permlink == null){
                $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             } else {
                $bl_model['permlink'] = $model->permlink;
            
             }
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'mapala';
             $json['tags'][1] = Blockchain::tag_to_eng(\Yii::t('frontend', 'News'));
             
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $arr = Art::get_array_links_and_images($model->body);
             $json['app'] = 'mapala';
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    
    
    
   static function construct_reply($data){
            /* data (json_array) 
             * data['parentAuthor'];
             * data['parentPermlink'];
             * data['body'];
             * data['category'];
             * 
            */   
       
             $data = json_decode($data,true);
      
             $bl_model['parentAuthor'] = $data['parentAuthor'];
             $bl_model['parentPermlink'] = $data['parentPermlink']; //
             $bl_model['permlink'] = BlockChain::create_permlink_for_reply($data['parentPermlink'],$data['parentAuthor']); 
             $bl_model['body'] = $data['body'];
             $bl_model['title'] = '';
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = $data['category'];
             $arr = Art::get_array_links_and_images($model->body);
                 
             if (array_key_exists('links', $arr))
                $json['links'] = $arr['links'];
             
             if (array_key_exists('image', $arr))
                $json['image'] = $arr['image'];
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    static function convert_country_to_lang($id){
        $country = Countries::find()->select('name')->where('id=' . $id )->asArray()->one();
        return $country['name'];
      
    }
    
    static function convert_country_to_id($name){
        $id = Countries::find()->where('name=' . "'" .  $name . "'")->asArray()->one();
        
        return $id['id'];
        
        
    }
    
    

    
    
    static function convert_city_to_lang($id){
      $id_old = intval($id);
        if ($id_old != 0){
        $city = Cities::find()->select('name')->where('id=' . $id)->asArray()->one();
        return $city['name'];
       } else {
          return $id;
      } 
        
    }

    
    static function convert_tags_to_lang($name){
        $blockchain = BlockChain::get_blockchain_from_locale();
        $id = OurCategory::find()->where('name=' . "'" .  $name . "'")->asArray()->one();
        
        return $id['id'];
        
    }

    

    static function free_on_different_lang($free){
        $current_lang = Yii::$app->language;
             switch ($current_lang){
                 case 'ru-RU':
                    if ($free == 0){
                        $sub_category = BlockChain::tag_to_eng(Yii::t('frontend','Free'));
                    } else {
                        $sub_category = BlockChain::tag_to_eng(Yii::t('frontend','Must pay'));
                    }
                 break;
             
                 case 'en-US':
                     if ($free == 0){
                        $sub_category = strtolower(Yii::t('frontend','Free'));
                       
                     } else {
                        $sub_category = strtolower(Yii::t('frontend','Must pay'));
                     }
                break;
            }
    return $sub_category;        
        
        
    }
    
    
    
    
    
    
    static function get_blockchain_from_locale(){
      
        return (Yii::$app->language == "ru-RU") ? 'golos' : 'steem';
        
    }
    
    
       
   static function create_permlink($title){
       $title = mb_strtolower(str_replace(" ", "-", $title));
       $title = BlockChain::tag_to_eng($title, 1);
       $title= preg_replace('/[^a-z-а-яё0-9\s.,]+/iu', '', $title);
       
    return $title;
   }
   
      
   static function create_permlink_for_reply($parent_permlink, $parent_author){
       list($sec, $usec) = explode('.', microtime(true));
       $usec = str_replace("0.", ".", $usec);     //remove the leading '0.' from usec
       $usec = substr($usec, 0, -1);
       $now = date('Ymd\tHis', $sec) . $usec . 'z';       //appends the decimal portion of seconds
       $re = '/([0-9]+.+)/m';                           //looking for old date
       preg_match_all($re, $parent_permlink, $matches);
       if (array_key_exists(0, $matches[1])){
           $permlink = str_replace($matches[1], $now, $parent_permlink); //replace old date if exist
       }
       else {
           $permlink = $parent_permlink . '-' . $now; //add new date, if not exist
           
       }
        
       return $permlink;
   }
    
   
   // Encrypt Function
       static function mc_encrypt($encrypt, $key){
        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
        return $encoded;
    }
    // Decrypt Function
    static function mc_decrypt($decrypt, $key){
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }
   
    
    
    
}
    