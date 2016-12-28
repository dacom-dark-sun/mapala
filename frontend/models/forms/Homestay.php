<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Homestay extends Model
{
    public $title;  
    public $contacts;
    public $country;
    public $city;
    public $cost=0 ;
    public $free = 1;
    public $body;
    public $parentPermlink = '';
    public $parentAuthor = '';
    public $coordinates;
    public $permlink = null;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['coordinates','title', 'cost', 'country', 'contacts', 'city', 'body'], 'required'],
            // We need to sanitize them
            [['title', 'cost', 'country', 'contacts', 'city'], 'filter', 'filter' => 'strip_tags'],
            // verifyCode needs to be entered correctly
            [['cost'], 'number'],
            [['free'], 'boolean']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('frontend', 'Title'),
            'country' => Yii::t('frontend', 'Country'),
            'contacts' => Yii::t('frontend', 'Contacts'),
            'city' => Yii::t('frontend', 'City'),
            'body' => Yii::t('frontend', 'Body'),
            'category' => Yii::t('frontend', 'Category'),
            'cost' => Yii::t('frontend', 'Cost, USD'),
            'coordinates' => Yii::t('frontend', 'Coordinates'),
            'free' => Yii::t('frontend','Free'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }

