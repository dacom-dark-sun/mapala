<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="row">
    <div class="col-lg-12">
  
        
<div class ='col-xs-6 col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>      <?= Yii::t('frontend', 'All investments, BTC') ?>  </center>
                    </div>
                    <div class="panel-body">
                        <center>    <?= $total_btc ?>
                    </div>
                </div>
   </div>
        
    <div class ='col-xs-6 col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'All distributed tokens') ?>  </center>
                    </div>
                    <div class="panel-body">
                        <center>    <?= $total_tokens ?> </center>
                    </div>
                </div>
   </div>
    </div>  
    
    <div class = 'col-lg-2'>   
<?=  Html::a(Yii::t('frontend', '<-- ICO'), 
                              ['/site/ico'], 
                              ['class'=>'btn btn-success change_category_btn']);
                      ?>  
    </div>
        
        
    </div>
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Distribution')?>  
                    </div>
       <div class="panel-body">
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
                        ['attribute' => 'name', 
                         'label' => Yii::t('frontend', 'Username'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                        ],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                          'contentOptions' => ['class' => 'text-center'],
                          'headerOptions' => ['class' => 'text-center'],

                            ],
                         ['attribute' => 'symbol', 
                         'label' => Yii::t('frontend', 'Currency'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center'],
                        ],

                         ['attribute' => 'bonuse', 
                         'label' => Yii::t('frontend', 'Bonuse, %'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],



                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center'],
                        ],

                        ['attribute' => 'hash', 
                         'label' => Yii::t('frontend', 'Hash'),
                         'format' => 'raw',
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center'],

                         'value' => function ($model) {
                         if ($model['symbol'] == 'GBG'){
                            $block = BitCoin::get_block_from_gbg_table($model['hash']);
                              return '<a target=_blank href=https://golostools.ru/explorer/#method=get_block&params=[' . $block . ']' . '> ' . Yii::t('frontend', 'Link') .'</a>';
                   
                         } else {
                              return '<a target=_blank href=https://blockexplorer.com/tx/' . $model['hash'] . '> ' . Yii::t('frontend', 'Link') .'</a>';
                         } 
        },],


                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>

           
           
           
       </div>
       </div>
        
           
    
    </div>
   
    
    


