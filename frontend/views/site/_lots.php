<?php
use yii\grid\GridView;
?> 
  <?= GridView::widget([
                    'dataProvider' => $lots,
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
                       
                        ['attribute' => 'total_amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                        ],
                            
                        
                        ['attribute' => 'total_amount_in_usd', 
                         'label' => Yii::t('frontend', 'Amount, USD'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                        ],
                        
                            
                         ['attribute' => 'solded', 
                         'label' => Yii::t('frontend', 'Solded, %'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                            
                          
                        ['attribute' => 'discount', 
                         'label' => Yii::t('frontend', 'Discount, %'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                            
                       
                        
                      


                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>

                 
                 