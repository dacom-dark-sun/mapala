<?php
use yii\grid\GridView;
use yii\helpers\Html;
use common\models\BitCoin;
use common\models\Art;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php $this->title = Yii::t('frontend','ICO'); ?>


<div class="row">
    <div class="col-lg-12">
  
<div class ='col-xs-3 col-lg-4'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'Personal Bitcoin Address') ?></center>
                    </div>
                    <div class="panel-body">
                  <center>  <?= $total_payout_value ?>    </center>
                    </div>
                    <center> <span class ="link" onclick="btc_info();"> <?= Yii::t('frontend', 'min: 0.002 BTC (100 RUB)')?> </span></center>
                   <center> <span class ="link" onclick="btc_info();"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                       
                </div>
    <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'GBG account') ?></center>
                    </div>
                       <div class="panel-body">
                           <center>  mapala.ico </center>               
                       </div>
                    <center> <span class ="link" onclick="gbg_info();"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                 
                </div>
    
    
            </div>

        <div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                <center>        <?= Yii::t('frontend', 'Weekly income') ?>  </center>
                    </div>
                    <div class="panel-body">
                 <center> BTC </center>
                    </div>
                 <div class="panel-body">
                        <center>  GBG </center>
                    </div>
                    <hr>
                <center> <?= Yii::t('frontend', 'Current rate:') ?></center>
                
                    <center> BTC/MPL </center>
                    
               
                </div>
   </div>

<div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Personal information') ?></center>
                    </div>
                    <div class="panel-body">
                   <center>   BTC</center>
                    </div>
                    <div class="panel-body">
                   <center>   GBG</center>
                    </div>
                    <hr>
                 <div class="panel-body">
                 <center>  <?= Yii::t('frontend', 'Tokens') ?></center>
                    </div>
               
                 <center>    <?=  Html::a(Yii::t('frontend', 'History'), 
                              ['/site/personal_history'], 
                              ['class'=>'btn btn-success change_category_btn']);
                      ?></center>

                </div>
            </div>
        
        
        
<div class ='col-xs-6 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                <center>        <?= Yii::t('frontend', 'Total information') ?>  </center>
                    </div>
                    <div class="panel-body">
                 <center> <?= Yii::t('frontend', 'All investments - ') ?>      BTC </center>
                    </div>
                 <div class="panel-body">
                        <center>  <?= Yii::t('frontend', 'All distributed tokens - ') ?>        </center>
                    </div>
                     <center>    <?=  Html::a(Yii::t('frontend', 'History'), 
                              ['/site/investors'], 
                              ['class'=>'btn btn-success change_category_btn']);
                      ?></center>
               
                </div>
   </div>
        
        
        
        
    </div>
    
   <div class = 'col-lg-2'>   
       
       <button class="btn btn-danger change_category_btn" onclick="bonus_info();"> <?= Yii::t('frontend', 'BONUS TODAY:')?>  %</button>
    </div>
     
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
                    </div>
       <div class="panel-body">
           <b>   <?= Yii::t('frontend', 'Tokens for distribution: 810000')?> </b> 
           
            <?= GridView::widget([
                    'dataProvider' => $data_provider,
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
                        ['attribute' => 'author', 
                         'label' => Yii::t('frontend', 'Username'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                            ],

                        ['attribute' => 'total_pending_payout_value', 
                         'label' => Yii::t('frontend', 'Money'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center'],
                          'value' => function ($model) {
                            return Art::convert_currency($model['total_pending_payout_value']);
                   
                         }
                         ],

                        ['attribute' => 'country', 
                         'label' => Yii::t('frontend', 'tag1'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                        
                            
                        ['attribute' => 'city', 
                         'label' => Yii::t('frontend', 'tag2'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],


                        ['attribute' => 'category', 
                         'label' => Yii::t('frontend', 'category'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'sub_category', 
                         'label' => Yii::t('frontend', 'sub_category'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                                 ]

                            
                       
                ]);?>

           
           
           
       </div>
       </div>
        
           
    
    </div>
    
</div>




