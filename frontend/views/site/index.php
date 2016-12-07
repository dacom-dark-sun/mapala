
<script src="//cdn.steemjs.com/lib/latest/steem.min.js"></script>
    <?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;

?>

<?= yii\jui\menu::widget([]) ?>

<div class="site-index">

     <div class="body-content">
        <div class="row">
            <div class="col-lg-11">
               <div id="article-index">

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'_item',
        'summary'=>'',
    ])?>
</div>
            </div>
            <div class="col-lg-1">
                <div class = "category_panel">
                    <div class ="addbutton">
                               <?= Html::a('Пополнить Базу', ['/site/add'], ['class'=>'btn btn-success']) ?>
                   </div
                   <?= $this->render('_categories',['data'=>$data]) ?>
               
                                            
            </div>
        </div>
    
    </div>
    </div>
    
    
    
    
</div>

