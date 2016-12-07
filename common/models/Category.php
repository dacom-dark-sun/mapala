<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $country
 * @property string $country_json
 * @property string $city
 * @property string $city_json
 * @property string $category_json
 * @property string $sub_category_json
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'country_json', 'city', 'city_json', 'category_json', 'sub_category_json'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'country_json' => 'Country Json',
            'city' => 'City',
            'city_json' => 'City Json',
            'category_json' => 'Category Json',
            'sub_category_json' => 'Sub Category Json',
        ];
    }
}
