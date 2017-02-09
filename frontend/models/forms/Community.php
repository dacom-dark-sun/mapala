<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Community extends Model{
    public $title;
    public $body;
    public $tags;
    public $permlink = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['title','body', 'tags'], 'required'],
            // We need to sanitize them
            [['title','tags'], 'filter', 'filter' => 'strip_tags'],
       

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
            'body' => Yii::t('frontend', 'Body'),
            'tags' => Yii::t('frontend', 'Category'),
            'coordinates' => Yii::t('frontend', 'Coordinates'),
            'location' => Yii::t('frontend', 'Location'),
            'city' => Yii::t('frontend', 'City'),
    
           
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }
