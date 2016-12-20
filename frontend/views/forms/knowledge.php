
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\models\Countries;
use kartik\markdown\MarkdownEditor;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use common\models\OurCategory;
use yii\helpers\Html;
use common\models\BlockChain;
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 

$this->title = Yii::t('frontend','Knowledge');

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Update database'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?php echo Html::encode($this->title) ?></h1>


<div class="form-index">
    <div class="row">
        <div class="col-lg-7">
            <?php //------ Start active form and show title
            $form = ActiveForm::begin(['id' => 'add-form']); ?>
            <?php echo $form->field($model, 'title') ?>
            
                         
<?php //-------SHOW Categories-----------------//TODO - List PRE-data.   
            echo $form->field($model, 'tags')->widget(Select2::classname(),[
                 'options' => ['placeholder' => 'Select a category ...'],
                
                "data" => ArrayHelper::map(OurCategory::find()
                        ->Where(['model' => StringHelper::basename(get_class($model))])
                        ->all(), BlockChain::get_blockchain_from_locale(), BlockChain::get_blockchain_from_locale()),
                //---------------------------------------------------------------------
            ]); 
      
           ?> 
            
            
            
            <?php //Show Countries-------------------------------------------------------------
            echo $form->field($model, 'country')->widget(Select2::classname(),[
                "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginEvents' => [
                "change"=>'function(event, id, value, count){save_country($(this).val())}'
                ],//---------------------------------------------------------------------
            ]); 
            ?>
                
             <?php 
                //Show depended cities by ajax ----------------------------------------------------------
                echo $form->field($model, 'city')->widget(Select2::classname(), [
                     'options' => ['placeholder' => 'Search for a city ...'],
                    'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Yii::$app->urlManager->createUrl('forms/citylist'),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],//--------------------------------------------------------------------------------------
                ]);?>     




 <?php //MARKDOWN EDITOR -----------------------------
 echo $form->field($model, 'body')->widget(
	MarkdownEditor::classname(), 
	['height' => 400, 'encodeLabels' => true]
);//---------------------------------------------------
?>

        





            
            
            
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        </div>
        </div>
   <div class="col-lg-5">
            
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Title') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Enter the title') ?></div>
                </div>
            
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Category') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 
                            '- <b>Lifehacks</b> - tell secrets life in your country/city; <br>'
                            . '- <b>Weather</b> - tell about climat in your country/city; <br>'
                            . '- <b>Geography</b> - sure, not everybody knows where your city and what landscape around. Tell about it; <br>'
                            . '- <b>Traditions</b> - tell about the traditions, ceremonies and customs; <br>'
                            . '- <b>Language</b> - tell about language in your place; <br>'
                            . '- <b>Video Presentation</b> - show your city in promo video;') ?></div>
                </div>
             <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Country') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Select a country, which will head branch of tree') ?></div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'City') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Select a city, which will next level your branch') ?></div>
                </div>

            
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Body') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Tell all what you want to say.') ?></div>
                </div>
            <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'You can mark the place. Or not mark.. It is up to you.') ?></div>
                </div>
        </div>
    </div>
    
<div id ="map-container">   
     <div id="map">
       <?= $this->render('map',['model'=>$model, 'form' => $form]) ?>
            
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