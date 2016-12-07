<?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;

?>

<div class="personal_blog_text">
      <?php echo $author ?>
</div>
    <button type="button" class="btn btn-default previous" onclick = " window.history.back();">Назад</button>
  

    <?= Html::a('Отправить сообщение', ['/site/message'], ['class'=>'btn btn-success']) ?>
<div class="site-index">

     <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
               <div id="article-index">

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'_item',
        'summary'=>'',
    ])?>
</div>
            </div>
   
    
    </div>
    </div>
    
    
    
    
</div>

