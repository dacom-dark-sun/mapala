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
class Trail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'key', 'blockchain'], 'string'],
            [['weight', 'imported', 'active'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }
}
