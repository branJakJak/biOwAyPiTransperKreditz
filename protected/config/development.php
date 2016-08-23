<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$yiiApplicationConfiguration = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'VOIP Credits',
    'theme' => 'abound',
    // preloading 'log' component
    'preload' => array('log', 'maintenanceMode'),
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.bestvoipAPI.*',
        'application.components.dataprovider.*',
        'application.commands.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.extensions.TopupLogs.*',
        'bootstrap.helpers.TbHtml',
        'bootstrap.helpers.TbArray',
        'bootstrap.behaviors.TbWidget',
        'ext.YiiMailer.YiiMailer',
    ),
    'modules' => array(
        'user' => array(
            'tableUsers' => 'tbl_users',
            'tableProfiles' => 'tbl_profiles',
            'tableProfileFields' => 'tbl_profiles_fields',
            'hash' => 'md5',
            'sendActivationMail' => true,
            'loginNotActiv' => true,
            'activeAfterRegister' => true,
            'autoLogin' => true,
            'registrationUrl' => array('/user/registration'),
            'recoveryUrl' => array('/user/recovery'),
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/sipAccount/index'),
            'returnLogoutUrl' => array('/user/login'),
        ),
        'rights' => array(
            'superuserName' => 'admin', // Name of the role with super user privileges.
            'authenticatedName' => 'Authenticated',  // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username',  // Name of the user name column in the database.
            'enableBizRule' => true,  // Whether to enable authorization item business rules.
            'enableBizRuleData' => true,   // Whether to enable data for business rules.
            'displayDescription' => true,  // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'rights.views.layouts.main',  // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'cssFile' => 'rights.css', // Style sheet file to use for Rights.
            'debug' => false,
        ),
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'topUpMainAccount'=>array(
            'class'=>'application.components.TopUpMainAccount'
        ),
        'topUpCustomerAccount'=>array(
            'class'=>'application.components.TopupCustomerAccount'
        ),
        'campaignInformationRetriever'=>array(
            'class'=>'application.components.CampaignInformationRetriever'
        ),
        'hopperListData'=>array(
            'class'=>'application.components.HopperListDataRetriever'
        ),
        'activeCallReport'=>array(
            'class'=>'application.components.ActiveCallReport'
        ),
        'ringingReport'=>array(
            'class'=>'application.components.RingingReport'
        ),
        'liveCallReport'=>array(
            'class'=>'application.components.LiveActiveCallReport'
        ),
        'channelReport'=>array(
            'class'=>'application.components.ChannelReport'
        ),
        'campaignForcer' => array(
            'class' => 'application.components.CampaignForcer'
        ),
        'vicidialDbHelper' => array(
            'class' => 'application.components.VicidialDbHelper'
        ),
        'controlDataSourceRetirever' => array(
            'class' => 'application.components.ControlDataSourceRetriever'
        ),
        'vicidialDeactivator' => array(
            'class' => 'application.components.VicidialDbDeactivator'
        ),
        'vicidialActivator' => array(
            'class' => 'application.components.VicidialDbActivator'
        ),
        'maintenanceMode' => array(
            'class' => 'application.extensions.MaintenanceMode.MaintenanceMode',
            'enabledMode' => false,
            'message' => 'We are off air at the moment. Please come back later.<br><b>This downtime will last 3 hours</b>',
            'users' => array('admin'),
            'urls' => array('user/login'),
        ),
        'user' => array(
            'class' => 'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
            'assignmentTable' => 'authassignment',
            'rightsTable' => 'rights',
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        'yiiwheels' => array(
            'class' => 'ext.yiiwheels.YiiWheels',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=server5_ds',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'asterisk_db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=68.168.223.221;dbname=asterisk',
            'emulatePrepare' => true,
            'username' => 'paulit',
            'password' => 'Mad4itNOW!!',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    // 'class' => 'CFileLogRoute',
                    'class' => 'CWebLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'categories' => 'activation',
                    'logFile' => 'activation_log',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'categories' => 'deactivation',
                    'logFile' => 'deactivation_log',
                ),
                // uncomment the following to show log messages on web pages
                /*
                  array(
                  'class'=>'CWebLogRoute',
                  ),
                  array(
                  'class'=>'CEmailLogRoute',
                  'levels'=>'error',
                  'emails'=>'hellsing357@gmail.com',
                  ),
                 */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'notifyEnabled' => false
    ),
);


if (YII_DEBUG) {
    $yiiApplicationConfiguration['components']['hopperListData'] = array(
            'class'=>'application.placeholder.HopperListDataRetrieverPlaceholder'
    );
}

return $yiiApplicationConfiguration;