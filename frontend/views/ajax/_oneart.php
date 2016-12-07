<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>

<?php
use \yii2mod\comments;
use yii\widgets\Pjax;
use dosamigos\editable\EditableAddressAsset;
use dosamigos\editable\Editable;
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>
<button type="button" class="btn btn-default previous" onclick = "back()">Назад</button>
<hr/>
<div class="article-full row">
    <div class="col-xs-12">
        <h2 class="article-title">
              <?php echo Html::label($model->title, "" ,['class' => 'onepage_link']) ?>
        </h2>
          <div class ="location">
                     <span>
                       <?php echo Html::label($model->country, "" ,['class' => 'label label-default', 'onclick' => 'render_single_tag(' . $model->country . ')']) ?>
                     </span>
                      <span>
                       <?php echo Html::label($model->city, "" ,['class' => 'label label-primary', 'onclick' => 'render_single_tag(' . $model->city . ')']) ?>
                     </span>
                      <span>
                       <?php echo Html::label($model->category, "" ,['class' => 'label label-success', 'onclick' => 'render_single_tag(' . $model->category . ')']) ?>
                     </span>
          </div>
        
        <div class="article-content">
            <div class="article-text">
            
           <?php 
             $show = str_replace("\\n", "<p/>", $model->body);
             $show = \kartik\markdown\Markdown::convert($show);
             echo $show; 
           ?>
            </div>
        </div>
       
    </div>
        <div class="article-metainfo">
            <?= $this->render('/site/_metainfo',['model'=>$model]) ?>
        </div>  
    
</div>

<div id ="comments">
<?php Pjax::begin() ?>
<?php echo \yii2mod\comments\widgets\Comment::widget([
    'model' => $model,
    'clientOptions' => [
        'pjaxSettings' => [
            'timeout' => 0,
            'url' => \yii\helpers\Url::to(['/ajax/comments', 'permlink' => $model->permlink]),
            'scrollTo' => false,
            'enablePushState' => true
        ]
    ]
]);
Pjax::end();?>
</div>


<script>

function back(){
    $.ajax({
         method: "GET",
         data: {},
         url: '<?php echo Yii::$app->request->baseUrl . '/ajax/back' ?>',
         success: function(view) {
             if (view != 'null')
                $('#article-index').html(view);
            else alert('undefined');
         }
     });
}



</script>
