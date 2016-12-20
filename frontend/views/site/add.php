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

$this->title = Yii::t('frontend','Update database');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <h1><?php echo Html::encode($this->title) ?></h1>
    
    <div class="row">
        <div class="col-lg-12">
            
    <?= Html::a(Yii::t('frontend','People'), ['/forms/immapala'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Homestay'), ['/forms/homestay'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Knowledge'), ['/forms/knowledge'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Must See'), ['/forms/must_see'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Story'), ['/forms/story'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
   
            
        </div>
    </div>
    
    

</div>



