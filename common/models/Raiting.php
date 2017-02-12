<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "raiting".
 *
 * @property integer $id
 * @property integer $calend_id
 * @property integer $user_id
 * @property integer $raiting
 * @property string $username
 *
 * @property Calendar $calend
 * @property User $user
 */
class Raiting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'raiting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calend_id', 'user_id', 'raiting'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['calend_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calend_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calend_id' => 'Calend ID',
            'user_id' => 'User ID',
            'raiting' => 'Raiting',
            'username' => 'Username',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalend()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calend_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRaitingRows()
    {
        return $this->find()->asArray()->all();
    }
}
