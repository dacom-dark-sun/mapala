<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\forms;
use frontend\models\forms\Base;
use frontend\models\forms\Companions;
use frontend\models\forms\Homestay;
use frontend\models\forms\ImMapala;
use frontend\models\forms\Lifehack;
use frontend\models\forms\Mapala_events;
use frontend\models\forms\Must_see;
use frontend\models\forms\Story;
use frontend\models\forms\Transport;
use frontend\controllers\SiteController;
use yii\web\Controller;

/**
 * ContactForm is the model behind the contact form.
 */
class AddForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body', 'verifyCode'], 'required'],
            // We need to sanitize them
            [['name', 'subject', 'body'], 'filter', 'filter' => 'strip_tags'],
            // email has to be a valid email address
            ['email', 'email'],
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
            'email' => Yii::t('frontend', 'Email'),
            'subject' => Yii::t('frontend', 'Subject'),
            'body' => Yii::t('frontend', 'Body'),
            'verifyCode' => Yii::t('frontend', 'Verification Code')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function Add($email)
    {
        if ($this->validate()) {
            return Yii::$app->session->setFlash('success', 'Успешно добавлено!');
        } else {
            return Yii::$app->session->setFlash('success', 'Успешно добавлено!');
        }
    }
    
    static function get_model($model_request){
        switch ($model_request){
            case "im_mapala": 
                $model = new ImMapala();
            break;
            
            case "homestay":
                $model = new homestay();
            break;
        
            case "companions":
                $model = new Companions();
            break;
        
            case "lifehack":
                $model = new Lifehack();
            break;
        
            case "mapala_events":
                $model = new Mapala_events();
            break;
        
            case "must_see":
                $model = new Must_see();
            break;
        
            case "story":
                $model = new Story();
            break;
              
        }
        
       return $model;
        
        
        
        
    }
    
}

