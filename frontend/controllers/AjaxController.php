<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use yii\web\Controller;
use common\models\ArtSearch;
use common\models\Art;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AjaxController extends Controller{

    
    public function actionShow_by_category($categories){
     
        $dataProvider = Art::get_data_by_categories($categories);
        return $this->renderPartial('_index_new_view_by_category', ['dataProvider'=>$dataProvider,
              ]);
    }
   
    
     public function actionComments($permlink) {
           $model = Art::find()->where(['permlink' => $permlink])->one();
      
      return $this->renderAjax('comments', [
         'model' => $model
     ]);
     }
     
     
}
   

     
     
     
     
