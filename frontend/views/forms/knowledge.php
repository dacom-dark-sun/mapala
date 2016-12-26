
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
        <div class="col-lg-12">
            <div class ='col-lg-7'>
            <?php //------ Start active form and show title
            $form = ActiveForm::begin(['id' => 'add-form']); ?>
            <?php echo $form->field($model, 'title') ?>
            </div>
            <div class ='col-lg-5'>
            <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Title') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Постарайся уложиться в 100 символов, кратко и емко рассказав о сути знания') ?></div>
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
                            '- <b>Лайфхак</b> - расскажи секреты жизни в своем городе и стране; <br>'
                            . '- <b>Погода</b> - расскажи о климате и временах года, к чему путешественнику быть готовым?; <br>'
                            . '- <b>География</b> - конечно, не все знают где находится твой город и какой пейзжах вокруг. Расскажи об этом, а лучше - покажи;<br>'
                            . '- <b>Традиции</b> - расскажи о традициях, обрядах и церемониях; <br>'
                            . '- <b>Язык</b> - расскажи на каких языках говорят в твоем городе, расскажи о нем; <br>'
                            . '- <b>Видео-презентация</b> - покажи короткую видеопрезентацию города. Позволь путешественникам взглянуть на него твоими глазами;') ?></div>
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
                
            
            <div class ='col-lg-7'>
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
            </div>
            <div class='col-lg-5'>
                 <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'City') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Город будет являться вложенной папкой в дереве тегов') ?></div>
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