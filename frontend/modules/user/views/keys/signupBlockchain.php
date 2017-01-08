<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-blockchain-submit']); ?>
                <?php echo $form->field($signupBl_model, 'username') ?>
                <?php echo $form->field($signupBl_model, 'password')->passwordInput() ?>
               
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
               
            <?php ActiveForm::end(); ?>
        
        <div class ="loader_head"  style="display: none;">Transaction...
                       <div id = 'steem_load' class = 'loader' ></div>
                       </div>    
                    
        </div> 
    <div class ='col-lg-5'>
              <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Сохраняйте пароль НАДЕЖНО. Мы не можем его восстановить.') ?>
                    </div>
                    
         </div>
    </div>
    </div>
</div>

