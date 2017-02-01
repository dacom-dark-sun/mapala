<?php
$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
     //   'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'/site/_item',
        'summary'=>'',
    ]);
    


