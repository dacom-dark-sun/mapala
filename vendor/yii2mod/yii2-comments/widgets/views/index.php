<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $comments array */
/* @var $commentModel \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */
/* @var $encryptedEntity string */
/* @var $pjaxContainerId string */
/* @var $formId string comment form id */
/* @var $showDeletedComments boolean show deleted comments. */
?>
<?php Pjax::begin(['enablePushState' => false, 'timeout' => 20000, 'id' => $pjaxContainerId]); ?>
<?php  $this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); ?>

<div class="comments row">
    <div class="col-md-12 col-sm-12">
        <div class="title-block clearfix">
            <h3 class="h3-body-title">
                <?php echo Yii::t('yii2mod.comments', "Comments", $commentModel->getCommentsCount($showDeletedComments ? false : true)); ?>
                <?php echo Html::hiddenInput('relatedTo', $commentModel->permlink, ['id' => 'relatedTo']); ?>
                <?php echo Html::hiddenInput('author', $commentModel->author, ['id' => 'main_author']); ?>
               
            </h3>
            <div class="title-separator"></div>
        </div>
        <ol class="comments-list">
            <?php echo $this->render('_list', ['comments' => $comments, 'maxLevel' => $maxLevel]) ?>
        </ol>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php echo $this->render('_form', [
                'commentModel' => $commentModel,
                'encryptedEntity' => $encryptedEntity,
                'formId' => $formId
            ]); ?>
        <?php endif; ?>
    </div>
</div>
<?php Pjax::end(); ?>
<script>
     function send_comment($this){
        var author;
        var body;
        var parent_permlink = $this[0].form[2].form[2].defaultValue; //get parent_permlink
        if (parent_permlink == '') 
        {                                                   //if '' that mean, this reply for main article and need take a main permlink from hidden input
            parent_permlink = $('#relatedTo').val();
            author = $('#main_author').val();
        } else {
            parent_permlink = $this[0].form[2].form[2].defaultValue;  //get parent_permlink for simple reply
            author = $this[0].form[1].offsetParent.lastElementChild.children[1].childNodes[7].firstChild.parentElement.firstElementChild.innerText; //get parent author
        }
        body = $this[0].form[2].form[1].value;        //get body new comment get body
            
        alert(author);
        alert(parent_permlink);
        alert(body);
        $this.submit();
    }
    
    </script>