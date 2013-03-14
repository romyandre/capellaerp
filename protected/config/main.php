<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Capella ERP Indonesia',

	// preloading 'log' component
	'preload'=>array(
		'bootstrap'
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.fpdf.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array(
				  'bootstrap.gii'
			 ),
		),
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
    'session'=>array(
      'class' => 'system.web.CDbHttpSession',
      'connectionID' => 'db',
'autoStart' => true
    ),	
		// uncomment the following to use a MySQL database
		'db'=>array(
		'connectionString' => 'mysql:host=localhost;dbname=capella',
		'emulatePrepare' => true,
		'username' => 'capella',
		'password' => 'capella',
		'charset' => 'utf8',
		'initSQLs'=>array('set names utf8'),
		//'enableProfiling'=>true,
	'enableParamLogging' => true,
	'schemaCachingDuration' => 3600,
	),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'director@prismadataabadi.com',
		'defaultPageSize'=>5,
		'defaultnumberqty'=>'#,##0.00',
'defaultnumberprice'=>'#,##0.0000',
'dateviewfromdb'=>'d-M-Y',
        'dateviewcjui'=>'dd-mm-yy',
        'dateviewgrid'=>'dd-MM-yyyy',
        'datetodb'=>'Y-m-d',
        'timeviewfromdb'=>'h:m',
        'datetimeviewfromdb'=>'d-M-Y h:i',
        'timeviewcjui'=>'h:m',
        'datetimeviewgrid'=>'dd-MM-yyyy H:m',
        'datetimetodb'=>'Y-m-d h:i',
	),
);