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
    <?= Html::a(Yii::t('frontend','People'), ['/forms/immapala'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>
    <?= Html::a(Yii::t('frontend','Homestay'), ['/forms/homestay'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px;']) ?>

 *  */

$this->title = Yii::t('frontend','Update database');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
          <h1>     <?= Yii::t('frontend', 'Выбери тип контента для публикации в BlockChain:') ?> </h1>
          <br>
    
    <div class="row">
        <div class="col-lg-12">
               
            
            <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                      <center>  <b>  <?= Yii::t('frontend', 'Поделись полезными знаниями и туристическими секретами') ?> </b></center>
                      <?= Html::a('<img src="/img/alexandria.jpg" style="width: 100%;">', ['/forms/knowledge'], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
                       <?= Html::a(Yii::t('frontend','Knowledge'), ['/forms/knowledge'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                    </div>
                </div>

                
            </div>
            <div class ='col-lg-3'>
              <div class="panel panel-success">
                    <div class="panel-heading">   
                   <center>   <b>  <?= Yii::t('frontend', 'Расскажи о интересных местах, которые стоит посетить') ?> </b></center>
                   <?= Html::a('<img src="/img/train.jpg" style="width: 100%;">', ['/forms/places'], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
                   <?= Html::a(Yii::t('frontend','Places'), ['/forms/places'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            
            
            </div>
            <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>  <b>   <?= Yii::t('frontend', 'Расскажи историю своего приключения') ?> </b> </center>
                         <?= Html::a('<img src="/img/tuzemec.jpg" style="width: 100%;"> ', ['/forms/blogs'], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                        
                         <?= Html::a(Yii::t('frontend','Blogs'), ['/forms/blogs'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            </div>
            <?php if ((!Yii::$app->user->isGuest)&&(Yii::$app->user->identity->username == 'mapala')): ?>
                <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>  <b>   <?= Yii::t('frontend', 'Новости') ?> </b> </center>
                         <?= Html::a(Yii::t('frontend','Новости'), ['/forms/news'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            </div>
                
           <?php endif; ?>
   
            
        </div>
    </div>
    
    

</div>



