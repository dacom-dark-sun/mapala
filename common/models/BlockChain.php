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
             $bl_model['parentPermlink'] = 'im-mapala'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
            
             $languages = BlockChain::tag_to_eng(strtolower($model->languages));
             $json['contacts'] = strtolower($model->contacts);
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::tag_to_eng(mb_strtolower($model->country));
             $json['tags'][2] =  BlockChain::tag_to_eng(mb_strtolower($model->city));
             $json['tags'][3] = 'im-mapala';
             $json['languages'] = explode(", ", $languages);
             $json['coordinates'] = $model->coordinates;
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
             $bl_model['metadata'] = $json;
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
      
    }
    
    
   static function construct_homestay($model){
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'homestay'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
             
             $json['contacts'] = mb_strtolower($model->contacts);
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::tag_to_eng($model->country);
             $json['tags'][2] =  BlockChain::tag_to_eng($model->city);
             $json['tags'][3] = 'homestay';
             $json['tags'][4] = BlockChain::free_on_different_lang($model->free);
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
           
             $bl_model['metadata'] = json_encode($json);
             
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
        
        
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
    
    
    
   static function construct_must_see($model){
             $bl_model['parentAuthor'] = '';
             $bl_model['parentPermlink'] = 'must-see'; //
             $bl_model['permlink'] = BlockChain::create_permlink($model->title); 
             $bl_model['body'] = $model->body;
             $bl_model['title'] = $model->title;
             $bl_model['blockchain'] = BlockChain::get_blockchain_from_locale();
            
             $json['tags'][0] = 'mapala';
             $json['tags'][1] =  BlockChain::tag_to_eng(mb_strtolower($model->country));
             $json['tags'][2] =  BlockChain::tag_to_eng(mb_strtolower($model->city));
             $json['tags'][3] = 'must-see';
             $json['model'] = strtolower(StringHelper::basename(get_class($model)));
           
             $bl_model['metadata'] = json_encode($json);
             return json_encode($bl_model, JSON_UNESCAPED_UNICODE);
      
        
        
    }
    
    
    
    
    
    static function get_blockchain_from_locale(){
      
        return (Yii::$app->language == "ru-RU") ? 'GOLOS' : 'STEEM';
        
    }
    
    
    
    
    
    
    
}
    