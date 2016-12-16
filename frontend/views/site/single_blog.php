<?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;


?>


    <button type="button" class="btn btn-default previous" onclick = " window.history.back();">Назад</button>
  

<div class="site-index">
     <div class="body-content">
        <div class="row">
            <div class="col-lg-10">
               <div id="article-index">

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
      //  'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'_item',
        'summary'=>'',
    ])?>
</div>
            </div>
                <div class="col-lg-2 category_panel">
                    <div class="personal_blog_text">
                          <?php echo $author ?>

                    </div>
                
                    <div class ="category_buttons">
                              <?= Html::Button('Отправить сообщение', ['class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
                    </div>
        </div>
   
    
    </div>
    </div>
    
    
    
    
</div>

