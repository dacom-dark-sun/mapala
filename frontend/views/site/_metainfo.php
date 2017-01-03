
<?php 
use yii\helpers\Html;
use kartik\popover\PopoverX;
use common\models\Art;
use common\models\BlockChain;
?>
     <div class ="col-xs-12 col-lg-9 article-metainfo">
        
           <div class="col-xs-4 col-lg-2 article-author">
            <?php echo Yii::t('frontend', 'автор: ') ?><?php echo Html::a(stripslashes($model->author),['/site/index/','author'=>$model->author]) ?>
           
          </div>
            <div class="col-xs-4 col-lg-2 article-total_pending_payout_value">
                <?php echo $model->convert_currency($model->total_pending_payout_value)?>
            
            </div>
            <div class="col-xs-4 col-lg-2 article-date left_margin">
                <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            
            </div>
           
            <div class="col-xs-4 col-lg-2 Icon voters">
                <svg id="Capa_1" version="1.1" viewBox="0 0 100 88" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M100,88c0,0-0.197-18.934-1.354-20.896c-1.721-2.923-5.729-4.932-13.17-8.041c-7.416-3.101-9.787-5.716-9.787-11.316 c0-3.364,2.264-2.264,3.26-8.419c0.412-2.555,2.412-0.043,2.795-5.872c0-2.324-1.092-2.903-1.092-2.903s0.555-3.437,0.771-6.084 c0.27-3.298-1.662-11.815-11.955-11.815c-10.295,0-12.225,8.518-11.955,11.815c0.217,2.647,0.77,6.084,0.77,6.084 s-1.09,0.579-1.09,2.903c0.383,5.829,2.381,3.317,2.795,5.872c0.994,6.155,3.26,5.056,3.26,8.419c0,3.807-1.102,6.235-4.137,8.375 c16.203,8.111,18.375,9.764,18.375,17.015V88H100z M51.117,61.877c-9.891-4.134-13.051-7.621-13.051-15.086 c0-4.483,3.02-3.019,4.346-11.228c0.549-3.404,3.217-0.056,3.727-7.829c0-3.098-1.455-3.868-1.455-3.868s0.74-4.583,1.029-8.112 C46.072,11.357,43.498,0,29.771,0C16.047,0,13.471,11.357,13.832,15.754c0.289,3.529,1.027,8.112,1.027,8.112 s-1.455,0.77-1.455,3.868c0.512,7.773,3.178,4.425,3.729,7.829c1.326,8.208,4.346,6.744,4.346,11.228 c0,7.465-3.162,10.952-13.051,15.086C5.414,63.137,0,65.088,0,69.783V88h69.469c0,0,0-10.776,0-13.659 C69.469,70.059,61.037,66.025,51.117,61.877z"></path></g></svg>
                <?php 
                echo PopoverX::widget([
                    'header' => Yii::t('frontend', 'Голоса'),
                    'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
                    'content' => Art::get_voters($model->voters),
                    'toggleButton' => ['label'=>$model->votes . ' ' . Yii::t('frontend', 'голосов') . '&#9660', 'tag' => 'label', 'class'=>'votes-counter'],
                ]);?>
                <div is="[object Object]"></div>
                
            </div>
            <div class="col-xs-4 col-lg-2 Icon chatbox">
               
                <svg version="1.1" style="margin-top: 1px" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><path d="M124.3,400H277c14.4,0,14.4,0.1,21.3,5.2S384,464,384,464v-64h3.7c42.2,0,76.3-31.8,76.3-71.4V119.7 c0-39.6-34.2-71.7-76.3-71.7H124.3C82.2,48,48,80.1,48,119.7v208.9C48,368.2,82.2,400,124.3,400z"></path></svg>
           <?php echo $model->replies?>
            
            </div>
           
             <div class="col-xs-4 col-lg-1 article-vote-up">
                 <?php $params = '\'' . $model->blockchain . '\', \'' . $model->author . '\', \'' . $model->permlink . '\', ' . 10000 ?>
                 <span class="filter"  id ='<?php echo $model->permlink ?>' onclick="down_vote(<?php echo $params ?>)"></span> 
                 <img src='/frontend/web/img/up0.png' id = '<?php echo 'icon_' . $model->permlink ?>' class= 'vote'  
                  onclick = <?php echo 'vote("' . $model->blockchain . '","' . $model->author . '","' . $model->permlink . '",10000)';?>
                     >
             </div>
        </div>           
            
            <script>
                var voters = '<?php echo $model->voters ?>';
                voters = JSON.parse(voters);
                var blockchain = '<?php echo BlockChain::get_blockchain_from_locale() ?>';
                var account = blockchain.toLowerCase() + 'ac';
                    account = getCookie(account);
                
                var key = voters.indexOf(account);
                if (key != '-1')
                  $('#<?php echo $model->permlink ?>').css('z-index', 10);
              
                
            </script>