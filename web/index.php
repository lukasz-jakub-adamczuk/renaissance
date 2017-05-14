<?php

// settings
date_default_timezone_set('Europe/Warsaw');
setlocale(LC_ALL, 'pl_PL.UTF8');

// load config
if ($_SERVER['HTTP_HOST'] == 'squarezone.pl') {
	error_reporting(0);
	require_once 'config/production.php';
} else {
	// if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == IP) {
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		require_once 'config/local.php';
	}
	if ($_SERVER['HTTP_HOST'] == 'squarezone.dev') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		require_once 'config/vhost.php';
	}
	if ($_SERVER['HTTP_HOST'] == 'beta.squarezone.pl') {
		error_reporting(0);
		require_once 'config/beta.php';
	}
	if ($_SERVER['HTTP_HOST'] == 'dev.squarezone.pl') {
		error_reporting(E_ALL);
		require_once 'config/dev.php';
	}
}

// analytics
require_once AYA_DIR.'/Core/Time.php';

Time::start();

require_once AYA_DIR.'/Core/Logger.php';

Logger::addLogSpace('404', LOG_DIR.'/404/'.date('Y-m-d').'.log');

Logger::addLogSpace('visits', LOG_DIR.'/visits/'.date('Y-m-d').'.log');
Logger::addLogSpace('issues', LOG_DIR.'/issues/'.date('Y-m-d').'.log');
Logger::addLogSpace('redirects', LOG_DIR.'/redirects/'.date('Y-m-d').'.log');

Logger::logStandardRequest('visits');


// begin all
require_once AYA_DIR.'/Core/Starter.php';

Starter::init();

require_once AYA_DIR.'/Core/Debug.php';

require_once AYA_DIR.'/Core/Db.php';
require_once AYA_DIR.'/Core/Dao.php';
require_once AYA_DIR.'/Core/User.php';
require_once AYA_DIR.'/Core/Navigator.php';
require_once AYA_DIR.'/Core/MessageList.php';
require_once AYA_DIR.'/Core/Router.php';


require_once AYA_DIR.'/Helpers/Breadcrumbs.php';
require_once AYA_DIR.'/Helpers/ValueMapper.php';
require_once AYA_DIR.'/Helpers/RelatedActions.php';


require_once CTRL_DIR.'/FrontController.php';
require_once CTRL_DIR.'/CrudController.php';

// ob_start('ob_gzhandler');
ob_start();
// echo 'renaissance';
Router::init();

ob_end_flush();
