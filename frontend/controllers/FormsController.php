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
use frontend\models\forms\News;
use frontend\models\forms\Places;
use frontend\models\forms\Blogs;
use frontend\models\forms\Transport;
use frontend\controllers\SiteController;
use common\models\Art;
use frontend\models\forms\Community;
use common\models\BlockChain;
use common\models\Countries;
use common\models\Cities;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\db\Query;
/**
 * Forms controller, вызывается при нажатии на кнопку добавления статьи определенной модели данных
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

    /*
    Каждое действие контроллера вызывает соответствущую для него модель и обрабатывает в зависимости от полученных (или не полученных) параметров author и permlink. Наличие параметров определяет то, редактируется ли старая статья, или добавляется новая. Обращение к действию происходит при нажатии кнопки выбора модели данных на странице Пополнения Базы (контроллер site/add), или при нажатии на кнопку редактирования в статье. 
    */
    
    
    /*
    Действие Immapala показывает форму добавления информации о путешественнике с возможностью редактирования. На данный момент действие ОТКЛЮЧЕНО и УСТАРЕЛО (требует проверки и отладки перед запуском).
    */
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
             $model->body = str_replace('"=""','',$model->body);
            
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

    
    /*
    Действие Homestay показывает форму добавления информации о жилье с возможностью редактирования. На данный момент действие ОТКЛЮЧЕНО и УСТАРЕЛО (требует проверки и отладки перед запуском).
    */

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
             $model->body = str_replace('"=""','',$model->body);
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

    /*
    Действие Knowledge показывает форму пополнения базы знаний о стране. 
    */

    public function actionKnowledge($author = null, $permlink = null)
    {
/*  public $title;
    public $country;
    public $body;
    public $tags;
    public $coordinates;
 */
        //Если пользователь - гость, перенаправляем на контроллер логина.
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
        
         $model = new Knowledge();
        
        /*
        При нажатии на кнопку submit формы добавления материала, вызывается это же действие, в котором проверяется поступление данных через массив POST. В случае их наличия и успешной валидации, запускается процесс конструирования массива с данными, готовыми к транзакции в блокчейн. 
        */
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
             $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_knowledge($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT        
        /*
        Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_places_or_blogs($model,$meta, $current_art);
          }
     
              return $this->render('knowledge', [ //CLEAR
                'model' => $model, 
                'author' => $author,
                'permlink' => $permlink
                ]);
   
    }
       
    
    
    public function actionCommunity($author = null, $permlink = null)
    {
/*  public $title;
    public $body;
    public $tags;
 */
        //Если пользователь - гость, перенаправляем на контроллер логина.
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
        
         $model = new Community();
        
        /*
        При нажатии на кнопку submit формы добавления материала, вызывается это же действие, в котором проверяется поступление данных через массив POST. В случае их наличия и успешной валидации, запускается процесс конструирования массива с данными, готовыми к транзакции в блокчейн. 
        */
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
             $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_community($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT        
        /*
        Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_community($model,$meta, $current_art);
          }
     
              return $this->render('community', [ //CLEAR
                'model' => $model, 
                'author' => $author,
                'permlink' => $permlink
                ]);
   
    }
    
    
    /*
    Действие Places показывает форму пополнения достопримечательностей. 
    */
 
    public function actionPlaces($author = null, $permlink = null)
        {
         //Если пользователь - гость, перенаправляем на контроллер логина.
       
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
         $model = new Places();
         /*
        При нажатии на кнопку submit формы добавления материала, вызывается это же действие, в котором проверяется поступление данных через массив POST. В случае их наличия и успешной валидации, запускается процесс конструирования массива с данными, готовыми к транзакции в блокчейн. 
        */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
             $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_places($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        /*
        Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
              $model->city = ucwords(strtolower($model->city));

              $meta = Art::explode_meta($current_art);
              $model = Art::fill_places_or_blogs($model,$meta, $current_art);
         
    }
                return $this->render('places', [ //CLEAR
                   'model' => $model, 
                   'author'=> $author,
                   'permlink' => $permlink
                ]);
  
    }
      
        
        
    
    /*
    Действие Blogs показывает форму добавления истории о путешествии. 
    */
    
    public function actionBlogs($author = null, $permlink = null)
        {
         //Если пользователь - гость, перенаправляем на контроллер логина.
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
        
           $model = new Blogs();
        
        /*
        При нажатии на кнопку submit формы добавления материала, вызывается это же действие, в котором проверяется поступление данных через массив POST. В случае их наличия и успешной валидации, запускается процесс конструирования массива с данными, готовыми к транзакции в блокчейн. 
        */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
           $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_blogs($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
         /*
        Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $model->country = BlockChain::convert_country_to_id($model->country);
              
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_places_or_blogs($model,$meta, $current_art);
              
    }
     
        return $this->render('blogs', [ //CLEAR
        'model' => $model,
        'author' => $author,
        'permlink' => $permlink
             
        ]);
 
    }
      
        
      
    /*
    Действие News показывает форму добавления новостей. Форма доступна только пользователю с ником "mapala".  
    */  
    
    public function actionNews($author = null, $permlink = null)
        {
        //Если пользователь - гость, перенаправляем на контроллер логина.
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
        
        $model = new News();

        if (Yii::$app->user->identity->username == 'mapala'){
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
           $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_news($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        /* Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_news($model,$meta, $current_art);
    
        }
     }
        return $this->render('news', [ //CLEAR
        'model' => $model,
            'author' => $author,
        'permlink' => $permlink
        ]);
 
    }
      
    
    
     public function actionTest($author = null, $permlink = null)
        {
        //Если пользователь - гость, перенаправляем на контроллер логина.
        if(Yii::$app->user->isGuest) {
            $this->redirect(array('user/sign-in/login'));
        }
        
        $model = new News();

        if (Yii::$app->user->identity->username == 'mapala'){
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //SAVE
           $model->body = str_replace('"=""','',$model->body);
            if ($permlink != null){
                $model->permlink = $permlink;
            } 
            $bl_model = BlockChain::construct_test($model);
             return $bl_model;
        }
        
        if (($author != null)&&($permlink != null)){ //EDIT          
        /* Если в контроллер поступают данные об авторе и прямой ссылке, то запускается процесс "доконструирования" модели данных. Поскольку часть данных записывается в metadata, их необходимо передать файлу view вместе с основной моделью. Процесс не из самых "красивых" и требует переработки. 
        */
        //Here $model - is model for edit (immapala), $current_art - it is model current article, 
        //from which we need to get additional parametrs (meta) and add to main model

              $current_art= Art::get_article_for_edit($author, $permlink);
              $model->attributes = $current_art->attributes;
              $meta = Art::explode_meta($current_art);
              $model = Art::fill_news($model,$meta, $current_art);
    
        }
     }
        return $this->render('news', [ //CLEAR
        'model' => $model
        ]);
 
    }
    
    
    
    public function actionEvents()
        {
       
        }

    

    

    
     public function actionBase()
      {
      }

    
     public function actionCompanions()
        {
       
        }

    
    public function actionTransport()
        {
        }


    /*
    В тех моделях, где необходимо выбрать город, список городов подгружается с использованием cookies. При выборе страны, отправляется ajax запрос, который сохраняет страну и при клике на список городов, подгружает нужный список.
    */
     
     public function actionSave_country($id)
    {
           $country = $id;
           $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'country',
                'value' => $country
      ]));
    }
    
    
/*
Действие используется для получения списка городов с учетом сохраненной страны.
*/
    
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