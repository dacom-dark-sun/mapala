<?php
use common\models\Countries;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlockChain;
use common\models\OurCategory;
use yii\helpers\StringHelper;
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
                 'options' => ['placeholder' => 'Select a state ...'],
                
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
                            '- <b>Nature</b> - All natural attractions you can enter here; <br>'
                            . '- <b>Manmade</b> - People have created something interesting? Enter it here; <br>'
                           ) ?></div>
                </div>
             <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Country') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Select a country, which will head branch of tree;') ?></div>
                </div>
              
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Body') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Tell all what you want to say;') ?></div>
                </div>
            <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'It is very difficult to find a nice place, without coordinates.') ?></div>
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
     



