<?php

require_once dirname(__FILE__) . '/../app/bootstrap.php';

// begin all
require_once AYA_DIR.'/Core/Starter.php';

Starter::init();


// analytics

Time::start();

Logger::addLogSpace('404', LOG_DIR.'/404/'.date('Y-m-d').'.log');
Logger::addLogSpace('visits', LOG_DIR.'/visits/'.date('Y-m-d').'.log');
Logger::addLogSpace('issues', LOG_DIR.'/issues/'.date('Y-m-d').'.log');
Logger::addLogSpace('redirects', LOG_DIR.'/redirects/'.date('Y-m-d').'.log');
Logger::logStandardRequest('visits');




require_once AYA_DIR.'/Helpers/Breadcrumbs.php';
require_once AYA_DIR.'/Helpers/ValueMapper.php';
require_once AYA_DIR.'/Helpers/RelatedActions.php';


require_once CTRL_DIR.'/FrontController.php';
require_once CTRL_DIR.'/CrudController.php';

// ob_start('ob_gzhandler');
ob_start();

Router::init();

ob_end_flush();
