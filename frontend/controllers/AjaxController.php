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
   
     
    
    
    
     public function actionComments($permlink) {
      $model = new Art();
      $model = Art::find()->where(['permlink' => $permlink])->one();
    
      return $this->renderAjax('comments', [
         'model' => $model
     ]);
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
   

     
     
     
     
