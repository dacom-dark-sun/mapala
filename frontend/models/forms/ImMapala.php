<?php

namespace frontend\models\forms;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ImMapala extends Model
{
    public $title; //title
    public $contacts; //tag
    public $country;  //tag
    public $city;     //tag
    public $languages; //json
    public $body;     //body
    public $is_it_traveler = 1;    //living in this place
    public $date_until_leave;
    public $coordinates;
    private $meta;
    
    
     public function getMeta(){
         return $this->meta;
     }

     public function setMeta($meta){
         $this->meta = $meta;
     }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
         return [
         //    name, email, subject and body are required
            [['coordinates','title', 'country', 'contacts', 'city', 'languages', 'body'], 'required'],
            // We need to sanitize them
            [['title', 'country', 'contacts', 'city', 'languages', 'body'], 'filter', 'filter' => 'strip_tags'],
            // verifyCode needs to be entered correctly
             [['date_until_leave'], 'string'],
             [['is_it_traveler'],'boolean'],
             
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('frontend', 'Introduce yourself, please (title)'),
            'country' => Yii::t('frontend', 'Country'),
            'contacts' => Yii::t('frontend', 'Contacts'),
            'city' => Yii::t('frontend', 'City'),
            'languages' => Yii::t('frontend', 'Languages'),
            'body' => Yii::t('frontend', 'Body'),
            'verifyCode' => Yii::t('frontend', 'Verification Code'),
            'date_until_leave' => Yii::t('frontend', 'Date until leave'),
            'is_it_traveler' => Yii::t('frontend','Im not in the travel now and this is my permanent place'),
      
            
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
        
    }

