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

$this->title = Yii::t('frontend','Add Post');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
          <h1>     <?= Yii::t('frontend', 'Choose a type of content to publish on the BlockChain:') ?> </h1>
          <br>
    
    <div class="row">
        <div class="col-lg-12">
               
            
            <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                      <center>  <b>  <?= Yii::t('frontend', 'Share usefull knowledge and traveler secrets') ?> </b></center>
                      <?= Html::a('<img src="/img/alexandria.jpg" style="width: 100%;">', ['/forms/knowledge', 'author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
                       <?= Html::a(Yii::t('frontend','Knowledge'), ['/forms/knowledge', 'author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                    </div>
                </div>

                
            </div>
            <div class ='col-lg-3'>
              <div class="panel panel-success">
                    <div class="panel-heading">   
                   <center>   <b>  <?= Yii::t('frontend', 'Tell about interesting places that are worth visting') ?> </b></center>
                   <?= Html::a('<img src="/img/train.jpg" style="width: 100%;">', ['/forms/places', 'author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
                   <?= Html::a(Yii::t('frontend','Places'), ['/forms/places', 'author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            
            
            </div>
            <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>  <b>   <?= Yii::t('frontend', 'Tell a story of your adventure') ?> </b> </center>
                         <?= Html::a('<img src="/img/tuzemec.jpg" style="width: 100%;"> ', ['/forms/blogs','author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                        
                         <?= Html::a(Yii::t('frontend','Blogs'), ['/forms/blogs','author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            </div>
             <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>  <b>   <?= Yii::t('frontend', 'Here boiling life of the community. In this section, you can report problems, share ideas or useful materials for the community.') ?> </b> </center>
                         <?= Html::a('<img src="/img/community2.png" style="width: 100%;"> ', ['/forms/community','author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-active', 'style' => 'padding-right:10px; width:100%; ']) ?>
      
                        
                         <?= Html::a(Yii::t('frontend','Community'), ['/forms/community','author'=> $author, 'permlink' => $permlink], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            </div>
            <?php if ((!Yii::$app->user->isGuest)&&(Yii::$app->user->identity->username == 'mapala')): ?>
                <div class ='col-lg-3'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>  <b>   <?= Yii::t('frontend', 'News') ?> </b> </center>
                         <?= Html::a(Yii::t('frontend','Новости'), ['/forms/news'], ['class'=>'btn btn-primary', 'style' => 'padding-right:10px; width:100%;']) ?>
           
                    </div>
                </div>
            </div>
                
           <?php endif; ?>
   
            
        </div>
    </div>
    
    

</div>



