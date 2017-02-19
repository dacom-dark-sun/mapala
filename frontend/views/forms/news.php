
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\models\Countries;
use vova07\imperavi\Widget;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use common\models\OurCategory;
use yii\helpers\Html;
use common\models\BlockChain;
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 

$this->title = Yii::t('frontend','News');

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
          
                <?php //-------SHOW Categories-----------------//TODO - List PRE-data.   
                    echo $form->field($model, 'tags')->widget(Select2::classname(),[
                        'options' => ['placeholder' => 'Select a category ...'],
                        "data" => ArrayHelper::map(OurCategory::find()
                            ->Where(['model' => StringHelper::basename(get_class($model))])
                            ->all(), BlockChain::get_blockchain_from_locale(), BlockChain::get_blockchain_from_locale()),
                    //---------------------------------------------------------------------
                        ]);?> 

           <?php //---------------- EDITOR------------------------------
                 echo $form->field($model, 'body')->widget(Widget::className(), [
                    'settings' => [
                        'minHeight' => 400,
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
                       </div>
                       <div class="account_name"></div>
                   </div>
                   <?php ActiveForm::end(); ?>
                                 
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
       
    
    $('#add-form').on('beforeSubmit', function () {
          $('.loader_head').css('display', 'inline');
    });
    
     
</script>