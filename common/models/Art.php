<?php

namespace common\models;
use common\models\Category;
use Yii;
use common\models\ArtSearch;
use yii\helpers\StringHelper;
use common\models\BlockChain;
use yii\helpers\Html;
use yii\helpers\Markdown;

/**
 * This is the model class for table "art".
 *
 * @property integer $id
 * @property string $id_bl
 * @property string $created_at
 * @property string $country
 * @property string $city
 * @property string $category
 * @property string $sub_category
 * @property integer $votes
 * @property string $author
 * @property string $title
 * @property integer $total_pending_payout_value
 * @property integer $replies
 * @property string $body
 * @property string $meta
 * @property string $lang

 */
class Art extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    
    
    public static function tableName()
    {
        return 'art';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['votes', 'total_pending_payout_value', 'replies'], 'integer'],
            [['body', 'meta'], 'string'],
            [['id_bl'], 'string', 'max' => 11],
            [['country', 'city', 'category', 'sub_category', 'author', 'title'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_bl' => 'Id Bl',
            'created_at' => 'Created at',
            'country' => 'Country',
            'city' => 'City',
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'votes' => 'Votes',
            'author' => 'Author',
            'title' => 'Title',
            'total_pending_payout_value' => 'Total Payot Value',
            'replies' => 'Replies',
            'body' => 'Body',
            'meta' => 'Meta',
            'lang' => 'Lang',
          
        ];
    }
    
    
       
    
    static function create_array_categories($raw = null)
    {
        $data_full = null;
        $query = new Category();
         $blockchain =  BlockChain::get_blockchain_from_locale();    
            
            $array_categories = $query->find()->where(['blockchain'=> $blockchain])->asArray()->select('country_json, city_json, category_json, sub_category_json')->all();
            foreach ($array_categories as $line){
                $country_json = json_decode($line['country_json'], true);
                if ($country_json['text']!='null'){
                    $data_full[]= $country_json;
                }
                $city_json = json_decode($line['city_json'], true);
                foreach ($city_json as $city_js){
                    if ($city_js['text']!='null'){
                        $data_full[]= $city_js;
                    }
                }
                $category_json = json_decode($line['category_json'], true);
                foreach ($category_json as $cat_js){
                    if ($cat_js['text']!='null'){
                        $data_full[]= $cat_js;
                    }
                }
                $sub_category_json = json_decode($line['sub_category_json'], true);
                foreach ($sub_category_json as $sub_cat_js){
                    if ($sub_cat_js['text']!='null'){
                        $data_full[]= $sub_cat_js;
                    }
                }
                    
                
                
            }
         
        
        
        return $data_full;
   
        
        }
        
        
   
   
   
        static function clean_data($category){
            
        $category = str_replace("\"", "", $category);
        $category = str_replace("[", "", $category);
        $category = str_replace("]", "", $category);
         
        if (strpos($category, "+") > 0) {
            $category = explode('+', $category);
        }
        
        return $category;
        }
        
        
        
        //This function for get first image to preview from Thumbs folder
         static function get_images($model){
           $meta = $model->meta;
           $meta = json_decode(stripslashes($meta), true);
           $image = $model->validate_json($meta, 'image');
           $author = $model->author;
           $permlink = $model-> permlink;
           
            if ($image[0]){
             
                    $filename = basename($image[0]);
                    $re = '/^(.+?)(\?.*?)?(#.*)?$/m';
                    preg_match_all($re, $filename, $matches);
                    $filename = $matches[1][0];
                    $full_filename = 'https://' . Yii::$app->getRequest()->serverName . '/storage/web/thumbs/' . BlockChain::get_blockchain_from_locale() . '-' . $author . '-' . $permlink . '-' . $filename;
                
                
                return $full_filename;
                
            } else {
                return false;
            }
          
        }
        
        
        //This function use for clean and replace images links in preview
        static function get_images_links_for_clean_preview($model){
           $meta = $model->meta;
           $meta = json_decode(stripslashes($meta), true);
           $image = $model->validate_json($meta, 'image');
            if ($image[0]){
                return $image;
                
            } else {
                return false;
            }
          
        }
        
        static function get_links($model){
            $meta = $model->meta;
            $meta = json_decode(stripslashes($meta), true);
            $links = $model->validate_json($meta, 'links');
            if ($links){
                return $links;
                
            } else {
                return false;
            }
            
        }
        
        static function validate_json($meta, $arg){
            
            if (is_array($meta)&&(isset($meta[$arg][0]))){ //проверяем на существование и на массив/строку
                if (is_array($meta[$arg]))
                    return $meta[$arg];

                elseif (is_string($meta[$arg]))
                    $array_meta[$arg][] = $meta[$arg];
                    return $array_meta;                  
                
            } else {
                return false;
            }
            
            
        }
        
        /*
         * This function clean text for first line each item
         */
        static function get_first_line($model){
//                $links = $model::get_links($model);
          //      $body = \kartik\markdown\Markdown::convert($model->body);
            $body = $model->body; 
                $first_line = StringHelper::truncate($body, 500, '...', null, true);
                $matches = Art::parse_links_and_urls($first_line);
               
                foreach($matches[0] AS $m){
                    $first_line = str_replace($m,'',$first_line);
                
               }
                $first_line = str_replace("\\n\\n", ". ", $first_line);
                $first_line = strip_tags($first_line);
            //    $first_line= preg_replace('/[^a-zа-яё\s.,]+/iu', '', $first_line);
        
              return $first_line;
        }
        
        
        
        static function get_body($model){
          //  $body = \kartik\markdown\Markdown::convert($model->body);
             
         //   $format_img = ['jpg','png','gif','jpeg','swf','bmp','tiff','tipp'];
            $body = $model->body;
         //   $matches = Art::parse_links_and_urls($body);
         //   foreach($matches[0] as $id => $m){
         //       if (in_array($matches[5][$id], $format_img)){
         //           $body = str_replace($m,'<img src=' . $m . '>', $body);
         //       }// else {
                 //   $body = str_replace($m,'[' . $m . ']('. $m . ')', $body);
                 // }
                
        //   }
           return $body;
        }
        
        
        
        /*
         * This function parse all links and images and return in array for cleaning or change
         */
        static function parse_links_and_urls($text){
           $re = '/((https?:\/\/)?([A-Za-z:1-9\]+)\.][\/A-Za-zаА-Яа-я0-9-_#=&;%+?]{1,})([\/.-_A-Za-zаА-Яа-я0-9-_#=&;%+?]{2,})\.([A-Za-zА-Яа-я0-9-_#=;%+]{2,})([@\/A-Za-zА-Яа-я0-9-_#?=;%+]{0,}))/mu';
         
           preg_match_all($re, $text, $matches);
            return $matches;
           
        }
        
        static function get_array_links_and_images($body){
           $matches = Art::parse_links_and_urls($body);
           $arr = array();
            $format_img = ['jpg','png','gif','jpeg','swf','bmp','tiff','tipp'];
            $matches = Art::parse_links_and_urls($body);
            foreach($matches[0] as $id => $m){
                if (in_array($matches[5][$id], $format_img)){
                    $arr['image'][] = $m; 
                } else {
                    $arr['links'][] = $m; 
               
                }
                
           }
           return $arr;
            
            
        }
        
       
        
        /*
         * Функция делает выборку статей из базы по ключевым тегам категорий. Категории передаются в формате
         * cat1+cat2+cat3 (string).
         */
        
        static function get_data_by_categories($categories = null, $state = 'new'){
             $searchModel = new ArtSearch();
             $blockchain =  BlockChain::get_blockchain_from_locale();    
             
             if ($categories == null){
                $dataProvider = $searchModel->search([$searchModel->formName() => ['blockchain'=> $blockchain]]);
             }
             else {
                 $categories = Art::clean_data($categories);
                 $count = count($categories);
                 if ($count == 1) {
                     
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories, 'blockchain'=> $blockchain]]);
                     $count1 = $dataProvider->getTotalCount(); 
                     /* Этот код написан для того, чтобы использовать адресную строку для задания критериев поиска по категории
                     * В адресной строке можно передавать страны, города, или одни лишь категории, а нижеследующий код побирает им свои места (работает для 1 категории) 
                     */ 
                     if ($dataProvider->getTotalCount() === 0) {
                            $searchModel = new ArtSearch();
                           $dataProvider = $searchModel->search([$searchModel->formName() => ['city' => $categories,'blockchain'=> $blockchain]]);
                             if ($dataProvider->getTotalCount() === 0) {
                                  $searchModel = new ArtSearch();
                                 $dataProvider = $searchModel->search([$searchModel->formName() => ['category' => $categories, 'blockchain'=> $blockchain]]);
                             }
                     }

            } else if ($count == 2) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1], 'blockchain'=> $blockchain]]);
                 } else if ($count == 3) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1], 'category' => $categories[2],'blockchain'=> $blockchain]]);
                 } else if ($count == 4) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1], 'category' => $categories[2], 'sub_category' => $categories[3],'blockchain'=> $blockchain]]);
                 }
                 
             }
             
             //Change order for different views
             //TODO REPAIR order list and modificate it for correct list by days
             if ($state =='new'){
                 $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                 ];
             }
             if ($state == 'trending'){
                 $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC, 'total_pending_payout_value' => SORT_DESC]
             ];
             }
             if ($state == 'discuss'){
                 $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC, 'replies' => SORT_DESC]
             ];
             }

             $dataProvider->pagination = ['pageSize' => 50];
             
                    
            return $dataProvider;
            
        }
        
        
        static function get_author_categories($author){
            $blockchain =  BlockChain::get_blockchain_from_locale();    
            
            if ($author == null) {
                 $author = Yii::$app->user->identity->username;
            }
            return $raw = (new \yii\db\Query())
                ->select('country,city,category,sub_category')
                ->from(['Art'])
                ->where('author=' . "'" .  $author . "'")
                ->andwhere('blockchain=' . "'" .  $blockchain . "'")
                ->all();
            
        }
        
        
        static function get_single_blog($author = null){
            $searchModel = new ArtSearch();
            $blockchain =  BlockChain::get_blockchain_from_locale();    
            
            $dataProvider = $searchModel->search([$searchModel->formName() => ['author' => $author, 'blockchain' => $blockchain]]);
            $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ];
            return $dataProvider;


        }
            
        static function get_single_art($author, $permlink){
        $blockchain =  BlockChain::get_blockchain_from_locale();
        $model = Art::find()->where(['author' => $author])->andWhere(['permlink' => $permlink])->andWhere(['blockchain' => $blockchain])->one();
        return $model;

        }
            
        
        public function convert_currency($price){
          $price_old =  floatval($price);
          $blockchain =  BlockChain::get_blockchain_from_locale();
          $GRAMM_IN_OZ = 31.1034768;
          
          switch ($blockchain){
              case "golos":
                $XAUOZ = (new \yii\db\Query())
                ->select('price')
                ->from(['pricefeed'])
                ->where('blockchain=' . "'" .  $blockchain . "'")
                ->one();
                $price = round($price_old * $XAUOZ['price'] / $GRAMM_IN_OZ / 1000, 2);
                $price = $price . ' RUB';
              break;
          
          case "steem":
                
                $price = $price_old . ' USD';
              break;
        
          
          }
            return $price;
            
        }
        
        
        static function get_voters($voters){
            $voters = json_decode($voters);
            $content = '';
            foreach ($voters as $v){
               $link = Html::a($v,['/site/index/','author'=>$v]);
               $content .= 
                $link . 
                ', ';
            }
            return $content;
            
        }
        
      static function explode_meta($art){
          $meta = $art->meta;
          $metadata = json_decode($meta, true);
      
      return $metadata; 
     }
     
     static function get_article_for_edit($author, $permlink){
            $blockchain =  BlockChain::get_blockchain_from_locale();    
            $query = new Art();
            $art = $query
                ->find()
                ->where('author=' . "'" .  $author . "'")
                ->andwhere('permlink=' . "'" .  $permlink . "'")
                ->andwhere('blockchain=' . "'" .  $blockchain . "'")
            
                ->one();
        
         return $art;
     }

     static function fill_immapala($model, $meta){
       /*public $title; //title
        public $contacts; //tag
        public $country;  //tag
        public $city;     //tag
        public $languages; //json
        public $body;     //body
        public $not_traveler = 1;    //json
        public $date_until_leave; //json
        public $coordinates; //json
           * 
          */
       
        $model->date_until_leave = (array_key_exists('date_until_leave', $meta)? $meta['date_until_leave'] :  "");
        $model->languages = (array_key_exists('languages', $meta)? implode(", ", $meta['languages']) :  "");
        $model->contacts =  (array_key_exists('contacts', $meta)? $meta['contacts'] :  "");
        $model->not_traveler = (array_key_exists('not_traveler', $meta)? $meta['not_traveler'] :  "");
        $model->coordinates = (array_key_exists('coordinates', $meta)? $meta['coordinates'] :  "");
    return $model;
         
         
     }
     
     static function fill_homestay($model, $meta){
              /*
         @public $title;  
         @public $contacts;
         @public $country;
         @public $city;
         @public $cost=0 ;
         @public $free = 1;
         @public $body;
         @public $parentPermlink = '';
         @public $parentAuthor = '';
         @public $blockchain
         @public $coordinates;
        */
        
        $model->contacts =  (array_key_exists('contacts', $meta)? $meta['contacts'] :  "");
        $model->not_traveler = (array_key_exists('not_traveler', $meta)? $meta['not_traveler'] :  1);
        $model->coordinates = (array_key_exists('coordinates', $meta)? $meta['coordinates'] :  "");
        $model->free = (array_key_exists('free', $meta)? $meta['free'] :  "");
        $model->cost = (array_key_exists('cost', $meta)? $meta['cost'] :  "");
        
    return $model;
         
         
     }
     
     

          
     static function fill_places_or_blogs($model, $meta, $current_art){
         /*
         public $title;
         public $country;
         public $body;
         public $tags;
         public $coordinates;        
         */
        $model->location =  (array_key_exists('location', $meta)? $meta['location'] :  "");
        $model->tags = $current_art->category;
        $model->coordinates = (array_key_exists('coordinates', $meta)? $meta['coordinates'] :  "");
    return $model;
         
         
     }
     
     
     static function fill_news($model, $meta, $current_art){
         /*
         public $title;
         public $body;
         public $tags;
         */
        
        $model->tags = $current_art->category;
    return $model;
         
         
     }
     
      
     static function fill_knowledge($model, $meta, $current_art){
         /*
         public $title;
         public $country;
         public $city;
         public $body;
         public $tags;
         public $coordinates;        
         */
        $model->location =  (array_key_exists('location', $meta)? $meta['location'] :  "");
        $model->tags = $current_art->sub_category;
        $model->coordinates = (array_key_exists('coordinates', $meta)? $meta['coordinates'] :  "");
    return $model;
         
         
     }
     
     
     
        
     static function get_current_model($model){
        $meta = json_decode($model['meta'], true);
        $model =  (array_key_exists('model', $meta)? $meta['model'] :  "blogs");
         return $model;
     }
     
     
     static function get_article_amount(){
         $query = new Art();
         $blockchain = BlockChain::get_blockchain_from_locale();
            $art = $query
                ->find()
                ->where('blockchain=' . "'" .  $blockchain . "'")
                ->andwhere(['<>','author', 'mapala'])
                ->count();
        
         return $art;
         
     }
        
        
}
