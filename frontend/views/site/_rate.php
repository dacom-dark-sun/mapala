<?php 
use miloschuman\highcharts\Highcharts;
?>

<?php
  //var_dump($yaxis);
  echo Highcharts::widget([
   'options' => [
      'title' => ['text' => Yii::t('frontend', 'Инвестируй в первое применение технологии блокчейн в реальном мире')],
      'xAxis' => [
         'categories' => $xaxis
      ],
      'yAxis' => [
         'title' => ['text' => 'BTC/MPL * 10^-6']
      ],
      'series' => [
         ['name' => Yii::t('frontend', 'Middle Rate'), 'data' => $yaxis],
      ]
   ]
]);
  ?>
        