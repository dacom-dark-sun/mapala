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
                       <?php echo Html::label($model->country, "" ,['class' => 'label label-default', 'onclick' => 'render_single_art(' . $model->country . ')']) ?>
                     </span>
                      <span>
                       <?php echo Html::label($model->city, "" ,['class' => 'label label-primary', 'onclick' => 'render_single_art(' . $model->city . ')']) ?>
                     </span>
                      <span>
                       <?php echo Html::label($model->category, "" ,['class' => 'label label-success', 'onclick' => 'render_single_art(' . $model->category . ')']) ?>
                     </span>
          </div>
        <div class="article-content">
            <?php 
            
            if ($images = $model::get_images($model)):
                 echo  ("<img src=" . $images . " class= 'article-thumb img-rounded pull-left'>");
            else:
               echo "<img src=https://s13.postimg.org/ror54hqyv/logo_small.png class= 'article-thumb img-rounded pull-left'>";
            endif; ?>
            
            <div class="article-text">
                <?php 
                
                echo $model::get_first_line($model) ?>
            </div>
        </div>
        <div class="article-metainfo">
     <?= $this->render('_metainfo',['model'=>$model]) ?>
        </div>  
    </div>
        <hr/>
</div>

