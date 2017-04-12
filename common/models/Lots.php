<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property string $name
 * @property string $tokens
 * @property string $created_at
 * @property string $description
 */
class Lots extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lots';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'number'], 'string'],
            [['id', 'tokens'], 'number'],
            [['created_at'], 'safe'],
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
            'tokens' => 'Tokens',
            'created_at' => 'Created At',
            'description' => 'Description',
        ];
    }
}
