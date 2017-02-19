<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\BlockChain;

/* @var $this \yii\web\View */
/* @var $commentModel \yii2mod\comments\models\CommentModel */
/* @var $encryptedEntity string */
/* @var $formId string comment form id */
?>
<div class="comment-form-container">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => $formId,
            'class' => 'comment-box'
        ],
        'action' => Url::to(['/comment/default/create', 'entity' => $encryptedEntity]),
        'validateOnChange' => false,
        'validateOnBlur' => false
    ]); ?>

    <?php echo $form->field($commentModel, 'content', ['template' => '{input}{error}'])->textarea(['placeholder' => Yii::t('yii2mod.comments', 'Add a comment...'), 'rows' => 4]) ?>
    <?php echo $form->field($commentModel, 'parent_permlink', ['template' => '{input}'])->hiddenInput(['data' => ['comment' => 'parent-id']]); ?>
    <?php echo $form->field($commentModel, 'permlink', ['template' => '{input}'])->hiddenInput(['data' => ['comment' => 'permlink']]); ?>
    <?php echo $form->field($commentModel, 'author', ['template' => '{input}'])->hiddenInput(['data' => ['comment' => 'author']]); ?>
    
    <div class="comment-box-partial">
        <div class="button-container show">
            <?php echo Html::a(Yii::t('yii2mod.comments', 'Click here to cancel reply.'), '#', ['id' => 'cancel-reply', 'class' => 'pull-right', 'data' => ['action' => 'cancel-reply']]); ?>
            <?php echo Html::Button(Yii::t('yii2mod.comments', 'Comment'), ['class' => 'btn btn-primary comment-submit', 'onclick' => 'send_comment($(this))']); ?>
        </div>
    </div>
    <div class ="comment_info"><a href = "https://guides.github.com/features/mastering-markdown" target="_blank"><?php echo Yii::t('frontend', 'You can use Markdown syntax'); ?></a></div>
 <div class ="loader_head"  style="display: none;">Transaction...
       <div class = 'loader_comment' ></div>
       </div>
       <div class="account_name"></div>    
    <?php $form->end(); ?>
   
     <div class="clearfix"></div>
</div>

   

  <script>    
      $( document ).ready(function() {
     var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
       acc = getCookie(acc);
       if (acc){
          $('.account_name').text(acc);
       } else {
         $('<a id="key_modal_ask"><?php echo Yii::t('frontend', 'please enter Steem private posting key') ?></a>').appendTo('.account_name');
         $(".comment-submit").attr("disabled", true);
       }
   
});
       
    $('#<?=$formId?>').on('afterSubmit', function () {
          $('.loader_head').css('display', 'none');
    });

   $(".account_name").click(function() {
      $('#modalKey').modal('show');
   });
    
        
  </script>