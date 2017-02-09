<?php

namespace common\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property string $date_start
 * @property string $date_end
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
        ];
    }

    public function getActualWeeks()
    {
        $result = $this->find()
            ->select(['id', 'date_start', 'date_end'])
            ->where(['finished' => 1])
            ->orderBy(['date_end' => SORT_DESC])
            ->asArray()
            ->all();
        if (is_null($result)) {
            throw new Exception('Нет активных недель');
        }

        return $result;
    }

    public function paginationQuery()
    {
        return $this->find()->where(['finished' => 1])->count();
    }
}
