
<?php
use yii\widgets\Pjax;
use dosamigos\editable\EditableAddressAsset;
use dosamigos\editable\Editable;
use common\models\Art;
use common\models\BlockChain;
use kartik\social\FacebookPlugin;
use yii\helpers\BaseUrl;

/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
 
            
    $image = $model::get_images($model);
    if (($image)&&(@fopen($image,'r'))):
         $image = $image;
    else:
       $image = "https://mapala.net/frontend/web/img/logo_small.png";
    endif; 


$this->title = $model->title;
    $this->registerMetaTag([
        'property' => 'og:title',
        'content' => $model->title,
    ]); 
    $this->registerMetaTag([
        'property' => 'og:description',
        'content' => Art::get_first_line($model),
    ]); 
    $this->registerMetaTag([
        'property' => 'og:url',
        'content' => 'https://mapala.net' . Yii::$app->request->url,
    ]); 
    $this->registerMetaTag([
        'property' => 'og:image',
        'content' => $image,
    ]);
    $this->registerMetaTag([
        'property' => 'og:type',
        'content' => 'website'
    ]);
    

$this->title = $model->title;
    $this->registerMetaTag([
        'itemprop' => 'og:title',
        'content' => $model->title,
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:description',
        'content' => Art::get_first_line($model),
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:url',
        'content' => 'https://mapala.net' . Yii::$app->request->url,
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:image',
        'content' => $image,
    ]);
    $this->registerMetaTag([
        'itemprop' => 'og:type',
        'content' => 'website'
    ]);
    
    $this->registerMetaTag([
        'itemprop' => 'og:title',
        'content' => $model->title,
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:description',
        'content' => Art::get_first_line($model),
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:url',
        'content' => 'https://mapala.net' . Yii::$app->request->url,
    ]); 
    $this->registerMetaTag([
        'itemprop' => 'og:image',
        'content' => $image,
    ]);
    $this->registerMetaTag([
        'itemprop' => 'og:type',
        'content' => 'website'
    ]);


?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8&appId=1794193514175666";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class ="site-index">
<button type="button" class="btn btn-default previous" onclick = "window.history.back();"><?= Yii::t('frontend','Back')?></button>
<?php echo Html::a(Yii::t('frontend','Author blog'),['/site/index/','author'=>$model->author],['class'=>'btn btn-default previous']) ?>
       
<hr/>
<div class="article-full row">
    <div class="col-xs-12 col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 article-column">
        <h2 class="article-title">
              <?php echo Html::label($model->title, "" ,['class' => 'onepage_link']) ?>
        </h2>
          <div class ="location">
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

        <div class="col-xs-12 col-lg-12 col-md-12 col-lg-push-1 col-md-push-1 article-metainfo">

            <?= $this->render('/site/_metainfo',['model'=>$model]) ?>
         
            
            <?php 
            $model_name = Art::get_current_model($model);?>
      
        </div>
       <div class ="col-xs-12 col-lg-12 col-md-12 edit-button text-center">
       
        <div class="fb-share-button" data-href=" <?= 'https://mapala.net' . Yii::$app->request->url ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"><?= Yii::t('frontend','Share')?></a></div>
       </div>
       
        
       <div class ="col-xs-12 col-lg-12 col-md-12 edit-button text-center">
              <?php echo Html::a(Yii::t('frontend', 'Edit'),['forms/' . $model_name . '/','author'=>$model->author,'permlink'=>$model->permlink],['class'=>'btn btn-warning edit_link']) ?>
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