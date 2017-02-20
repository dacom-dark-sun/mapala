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
use common\models\Trail;



use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
/**
 * Site controller
 */
class TrailController extends Controller
{
    
    
    
    public function actionIndex()
    {
       $user_mapala = Yii::$app->user->identity->username;
       $used = Trail::find()->where(['user_mapala' => $user_mapala])->asArray()->one();
       if ($used)         
           $flag = $used['active'];
       else {
           $flag = 0;
       }
           return $this->render('trail',[
               'flag' => $flag
            ]); 
     
        
    }
    
    
    public function actionUse_trail(){
       $post = Yii::$app->request->post();
       $user_mapala = Yii::$app->user->identity->username;
       $key = $post['key'];
       $user = $post['user'];
       $blockchain = Blockchain::get_blockchain_from_locale();
       Yii::$app->db->createCommand()
             ->insert('trail', [
                 'key' => $key,
                 'user_mapala' => $user_mapala,
                 'user' => $user,
                 'blockchain' => $blockchain,
                 'weight' => 100,
                 
                ])
             ->execute();
       $used = Trail::find()->where(['user_mapala' => $user_mapala])->asArray()->one();
       if ($used)         
           $flag = $used['active'];
       else {
           $flag = 0;
       }
       
      $this->redirect(array('trail/index'));
    }
    
    
    
    public function actionCancel_trail(){
       $post = Yii::$app->request->post();
       $key = $post['key'];
       $user = $post['user'];
       $user_mapala = Yii::$app->user->identity->username;
       
       Yii::$app->db->createCommand()
             ->delete('trail', [
                 
                ],['user_mapala' => $user_mapala])
             ->execute();
       
       
         $this->redirect(array('trail/index'));

}

}    