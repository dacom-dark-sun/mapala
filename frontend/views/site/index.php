
    <?php

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use talma\widgets\JsTreeAsset;
use yii\widgets\Pjax;
/*
 *     
 *         <?= Html::a(Yii::t('frontend', 'New'), ['/site/index/','state'=>'new'], ['class'=>'btn btn-success each_category_button']) ?>
                              <?= Html::a(Yii::t('frontend', 'Trending'), ['/site/index/','state'=>'trending'], ['class'=>'btn btn-success each_category_button']) ?>
                              <?= Html::a(Yii::t('frontend', 'Discuss'), ['/site/index/','state'=>'discuss'], ['class'=>'btn btn-success each_category_button']) ?>
       
 */
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
                  
                    </div>
                    <div class ='col-lg-12'>
                      <div class="panel panel-warning">
                          <div class="panel-heading" style="padding: 5px 15px;">   
                          <center> <?= Yii::t('frontend', 'Warning') ?> </center>
                      </div>
                          <div class="panel-body" style="padding: 6px; font-size: 12px; text-align: center;"><?= Yii::t('frontend', 'This is an experimental version of travel community, that pays money to authors for their articles. We have developed an up to date version that will be p2p tourism portal, based on 3 blockchains. More information on: ') ?> <a href="http://ico.mapala.net" target="_blank">ico.mapala.net</a></div>
                     </div>
                   </div>
            
                
                    <?= $this->render('_categories',['data'=>$data]) ?>
                    </div>
                    </div>
                                            
            </div>
    
            
            
    </div>
    </div>
    
    
    
    
</div>
