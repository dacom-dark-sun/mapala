<?php
$config = [
    'homeUrl'=>Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'comment' => [
        'class' => 'yii2mod\comments\Module',
        // use comment controller event example
        'controllerMap' => [
            'default' => [
                'class' => 'yii2mod\comments\controllers\DefaultController',
                'on afterCreate' => function ($event) {
                    // get saved comment model
                    $event->getCommentModel();
                    // your custom code
                }
            ]
        ],
    
    ],
      'markdown' => [
        // the module class
        'class' => 'kartik\markdown\Module',
        
        // the controller action route used for markdown editor preview
        'previewAction' => '/markdown/parse/preview',
        
        // the controller action route used for downloading the markdown exported file
        'downloadAction' => '/markdown/parse/download',
        
        // the list of custom conversion patterns for post processing
        'customConversion' => [
            '<table>' => '<table class="table table-bordered table-striped">'
        ],
        
        // whether to use PHP SmartyPantsTypographer to process Markdown output
        'smartyPants' => false,
        
        // array the the internalization configuration for this module
       
    ],
                    
        'user' => [
            'class' => 'frontend\modules\user\Module',
            //'shouldBeActivated' => true
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module'
            ]
        ]
    ],
    'components' => [
         'assetManager' => [
                'bundles' => [
                    'dosamigos\google\maps\MapAsset' => [
                        'options' => [
                            'key' => 'AIzaSyC9PkCzTGG3Ial2tkDuSmmZvV2joFfzj0Y',
                            'language' => 'en',
                            'version' => '3.1.18'
                        ]
                    ]
                ]
            ],
        
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'=>['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators'=>[
            'crud'=>[
                'class'=>'yii\gii\generators\crud\Generator',
                'messageCategory'=>'frontend'
            ]
        ]
    ];
}

return $config;
