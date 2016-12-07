<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "current_block".
 *
 * @property integer $current_block
 */
class CurrentBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'current_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['current_block'], 'required'],
            [['current_block'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'current_block' => 'Current Block',
        ];
    }
}
