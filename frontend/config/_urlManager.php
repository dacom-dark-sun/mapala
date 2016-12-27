<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
       'site/<action:\w+>/<author:\w+>/<permlink:\w+>' => 'site/<action>',
        'site/<action:\w+>/<author:\w+>' => 'site/<action>',
        '' => 'site/index',
        
      
      
    ]
];
