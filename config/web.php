<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',

            // the global settings for the disqus widget
            // 'disqus' => [
            //     'settings' => ['shortname' => 'DISQUS_SHORTNAME'] // default settings
            // ],

            // the global settings for the facebook plugins widget
            'facebook' => [
                'appId' => '1046596572030272',
                'secret' => 'a883dbc53a6d232568af93d9e02f03e7',
            ],

            // the global settings for the google plugins widget
            // 'google' => [
            //     'pageId' => 'GOOGLE_PLUS_PAGE_ID',
            //     'clientId' => 'GOOGLE_API_CLIENT_ID',
            // ],

            // the global settings for the google analytic plugin widget
            // 'googleAnalytics' => [
            //     'id' => 'TRACKING_ID',
            //     'domain' => 'TRACKING_DOMAIN',
            // ],

            // the global settings for the twitter plugins widget
            // 'twitter' => [
            //     'screenName' => 'TWITTER_SCREEN_NAME'
            // ],
        ]
    ],
    'components' => [
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'itemojkiyd',
        ],
        // 'cache' => [
        //     'class' => 'yii\caching\FileCache',
        // ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 60,
                ]
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserMaster',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'boundstate\mailgun\Mailer',
            'key' => 'key-4613485ce7b9137d9a8b3c516aa26c34',
            'domain' => 'sandboxc6a5d672bcdd436080b5661000efa459.mailgun.org',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    'clientId' => '1046596572030272',
                    'clientSecret' => 'a883dbc53a6d232568af93d9e02f03e7',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'item/<id:\d+>' => 'site/item',
                'store/<id:\d+>' => 'site/store',
                'checkout/<id:\d+>' => 'site/checkout',
                '<action>'=>'site/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['components']['assetManager']['forceCopy'] = true;
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
