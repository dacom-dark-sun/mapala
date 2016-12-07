<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>


<?php 
echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager' => ['class' => kop\y2sp\ScrollPager::className(), 'item' => '.article-item'],
        'itemView'=>'/site/_item',
        'summary'=>'',
    ]);
    


