<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_raw".
 *
 * @property integer $id
 * @property integer $new_account_name
 */
class UsersRaw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_raw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['new_account_name'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'new_account_name' => 'New Account Name',
        ];
    }
}
