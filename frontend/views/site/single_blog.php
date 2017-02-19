<?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;
use common\models\BlockChain;
$this->title = '@' . $author;
?>

<div class ="site-index">
    <button type="button" class="btn btn-default previous" onclick = " window.history.back();"><?= Yii::t('frontend','Back')?></button>
     <div class="body-content">
        <div class="row">
             <div class="col-xs-12 col-lg-2 col-md-2 col-sm-2 col-lg-push-10 col-md-push-10 col-sm-push-10 category_panel">
                    <div class="personal_blog_text">
                          <?php echo $author ?>
                        <div class="undefined" style="cursor:pointer"></div>
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

<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Key STEEM') . '</h2>',
            'id' => 'modalKey',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('@frontend/modules/user/views/keys/keysForm');
        yii\bootstrap\Modal::end();

        ?>

<script>
var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
       acc = getCookie(acc);
       if (!acc){
         $('<a id="key_modal_ask"><?php echo Yii::t('frontend', 'please enter Steem private posting key') ?></a>').appendTo('.undefined');
         $(":submit").attr("disabled", true);
       } 
       
    $(".undefined").click(function() {
      $('#modalKey').modal('show');
    });
</script>