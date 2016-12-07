<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "votes_raw".
 *
 * @property integer $id
 * @property string $voter
 * @property string $author
 * @property string $permlink
 */
class VotesRaw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votes_raw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voter', 'author', 'permlink'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'voter' => 'Voter',
            'author' => 'Author',
            'permlink' => 'Permlink',
        ];
    }
}
