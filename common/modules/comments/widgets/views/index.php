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
    <div class="col-md-12 col-sm-12 comments_column">
        <div class="title-block clearfix">
            <h3 class="h3-body-title">
                <?php echo Yii::t('yii2mod.comments', "Comments", $commentModel->getCommentsCount($showDeletedComments ? false : true)); ?>
               
            </h3>
            <div class="title-separator"></div>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php echo $this->render('_form', [
                'commentModel' => $commentModel,
                'encryptedEntity' => $encryptedEntity,
                'formId' => $formId
            ]); ?>
         <?php else: ?>
        <div class="description_comments"> 
        <?php echo Yii::t('frontend','Authors get paid when people like you upvote their post. If you enjoyed what you read here, earn $4.50 of STEEM Power when you Sign Up and vote for it.')?>
        </div>
        <?php endif; ?>
        
        
        <ol class="comments-list">
            <?php echo $this->render('_list', ['comments' => $comments, 'maxLevel' => $maxLevel]) ?>
        </ol>
        
        
    </div>
</div>
<?php Pjax::end(); ?>
 


<script>
    
function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
    
     function send_comment($this){
        $('.loader_head').css('display', 'inline');
        var data;
        var category = $('#category').val(); //get category main article
        var parentPermlink = $this[0].form[2].form[3].defaultValue; //get parent_permlink
        var parentAuthor = $this[0].form[2].form[4].defaultValue; //get parent_permlink
        
        var body = $this[0].form[2].form[1].value;        //get body new comment get body
        
        data = JSON.stringify({parentAuthor, parentPermlink, body, category});
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/ajax/send_comment/' ?>',
            type: "post",
     
            data   : {data: data},
            success: function (comment_data) 
            {
                console.log(comment_data);
                  reply(comment_data, function comment_callback(result){
                      $this.submit();
                });
            },
            error  : function (xhr, ajaxOptions, thrownError) 
            {
               console.log('internal server error');
            }
            });
            
            
       
    }
    
    </script>