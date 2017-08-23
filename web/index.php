<?php

use Aya\Core\Logger;
use Aya\Core\Router;
use Aya\Helper\Time;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';

// analytics
Time::start();

error_reporting(E_ALL);

Logger::addLogSpace('404', LOG_DIR.'/404/'.date('Y-m-d').'.log');
Logger::addLogSpace('visits', LOG_DIR.'/visits/'.date('Y-m-d').'.log');
Logger::addLogSpace('issues', LOG_DIR.'/issues/'.date('Y-m-d').'.log');
Logger::addLogSpace('redirects', LOG_DIR.'/redirects/'.date('Y-m-d').'.log');

Logger::logStandardRequest('visits');

// ob_start('ob_gzhandler');
ob_start();

Router::init();

ob_end_flush();
