<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "current_block".
 *
 * @property integer $current_block
 */
class Validated_arts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'validated_arts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['validated_arts'], 'required'],
            [['validated_arts'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'validated_arts' => 'Validated Arts',
        ];
    }
}
