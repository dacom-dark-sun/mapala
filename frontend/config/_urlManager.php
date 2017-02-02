<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        '/report/<action:index>' => 'report/<action>',
        '/ajax/<action>' => 'ajax/<action>',
        '/site/<action:add|show_single_blog|ico|stat|team|investors|set-locale|captcha|personal_history|image-upload>' => 'site/<action>',
        '/forms/<action>' => 'forms/<action>',
        '/page/<action>' => 'page/<action>',
        '/category/<categories>' => 'site/index',
        '<author:[\wd.-]+>/<permlink:[\wd.-]+>' => 'site/view',
        '<author:[\wd.-]+>' => 'site/index',
        '' => 'site/index',

    ]
];
