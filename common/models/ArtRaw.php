<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "art_raw".
 *
 * @property integer $id
 * @property string $parent_author
 * @property string $parent_permlink
 * @property string $author
 * @property string $permlink
 * @property string $tittle
 * @property string $body
 * @property string $json_metadata
 */
class ArtRaw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'art_raw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_author', 'parent_permlink', 'author', 'permlink', 'tittle', 'body', 'json_metadata'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_author' => 'Parent Author',
            'parent_permlink' => 'Parent Permlink',
            'author' => 'Author',
            'permlink' => 'Permlink',
            'tittle' => 'Tittle',
            'body' => 'Body',
            'json_metadata' => 'Json Metadata',
        ];
    }
}
