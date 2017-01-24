<?php

namespace frontend\modules\user\controllers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Yii;
use yii\web\Controller;
use frontend\modules\user\controllers\KeysController;
use frontend\modules\user\models\SignupBlockchain;
use common\models\BlockChain;

class KeysController extends Controller
{
    
public function actionIndex()
    {
    $signupBl_model = new SignupBlockchain();
    
    if($signupBl_model->load(Yii::$app->request->post()) && $signupBl_model->validate()){
        $posting_key = BlockChain::register($signupBl_model->username, $signupBl_model->password);
        
        return $posting_key;
    }
    
        return $this->render('keysForm',[
           'signupBl_model' => $signupBl_model,
        ]);
    }


    
    
}   