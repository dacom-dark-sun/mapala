<?php

namespace comments\events;

use yii\base\Event;
use common\modules\comments\models\CommentModel;

/**
 * Class CommentEvent
 * @package yii2mod\comments\events
 */
class CommentEvent extends Event
{
    /**
     * @var CommentModel
     */
    private $_commentModel;

    /**
     * @return CommentModel
     */
    public function getCommentModel()
    {
        return $this->_commentModel;
    }

    /**
     * @param CommentModel $commentModel
     */
    public function setCommentModel(CommentModel $commentModel)
    {
        $this->_commentModel = $commentModel;
    }
}