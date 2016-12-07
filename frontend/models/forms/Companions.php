<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Companions extends Model
{
    public $name;
    public $contacts;
    public $country;
    public $city;
    public $languages;
    public $body;
    public $verifyCode;
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['name', 'country', 'contacts', 'city', 'languages', 'body','verifyCode'], 'required'],
            // We need to sanitize them
            [['name', 'country', 'contacts', 'city', 'languages', 'body'], 'filter', 'filter' => 'strip_tags'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Name'),
            'country' => Yii::t('frontend', 'Country'),
            'contacts' => Yii::t('frontend', 'Contacts'),
            'city' => Yii::t('frontend', 'City'),
            'languages' => Yii::t('frontend', 'Languages'),
            'body' => Yii::t('frontend', 'Body'),
            'verifyCode' => Yii::t('frontend', 'Verification Code')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }
