<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ico".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $hash
 * @property integer $currency
 */
class Ico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'amount', 'created_at', 'updated_at', 'status', 'hash', 'currency'], 'integer'],
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
        ];
    }
}
