<?php 
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="row">
    <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <center>      <b> <?= Yii::t('frontend', 'Available: ') . $access_ref . ' BTC' ?> </b> </center>
                  </div>
                </div>
        
        
        <div class="col-lg-4">
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Referal bonuses') ?>
                    </div>
                           <div class="panel-body">
        <?= GridView::widget([
                    'dataProvider' => $ref_provider,
                    'summary'=>'',
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered'
                    ],
                        'columns' => [
                        /**
                         * Столбец нумерации. Отображает порядковый номер строки
                         */
                        [
                            'class' => \yii\grid\SerialColumn::class,
                        ],
                        /**
                         * Перечисленные ниже поля модели отображаются как колонки с данными без изменения
                         */
                        ['attribute' => 'referer', 
                         'label' => Yii::t('frontend', 'Referer'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                            ],

                        ['attribute' => 'amount_to_ref', 
                         'label' => Yii::t('frontend', 'Amount, BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                       

                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>                    </div>
                
                </div>
                
        
        

         
        
        </div>
        
        <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-body">
                    
        <?php //------ Begin active form and show the title
                    $form = ActiveForm::begin(['id' => 'add-form']); ?>
                 <?php //Show Location-------------------------------------------------------------
                echo $form->field($model, 'wallet')->input(['text'], ['placeholder' => Yii::t('frontend', 'Enter a BTC-Wallet'), 'id'=>'Wallet']); 
                ?>
                 <?php //Show Location-------------------------------------------------------------
                   echo $form->field($model, 'amount')->input(['text'], ['placeholder' => Yii::t('frontend', 'Amount to Withdraw'), 'id'=>'Amount']); 
              ?>
              
                       <?php echo Html::submitButton(Yii::t('frontend', 'Withdraw'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                       <?php ActiveForm::end(); ?>
            </div>
        </div>
        </div>
        
        
        <div class="col-lg-4">
        <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Withdraw') ?>
                    </div>
                           <div class="panel-body">
                       <?= GridView::widget([
                    'dataProvider' => $ref_wd_provider,
                    'summary'=>'',
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered'
                    ],
                        'columns' => [
                        /**
                         * Столбец нумерации. Отображает порядковый номер строки
                         */
                        [
                            'class' => \yii\grid\SerialColumn::class,
                        ],
                        /**
                         * Перечисленные ниже поля модели отображаются как колонки с данными без изменения
                         */
                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                        ['attribute' => 'created_at', 
                         'label' => Yii::t('frontend', 'Date, Time'),
                          'format'=>'datetime',
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                            ],

                        ['attribute' => 'status', 
                         'label' => Yii::t('frontend', 'Status'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                       

                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>
        
             </div>
                </div>

       
        </div>
        <div class="col-lg-4">
            <div class="panel panel-success">
                 <br>
                          <center> 
                           <?= Yii::t('frontend', 'Referal link: ')?>   </center>
                 <center>
                     <input type="text" id="link" style="width: 100%; text-align: center" value="http://mapala.net/?r=<?= Yii::$app->user->identity->username; ?>" readonly>
                            </center>
                 <center>
                            <span class ="btn btn-success change_category_btn" onclick="copyToClipboard_link();"> <?= Yii::t('frontend', 'Copy')?> </span>
                 </center>
            </div>            
        </div>
        
        
    </div>
</div>

