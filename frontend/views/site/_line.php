<div class ='col-lg-12'>
               <div class="panel panel-success">
                    <div class="panel-heading">
                        
                        <center>   
                        <span class ="line_rate"><b><?= Yii::t('frontend', 'Current rate: ') ?></b> <?= $current_rate * 1000000 ?> * 10<sup>-6</sup> BTC/MPL </span> 
                        <span class ="line_rate"><b> <?= Yii::t('frontend', 'Investments: ') ?> </b>     <?= $total_btc ?> BTC</span>
                        <span class ="line_rate" style="margin-right: 0px"><b> <?= Yii::t('frontend', 'Distributed tokens: ') ?></b>       <?= round($total_tokens) ?> MPL </span>
                        </center>    
                    </div>
                        </div>
                    </div>
            
                      