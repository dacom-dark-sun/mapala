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
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 

$this->title = Yii::t('frontend','Истории'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-indext">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-7">
             <?php //------ Start active form and show title
            $form = ActiveForm::begin(['id' => 'add-form']); ?>
            <?php echo $form->field($model, 'title') ?>
            
            <?php //Show Countries-------------------------------------------------------------
            echo $form->field($model, 'country')->widget(Select2::classname(),[
                "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                'pluginEvents' => [
                 ],//---------------------------------------------------------------------
            ]); 
            ?>
            
           


 <?php //MARKDOWN EDITOR -----------------------------
 echo $form->field($model, 'body')->widget(
	MarkdownEditor::classname(), 
	['height' => 400, 'encodeLabels' => true]
);//---------------------------------------------------
?>
            
            
<?php //-------SHOW TAGS-----------------//TODO - List PRE-data.   
 echo $form->field($model, 'tags')->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Select a color ...', 'multiple' => false],
    
    'pluginOptions' => [
        'tags' => true,
         
        'size' => Select2::LARGE,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 30
    ]])->label(Yii::t('frontend','Tag'));
           ?> 
            
           
            <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
             
            </div>
                   <?php echo $form->field($model, 'coordinates')->hiddenInput(['value'=> ""])->label(Yii::t('frontend','Coordinates')) ?>
        
                <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5">
           text
        </div>
    </div>

     <div id ="map-container">   
         <div id="map">
             
       <?= $this->render('map',['model'=>$model, 'form' => $form]) ?>
             
         </div>
    </div>
    
    
</div>





