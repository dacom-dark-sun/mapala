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
  
        
<div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'All investments, BTC') ?>  
                    </div>
                    <div class="panel-body">
                        <?= $total_btc ?>
                    </div>
                </div>
   </div>
        
    <div class ='col-xs-6 col-lg-2'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'All distributed tokens') ?>  
                    </div>
                    <div class="panel-body">
                        <?= $total_tokens ?>
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
                         'label' => Yii::t('frontend', 'Username')],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                            ],

                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC')],

                       

                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens')],

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
   
    
    
</div>


