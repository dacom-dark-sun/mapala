<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm
 * 
 *  <h2><?php echo Yii::t('frontend', 'Log in with')  ?>:</h2>
                <div class="form-group">
                    <?php echo yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/sign-in/oauth']
                    ]) ?>
                </div>
 *  */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php echo $form->field($model, 'identity') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <div class="form-group">
                    <?php echo Yii::t('frontend', 'If you have not registered, do it <a href="{link}">here</a>.', [
                        'link'=>yii\helpers\Url::to(['sign-in/signup'])
                    ]) ?>
                
                </div>
                <div style="color:#999;margin:1em 0">
                    <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                        'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                    ]) ?>
                </div>

               
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>