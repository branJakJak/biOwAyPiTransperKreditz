<?php

// change the following paths if necessary
$vendors=dirname(__FILE__).'/../vendor/autoload.php';
$yiit=dirname(__FILE__).'/../../../yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';



require_once($vendors);
require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');


Yii::createWebApplication($config);

