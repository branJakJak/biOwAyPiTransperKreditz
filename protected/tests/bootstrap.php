<?php

error_log(E_ALL);
ini_set('display_errors', true);
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// change the following paths if necessary
$vendors=dirname(__FILE__).'/../vendor/autoload.php';
$yiit=dirname(__FILE__).'/../../../yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/console_dev.php';



require_once($vendors);
require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');


Yii::createWebApplication($config);

