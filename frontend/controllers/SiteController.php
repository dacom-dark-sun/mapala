<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use yii\web\Controller;
use common\models\ArtSearch;
use common\models\Art;

/**
 * Site controller
 */
class SiteController extends Controller
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

    public function actionIndex($state = 'new', $author = null, $permlink = null, $categories = null)
    {
        $categories_tree = Art::create_array_categories();
        
        if ($categories != null){
            $dataProvider = Art::get_data_by_categories($categories);
            $categories_tree = Art::create_array_categories();
        
            return $this->render('index', ['dataProvider'=>$dataProvider,
            'data' => $categories_tree,
             ]); 
        }
        
        if (($permlink == null)&&($author != null)) {
            $dataProvider = Art::get_single_blog($author);
            return $this->render('single_blog', ['dataProvider' => $dataProvider,
                'data' => $categories_tree,
                'author'=>$author,
            ]);
            
        } elseif (($permlink != null)&&($author != null)) {
            $model = Art::get_single_art($author, $permlink);
            if ($model == null){
                return $this->render('empty_blog');
            } else{ 
                return $this->render('single_art', ['model'=>$model,
              ]);
            }
            
        }
        
        $dataProvider = Art::get_data_by_categories($categories=null, $state);
        return $this->render('index', ['dataProvider'=>$dataProvider,
            'data' => $categories_tree,
         ]);
        
}



    
    
    
    public function actionAdd()
    {
        $model = new AddForm();
        return $this->render('add', [
            'model' => $model
        ]);
    }
    
    
       
    public function actionShow_single_blog(){
      
        return $this->render('_pre_single_blog');
    }
    
    
    public function actionComments($permlink) {
      $model = new Art();
      $model = Art::find()->where(['permlink' => $permlink])->one();
    
      return $this->renderAjax('comments', [
         'model' => $model
     ]);
     }
       
    
}
