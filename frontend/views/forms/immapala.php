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

\frontend\assets\KeyAsset::register($this);
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','Я - Мапала'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
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
           <?php echo $form->field($model, 'is_it_traveler')->widget(AwesomeCheckbox::classname())->label(false); ?>

            
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
           text
        </div>
        
    </div>
    

<div id ="map-container">   
     <div id="map">
    
            <?php
            
                echo $form->field($model, 'coordinates')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
                    'key' => 'AIzaSyC9PkCzTGG3Ial2tkDuSmmZvV2joFfzj0Y' ,   // require , Put your google map api key
                    'valueTemplate' => '{latitude},{longitude}' , // Optional , this is default result format
                    'options' => [
                        'style' => 'width: 100%; height: 500px',  // map canvas width and height
                    ] ,
                    'enableSearchBox' => true , // Optional , default is true
                    'searchBoxOptions' => [ // searchBox html attributes
                        'style' => 'width: 90%;', // Optional , default width and height defined in css coordinates-picker.css
                    ],
                    'searchBoxPosition' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'), // optional , default is TOP_LEFT
                    'mapOptions' => [
                        // google map options
                        // visit https://developers.google.com/maps/documentation/javascript/controls for other options
                        'mapTypeControl' => true, // Enable Map Type Control
                        'mapTypeControlOptions' => [
                              'style'    => new JsExpression('google.maps.MapTypeControlStyle.HORIZONTAL_BAR'),
                              'position' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'),
                        ],
                        'streetViewControl' => true, // Enable Street View Control
                    ],
                    'clientOptions' => [
                        'zoom' => 2,
                        'location' => [
                            'latitude'  => 44.67142437752303 ,
                            'longitude' => -35.7470703125,
                      
                        ],
                        // jquery-location-picker options
                        'radius'    => 300,
                        'addressFormat' => 'street_number',
                        
                    ]
                ]);
            ?>
            
            </div>
            
    </div>
            
            
            
            
            
            <?php ActiveForm::end(); ?>







<script>
    
           $('.field-immapala-date_until_leave').hide(); 
 
 
 
 
$('#immapala-is_it_traveler').click(function(){
    console.log('tru');
    if (!$('.field-immapala-date_until_leave').is(":visible")){
        $('#is_it_traveler').val(0);
           $('.field-immapala-date_until_leave').show();  
    } else{
        $('#is_it_traveler').val(1);
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
     
     