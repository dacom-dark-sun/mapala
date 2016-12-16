<?php


use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap;
use frontend\assets\KeyAsset;
KeyAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Keys')
?>
<div class="form-index">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                
                <label for="usr"><?php echo Yii::t('frontend', 'Steem private posting key')?>:</label>
                <div><input type="text" class="form-control"  id="STEEM" ><div id = 'steem_load' class = 'loader' ></div></div>
                <div class ="keys_save_edit_buttons">
                    <button type="button" id='steem-btn-save' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                <button type="button" id= 'steem-btn-edit' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
                
            </div>
            <div class="form-group">
                <label for="pwd"><?php echo Yii::t('frontend', 'Golos private posting key')?>:</label>
                <div><input type="text" class="form-control"  id="GOLOS" ><div id = 'golos_load' class = 'loader' ></div></div>
                    <div class ="keys_save_edit_buttons">
                    <button type="button" id= 'golos-btn-save' class="btn btn-success"><?php echo Yii::t('frontend', 'Save')?></button>
                    <button type="button" id= 'golos-btn-edit' style='display:none' class="btn btn-warning"><?php echo Yii::t('frontend', 'Edit')?></button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function(){
   if (getCookie('steemsig')) {
     $('#STEEM').prop('disabled', true);
     $('#STEEM').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
     $("#steem-btn-save").hide();
     $("#steem-btn-edit").show();
     
  
   }
   
   if (getCookie('golossig')) {
     $('#GOLOS').prop('disabled', true);
     $('#GOLOS').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
     $("#golos-btn-save").hide();
     $("#golos-btn-edit").show();
    
   }
   $('#steem_load').hide();
   $('#golos_load').hide();
  
});


    

</script>