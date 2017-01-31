<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


  <?php $form = ActiveForm::begin(['id' => 'add-form']); ?>
  <?php echo $form->field($model, 'btc',['inputOptions' => [
'autocomplete' => 'off']]) ?>
  <?php echo $form->field($model, 'btc_address') ?>
  
  <?php echo Html::submitButton(Yii::t('frontend', 'Withdraw'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
         <input id ="tokens" readonly> tokens           
         
  <?php ActiveForm::end(); ?>

<script>
    $('#withdraw-btc').on('keyup', function(){
        btc = $('#withdraw-btc').val();
        rate =  <?=\common\models\BitCoin::get_rate(); ?>;
        tokens = btc/rate; 
        $('#tokens').val(tokens.toFixed(6));
        
    })
    
    </script>
    
     