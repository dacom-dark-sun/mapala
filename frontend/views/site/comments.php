
<?php echo \yii2mod\comments\widgets\Comment::widget([
    'model' => $model,
    'clientOptions' => [
        'pjaxSettings' => [
            'url' => \yii\helpers\Url::to(['/site/comments/', 'permlink' => $model->permlink]),
            'timeout' => 10000,
            'scrollTo' => false,
            'enablePushState' => false
        ]
    ]
]); ?>
