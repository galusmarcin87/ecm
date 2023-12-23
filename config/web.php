<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$bootstrap = ['log', 'languageSwitcher'];
if (YII_ENV == 'prod') {
  $bootstrap[] = 'assetsAutoCompress';
}

$config = [
    'id' => 'basic',
    'name' => 'Opal',
    'basePath' => dirname(__DIR__),
    'bootstrap' => $bootstrap,
    'language' => 'pl',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => require __DIR__ . '/components.php',
    'modules' => [
        'backend' => [
            'class' => 'app\modules\backend\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'datecontrol' => require __DIR__ . '/inc/datecontrol.php',
        'file' => [
            'class' => '\rmrevin\yii\module\File\Module',
            'upload_alias' => '@app/web/upload',
            'upload_web_alias' => '/upload',
            'storage_alias' => '@app/web/storage',
            'storage_web_alias' => '/storage',
            'max_upload_file_size' => 10, // megabytes
        ],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',
            // the global settings for the disqus widget
            'disqus' => [
                'settings' => ['shortname' => 'mgcms'] // default settings
            ],
            // the global settings for the facebook plugins widget
            'facebook' => [
                'app_id' => '556556',
                'app_secret' => 'dsfsd',
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
      // uncomment the following to add your IP if you are not connecting from localhost.
      //'allowedIPs' => ['127.0.0.1', '::1'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
      'generators' => [//here
          'enhanced-gii-crud' => [// generator name
              'class' => 'app\gii\generators\crud\Generator', // generator class
              'templates' => [//setting for out templates
                  'mgcms' => '@app/gii/generators/crud/mootensai_mgcms', // template name => path to template
              ]
          ],
          'enhanced-gii-model-mgcms' => [// generator name
              'class' => 'app\gii\generators\model\Generator', // generator class
              'templates' => [//setting for out templates
                  'mgcms' => '@app/gii/generators/model/mootensai_mgcms', // template name => path to template
              ]
          ]
      ],
      // uncomment the following to add your IP if you are not connecting from localhost.
      //'allowedIPs' => ['127.0.0.1', '::1'],
  ];
}

return $config;
