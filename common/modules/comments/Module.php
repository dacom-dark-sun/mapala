<?php

namespace common\modules\comments;

use Yii;
use common\modules\comments\models\CommentModel;

/**
 * Class Module
 * @package yii2mod\comments
 */
class Module extends \yii\base\Module
{
    /**
     * @var string module name
     */
    public static $name = 'comment';

    /**
     * @var string the class name of the [[identity]] object.
     */
    public $userIdentityClass;

    /**
     * @var string the class name of the comment model object, by default its yii2mod\comments\models\CommentModel::className();
     */
    public $commentModelClass;

    /**
     * @var string the namespace that controller classes are in.
     */
    public $controllerNamespace = '@common\modules\comments\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->userIdentityClass)) {
            $this->userIdentityClass = Yii::$app->getUser()->identityClass;
        }

        if (empty($this->commentModelClass)) {
            $this->commentModelClass = CommentModel::className();
        }

        parent::init();
    }
}