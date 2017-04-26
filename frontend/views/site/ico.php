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
         <?= $this->render('_rate',['xaxis'=>$xaxis, 'yaxis' => $yaxis, 'fast_yaxis' => $fast_yaxis]) ?>
   
        
       
     <div class ='col-lg-5'>
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
                            <center> <?= Yii::t('frontend', 'Tokens for distribution: 810000') ?>
                        </div>
                 
                        <?= Html::a(Yii::t('frontend','Auction'), ['/site/auction'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                      
                    </div>
                </div>
    </div>
        
        <div class ='col-lg-2' style="text-align: center;"> 
            <?php IF (!Yii::$app->user->isGuest):?>
            
            
            <div class ='col-xs-12 col-lg-12'>
                <div class="panel panel-danger">
                    <div class="panel-heading">   
                    <center>    <?= Yii::t('frontend', 'Personal information') ?></center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= Bitcoin::get_personal_btc(); ?> BTC</center>
                    </div>
                    <div class="panel-body">
                   <center>  <?= Bitcoin::get_personal_gbg(); ?> GBG</center>
                    </div>
                    <hr>
                 <div class="panel-body">
                 <center> <?= BitCoin::get_tokens() ?> Tokens</center>
                    </div>
                </div>
            </div>
           
            <?php ENDIF ; ?>
              <center><?=  Html::a(Yii::t('frontend', 'FAQ'), 
                              ['/site/icofaq/'], 
                              ['class'=>'btn btn-success change_category_btn width_100']);?></center>
            
            
              <center><?=  Html::a(Yii::t('frontend', 'History investments'), 
                              ['/site/investors'], 
                              ['class'=>'btn btn-success change_category_btn width_100']);?></center>
            
            <center><?=  Html::a(Yii::t('frontend', 'Blog Mapala-Team'), 
                              ['/mapala'], 
                              ['class'=>'btn btn-success change_category_btn width_100']);?></center>
            
       </div>
        
            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                      <center>  <b>  <?= Yii::t('frontend', 'Direct purchase') ?> </b></center>
                    </div>
               <div class="panel-body">
                <?= $this->render('_lots',['lots'=>$lots]) ?>
                 
                 
                 
                 
                 
                    <?= Html::a(Yii::t('frontend','Purchase'), ['/site/direct'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                      
                     </div>
                  
            </div>
            </div>
        

        
  
        
        
        
        
    </div>
    
   
     
    
    
    
    
</div>



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




