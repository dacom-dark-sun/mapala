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

if (Yii::$app->controller->id == 'keys')
    $this->title = Yii::t('frontend', 'Ключ GOLOS')
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
                <label for="usr"><?php echo Yii::t('frontend', 'Получить приватный ключ из пароля')?>:</label>
                 <div><input type="text" class="form-control"  id="username" placeholder="<?php echo Yii::t('frontend', 'Username')?>"  ></div>
                 <div><input type="text" class="form-control"  id="STEEM_pass" placeholder="<?php echo Yii::t('frontend', 'Password')?>" ><div class = 'loader' style="display: none" ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='steem-btn-save_pass' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                <button type="button" id= 'steem-btn-edit_pass' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
    <?php else: ?>            
    
            <div class="form-group">
                <label for="pwd"><?php echo Yii::t('frontend', 'Golos private posting key')?>:</label>
                <div><input type="text" class="form-control"  id="GOLOS" placeholder="<?php echo Yii::t('frontend', 'Posting Key, begins with 5..')?>" ><div  style="display: none"  class = 'loader' ></div></div>
                    <div class ="keys_save_edit_buttons">
                    <button type="button" id= 'golos-btn-save' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                    <button type="button" id= 'golos-btn-edit' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
               <div class="form-group" id="golos_pass_form">
                <label for="usr"><?php echo Yii::t('frontend', 'Получить приватный ключ из пароля')?>:</label>
                 <div><input type="text" class="form-control"  id="username" placeholder="<?php echo Yii::t('frontend', 'Username')?>"  ></div>
                <div><input type="text" class="form-control"  id="GOLOS_pass" placeholder="<?php echo Yii::t('frontend', 'Password')?>" ><div  style="display: none"  class = 'loader' ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='golos-btn-save_pass' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                <button type="button" id= 'golos-btn-edit_pass' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
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
                    <div class="panel-body"><?= Yii::t('frontend', 'Вы можете использовать логин и пароль от аккаунта Steem/Golos для получения приватного постинг-ключа, или можете самостоятельно взять его '
                            . 'в кошельке аккаунта Steem/Golos и сохранить его на Mapala.Net. Подробнее о сохранении постинг-ключа см. <span id="instruction">инструкцию</span><br><br>'
                            . '<b> Ключи и пароли ни в каком виде НЕ передается на сервер MapalaNet. Все операции происходят между вашим устройством и блокчейном, после чего, '
                            . 'ключ шифруется и сохраняется в cookies браузера. </b>'
                            ) ?>
                    </div>
                </div>
             </div>
      
        
    </div>
        <div class="col-lg-12">
            <div class="panel panel-success instruction" style="display: none">
                    <div class="panel-body"><?= Yii::t('frontend', '<h3>Инструкция по получению постинг ключа: </h3>'
                       . 'Для публикации постов, голосования, и получения вознаграждений, вам необходимо скопировать и '
                       . 'сохранить в соответствующем поле приватный постинг ключ социально-медийной платформы GOLOS. '
                       . 'Найти приватный постинг ключ можно на <a href=http://golos.io>golos.io</a> во вкладке "Разрешения". '
                       . 'Обратите внимание, что приватный ключ начинается с цифры "5"') ?>
                        <img src='/img/keys_ru.png' style="width: 100%">
                    </div>
                </div>
      
        
    </div>
    </div>
    
</div>

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

    

</script>