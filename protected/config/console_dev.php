<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'preload' => array('log'),    
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
    ),
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
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username', // Name of the user name column in the database.
            'enableBizRule' => true, // Whether to enable authorization item business rules.
            'enableBizRuleData' => true, // Whether to enable data for business rules.
            'displayDescription' => true, // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'rights.views.layouts.main', // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'cssFile' => 'rights.css', // Style sheet file to use for Rights.
            'debug' => false,
        ),
    ),
    // application components
    'components' => array(
        'topUpMainAccount'=>array(
            'class'=>'application.components.bestvoipAPI.TopUpMainAccount'
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
            'class' => 'application.components.LocalCampaignEnforcer'
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
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=server5_ds',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
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
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username', // Name of the user name column in the database.
            'enableBizRule' => true, // Whether to enable authorization item business rules.
            'enableBizRuleData' => true, // Whether to enable data for business rules.
            'displayDescription' => true, // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'rights.views.layouts.main', // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'cssFile' => 'rights.css', // Style sheet file to use for Rights.
            'debug' => false,
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'categories' => 'scheduled_force_agent',
                    'logFile' => 'scheduled_force_agent_log',
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
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'categories' => 'log_credits',
                    'logFile' => 'log_credits',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                ),

            ),
        ),

    ),
);