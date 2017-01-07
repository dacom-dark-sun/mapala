<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use yii\web\Controller;
use common\models\ArtSearch;
use common\models\Art;
use common\models\BlockChain;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AjaxController extends Controller{

    /*
    Для обеспечения работы сайта без перезагрузки страницы, используется ajax запрос, вызываемый нажатием на кнопку выбора категории в дереве (функция function_a в frontend/views/layout/main). Запрос отправляется действию Ajax/Show_by_category.
    
    */
    
    public function actionShow_by_category($categories){
     
        $dataProvider = Art::get_data_by_categories($categories);
        return $this->renderAjax('_index_new_view_by_category', ['dataProvider'=>$dataProvider,
              ]);
    }
   
    
    /*
    Для того, чтобы иметь возможность поставить в соответствие аккаунты пользователей MapalaNet с их аккаунтами на Golos/Steem, каждый никнейм при сохранении приватного ключа сохраняется в таблицу user, колонки steem/golos. 
    */
    
    public function actionSave_name ($name){
        $blockchain = BlockChain::get_blockchain_from_locale();
        $name = strip_tags($name);
        $sql_name = Yii::$app->user->identity->username;
        
        Yii::$app->db->createCommand()
             ->update('user', [$blockchain => $name], ['username' => $sql_name])
             ->execute();
    }
    
     
    /*
    При отправке комментария используется действие Send_comment, которое запрашивает модель Blockchain о подготовке данных к отправке. 
    */
      
     public function actionSend_comment() {
      $data = Yii::$app->request->post();
      
      if ($data['data']){
          $bl_model = BlockChain::construct_reply($data['data']);
          return $bl_model;

          
      } else{
        return 'internal server error';
      }
      
    }
      
      
     
     
}
   

     
     
     
     
