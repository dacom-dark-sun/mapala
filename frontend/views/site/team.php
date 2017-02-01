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
<?php $this->title = Yii::t('frontend','ICO'); ?>


<div class="row">
    
    
    <div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Total information') ?></center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= $total_btc ?> team BTC </center>
                   <br>
                   <center>  <?= $current_rate ?> BTC/MPL</center>
                   
                    </div>
                 
                

                </div>
            </div>

    <div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Personal information') ?></center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= $personal_tokens ?> Tokens</center>
                    </div>
                   
     <center>   <button type="button" class="btn btn-danger previous" onclick = "wd();">Продать токены</button></center>
     <br>
                </div>
    </div>
    
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
       <div class="panel-body">
                      <b>   <?= Yii::t('frontend', 'Team Tokens')?> </b> 

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
    
    <div class="col-lg-12">
   <div class="panel panel-info">
       <div class="panel-body">
           <b>   <?= Yii::t('frontend', 'Withdraws')?> </b> 
           
            <?= GridView::widget([
                    'dataProvider' => $wd_provider,
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
                         'headerOptions' => ['class' => 'text-center']
                            ],
                        ['attribute' => 'rate', 
                         'label' => Yii::t('frontend', 'Rate'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                            ],

                      
                        ['attribute' => 'btc', 
                         'label' => Yii::t('frontend', 'BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                         ['attribute' => 'btc_address', 
                         'label' => Yii::t('frontend', 'Address'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                             ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                        ['attribute' => 'status', 
                         'label' => Yii::t('frontend', 'Status'),
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


<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Withdraw') . '</h2>',
            'id' => 'withdraw',
            'size' => 'modal-xs',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:200px']
        ]);
        
        echo $this->context->renderPartial('/site/wd', ['model' => $model]);
        yii\bootstrap\Modal::end();

        ?>




<script>
    function wd(){
       $('#withdraw').modal('show');
       
    }
    
</script>




