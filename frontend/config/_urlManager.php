<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        '/ajax/<action>' => 'ajax/<action>',
        '/site/<action:add|show_single_blog|ico|image-upload>' => 'site/<action>',
        '/forms/<action>' => 'forms/<action>',
        '/page/<action>' => 'page/<action>',
        '/category/<categories>' => 'site/index',
        '<author:\w+>/<permlink:[\w-]+>' => 'site/view',
        '<author:\w+>' => 'site/index',
        '' => 'site/index',
    ]
];
