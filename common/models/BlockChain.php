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
         
   static function create_permlink($title){
       $title = str_replace(" ", "-", $title);
       $title = strtolower($title);
       
       return $title;
   }
   
   
   
   static function tag_to_eng($str){
    $str = mb_strtolower($str);
    $rus = array('щ','ш','ч','ц','й','ё','э','ю','я','х','ж','а','б','в','г','д','е','з','и','к','л','м','н','о','п','р','с','т','у','ф','ъ','ы','ь');
    $eng = array('shch','sh','ch','cz','ij','yo','ye','yu','ya','kh','zh','a','b','v','g','d','e','z','i','k','l','m','n','o','p','r','s','t','u','f','xx','y','x');
    
    return str_replace($rus, $eng, $str);
      
   }
    
    
   static function construct_im_mapala($model){
             
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'test'; //im-mapala
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
            
             $languages = BlockChain::tag_to_eng(strtolower($model->languages));
             $json['contacts'] = strtolower($model->contacts);
             $json['languages'] = explode(", ", $languages);
             $json['tags'][0] = 'test';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::convert_city_to_lang($model->city);
             $json['tags'][3] = 'im-mapala';
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             
             $bl_model['metadata'] = $json;
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
      
    }
    
    
   static function construct_homestay($model){
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'test'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
             
             $json['contacts'] = mb_strtolower($model->contacts);
             $json['capacity'] = $model->capacity;
             $json['cost'] = $model->cost;
            
             $json['tags'][0] = 'test';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][2] =  BlockChain::convert_city_to_lang($model->city);
             $json['tags'][3] = 'homestay';
             $json['tags'][4] = BlockChain::free_on_different_lang($model->free);
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
    }
    
    
    
    
   static function construct_lifehack($model){
/*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'test'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'test';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][3] = 'lifehack';
             $json['tags'][4] = BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
    }
    
    
    
   static function construct_must_see($model){
           /*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'test'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'test';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][3] = 'must_see';
             $json['tags'][4] = BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    
    
   static function construct_story($model){
/*  public $title;
    public $country;
    public $body;
    public $tags; -- one tag
    public $coordinates;
*/    
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'test'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
                         
             $json['tags'][0] = 'test';
             $json['tags'][1] =  BlockChain::convert_country_to_lang($model->country);
             $json['tags'][3] = 'must_see';
             $json['tags'][4] = BlockChain::tag_to_eng($model->tags);
             
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             
             $bl_model['metadata'] = $json;
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    
    
    static function convert_country_to_lang($id){
        $country = Countries::find()->select('name')->where('id=' . $id)->asArray()->one();
        return $country['name'];
    }
    
    static function convert_city_to_lang($id){
        $city = Cities::find()->select('name')->where('id=' . $id)->asArray()->one();
        return $city['name'];
        
        
    }


    static function free_on_different_lang($free){
        $current_lang = Yii::$app->language;
             switch ($current_lang){
                 case 'ru-RU':
                    if ($free == 1){
                        $sub_category = BlockChain::tag_to_eng(Yii::t('frontend','Free'));
                    } else {
                        $sub_category = BlockChain::tag_to_eng(Yii::t('frontend','Must pay'));
                    }
                 break;
             
                 case 'en-US':
                     if ($free == 1){
                        $sub_category = strtolower(Yii::t('frontend','Free'));
                       
                     } else {
                        $sub_category = strtolower(Yii::t('frontend','Must pay'));
                     }
                break;
            }
    return $sub_category;        
        
        
    }
    
    
    
    
    
    
    static function get_blockchain_from_locale(){
      
        return (Yii::$app->language == "ru-RU") ? 'GOLOS' : 'STEEM';
        
    }
    
    
    
    
    
    
    
}
    