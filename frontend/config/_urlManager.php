<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        '' => 'site/index',
       '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ]
];
