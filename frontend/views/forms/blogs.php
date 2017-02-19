<?php

use common\models\Countries;
//use vova07\imperavi\Widget;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlockChain;
use common\models\OurCategory;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use common\components\editorwidget\EditorWidget;

$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','Blogs'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Add Post'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-index">
    <h1><?php echo Html::encode($this->title) ?></h1>
 <?php if ($author&&$permlink){
              echo Html::a(Yii::t('frontend', 'Change the data model'), 
                  ['/site/add', 'author' => $author, 'permlink' => $permlink], 
                  ['class'=>'btn btn-warning change_category_btn']);
          }
          ?>
       
    <div class="row">
        <div class="col-lg-12">
            <div class ='col-lg-7'>            
                <?php //------ Begin active form and show the title
                    $form = ActiveForm::begin(['id' => 'add-form']); 
                    echo $form->field($model, 'title') ?>

                <?php //-------SHOW Categories-----------------//TODO - List PRE-data.   
                    echo $form->field($model, 'tags')->widget(Select2::classname(),[
                        'options' => ['placeholder' => 'Select a category ...'],
                        "data" => ArrayHelper::map(OurCategory::find()
                            ->Where(['model' => StringHelper::basename(get_class($model))])
                            ->all(), BlockChain::get_blockchain_from_locale(), BlockChain::get_blockchain_from_locale()),
                    //---------------------------------------------------------------------
                        ]);?> 


                <?php //Show Countries-------------------------------------------------------------
                echo $form->field($model, 'country')->widget(Select2::classname(),[
                     'options' => ['placeholder' => 'Select a state ...'],

                    "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                    'pluginEvents' => [
                     ],//---------------------------------------------------------------------
                ]); 
                ?>
                <?php //Show Location-------------------------------------------------------------
                echo $form->field($model, 'location')->input(['text'], ['placeholder' => 'Select a location ...', 'id'=>'location']); 
                ?>
                 <?php //Show Location-------------------------------------------------------------
                echo $form->field($model, 'city')->hiddenInput(['text'], ['placeholder' => 'Select a location ...', 'id'=>'city'])->label(false); 
                ?>


                <?php //---------------- EDITOR------------------------------
                 echo $form->field($model, 'body')->widget(EditorWidget::className(), [
                    'settings' => [
                        'minHeight' => 400,
                        'toolbarFixedTopOffset' => 50,
                         'imageResizable' => true,
                         'imagePosition' => true,
                        'imageUpload' => yii\helpers\Url::to(['/site/image-upload']),
                        'plugins' => [
                            'fullscreen',
                            'imagemanager'
                        ]
                    ]//-------------------------------------------------
                ]);?> 

                <div class="form-group">
                       <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                        <div class ="loader_head"  style="display: none;">Transaction...
                       <div id = 'steem_load' class = 'loader' ></div>
                       </div>       </div>
                        <div class="account_name"></div>
                     
                          <?= $this->render('map',['model'=>$model, 'form' => $form]) ?>
                          <?php ActiveForm::end(); ?>


            </div>
            
            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Title') ?>
                    </div>
                           <div class="panel-body"><?= Yii::t('frontend', 'Please try to fit description into 100 symbols, briefly, but fully describing the Summary') ?></div>
                </div>
            </div>
            


            <div class ='col-lg-5'>
                  <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Country') ?>
                    </div>
                <div class="panel-body"><?= Yii::t('frontend', 'Country would be placed at the root of the tag tree') ?></div>
                   </div>
            </div>
            




            <div class='col-lg-5'>
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Category') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', '- <b>Adventure</b> - tell the story of your adventure;' ) ?></div>
                </div>
            </div>
            


            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Note to the editor:') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Use basic html syntax, MarkDown is not supported');?>
                    </div>
                </div>
            </div>




            <div class ='col-lg-5'>
                 <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'It is very difficult to find a special place without exact coordinates. Help other travelers, mark coordinates accurately.') ?></div>
                </div>
                
            </div>
            
    </div>
        
</div>
</div>
<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Ключ Golos') . '</h2>',
            'id' => 'modalKey',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('@frontend/modules/user/views/keys/keysForm');
        yii\bootstrap\Modal::end();

        ?>
    
        
<script>
    
    $('#add-form').on('beforeSubmit', function () {
          $('.loader_head').css('display', 'inline');
    });
 var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
       acc = getCookie(acc);
       if (acc){
          $('.account_name').text(acc);
       } else {
         $('<a id="key_modal_ask"><?php echo Yii::t('frontend', 'please enter Steem private posting key') ?></a>').appendTo('.account_name');
         $(":submit").attr("disabled", true);
       } 
       
       $(".account_name").click(function() {
          $('#modalKey').modal('show');
       });

</script>
 