<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
use common\models\Art;
use yii\helpers\Url;

?>

<div class="row article-item">
    <div class="col-xs-12">
        <h2 class="article-title">
          
            <?php echo Html::a(stripslashes($model->title),['/site/index/','author'=>$model->author,'permlink'=>$model->permlink],['class'=>'main_page_link']) ?>
        </h2>
                  <div class ="location">

                     <span>
                       <?php if ($model->country !='[]') echo Html::label($model->country, "" ,['class' => 'label label-default', 'onclick' => 'render_single_art(' . $model->country . ')']) ?>
                     </span>
                      <span>
                       <?php if ($model->city !='[]') echo Html::label($model->city, "" ,['class' => 'label label-primary', 'onclick' => 'render_single_art(' . $model->city . ')']) ?>
                     </span>
                      <span>
                       <?php if ($model->category !='[]') echo Html::label($model->category, "" ,['class' => 'label label-success', 'onclick' => 'render_single_art(' . $model->category . ')']) ?>
                     </span>
                     <span>
                       <?php if ($model->sub_category !='[]') echo Html::label($model->sub_category, "" ,['class' => 'label label-danger', 'onclick' => 'render_single_art(' . $model->category . ')']) ?>
                     </span>
          </div>
        <div class="article-content">
            <?php 
            
            $image = $model::get_images($model);
            if (($image)&&(@fopen($image,'r'))):
                 echo  ("<img src=" . $image . " class= 'article-thumb img-rounded pull-left'>");
            else:
               echo "<img src=https://s13.postimg.org/ror54hqyv/logo_small.png class= 'article-thumb img-rounded pull-left'>";
            endif; ?>
            
            <div class="article-text">
                <?php 
                
                echo $model::get_first_line($model) ?>
            </div>
        </div>
             <div class ="col-xs-12 col-lg-9 col-lg-push-1 col-md-push-1 article-metainfo">
     <?= $this->render('_metainfo',['model'=>$model]) ?>
             </div>
    </div>
   
</div>
 <hr>

