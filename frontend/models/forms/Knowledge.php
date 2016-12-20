<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Knowledge extends Model{
    public $title;
    public $country;
    public $city;
    public $body;
    public $tags;
    public $coordinates;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['coordinates','title','country', 'city','body', 'tags'], 'required'],
            // We need to sanitize them
            [['title','country', 'body', 'tags'], 'filter', 'filter' => 'strip_tags'],
           

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title'=> Yii::t('frontend', 'Title'),
            'country' => Yii::t('frontend', 'Country'),
            'city' => Yii::t('frontend', 'City'),
            'body' => Yii::t('frontend', 'Body'),
            'tags' => Yii::t('frontend', 'Category'),
            'coordinates' => Yii::t('frontend', 'Coordinates'),
           
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }
