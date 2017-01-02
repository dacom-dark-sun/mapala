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

    
    public function actionShow_by_category($categories){
     
        $dataProvider = Art::get_data_by_categories($categories);
        return $this->renderAjax('_index_new_view_by_category', ['dataProvider'=>$dataProvider,
              ]);
    }
   
     
    
    public function actionSave_name ($name){
        $blockchain = BlockChain::get_blockchain_from_locale();
        $name = strip_tags($name);
        $sql_name = Yii::$app->user->identity->username;
        
        Yii::$app->db->createCommand()
             ->update('user', [$blockchain => $name], ['username' => $sql_name])
             ->execute();
    }
    
     
      
      
     public function actionComments_save() {
      $data = Yii::$app->request->post();
      
      if ($data['data']){
          $bl_model = BlockChain::construct_reply($data['data']);
          return $bl_model;

          
      } else{
        return 'internal server error';
      }
      
    }
      
      
     
     
}
   

     
     
     
     
