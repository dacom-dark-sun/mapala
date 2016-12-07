<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use frontend\models\forms\Base;
use frontend\models\forms\Companions;
use frontend\models\forms\Homestay;
use frontend\models\forms\ImMapala;
use frontend\models\forms\Lifehack;
use frontend\models\forms\Mapala_events;
use frontend\models\forms\Must_see;
use frontend\models\forms\Story;
use frontend\models\forms\Transport;
use frontend\controllers\SiteController;
use common\models\Art;
use common\models\BlockChain;
use common\models\Countries;
use common\models\Cities;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\db\Query;
/**
 * Site controller
 */
class FormsController extends SiteController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    
    public function actionAdd_im_mapala()
    {
        $model = new ImMapala();
        
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          return var_dump($model);
             $bl_model = BlockChain::construct_im_mapala($model);
             return $bl_model;
             
               }
        else { 
            return $this->render('immapala', [
            'model' => $model
            ]);
        }
    }
    
            
    public function actionAdd_lifehack()
    {
        $model = new Lifehack();
        
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        return var_dump($model);  
        }
        else{ return $this->render('lifehack', [
            'model' => $model
            ]);
        }
    }
    
    public function actionAdd_must_see()
        {
          $model = new Must_see();
        
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           return  var_dump($model);
            $bl_model = BlockChain::construct_must_see($model);
             return $bl_model;
             
               }
        else { 
            return $this->render('must_see', [
            'model' => $model
            ]);
        }
    }

    
    public function actionAdd_mapala_events()
        {
        $model = new Mapala_events();
       
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $art = new Page();
            $art->title = $model->city;
            $art->body = $model->country;
            $art->status="1";
            $art->slug = $model->contacts;
            $art->save();
          
            Yii::$app->session->setFlash('success', 'Some Message.');
            return $this->redirect(['/site/my_blog']);
        }
        else{ return $this->render('mapala_events', [
            'model' => $model
            ]);
        }
    }

    
    public function actionAdd_story()
        {
        $model = new Story();
        
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return var_dump($model);
            $bl_model = BlockChain::construct_im_mapala($model);
             return $bl_model;

               }
        else { 
            return $this->render('story', [
            'model' => $model
            ]);
        }
    }

    
    public function actionAdd_homestay()
        {
        /*
         @public $title;  
         @public $contacts;
         @public $country;
         @public $city;
         @public $capacity;
         @public $cost=0 ;
         @public $free = 1;
         @public $body;
         @public $parentPermlink = '';
         @public $parentAuthor = '';
         @public $blockchain
        
        */
        $model = new Homestay();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             $bl_model = new BlockChain();
             $bl_model = BlockChain::construct_homestay($model);
             return $bl_model;
          }
        else{ return $this->render('homestay', [
            'model' => $model
            ]);
        }
    }

    
     public function actionAdd_base()
      {
        $model = new Base();
       
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $art = new Page();
            $art->title = $model->city;
            $art->body = $model->country;
            $art->status="1";
            $art->slug = $model->contacts;
            $art->save();
              Yii::$app->session->setFlash('success', 'Some Message.');
            return $this->redirect(['/site/my_blog']);
        }
        else{ return $this->render('base', [
            'model' => $model
            ]);
        }
    }

    
     public function actionAdd_companions()
        {
        $model = new Companions();
       
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          $art = new Page();
            $art->title = $model->city;
            $art->body = $model->country;
            $art->status="1";
            $art->slug = $model->contacts;
            $art->save();
               Yii::$app->session->setFlash('success', 'Some Message.');
            return $this->redirect(['/site/my_blog']);
        }
        else{ return $this->render('companions', [
            'model' => $model
            ]);
        }
    }

    
    public function actionAdd_transport()
        {
        $model = new Transport();

         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $art = new Page();
            $art->title = $model->city;
            $art->body = $model->country;
            $art->status="1";
            $art->slug = $model->contacts;
            $art->save();
            Yii::$app->session->setFlash('success', 'Some Message.');
            return $this->redirect(['/site/my_blog']);
        }
        else{ return $this->render('transport', [
            'model' => $model
            ]);
        }
    }


     
     public function actionSave_country($id)
    {
           $country = $id;
           $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'country',
                'value' => $country
      ]));
    }
    
    
    
    
    
public function actionCitylist($q = null, $id = null) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $cookies = Yii::$app->request->cookies;
    $country = $cookies['country'];
    
    $out = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('id, name AS text')
            ->from('cities')
            ->where(['like', 'name', $q])
            ->andWhere(['country' => $country])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
        $out['results'] = ['id' => $id, 'text' => Cities::find($id)->name];
    }
    return $out;
}



}