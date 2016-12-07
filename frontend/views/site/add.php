<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm 
 *   
 * <?= Html::a(Yii::t('frontend','Попутчики'), ['/forms/add_companions'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
   <?= Html::a(Yii::t('frontend','События'), ['/forms/add_mapala_events'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
 <?= Html::a(Yii::t('app','Транспорт'), ['/forms/add_transport'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
 <?= Html::a(Yii::t('app','Базы Мапала'), ['/forms/add_base'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
*/

$this->title = Yii::t('frontend','Пополнить базу');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <h1><?php echo Html::encode($this->title) ?></h1>
    
    <div class="row">
        <div class="col-lg-12">
            
    <?= Html::a(Yii::t('frontend','Я - Мапала'), ['/forms/add_im_mapala'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Жилье путешественника'), ['/forms/add_homestay'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Лайфхаки'), ['/forms/add_lifehack'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Достопримечательности'), ['/forms/add_must_see'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Истории'), ['/forms/add_story'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
   
            
        </div>
    </div>
    
    

</div>



