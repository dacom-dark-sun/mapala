<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use Yii;
use frontend\models\AddForm;
use yii\web\Controller;
use common\models\ArtSearch;
use common\models\Art;
use common\models\VotesRaw;
use common\models\ArtRaw;
use common\models\UsersRaw;
use common\models\Parsing;
class ParserController extends Controller{

    public function actionBlock(){
       
        
  
//        $block = Parsing::get_content_from_block(123);
        $current_sql_block = Parsing::process();
  //      var_dump($current_sql_block);
 //       return Parsing::example();
        
        
       
        
        
            
            
            
        //return $this->render('parser', ['out'=>$out,
        //      ]);
        
    }
    
}


