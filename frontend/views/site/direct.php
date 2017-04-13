<?php
use yii\grid\GridView;
use yii\helpers\Html;
use common\models\BitCoin;
use miloschuman\highcharts\Highcharts;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php $this->title = Yii::t('frontend','ICO'); ?>


<div class="row">
    <div class="col-lg-12">
        
                <?= $this->render('_line',['current_rate'=>$current_rate, 'total_btc' => $total_btc, 'total_tokens' => $total_tokens]) ?>
       
   
  <?php
 // var_dump($yaxis);
 /* echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Rate'],
      'xAxis' => [
         'categories' => $xaxis
      ],
      'yAxis' => [
         'title' => ['text' => 'BTC/MPL * 1000']
      ],
      'series' => [
         ['name' => 'rate', 'data' => $yaxis],
      ]
   ]
]);*/
  ?>
        
<div class ='col-xs-5 col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'Lots') ?></center>
                    </div>
                    <div class="panel-body">
                       <?= $this->render('_lots',['lots'=>$lots]) ?>
                    </div>
                </div>
            </div>
        
        
<div class ='col-xs-3 col-lg-4'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'Personal Bitcoin Address') ?></center>
                    </div>
                    <div class="panel-body">
                        <center> <input type="text" id="btc_wallet" value="<?= $btc_wallet ?>" readonly>   </center>
                    </div>
                    <center>ВНИМАНИЕ! Минимальная сумма для прямой покупки - 2 BTC. При покупке токенов на меньшую сумму, деньги автоматически перенаправятся в аукцион. </center><br>
                   <center> <span class ="link" onclick="btc_info();"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                        <center> 
                            <span class ="btn btn-success change_category_btn" onclick="copyToClipboard();"> <?= Yii::t('frontend', 'Copy')?> </span>
                        </center>
                </div>
    
    
            </div>

   

<div class ='col-xs-3 col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Personal information') ?></center>
                    </div>
                    <div class="panel-body">
                        
                        <center> <?= Yii::t('frontend', 'Investments: ')?></center>
                        <center>  <?= $personal_btc ?> BTC</center>
                   <center>  <?= $personal_gbg ?> GBG</center>
                   <br>
                    </div>
                    <center> <?= Yii::t('frontend', 'Tokens: ')?></center>
                        
                 <center> <?= round($tokens,2) ?> <?= Yii::t('frontend', 'Mpl') ?></center>
                 <hr>
                 <center><?= Yii::t('frontend', 'Available refferal bonuse: ') . $access_ref . " BTC" ?></center>
                 <br>
                 <div>
                 <center>   <?php echo Html::a(Yii::t('frontend','Withdraw'),['/site/ref'],['class'=>'btn btn-success']) ?></center>
                 </div>
                 <br>
                          <center> 
                           <?= Yii::t('frontend', 'Referal link: ')?>   </center>
                 <center>
                     <input type="text" id="link" style="width: 100%; text-align: center" value="http://mapala.net/site/index?r=<?= Yii::$app->user->identity->username; ?>" readonly>
                            </center>
                 <center>
                            <span class ="btn btn-success change_category_btn" onclick="copyToClipboard_link();"> <?= Yii::t('frontend', 'Copy')?> </span>
                 </center>
            
                 <br>

                </div>
            </div>
        

        
        
        
        
    </div>
    <center><h2> <?= Yii::t('frontend','Direct purchase')?></h2></center>
     
   <div class="col-lg-12">
   <div class="panel panel-info">
           
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
                        
                       

                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'lot', 
                         'label' => Yii::t('frontend', 'Lot'),
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


<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Instruction SBD') . '</h2>',
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
            'header' => '<h2>' . Yii::t('frontend', 'Instruction BTC') . '</h2>',
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
            'header' => '<h2>' . Yii::t('frontend', 'CURRENT BONUS:') . '</h2>',
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
    
    function copyToClipboard() {
       var element = $('#btc_wallet').select(); 
        document.execCommand("copy");
    }
    
    function copyToClipboard_link(){
        var element = $('#link').select(); 
        document.execCommand("copy");
    }
    
</script>




