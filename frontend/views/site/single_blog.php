<?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;

$this->title = '@' . $author;
?>

<div class ="site-index">
    <button type="button" class="btn btn-default previous" onclick = " window.history.back();">Назад</button>
     <div class="body-content">
        <div class="row">
             <div class="col-xs-12 col-lg-2 col-md-2 col-sm-2 col-lg-push-10 col-md-push-10 col-sm-push-10 category_panel">
                    <div class="personal_blog_text">
                          <?php echo $author ?>

                    </div>
                
                    <div class ="category_buttons">
                              <?php // echo Html::Button('Отправить сообщение', ['class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
                    </div>
        </div>
            <div class="col-xs-12 col-lg-10 col-md-10 col-sm-10">
               <div id="article-index">

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
      //  'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'_item',
        'summary'=>'',
    ])?>
</div>
            </div>
               
   
    
    </div>
    </div>
    
    
    
    
</div>

