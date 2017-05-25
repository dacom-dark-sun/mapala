<?php 
use yii\grid\GridView;
use common\models\BitCoin;
?>
<h3> Investors </h3>
Total BTC : <?= $total_btc ?> <br>
Total Tokens : <?= round($total_tokens) ?> <br>
<?= GridView::widget([
                    'dataProvider' => $data_provider,
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
                        ['attribute' => 'name', 
                         'label' => Yii::t('frontend', 'Username'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                      
                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                        
                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                      
                            
                        


                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>

<h3>Team</h3>
        <?= GridView::widget([
                    'dataProvider' => $data_provider2,
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
                        ['attribute' => 'name', 
                         'label' => Yii::t('frontend', 'Username'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],

                      
                        ['attribute' => 'amount', 
                         'label' => Yii::t('frontend', 'Amount, BTC'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                        
                        ['attribute' => 'tokens', 
                         'label' => Yii::t('frontend', 'Tokens'),
                         'contentOptions' => ['class' => 'text-center'],
                         'headerOptions' => ['class' => 'text-center']
                         ],
                      
                            
                        


                        /**
                         * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
                         */],
                ]);?>

        
        