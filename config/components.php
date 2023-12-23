<?php
$arr = [
    'request' => [
// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'alsdaf8*D(as8dasj',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
        'defaultDuration' => 3600,
    ],
    'user' => [
        'identityClass' => 'app\models\mgcms\db\User',
        'enableAutoLogin' => true,
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
// 'useFileTransport' to false and configure a transport
// for the mailer to send real emails.
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 's6.cyber-folks.pl',
            'username' => 'test@opal.vertes-projekty.pl',
            'password' => 'NPf-2)-dM5O.!kFQ',
            'port' => '587',
            'encryption' => '',
        ],
        // send all mails to a file by default. You have to set
// 'useFileTransport' to false and configure a transport
// for the mailer to send real emails.
        'useFileTransport' => false,
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'logVars' => [],
                'categories' => ['own'],
                'exportInterval' => 1,
                'logFile' => '@app/runtime/logs/my.log',

            ],
        ],
    ],
    'db' => $db,
    'urlManager' => require __DIR__ . '/router.php',
    'assetManager' => [
        'appendTimestamp' => false,
        'forceCopy' => YII_DEBUG ? true : false,
        'converter' => [
            'commands' => [
                'scss' => ['css', 'sass {from} {to}']
            ],
            'class' => 'nizsheanez\assetConverter\Converter',
            'parsers' => [
                'less' => [// file extension to parse
                    'class' => 'nizsheanez\assetConverter\Less',
                    'output' => 'css', // parsed output file type
                    'options' => [
                        'auto' => true, // optional options
                    ]
                ]
            ]
        ],
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                'js' => ['/js/jquery.min.js']
            ],
            'yii\bootstrap\BootstrapAsset' => [
                'css' => [
                    'bootstrap.css' => null
                ]
            ]
        ],
    ],
    'assetsAutoCompress' =>
        [
            'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
        ],
    'assetsAutoCompress' => require __DIR__ . '/inc/assetsAutoCompress.php',
    'i18n' => [
        'class' => vintage\i18n\components\I18N::className(),
        'languages' => $params['languages'],
        'messageTable' => 'i18n_message',
        'sourceMessageTable' => 'i18n_source_message',
        'translations' => [
            'app' => [
                'class' => yii\i18n\PhpMessageSource::className(),
            ],
        ]
    ],
    'formatter' => [
        'class' => 'app\components\mgcms\MgcmsFormatter',
    ],
    'languageSwitcher' => [
        'class' => 'app\components\mgcms\languageSwitcher',
    ],
//    'reCaptcha' => [
//        'name' => 'reCaptcha',
//        'class' => 'app\components\mgcms\recaptcha\ReCaptcha',
//        'siteKey' => '6LeA-CUbAAAAACVgBPUjUY2PfRo3HOaK3gVzVyPj',
//        'secret' => '6LeA-CUbAAAAAErEaliKQa3oKkP7uVxJCP6x7mg2',
//    ],
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '167967777518-nifdgpfeos5g12diu9ntc6i1g5gp8j0c.apps.googleusercontent.com',
                'clientSecret' => 'VCnbwo6MIGdeRsRkMe-JdUc0'
            ],
            'facebook' => [
                'class' => 'yii\authclient\clients\Facebook',
                'clientId' => 'facebook_client_id',
                'clientSecret' => 'facebook_client_secret',
            ],
        ],
    ],
    'socialShare' => [
        'class' => \ymaker\social\share\configurators\Configurator::class,
        'socialNetworks' => [
            'facebook' => [
                'class' => \ymaker\social\share\drivers\Facebook::class,
                'options' => ['class' => 'social-icons__icon social-icons__icon--fb'],
                'label' => '<img src="/svg/facebook.svg" alt="" />'
            ],
            'twitter' => [
                'class' => \ymaker\social\share\drivers\Twitter::class,
                'label' => '<img src="/svg/twitter.svg" alt="" />',
                'options' => ['class' => 'social-icons__icon social-icons__icon--tw'],
            ],
            'linkedin' => [
                'class' => \ymaker\social\share\drivers\LinkedIn::class,
                'label' => '<img src="/svg/linkedin.svg" alt="" />',
                'options' => ['class' => 'social-icons__icon social-icons__icon--ln'],
            ],
        ],
        'options' => [
            'class' => 'social-icons social-icons--color',
        ],
    ],
    'ip2location' => [
        'class' => 'app\components\IP2Location\Geolocation',
        'database' => __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'IP2Location'.DIRECTORY_SEPARATOR.'IP2LOCATION-LITE-DB1.BIN',
        'mode' => 'FILE_IO',
    ],
];

return $arr;
