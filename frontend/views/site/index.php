
    <?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;
use yii\widgets\Pjax;

?>


   

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
      
<div class ='categories'>          
                    <div class ="category_buttons">
                              <?= Html::a(Yii::t('frontend', 'Update database'), ['/site/add'], ['class'=>'btn btn-danger each_category_button']) ?>
                              <?= Html::a(Yii::t('frontend', 'New'), ['/site/index/','state'=>'new'], ['class'=>'btn btn-success each_category_button']) ?>
                              <?= Html::a(Yii::t('frontend', 'Trending'), ['/site/index/','state'=>'trending'], ['class'=>'btn btn-success each_category_button']) ?>
                              <?= Html::a(Yii::t('frontend', 'Discuss'), ['/site/index/','state'=>'discuss'], ['class'=>'btn btn-success each_category_button']) ?>
       
                    </div>
                <?= $this->render('_categories',['data'=>$data]) ?>
</div>                            
        </div>
    
    </div>
    </div>
    
    
    
    
</div>

