<?php

// opcache_reset();
// ini_set('opcache.enable', 0);

use Aya\Core\Logger;
use Aya\Core\Router;
use Aya\Helper\Time;

use Aya\Exception\MissingControllerException;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';

// analytics
Time::start();

error_reporting(E_ALL);

// ini_set('opcache.enable', '0');

Logger::addLogSpace('404', LOG_DIR.'/404/'.date('Y-m-d').'.log');
Logger::addLogSpace('visits', LOG_DIR.'/visits/'.date('Y-m-d').'.log');
Logger::addLogSpace('issues', LOG_DIR.'/issues/'.date('Y-m-d').'.log');
Logger::addLogSpace('redirects', LOG_DIR.'/redirects/'.date('Y-m-d').'.log');

Logger::logStandardRequest('visits');

// ob_start('ob_gzhandler');
ob_start();

$controller = Router::init();

// try {

// } catch (MissingControllerException $e) {
//     $controller->setTemplateName('404');
//     Logger::logStandardRequest('404');
// }

$controller->run();

ob_end_flush();
