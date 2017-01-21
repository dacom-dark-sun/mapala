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
  
<div class ='col-xs-3 col-lg-4'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'Personal Bitcoin Address') ?></center>
                    </div>
                    <div class="panel-body">
                  <center>      <?= $btc_wallet ?></center>
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
                 <center> <?= $weekly_btc ?> BTC </center>
                    </div>
                 <div class="panel-body">
                        <center><?= $weekly_gbg ?> GBG </center>
                    </div>
                     
               
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
                 <center> <?= $tokens ?> <?= Yii::t('frontend', 'Tokens') ?></center>
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
       
       <button class="btn btn-danger change_category_btn" onclick="bonus_info();"> <?= Yii::t('frontend', 'BONUS TODAY:')?> <?= $bonuse_today; ?> %</button>
    </div>
     
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Distribution') . '     (' . $interval['date_start'] . ' - ' . $interval['date_end'] . ')  UTC   '?>  
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
                         'label' => Yii::t('frontend', 'Bonuse, %'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],


                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'stake', 
                         'label' => Yii::t('frontend', 'Week stake, %'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
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
    
</div>


<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Instruction GBG') . '</h2>',
            'id' => 'gbginfo',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('/site/gbginfo');
        yii\bootstrap\Modal::end();

        ?>


<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Instruction GBG') . '</h2>',
            'id' => 'btcinfo',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('/site/btcinfo', ['btc_wallet' => $btc_wallet]);
        yii\bootstrap\Modal::end();

        ?>
<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Bonuses:') . '</h2>',
            'id' => 'bonusinfo',
            'size' => 'modal-xs',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('/site/bonusinfo', ['btc_wallet' => $btc_wallet]);
        yii\bootstrap\Modal::end();

        ?>


<script>
    function gbg_info(){
       $('#gbginfo').modal('show');
       
    }
    
     function btc_info(){
       $('#btcinfo').modal('show');
       
    }
    
     function bonus_info(){
       $('#bonusinfo').modal('show');
       
    }
    
    
</script>




