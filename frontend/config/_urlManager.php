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
        '<author:[\wd.-]+>/<permlink:[\wd.-]+>' => 'site/view',
        '<author:[\wd.-]+>' => 'site/index',
        '' => 'site/index',
    ]
];
