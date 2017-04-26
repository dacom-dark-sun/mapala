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
           <div class ='col-xs-6 col-lg-2'>
                    <div class="panel panel-success">
                    <div class="panel-heading">   
                      <center>  <b>  <?= Yii::t('frontend', 'Auction') ?> </b></center>
                       </div>
                    <div class="panel-body">
                    <center>        <?= Yii::t('frontend', 'Weekly income') ?>  </center>
                    <center>BTC: <?= $weekly_btc ?> </center>
                    <div class="panel-body">
                        <center>GBG: <?= $weekly_gbg ?> </center>
                        <hr>
                       
                        <center><?= Yii::t('frontend','Total: ') . '$' . $total_usd ?>
                   </div>
                    <div class ="col-lg-12">
                        <button class="btn btn-danger change_category_btn" style="white-space: normal;" onclick="bonus_info();"> <?= Yii::t('frontend', 'CURRENT BONUS:')?> <?= $bonuse_today; ?> %</button>
                    </div>
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
                   <center> <span class ="link" onclick="btc_info();"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                        <center> 
                            <span class ="btn btn-success change_category_btn" onclick="copyToClipboard();"> <?= Yii::t('frontend', 'Copy')?> </span>
                        </center>
                </div>
            </div>

        
    
    <div class ='col-xs-12 col-lg-3'>
    <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>    <?= Yii::t('frontend', 'GBG account') ?></center>
                    </div>
                       <div class="panel-body">
                           <center>  mapala.ico </center>               
                       </div>
                    <center> <span class ="link" onclick="gbg_info();"> <?= Yii::t('frontend', 'INSTRUCTION')?> </span></center>
                 
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
                 <br>
                   <center> <?= Yii::t('frontend', 'Bounty: ') ?> <center>
                    <?= Bitcoin::get_bounty() ?> Mpl
                 </div>
       
            </div>
        



        
        
    </div>
    
    <div class ="col-lg-12"> 
        <?php echo Html::a(Yii::t('frontend','<-- ICO'),['/site/ico/'],['class'=>'btn btn-success']) ?>
    
    </div>
    
    <center><h2> <?= Yii::t('frontend','Auction')?></h2></center>
   
     
    
    
    <div class="col-lg-12">
   <div class="panel panel-info">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Distribution of tokens') . '     (' . $interval['date_start'] . ' - ' . $interval['date_end'] . ')  UTC   '?>  
                    </div>
       <div class="panel-body">
           <b>   <?= Yii::t('frontend', 'Tokens for distribution: 810000')?> </b> 
           <?= $this->render('_weekly_auct',['data_provider'=>$data_provider]) ?>
           

           
           
           
       </div>
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
    
    
</script>




