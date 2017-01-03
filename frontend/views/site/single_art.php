
<?php
use yii\widgets\Pjax;
use dosamigos\editable\EditableAddressAsset;
use dosamigos\editable\Editable;
use common\models\Art;
use common\models\BlockChain;
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>
<div class ="site-index">
<button type="button" class="btn btn-default previous" onclick = "window.history.back();">Назад</button>
<?php echo Html::a("Блог Автора",['/site/index/','author'=>$model->author],['class'=>'btn btn-default previous']) ?>
       
<hr/>
<div class="article-full row">
    <div class="col-xs-12 col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 article-column">
        <h2 class="article-title">
              <?php echo Html::label($model->title, "" ,['class' => 'onepage_link']) ?>
        </h2>
          <div class ="col-xs-12 col-lg-12 col-md-12 location">
                          <span>
                       <?php if ($model->country !='[]') echo Html::label($model->country, "" ,['class' => 'label label-default']) ?>
                     </span>
                      <span>
                       <?php if ($model->city !='[]') echo Html::label($model->city, "" ,['class' => 'label label-primary']) ?>
                     </span>
                      <span>
                       <?php if ($model->category !='[]') echo Html::label($model->category, "" ,['class' => 'label label-success']) ?>
                     </span>
                     <span>
                       <?php if ($model->sub_category !='[]') echo Html::label($model->sub_category, "" ,['class' => 'label label-danger']) ?>
                     </span>
        </div>
        
        <div class="article-content">
            <div class="article-text">
            
           <?php 
             $body = \common\models\Art::get_body($model);
             $body = str_replace("\\n", "<p/>", $body);

             echo $body; 
           ?>
            </div>
        </div>
       
     <div class ="additional-info">
         <hr>
         <?= $this->render('/site/_addmetainfo',['model'=>$model]) ?>

     </div>

        <div class="col-xs-12 col-lg-12 col-md-12 col-lg-psh-1 col-md-push-1 article-metainfo">

            <?= $this->render('/site/_metainfo',['model'=>$model]) ?>
            <?php 
            $model_name = Art::get_current_model($model);?>
            <?php echo Html::a(Yii::t('frontend', 'Edit'),['forms/' . $model_name . '/','author'=>$model->author,'permlink'=>$model->permlink],['class'=>'edit_link']) ?>
      
        </div>
                <div id ="comments">
        <?php echo common\modules\comments\widgets\Comment::widget([
            'model' => $model,
            'clientOptions' => [
                'pjaxSettings' => [
                    'timeout' => 20000,
                    'url' => \yii\helpers\Url::to(['/site/comments', 'permlink' => $model->permlink]),
                    'scrollTo' => false,
                    'enablePushState' => false
                ]
            ]
        ]);?>
        </div>

        </div>  


    
</div>

</div>

<?php echo Html::hiddenInput('relatedTo', $model->permlink, ['id' => 'relatedTo']); ?>
<?php echo Html::hiddenInput('author', $model->author, ['id' => 'main_author']); ?>
<?php echo Html::hiddenInput('category', $model->parent_permlink, ['id' => 'category']); ?>
                

        


<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Ключ Golos') . '</h2>',
            'id' => 'modalKey',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('@frontend/modules/user/views/keys/keysForm');
        yii\bootstrap\Modal::end();

        ?>

<script>
var blockchain = '<?php echo BlockChain::get_blockchain_from_locale() ?>';
var account = blockchain.toLowerCase() + 'ac';
    account = getCookie(account);
var main_author = $('#main_author').val();
if (account == main_author)
    $('.edit_link').show();

</script>