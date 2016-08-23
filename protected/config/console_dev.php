<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    'import'=>array(
        'ext.YiiMailer.YiiMailer',
    ),
    'modules'=>array(
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
        ),
    // application components
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=server5_ds',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
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
    ),
);