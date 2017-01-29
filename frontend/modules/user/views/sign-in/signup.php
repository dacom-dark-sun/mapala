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
                <?php echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
               <?php echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                   'captchaAction' => '/site/captcha',
                ]) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
               
            <?php ActiveForm::end(); ?>
        </div> 
</div>
    <div class ='col-lg-5'>
              <div class="panel panel-danger">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Сохраняйте пароль НАДЕЖНО. Мы не можем его восстановить.') ?>
                    </div>
                  
                  
         </div>
    </div>
