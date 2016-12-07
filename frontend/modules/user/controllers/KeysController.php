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

class KeysController extends Controller
{
    
public function actionIndex()
    {
        return $this->render('keysForm');
    }

public function actionAjax()
    {
        return $this->renderAjax('keysForm');
    }

    
    
}   