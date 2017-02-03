<?php
namespace frontend\controllers;

use Yii;
use frontend\models\AddForm;
use yii\web\Controller;
use common\models\ArtSearch;
use common\models\Art;
use common\models\BlockChain;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use common\models\Ico;
use common\models\User;
use DateTime;
use common\models\Calendar;
use common\models\BitCoin;
use yii\data\ArrayDataProvider;
use Coinbase\Wallet\Enum\Param;
use common\models\Withdraw;




use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
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
            ],
            'image-upload' => [
            'class' => 'vova07\imperavi\actions\UploadAction',
                'validatorOptions' => [
                'maxSize' => 4000000
              ],
            'url' => 'https://mapala.net/storage/web/img/', // Directory URL address, where files are stored.
            'path' => '@storage/web/img/' // Or absolute path to directory where files are stored.
            ],
        ];
    }
    
    
/*
Начальная страница проекта возвращается действием Index контроллера Site. В качестве параметров передаются переменные: $state = 'new'/'trending'/'discuss, что меняет порядок отображения контента в ленте. Если в параметрах указаны автор и прямая ссылка - контроллер возвращает статью. Если только автор - блог автора. Если массив категорий - возвращаются данные по одной или нескольким категориям. 
*/
    
    
    public function actionIndex($state = 'new', $author = null, $permlink = null, $categories = null)
    {
        $categories_tree = Art::create_array_categories();
        
        if ($categories != null){ //Отображение по категориям
            $dataProvider = Art::get_data_by_categories($categories);
            $categories_tree = Art::create_array_categories();
        
            return $this->render('index', ['dataProvider'=>$dataProvider,
            'data' => $categories_tree,
             ]); 
        }
        
        if (($permlink == null)&&($author != null)) { //Отображение персонального блога
            $dataProvider = Art::get_single_blog($author);
            return $this->render('single_blog', ['dataProvider' => $dataProvider,
                'data' => $categories_tree,
                'author'=>$author,
            ]);
            
        } elseif (($permlink != null)&&($author != null)) { //Отображение статьи в полный экран
            $model = Art::get_single_art($author, $permlink);
            if ($model == null){
                return $this->render('empty_blog');
            } else{ 
                return $this->render('single_art', ['model'=>$model,
              ]);
            }
            
        }
        
        $dataProvider = Art::get_data_by_categories($categories=null, $state); //Стандартное отображение с порядком вывода, определяемым переменной $state
        return $this->render('index', ['dataProvider'=>$dataProvider,
            'data' => $categories_tree,
         ]);
        
    }

    /**
     * Отображение статьи в полный экран
     *
     * @param string $author Символьный код автора статьи
     * @param string $permlink Символьный код статьи
     *
     * @return mixed
     */
    public function actionView($author, $permlink)
    {
        $model = Art::get_single_art($author, $permlink);
        if ($model == null){
            return $this->render('empty_blog');
        } else{
            return $this->render('single_art', ['model'=>$model,
            ]);
        }
    }


    /*
    Действие ADD используется для обновление базы. В качестве параметров возможно передать автора и прямую ссылку, что используется для смены категорий в процессе редактирования опубликованной статьи. 
    */
    
    
    public function actionAdd($author = null, $permlink = null)  //for change data model
    {
        $model = new AddForm();
        return $this->render('add', [
            'author' => $author,
            'permlink' => $permlink
        ]);
    }
    
    
    
    /*
    Поскольку мы не храним ключей пользователя и не передаем их на сервер ни в каком виде, то единственный способ перейти в блог пользователя - это перенаправить его на страницу, где выполнится javascript скрипт, получающий имя аккаунта пользователя и переадресующий с ним на действие Site/Index с параметром author.
    */
    
       
    public function actionShow_single_blog(){
      
        return $this->render('_pre_single_blog');
    }
    
    

    /*
    Используется для построения дерева комментарием к определенной статье. 
    */
    
    public function actionComments($permlink) {
      $model = new Art();
      $model = Art::find()->where(['permlink' => $permlink])->one();
    
      return $this->renderAjax('comments', [
         'model' => $model
     ]);
     }
     
     
    public function actionInvestors(){
        $investors = Bitcoin::get_all_investors();
        $total_btc = Bitcoin::get_all_btc();
        $total_tokens = Bitcoin::get_all_tokens();
        
    $data_provider = new ArrayDataProvider([
        'allModels' => $investors,
        'sort' => [
            'attributes' => ['name', 'created_at', 'amount', 'bonuse', 'tokens', 'bonuse', 'symbol'],
        ],
        'pagination' => [
            'pageSize' => 50,
        ],
    ]);
        
        return $this->render('investors',[
            'total_btc' => $total_btc,
            'total_tokens' => $total_tokens,
            'data_provider' => $data_provider,
        ]);   
    } 
     
     
     
    public function actionIco(){
 


     if(Yii::$app->user->isGuest) {
                redirect(array('user/sign-in/login'));
     } else {
        
         
         
         
$btc_wallet = BitCoin::get_user_wallet();
$total_invest_by_user = BitCoin::get_user_btc_investments();
$total_amount = BitCoin::get_total_amount($total_invest_by_user);
$interval = Bitcoin::get_interval();
$data = BitCoin::get_data($interval);
$weekly_btc = BitCoin::get_weekly_btc($data);
$weekly_gbg = BitCoin::get_weekly_gbg($data);

$players = BitCoin::get_data($interval);
$personal_tokens = BitCoin::get_tokens();
$total_btc = Bitcoin::get_all_btc();
$personal_btc = Bitcoin::get_personal_btc();
$personal_gbg = Bitcoin::get_personal_gbg();
$total_tokens = Bitcoin::get_all_tokens();
$bonuse_today = BitCoin::get_bonuse_today();
$current_rate = BitCoin::get_rate();




    $data_provider = new ArrayDataProvider([
        'allModels' => $players,
        'sort' => [
            'attributes' => ['name', 'created_at', 'amount', 'bonuse', 'stake', 'currency', 'tokens', 'symbol'],
        ],
        'pagination' => [
            'pageSize' => 50,
        ],
    ]);
    
    
        return $this->render('ico',[
            'current_rate' => $current_rate,
            'amount' => $total_amount,
            'btc_wallet'=>$btc_wallet['btc_wallet'],
            'data_provider' => $data_provider,
            'tokens' => $personal_tokens,
            'interval' => $interval,
            'total_btc' => $total_btc,
            'total_tokens' => $total_tokens,
            'personal_btc' => $personal_btc, 
            'personal_gbg' => $personal_gbg,
            'weekly_btc' => $weekly_btc, 
            'weekly_gbg' => $weekly_gbg,
            'bonuse_today' => $bonuse_today,
        ]);   
        
        
    }
    }
    
    
    public function actionPersonal_history(){
        $btc_wallet = BitCoin::get_user_wallet();
        $total_btc = Bitcoin::get_all_btc();
        $personal_btc = Bitcoin::get_personal_btc();
        $personal_gbg = Bitcoin::get_personal_gbg();
        $personal_tokens = BitCoin::get_tokens();
        $total_invest_by_user = BitCoin::get_user_btc_investments();
        $total_tokens = Bitcoin::get_all_tokens();
        
    $data_provider_for_periods = new ArrayDataProvider([
        'allModels' => $total_invest_by_user,
        'sort' => [
            'attributes' => ['name', 'created_at', 'amount', 'bonuse', 'currency','tokens', 'symbol'],
        ],
        'pagination' => [
            'pageSize' => 50,
        ],
    ]);

        
        return $this->render('personal_info',[
            'total_btc' => $total_btc,
            'total_tokens' => $total_tokens,
            'data_provider_for_periods' => $data_provider_for_periods,
            'btc_wallet'=>$btc_wallet['btc_wallet'],
            'personal_btc' => $personal_btc, 
            'personal_gbg' => $personal_gbg,
               'tokens' => $personal_tokens,
         
       
            
        ]);   
    } 
    
    
    public function actionStat(){
        $users_per_week= Art::get_reg_user_q();
        
         $arts = Art::get_stat_from_prev_interval();
         $total_payout_value = 0 ;
         foreach ($arts as $art){
             $total_payout_value = $total_payout_value + $art['total_pending_payout_value'];
         }
         $total_payout_value = Art::convert_currency($total_payout_value);
             
         
         $data_provider = new ArrayDataProvider([
            'allModels' => $arts,
            'sort' => [
                'attributes' => ['username', 'total_pending_payout_value'],
            ],
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);
         
     
     
      return $this->render('stat',[
          'users_per_week' => $users_per_week,
            'total_payout_value' => $total_payout_value,
            'data_provider' => $data_provider,
        ]);  
     
        
        
    }
    
    
     public function actionTeam(){
     $wd_model = new Withdraw();
        
     if(Yii::$app->user->isGuest) {
                redirect(array('user/sign-in/login'));
     } else {
        if ($wd_model->load(Yii::$app->request->post()) && $wd_model->validate()) { //SAVE
            Bitcoin::add_wd($wd_model);
           }
         
         
         $personal_tokens = BitCoin::get_personal_team_tokens();
         $total_btc = Bitcoin::get_all_btc();
         $team = BitCoin::get_all_team_tokens();
         $current_rate = BitCoin::get_rate();
         $data_provider = new ArrayDataProvider([
            'allModels' => $team,
            'sort' => [
                'attributes' => ['name', 'created_at', 'tokens', 'description'],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
         
         $wd = Bitcoin::get_all_wd();
         
         
         $wd_provider = new ArrayDataProvider([
            'allModels' => $wd,
            'sort' => [
                'attributes' => ['name', 'created_at', 'tokens', 'description'],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
         
         
         
         
     }
      return $this->render('team',[
            'personal_tokens' => $personal_tokens,
            'model' => $wd_model,
            'total_btc' => $total_btc,
            'current_rate' => $current_rate,
            'data_provider' => $data_provider,
            'wd_provider' => $wd_provider,
        ]);  
     
        
        
    }
    
    
    
}
