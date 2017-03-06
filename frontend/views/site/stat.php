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
                        <center>    <?= Yii::t('frontend', 'Total payments in this week') ?></center>
                    </div>
                    <div class="panel-body">
                  <center>  <?= $total_payout_value ?>    </center>
                    </div>
                       
                </div>
    <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'New registrations per week') ?></center>
                    </div>
                       <div class="panel-body">
                           <center> <?= $users_per_week ?> </center>               
                       </div>
                 
                </div>
     <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'TOTAL PAYMENTS SINCE START') ?></center>
                    </div>
                       <div class="panel-body">
                           <center> <?= $total_payments ?> </center>               
                       </div>
                 
                </div>
    
            </div>

        
        

        
        
        
        
    </div>
    
   <div class = 'col-lg-2'>   
       
    </div>
     
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
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




