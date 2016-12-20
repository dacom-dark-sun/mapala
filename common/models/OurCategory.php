<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "our_category".
 *
 * @property integer $id
 * @property string $model
 * @property string $golos
 * @property string $steem
 */
class OurCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'our_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'golos', 'steem'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'golos' => 'Golos',
            'steem' => 'Steem',
        ];
    }
}
