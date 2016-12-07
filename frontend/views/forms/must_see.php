<?php
use common\models\Countries;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','Достопримечательности'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-indext">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
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
    </div>

     <div id ="map-container">   
        <div id="map"></div>
    </div>
    
    
</div>






<script>
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



</script>
     
     



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9PkCzTGG3Ial2tkDuSmmZvV2joFfzj0Y&callback=initMap" async defer></script>>