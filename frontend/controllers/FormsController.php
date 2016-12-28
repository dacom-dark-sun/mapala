<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use frontend\models\forms\Base;
use frontend\models\forms\Companions;
use frontend\models\forms\Homestay;
use frontend\models\forms\ImMapala;
use frontend\models\forms\Knowledge;
use frontend\models\forms\Mapala_events;
use frontend\models\forms\Places;
use frontend\models\forms\Blogs;
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

    
    public function actionImmapala($author = null, $permlink = null)
    {
          /*public $title; //title
            public $contacts; //tag
            public $country;  //tag
            public $city;     //tag
            public $languages; //json
            public $body;     //body
            public $not_traveler = 1;    //living in this place
            public $date_until_leave;
            public $coordinates;
               * 
              */
        $model = new ImMapala();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
            if ($permlink != null){
                $model->permlink = $permlink;
            }  
            $bl_model = BlockChain::construct_im_mapala($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_immapala($model,$meta);
    }
     
        return $this->render('immapala', [ //CLEAR
        'model' => $model
        ]);
 
    }


    public function actionHomestay($author = null, $permlink = null)
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
         @public $coordinates;
   
        
        */
        $model = new Homestay();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
            if ($permlink != null){
                $model->permlink = $permlink;
            }  
            $bl_model = BlockChain::construct_homestay($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_homestay($model,$meta);
    }
     
        return $this->render('homestay', [ //CLEAR
        'model' => $model
        ]);
 
    }

    
            
    public function actionKnowledge($author = null, $permlink = null)
    {
/*  public $title;
    public $country;
    public $body;
    public $tags;
    public $coordinates;
 */
        
         $model = new Knowledge();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_library($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
             
              $model->city = ucwords(strtolower($model->city));
              
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_simple_model($model,$meta);
    }
     
        return $this->render('knowledge', [ //CLEAR
        'model' => $model
        ]);
 
    }
        
     
    public function actionPlaces($author = null, $permlink = null)
        {
      
           $model = new Places();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_places($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
              $model->city = ucfirst(strtolower($model->city));
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_simple_model($model,$meta);
    }
     
        return $this->render('places', [ //CLEAR
        'model' => $model
        ]);
 
    }
      
        
        
    
    
    
    public function actionBlogs($author = null, $permlink = null)
        {
           $model = new Blogs();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_blogs($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
              $model->city = ucfirst(strtolower($model->city));
              
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_simple_model($model,$meta);
    }
     
        return $this->render('blogs', [ //CLEAR
        'model' => $model
        ]);
 
    }
      
        
        
        
    
    public function actionEvents()
        {
       
    }

    

    

    
     public function actionBase()
      {
        $model = new Base();
       
         
    }

    
     public function actionCompanions()
        {
        $model = new Companions();
       
        
    }

    
    public function actionTransport()
        {
        $model = new Transport();

       
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