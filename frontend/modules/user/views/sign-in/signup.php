<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm 

 * <h2><?php echo Yii::t('frontend', 'Sign up with')  ?>:</h2>
                <div class="form-group">
                    <?php echo yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/sign-in/oauth']
                    ]) ?>
                </div>
 *  */

$this->title = Yii::t('frontend', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    
            <div class ='col-lg-12 col-xs-12'>
                 <div class="panel panel-success">
                    <div class="panel-heading">   
                        <div class ="register_count"><?= Yii::t('frontend','Registered: ') ?><b><?php echo frontend\modules\user\models\SignupForm::get_registration_count() . " " .  Yii::t('frontend', 'members')?> </b></div>
                    </div>
                </div>
            </div>
            
     <?php echo $form->field($model, 'email') ?>                      
     <?php echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
               <?php echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                   'captchaAction' => '/site/captcha',
                ]) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['disabled' => 'disabled','class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    <p> Регистрация приостановлена в связи с переходом на BETA-версию. Приносим извинения за предоставленные неудобства </p>
                </div>
               
            <?php ActiveForm::end(); ?>
        </div> 
</div>
    <div class ='col-lg-5'>
              <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Keep passwords securely. We can not restore it.') ?>
                    </div>
                  
                  
         </div>
    </div>
</div>
