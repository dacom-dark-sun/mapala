<?php

namespace common\models;

use Yii;
use common\models\BitCoin;

/**
 * This is the model class for table "withdraw".
 *
 * @property integer $id
 * @property string $username
 * @property string $rate
 * @property string $tokens
 * @property string $btc
 */
class Withdraw_ref extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw_ref';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wallet', 'amount'], 'required'],
            [['wallet'], 'string'],
            [['amount'],'double', 'min' => 0.001],
            [['amount'], 'match', 'pattern'=>'/^[0-9]{1,12}(\.[0-9]{0,8})?$/'],
           // [['amount'], 'validateAmount','skipOnEmpty' => false, 'skipOnError' => false],

               
        ];
    }

     public function validateAmount()
    {
         $access_ref = Bitcoin::get_amount_access_refs() - Bitcoin::get_amount_wd_refs();
         //$value = floatval($this->amount);
         $access_ref = 1;
         $value = 10;
         if ($value >= $access_ref)
            $this->addError('amount', 'The token must contain letters or digits.');
         
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wallet' => Yii::t('frontend', 'BTC Wallet'),
            'amount' => Yii::t('frontend', 'Amount, BTC'),
            'rate' => 'Rate',
            'tokens' => 'Tokens',
            'btc' => 'Btc',
        ];
    }
}
