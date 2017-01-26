<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property integer $id
 * @property string $username
 * @property string $rate
 * @property string $tokens
 * @property string $btc
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'btc_address', 'created_at', 'status'], 'string'],
            [['rate', 'tokens', 'btc'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Username',
            'rate' => 'Rate',
            'tokens' => 'Tokens',
            'btc' => 'Btc',
        ];
    }
}
