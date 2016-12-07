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
use bookin\aws\checkbox\AwesomeCheckbox;

$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','Жилье путешественника'); 
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-index">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
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
            
                <?php echo $form->field($model, 'free')->widget(AwesomeCheckbox::classname())->label(false); ?>

            
            
            
                <?php echo $form->field($model, 'cost')->textInput(['readonly' => true]) ?>
                <?php echo $form->field($model, 'capacity')?>
                <?php echo $form->field($model, 'contacts') ?>
              

                 <?php //MARKDOWN EDITOR -----------------------------
                 echo $form->field($model, 'body')->widget(
                        MarkdownEditor::classname(), 
                        ['height' => 400, 'encodeLabels' => true]
                );//---------------------------------------------------
                ?>

        
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                </div>
                 <?php echo $form->field($model, 'coordinates')->hiddenInput(['value'=> ""])->label(Yii::t('frontend','Coordinates')) ?>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    <div id ="map-container">   
        <div id="map"></div>
    </div>

</div>



<script>
    
$(document).ready(function(){
    if ($('#homestay-free').val() == 0){
        $('#homestay-cost').prop('readonly',false); 
    } else $('#homestay-cost').prop('readonly',true);

    
})    
    
    
$('#homestay-free').click(function(){
    
    if ($('#homestay-free').val() == 1){
        $('#homestay-free').val(0);
        $('#homestay-cost').prop('readonly',false); 
    } else{
        $('#homestay-free').val(1);
        $('#homestay-cost').prop('readonly',true);
    }
    
    
})


//When user click to the map, we get coordinates and put it in the model (hide input)
var marker;
function placeMarker(location, map) {
var loc = JSON.stringify(location);
//Take name of Model for construct name hidden input, which depends from it
$('input[name="<?php echo $model->formName() ?>[coordinates]"]').attr('value',loc);
if ( marker ) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }
}

//Map initialization
function initMap() {
 
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 2,
    center: {lat: 35, lng: 0 }
  });

  map.addListener('click', function(e) {
    placeMarker(e.latLng, map);
  });
}


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
     
     



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9PkCzTGG3Ial2tkDuSmmZvV2joFfzj0Y&callback=initMap" async defer></script>

