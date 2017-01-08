<?php
namespace frontend\modules\user\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupBlockchain extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 6, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'=>Yii::t('frontend', 'Username'),
            'password'=>Yii::t('frontend', 'Password'),
        ];
    }

}
