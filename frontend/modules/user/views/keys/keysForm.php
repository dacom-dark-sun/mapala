<?php


use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap;
use frontend\assets\KeyAsset;
use common\models\BlockChain;
KeyAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 
if (Yii::$app->controller->id == 'keys')
    $this->title = Yii::t('frontend', 'STEEM key')
?>
<div class="form-index">
    <h1><?php if (Yii::$app->controller->id == 'keys')
             echo Html::encode($this->title) ?></h1>
    <div class="row">
        <div class='col-lg-12'>
        <div class="col-lg-6">
    <?php if (BlockChain::get_blockchain_from_locale() == 'steem'): ?>
            
            <div class="form-group">
                <label for="usr"><?php echo Yii::t('frontend', 'Steem private posting key')?>:</label>
                <div><input type="text" class="form-control"  id="STEEM" placeholder="<?php echo Yii::t('frontend', 'Posting Key, begins with 5..')?>" ><div  class = 'loader' style="display: none" ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='steem-btn-save' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                <button type="button" id= 'steem-btn-edit' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
            <div class="form-group" id="steem_pass_form">
                <label for="usr"><?php echo Yii::t('frontend', 'Get posting key from password')?>:</label>
                 <div><input type="text" class="form-control"  id="username" placeholder="<?php echo Yii::t('frontend', 'Username')?>"  ></div>
                 <div><input type="text" class="form-control"  id="STEEM_pass" placeholder="<?php echo Yii::t('frontend', 'Password')?>" ><div class = 'loader' style="display: none" ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='steem-btn-save_pass' class="btn btn-success"><?php echo Yii::t('frontend', 'Get posting key')?></button>
                <button type="button" id= 'steem-btn-edit_pass' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
    <?php else: ?>            
    
            <div class="form-group">
                <label for="pwd"><?php echo Yii::t('frontend', 'Steem private posting key')?>:</label>
                <div><input type="text" class="form-control"  id="GOLOS" placeholder="<?php echo Yii::t('frontend', 'Posting Key, begins with 5..')?>" ><div  style="display: none"  class = 'loader' ></div></div>
                    <div class ="keys_save_edit_buttons">
                    <button type="button" id= 'golos-btn-save' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                    <button type="button" id= 'golos-btn-edit' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
               <div class="form-group" id="golos_pass_form">
                <label for="usr"><?php echo Yii::t('frontend', 'Get posting key from password')?>:</label>
                 <div><input type="text" class="form-control"  id="username" placeholder="<?php echo Yii::t('frontend', 'Username')?>"  ></div>
                <div><input type="text" class="form-control"  id="GOLOS_pass" placeholder="<?php echo Yii::t('frontend', 'Password')?>" ><div  style="display: none"  class = 'loader' ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='golos-btn-save_pass' class="btn btn-success"><?php echo Yii::t('frontend', 'Get posting key')?></button>
                <button type="button" id= 'golos-btn-edit_pass' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
        <?php  if (Yii::$app->controller->id == 'keys'):?>      <button type="button" class="btn btn-danger" onclick=" $('#modalsignupBlockchain').modal('show')"> <?php echo Yii::t('frontend', 'Получить аккаунт GOLOS')?></button>
            <?php endif; ?>
                </div>
            </div>
    <?php endif; ?>
            <div class ="account_name"></div>
        </div>
   
            
            <div class="col-lg-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <?= Yii::t('frontend', 'Важно!') ?>
                </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'For receiving private posting key you can use login and  password from  Steem / Golos accounts. Or you can take it from the Steem / Golos  wallets by yourself and save it on mapala.net. For more details  about  posting key saving see the <span id="instruction">instruction</span><br><br><b>Mapala.net servers dont  get any keys and passwords. All the transactions occur between you and blockchain. Или  All the transactions are between you and blockchain. After that the key becomes encrypted and stored in browser cookies.</b>'
                            ) ?>
                    </div>
                </div>
             </div>
      
        
    </div>
        <div class="col-lg-12">
            <div class="panel panel-success instruction" style="display: none">
                    <div class="panel-body"><h3><?= Yii::t('frontend', 'How to get a posting key.')?></h3>
                        <?= Yii::t('frontend','You have to copy and save in appropriate posting field your private key from GOLOS platform to publish posts, vote and receive awards. You can find private posting key on<a href=http://golos.io>golos.io</a> in “permissions” tab. Please note that private key begin witha a number 5.');?>
                    <?php if (BlockChain::get_blockchain_from_locale() == 'steem'):?>
                        <img src='/img/keys_en2.jpg' style="width: 100%">
                    <?php elseif (common\models\BlockChain::get_blockchain_from_locale()=='golos'):?>
                        <img src='/img/keys_ru.png' style="width: 100%">
                                      
                    <?php endif;?>
                    </div>
                </div>
      
        
    </div>
    </div>
    
</div>

<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Создать аккаунт Golos') . '</h2>',
            'id' => 'modalsignupBlockchain',
            'size' => 'modal-md',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
        ]);


       if (Yii::$app->controller->id == 'keys'){
         echo $this->context->renderPartial('@frontend/modules/user/views/keys/signupBlockchain',[
            'signupBl_model'=> $signupBl_model,
        ]);
        yii\bootstrap\Modal::end();
       }
?>



<script>
$(document).ready(function(){
  var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
  acc = getCookie(acc);
  if (acc){
     $('.account_name').text(acc);
  }     
        
   if (getCookie('steemsig')) {
     $('#STEEM').prop('disabled', true);
     $('#STEEM').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
     $("#steem-btn-save").hide();
     $("#steem-btn-edit").show();
     $('#steem_pass_form').hide();
     
  
   }
   
   if (getCookie('golossig')) {
     $('#GOLOS').prop('disabled', true);
     $('#GOLOS').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
     $("#golos-btn-save").hide();
     $("#golos-btn-edit").show();
     $('#golos_pass_form').hide();
    
    
   }
   
});

$("#instruction").click(function() {
    $(".instruction").show();
    
});

function create_account(username, pass){
     $.ajax({
              url: '/site/create_account/',
       
            type: "post",
     
            data   : {username: username, pass: pass},
            success: function (comment_data) 
            {
                console.log(comment_data);
            },
            error  : function (xhr, ajaxOptions, thrownError) 
            {
               console.log('internal server error');
            }
            });
            
}
</script>