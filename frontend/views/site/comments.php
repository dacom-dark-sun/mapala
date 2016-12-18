
<?php echo common\modules\comments\widgets\Comment::widget([
    'model' => $model,
    'clientOptions' => [
        'pjaxSettings' => [
            'url' => \yii\helpers\Url::to(['/site/comments/', 'permlink' => $model->permlink]),
            'timeout' => 20000,
            'scrollTo' => false,
            'enablePushState' => false
        ]
    ]
]); ?>
