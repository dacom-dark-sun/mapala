<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\models\Countries;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use common\models\OurCategory;
use common\models\BlockChain;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 

$this->title = Yii::t('frontend','Blogs'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-indext">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-7">
             <?php //------ Start active form and show title
            $form = ActiveForm::begin(['id' => 'add-form']); ?>
            <?php echo $form->field($model, 'title') ?>
            </div>
            <div class="col-lg-5">
                
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Title') ?>
                    </div>
                      <div class="panel-body"><?= Yii::t('frontend', 'Постарайся уложиться в 100 символов, кратко и емко рассказав Главное') ?></div>
                </div>

            </div>
            
                           <div class ='col-lg-7'>
<?php //-------SHOW Categories-----------------//TODO - List PRE-data.   
            echo $form->field($model, 'tags')->widget(Select2::classname(),[
                 'options' => ['placeholder' => 'Select a category ...'],
                
                "data" => ArrayHelper::map(OurCategory::find()
                        ->Where(['model' => StringHelper::basename(get_class($model))])
                        ->all(), BlockChain::get_blockchain_from_locale(), BlockChain::get_blockchain_from_locale()),
                //---------------------------------------------------------------------
            ]);?> 
            </div>
            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Category') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 
                            '- <b>Приключение</b> - есть история приключений? Поделись!; <br>'
                           ) ?></div>
                </div>

            </div>
            
            
             
            <div class="col-lg-7">
            <?php //Show Countries-------------------------------------------------------------
            echo $form->field($model, 'country')->widget(Select2::classname(),[
                "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginEvents' => [
                "change"=>'function(event, id, value, count){save_country($(this).val())}'
                ],//---------------------------------------------------------------------
            ]); 
            ?>
            </div>
            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Country') ?>
                    </div>
                  <div class="panel-body"><?= Yii::t('frontend', 'Страна будет размещена в "голове" дерева тегов') ?></div>
                 </div>
                
            </div>
           
<div class="col-lg-7">
             <?php //MARKDOWN EDITOR -----------------------------
             echo $form->field($model, 'body')->widget(
                    MarkdownEditor::classname(), 
                    ['height' => 400, 'encodeLabels' => true]
            );//---------------------------------------------------
            ?>
            </div>
            <div class="col-lg-5">
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Body') ?>
                    </div>
               <div class="panel-body"><?= Yii::t('frontend', 'Расскажи все, что ты хочешь сказать') ?></div>
                     </div>
                
            </div>
            
    <div class="col-lg-7">
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        </div>
            </div>
    
    
    <div class='col-lg-7'>    
<div id ="map-container">   
     <div id="map">
       <?= $this->render('map',['model'=>$model, 'form' => $form]) ?>
            
            </div>
    </div>        
    </div>
            <div class ='col-lg-5'>
                 <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                      <div class="panel-body"><?= Yii::t('frontend', 'Отметь место на карте, если это уместно, или ничего не отмечай, если нет.') ?></div>
                      </div>
                
            </div>
            
            
</div>
        </div>
        
    </div>
    
   
         <?php ActiveForm::end(); ?>



<script>

    function save_country(id){
        id = parseInt(id);
       $.ajax({
            url    : '<?php echo Yii::$app->urlManager->createUrl('forms/save_country') ?>',
            type   : 'get',
            data   : { id : id}
            });
     }
     
</script>