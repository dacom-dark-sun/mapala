
    <?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;
use yii\widgets\Pjax;

?>
<?php $this->title = Yii::t('frontend','MAPALA'); ?>
<?php 

    $this->registerMetaTag([
        'property' => 'og:title',
        'content' => Yii::t('common','Mapala.net invite you to join the worldwide community')
    ]); 
    $this->registerMetaTag([
        'property' => 'og:description',
        'content' => Yii::t('common','Mapala.net sweeping the planet and inviting you to join. The project will be released soon. Hurry up!')
    ]); 
    $this->registerMetaTag([
        'property' => 'og:url',
        'content' => 'https://mapala.net',
    ]); 
    $this->registerMetaTag([
        'property' => 'og:image',
        'content' => 'https://mapala.net/frontend/web/img/logo_small.png',
    ]); 

?> 
   

<div class="site-index">

     <div class="body-content">
        <div class="row">
            <div class="col-lg-10 col-md-10">
               <div id="article-index">

                   <?php echo \yii\widgets\ListView::widget([
                        'dataProvider'=>$dataProvider,
                      //  'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
                        'itemView'=>'_item',

                        'summary'=>'',
                    ])?>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-ld-push-10 col-md-push-10 category_panel">
                <div class ="static">
                    <div class ='scroll'>
                    <div class ="category_buttons">
                              <?= Html::a(Yii::t('frontend', 'Add Post'), ['/site/add'], ['class'=>'btn btn-danger each_category_button']) ?>
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
    
    
    
    
</div>
