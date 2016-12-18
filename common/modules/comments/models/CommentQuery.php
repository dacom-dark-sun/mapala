<?php

namespace common\modules\comments\models;

use yii\db\ActiveQuery;
use common\modules\comments\models\enums\CommentStatus;

/**
 * Class CommentQuery
 * @package yii2mod\comments\models
 */
class CommentQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => CommentStatus::ACTIVE]);
    }

    /**
     * @return $this
     */
    public function deleted()
    {
        return $this->andWhere(['status' => CommentStatus::DELETED]);
    }
}