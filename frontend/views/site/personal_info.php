<?php
use yii\grid\GridView;
use yii\helpers\Html;
use common\models\BitCoin;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<div class="row">
    <div class="col-lg-12">
  
<div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'Personal Bitcoin Address') ?></center>
                    </div>
                    <div class="panel-body">
                  <center>      <?= $btc_wallet ?></center>
                    </div>
                    <center> <span class ="link" onclick="alert('test')"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                       
                </div>
    <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'GBG account') ?></center>
                    </div>
                       <div class="panel-body">
                           <center>  mapala.ico </center>               
                       </div>
                    <center> <span class ="link" onclick="alert('test')"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                 
                </div>
    
    
            </div>

       

<div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Personal information') ?></center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= $personal_btc ?> BTC</center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= $personal_gbg ?> GBG</center>
                    </div>
                    <hr>
                 <div class="panel-body">
                 <center> <?= $tokens ?> Tokens</center>
                    </div>
                </div>
            </div>
           
        
        
<div class ='col-xs-6 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                <center>        <?= Yii::t('frontend', 'Total information') ?>  </center>
                    </div>
                    <div class="panel-body">
                 <center> <?= Yii::t('frontend', 'All investments - ') ?>      <?= $total_btc ?> BTC </center>
                    </div>
                 <div class="panel-body">
                        <center>  <?= Yii::t('frontend', 'All distributed tokens - ') ?>       <?= $total_tokens ?> </center>
                    </div>
                     <center>    <?=  Html::a(Yii::t('frontend', 'History'), 
                              ['/site/investors'], 
                              ['class'=>'btn btn-success change_category_btn']);
                      ?></center>
               
                </div>
   </div>
    </div>
    <div class = 'col-lg-2'>   
<?=  Html::a(Yii::t('frontend', '<-- ICO'), 
                              ['/site/ico'], 
                              ['class'=>'btn btn-success change_category_btn']);
                      ?>  
    </div>
    
    <div class ='col-xs-12 col-lg-12'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'History') ?>  
                    </div>
                    <div class="panel-body">

                        <?= GridView::widget([
                                'dataProvider' => $data_provider_for_periods,
                                'summary'=>'', 
                                'tableOptions' => [
                                    'class' => 'table table-striped table-bordered'
                                ],
                                    'columns' => [
                                    /**
                                     * Столбец нумерации. Отображает порядковый номер строки
                                     */
                                    [
                                        'class' => \yii\grid\SerialColumn::class,
                                    ],
                                    /**
                                     * Перечисленные ниже поля модели отображаются как колонки с данными без изменения
                                     */

                                    ['attribute' => 'created_at', 
                                     'label' => Yii::t('frontend', 'Date, Time'),
                                      'format'=>'datetime',  
                                      'contentOptions' => ['class' => 'text-center'],
                                      'headerOptions' => ['class' => 'text-center']

                                        ],
                                     ['attribute' => 'symbol', 
                                     'label' => Yii::t('frontend', 'Currency'),
                                     'contentOptions' => ['class' => 'text-center'],
                                     'headerOptions' => ['class' => 'text-center']
                                     ],

                                    ['attribute' => 'amount', 
                                     'label' => Yii::t('frontend', 'Amount, BTC'),
                                      'contentOptions' => ['class' => 'text-center'],
                                      'headerOptions' => ['class' => 'text-center']
                                    ],
                                     ['attribute' => 'bonuse', 
                                     'label' => Yii::t('frontend', 'Amount, BTC'),
                                      'contentOptions' => ['class' => 'text-center'],
                                      'headerOptions' => ['class' => 'text-center']
                                    ],


                                    ['attribute' => 'currency', 
                                     'label' => Yii::t('frontend', 'Currency'),
                                     'contentOptions' => ['class' => 'text-center'],
                                     'headerOptions' => ['class' => 'text-center']
                                    ],
                                        
                                     ['attribute' => 'bonuse', 
                                      'label' => Yii::t('frontend', 'Bonuse, %'),
                                      'contentOptions' => ['class' => 'text-center'],
                                      'headerOptions' => ['class' => 'text-center']
                                    ],


                               
                                    ['attribute' => 'tokens', 
                                     'label' => Yii::t('frontend', 'Tokens'),
                                      'contentOptions' => ['class' => 'text-center'],
                                      'headerOptions' => ['class' => 'text-center']
                                    ],


                                    /**
                                     * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                                     */],
                            ]);?>

                    </div>
                </div>
            </div>
    
    
    
</div>


