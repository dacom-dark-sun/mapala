<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Must_see extends Model
{
    public $title;
    public $tags;
    public $body;
    public $country;
    public $coordinates;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['coordinates','country','title', 'tags', 'body'], 'required'],
            // We need to sanitize them
            [['title', 'body','country', 'tags'], 'filter', 'filter' => 'strip_tags'],
       
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
            'body' => Yii::t('frontend', 'Body'),
            'tag' => Yii::t('frontend', 'Tag'),
            'title'=>Yii::t('frontend', 'Title'),
            'coordinates' => Yii::t('frontend', 'Coordinates'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }