<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);defined('YII_ENV') or define('YII_ENV', 'dev');//prod | dev
//defined('YII_DEBUG') or define('YII_DEBUG', false);defined('YII_ENV') or define('YII_ENV', 'prod'); //prod | dev

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

if(isset($_GET['phpinfo'])){
    phpinfo();
}

if (YII_ENV == 'dev') {
    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', 'On');
}


$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
