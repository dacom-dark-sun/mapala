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
class TrailController extends Controller
{
    
    
    
    public function actionIndex($state = 'new', $author = null, $permlink = null, $categories = null)
    {
         return $this->render('trail',[
            ]); 
     
        
    }
    
    public function actionUse_trail(){
       $post = Yii::$app->request->post();
       $key = $post['key'];
       $user = $post['user'];
       
       Yii::$app->db->createCommand()
             ->insert('trail', [
                 'key' => $key,
                 'user' => $user,
                ])
             ->execute();
       
       return true;
    }
    
    public function actionCancel_trail(){
       $post = Yii::$app->request->post();
       $key = $post['key'];
       $user = $post['user'];
       
       Yii::$app->db->createCommand()
             ->delete('trail', [
                 'key' => $key,
                 'user' => $user,
                ])
             ->execute();
       
       return true;
    }

}    