<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gbg".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property string $hash
 * @property string $currency
 * @property string $tokens
 * @property integer $bonuses
 * @property integer $block
 * @property integer $symbol
 */
class Gbg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gbg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'amount', 'created_at', 'updated_at', 'status', 'hash', 'currency'], 'string'],
            [['tokens'], 'number'],
            [['bonuses', 'block', 'symbol'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'hash' => 'Hash',
            'currency' => 'Currency',
            'tokens' => 'Tokens',
            'bonuses' => 'Bonuses',
            'block' => 'Block',
            'symbol' => 'Symbol',
        ];
    }
}
