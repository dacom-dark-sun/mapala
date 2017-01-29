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
  
<div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Personal Bitcoin Address') ?>
                    </div>
                    <div class="panel-body">
                        <?= $btc_wallet ?>
                    </div>
                </div>
            </div>

<div class ='col-xs-3 col-lg-2'>
                <div class="panel panel-warning">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Your investments, BTC') ?>
                    </div>
                    <div class="panel-body">
                        <?= $amount ?>
                    </div>
                </div>
            </div>
        
        
<div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-warning">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Your Tokens') ?>  
                    </div>
                    <div class="panel-body">
                        <?= $tokens ?>
                    </div>
                </div>
            </div>
        
<div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'All investments, BTC') ?>  
                    </div>
                    <div class="panel-body">
                        <?= $total_btc ?> <a href="/site/investors"> <?=Yii::t('frontend', '(more...)')?> </a>
                    </div>
                </div>
   </div>
        
<div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'All distributed tokens') ?> 
                    </div>
                    <div class="panel-body">
                        <?= $total_tokens ?> <a href="/site/investors"> <?=Yii::t('frontend', '(more...)')?> </a>  
                    </div>
                </div>
   </div>
        
        
        
    </div>
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Distribution') . '     (' . $interval['date_start'] . ' - ' . $interval['date_end'] . ')     '?>  
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
                        ['attribute' => 'name', 
                         'label' => Yii::t('frontend', 'Username')],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                            ],

                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC')],
                        
                        ['attribute' => 'currency', 
                         'label' => Yii::t('frontend', 'Currency')],

                            
                        ['attribute' => 'bonuse', 
                         'label' => Yii::t('frontend', 'Bonuse, %')],


                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens')],

                        ['attribute' => 'stake', 
                         'label' => Yii::t('frontend', 'Week stake, %')],

                            
                        ['attribute' => 'hash', 
                         'label' => Yii::t('frontend', 'Hash'),
                         'format' => 'raw',
                         'value' => function ($model) {
              
                              return '<a target=_blank href=https://blockexplorer.com/tx/' . $model['hash'] . '> ' . Yii::t('frontend', 'Link') .'</a>';
                
        },],


                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>

           
           
           
       </div>
       </div>
        
           
    
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
                                        ],

                                    ['attribute' => 'amount', 
                                     'label' => Yii::t('frontend', 'Amount, BTC')],

                                    ['attribute' => 'currency', 
                                     'label' => Yii::t('frontend', 'Currency')],

                               
                                    ['attribute' => 'tokens', 
                                     'label' => Yii::t('frontend', 'Tokens')],


                                    /**
                                     * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                                     */],
                            ]);?>

                    </div>
                </div>
            </div>
    
    
    
</div>


