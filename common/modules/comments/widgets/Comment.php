<?php

namespace common\modules\comments\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;
use common\modules\comments\CommentAsset;
use common\modules\comments\Module;

/**
 * Class Comment
 * @package yii2mod\comments\widgets
 */
class Comment extends Widget
{
    
    public $author;
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;

    /**
     * @var string relatedTo custom text, for example: cms url: about-us, john comment about us page, etc.
     * By default - className:primaryKey of the current model
     */
    public $relatedTo;

    /**
     * @var string the view file that will render the comment tree and form for posting comments.
     */
    public $commentView = 'index';

    /**
     * @var string comment form id
     */
    public $formId = 'comment-form';

    /**
     * @var string pjax container id
     */
    public $pjaxContainerId;

    /**
     * @var null|integer maximum comments level, level starts from 1, null - unlimited level;
     */
    public $maxLevel = 7;

    /**
     * @var boolean show deleted comments. Defaults to `false`.
     */
    public $showDeletedComments = false;

    /**
     * @var string entity id attribute
     */
    public $permlinkAttribute = 'permlink';

    /**
     * @var array comment widget client options
     */
    public $clientOptions = [];

    /**
     * @var string hash(crc32) from class name of the widget model
     */
    protected $entity;

    /**
     * @var integer primary key value of the widget model
     */
    protected $permlink;

    /**
     * @var string encrypted entity key from params: entity, entityId, relatedTo
     */
    protected $encryptedEntityKey;

    /**
     * Initializes the widget params.
     */
    public function init()
    {
        if (empty($this->model)) {
            throw new InvalidConfigException(Yii::t('yii2mod.comments', 'The "model" property must be set.'));
        }

        if (empty($this->pjaxContainerId)) {
            $this->pjaxContainerId = 'comment-pjax-container-' . $this->getId();
        }

        $this->entity = '2520b329';
        $this->permlink = $this->model->{$this->permlinkAttribute};

        if (empty($this->permlink)) {
            throw new InvalidConfigException(Yii::t('yii2mod.comments', 'The "entityIdAttribute" value for widget model cannot be empty.'));
        }

        if (empty($this->relatedTo)) {
            $this->relatedTo = get_class($this->model) . ':' . $this->permlink;
        }
        
        if (empty($this->author)) {
            $this->author = $this->model->author;
        }

        $this->encryptedEntityKey = $this->generateEntityKey();

        $this->registerAssets();
    }

    /**
     * Executes the widget.
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule(Module::$name);
        $commentModelClass = $module->commentModelClass;
        $commentModel = Yii::createObject([
            'class' => $commentModelClass,
            'entity' => $this->entity,
            'permlink' => $this->permlink,
            'author' => $this->author,
            
        ]);

        $comments = $commentModelClass::getTree($this->entity, $this->relatedTo, $this->maxLevel, $this->showDeletedComments);

        return $this->render($this->commentView, [
            'comments' => $comments,
            'commentModel' => $commentModel,
            'maxLevel' => $this->maxLevel,
            'encryptedEntity' => $this->encryptedEntityKey,
            'pjaxContainerId' => $this->pjaxContainerId,
            'formId' => $this->formId,
            'showDeletedComments' => $this->showDeletedComments
        ]);
    }

    /**
     * Register assets.
     *
     * @return void
     */
    protected function registerAssets()
    {
        $this->clientOptions['pjaxContainerId'] = '#' . $this->pjaxContainerId;
        $this->clientOptions['formSelector'] = '#' . $this->formId;
        $options = Json::encode($this->clientOptions);
        $view = $this->getView();
        CommentAsset::register($view);
        $view->registerJs("jQuery('#{$this->formId}').comment({$options});");
    }

    /**
     * Get encrypted entity key
     *
     * @return string
     */
    protected function generateEntityKey()
    {
        return utf8_encode(Yii::$app->getSecurity()->encryptByKey(Json::encode([
            'entity' => $this->entity,
            'permlink' => $this->permlink,
            'relatedTo' => $this->relatedTo
        ]), Module::$name));
    }
}