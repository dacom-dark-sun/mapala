<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use bookin\aws\checkbox\AwesomeCheckbox;
use common\models\Countries;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use dosamigos\ckeditor;

$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','People'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Update database'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-index">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-7">
            <?php $form = ActiveForm::begin(['id' => 'add-form']); ?>
            
                <?php echo $form->field($model, 'title') ?>
               
       <?php //Show Countries-------------------------------------------------------------
            echo $form->field($model, 'country')->widget(Select2::classname(),[
                 'options' => ['placeholder' => 'Select a state ...'],
                "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
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
           <?php echo $form->field($model, 'not_traveler')->widget(AwesomeCheckbox::classname())->label(false); ?>

            
                <?php echo $form->field($model, 'date_until_leave')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter date until you leave ...',],
                'pluginOptions' => [
                    'autoclose'=>true,
                 
                ]
            ]);  ?>


                  <?php echo $form->field($model, 'contacts') ?>
                <?php echo $form->field($model, 'languages') ?>
                
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
                        <?= Yii::t('frontend', 'Introduce yourself, please (title)') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Enter the title or your name') ?></div>
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
                        <?= Yii::t('frontend', 'Im not in the travel now and this is my permanent place') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'If you living in that place, just not touch it. It will show to everybody, that this is your permanent place. '
                            . 'If your a traveler, choise date when you leave. It helps to other travelers find you on your way') ?></div>
                </div>
            
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Contacts') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Phone? Facebook? Telegram? Email? Any..') ?></div>
                </div>
            
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Languages') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Just mark language which you can speak. It helps to other travelers find people who can speak their native language.') ?></div>
                </div>
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Body') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Tell about yourself, about your traveler expirience. All what you want to say.') ?></div>
                </div>
            <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'You can mark the place around youself. Or not mark.. It is up to you.') ?></div>
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
       if(<?php echo $model->not_traveler ?> == 1 )
       {
           $('.field-immapala-date_until_leave').hide();
       } else { 
           $('.field-immapala-date_until_leave').show(); 
       };
 
 
 
$('#immapala-not_traveler').click(function(){
    if (!$('.field-immapala-date_until_leave').is(":visible")){
        $('#not_traveler').val(0);
           $('.field-immapala-date_until_leave').show();  
    } else{
        $('#not_traveler').val(1);
           $('.field-immapala-date_until_leave').hide(); 
    }
    
    
})
    
    
    
    
//When user click to the map, we get coordinates and put it in the model (hide input)



   //this for filter cities list if user choise the country 
   
    function save_country(id){
        id = parseInt(id);
       $.ajax({
            url    : '<?php echo Yii::$app->urlManager->createUrl('forms/save_country') ?>',
            type   : 'get',
            data   : { id : id}
            });
     }
     
     


</script>
     
     