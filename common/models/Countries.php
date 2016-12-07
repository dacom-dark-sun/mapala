<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $alias
 * @property string $lat
 * @property string $lng
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alias'], 'required'],
            [['id'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['name', 'code', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'alias' => 'Alias',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }
}
