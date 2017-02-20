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
$this->title = Yii::t('frontend','Auto-curating');
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
    
            <div class="form-group" id="trail_form">
                <label for="use"><?php echo Yii::t('frontend', 'Use your posting key for auto-curating')?>:</label>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='use_trail' class="btn btn-success"><?php echo Yii::t('frontend', 'Use')?></button>
                    <button type="button" id= 'cancel_use_trail' class="btn btn-danger"><?php echo Yii::t('frontend', 'Cancel auto-curating')?></button>
                    <div class ="loader_head"  style="display: none;">
                       <div id = 'steem_load' class = 'loader' ></div>
                       </div>
                </div>
            </div>

            <div class ="account_name"></div>
        </div>
   
            
            <div class="col-lg-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <?= Yii::t('frontend', 'Important!') ?>
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
                   
                    </div>
                </div>
      
        
    </div>
    </div>
    
</div>
<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Key STEEM') . '</h2>',
            'id' => 'modalKey',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('@frontend/modules/user/views/keys/keysForm');
        yii\bootstrap\Modal::end();

        ?>
    



<script>
    var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
       acc = getCookie(acc);
       if (acc){
          $('.account_name').text(acc);
       } else {
         $('<a id="key_modal_ask"><?php echo Yii::t('frontend', 'install STEEM posting private key') ?></a>').appendTo('.account_name');
         $(":submit").attr("disabled", true);
       } 
       
       $(".account_name").click(function() {
          $('#modalKey').modal('show');
       });
 
$(document).ready(function(){
  var flag = <?= \common\models\Art::is_curator() ?>;
  if (flag == 1){
      $('#use_trail').hide();
      $('#cancel_use_trail').show();
      
  } else {
      $('#use_trail').show();
      $('#cancel_use_trail').hide();
      
  }
    
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

$("#cancel_use_trail").click(function() {
  var current_blockchain = '<?= BlockChain::get_blockchain_from_locale()?>' + 'sig';
  var username = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
  var user = getCookie(username);
    var wif = get_wif(current_blockchain);
  
  if (wif.status  ==  'success'){
        result = cancel_use_trail(wif.plaintext, user);
    }    
    
});



$("#use_trail").click(function() {
  $('.loader').show();
  var current_blockchain = '<?= BlockChain::get_blockchain_from_locale()?>' + 'sig';
  var username = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
  var user = getCookie(username);
    var wif = get_wif(current_blockchain);
  
  if (wif.status  ==  'success'){
try{
    pub_key = convert_to_pub_key_steem(wif.plaintext);
      
    check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
        result = send_key(wif.plaintext, user);
         $('.loader').hide();
    }
    else {
           console.log(err['message']);
          $('.loader').hide();

    }
  
   });
} catch(err){ alert('Key Error. Check your keys'); $('.loader').hide();}
} else {
    alert('Key Error. Check your keys');
    $('.loader').hide();
}
  
  
  
  
  
});


$("#instruction").click(function() {
    $(".instruction").show();
    
});

function send_key(key, user){
     $.ajax({
              url: '/trail/use_trail/',
       
            type: "post",
     
            data   : {key: key, user:user},
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


function cancel_use_trail(key, user){
     $.ajax({
              url: '/trail/cancel_trail/',
       
            type: "post",
     
            data   : {key: key, user:user},
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