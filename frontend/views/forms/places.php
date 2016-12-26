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


$this->title = Yii::t('frontend','Places'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-indext">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
            <div class ='col-lg-7'>
             <?php //------ Begin active form and show the title
            $form = ActiveForm::begin(['id' => 'add-form']); ?>
            <?php echo $form->field($model, 'title') ?>
            </div>
            <div class ='col-lg-5'>
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
            ]); 
      
           ?> 
            </div>
            <div class='col-lg-5'>
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Category') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 
                            '- <b>Природные</b> - все природные чудеса и интересности вносить сюда; <br>'
                            . '- <b>Рукотворные</b> - люди создали что-то особенное? Пиши сюда; <br>'
                           ) ?></div>
                </div>
            </div>
            

            <div class ='col-lg-7'>
            <?php //Show Countries-------------------------------------------------------------
            echo $form->field($model, 'country')->widget(Select2::classname(),[
                 'options' => ['placeholder' => 'Select a state ...'],
                
                "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                'pluginEvents' => [
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
            
           

            <div class ='col-lg-7'>
             <?php //MARKDOWN EDITOR -----------------------------
             echo $form->field($model, 'body')->widget(
                    MarkdownEditor::classname(), 
                    ['height' => 400, 'encodeLabels' => true]
            );//---------------------------------------------------
            ?>
            </div>
            <div class ='col-lg-5'>
                             <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Базовая инструкция MarkDown:') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend',  'Ссылка: [название ссылки](адрес) <br>'
                            . 'Картинка: ![альтернативный текст](адрес) <br>'
                            . '<h5>#ЗАГОЛОВОК# - пишется между решетками</h5> '
                            . 'Между одинарных звездочек: <i>*КУРСИВ* </i> <br>'
                            . 'Между двух звездочек: <b>**ЖИРНЫЙ**</b> <br>'
                            . 'Между трех звездочек: <b><i>***ЖИРНЫЙ КУРСИВ*** </i></b> <br>'
                            . '<blockquote>`Цитата`- между двумя косыми линиями </blockquote> ' 
                            . '<ul><li>-каждый элемент списка</li>'
                            . '<li>-пишется слитно с чертой "-" </li></ul>' 
                            
                    );
                    ?>
                </div>
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
                    <div class="panel-body"><?= Yii::t('frontend', 'Очень тяжело найти особенное без без точных координат. Помоги другим путешественникам, укажи координаты точно.') ?></div>
                </div>
                
            </div>
            
            
</div>
        </div>
        
    </div>
    
        

       <?php ActiveForm::end(); ?>
     



