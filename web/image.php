<?php

$start = microtime(true);

// error_reporting(E_ALL);
// ini_set('show_errors', 1);

define('APP_DIR', dirname(__FILE__));

$sDir = APP_DIR;

if (isset($_GET['img'])) {
	$sImageName = strip_tags($_GET['img']);
}

$aParams = array();
if (substr($sImageName, 0, 7) == '/assets') {
	$aParams['path'] = $sDir . $sImageName;
} else {
	// http
	$aParams['path'] = $sImageName;
}
if (isset($_GET['asset'])) {
	$aParams['asset'] = strip_tags($_GET['asset']);
} else {
	// auto path parse
	$aPathParts = explode('/', $sImageName);
	if (count($aPathParts) > 2) {
		$aParams['asset'] = $aPathParts[2];
	}
}
if (isset($_GET['ext'])) {
	$aParams['ext'] = strip_tags($_GET['ext']);
} else {
	// auto path parse
	$aPathParts = explode('/', $sImageName);
	$sFileName = array_pop($aPathParts);
	$aFileParts = explode('.', $sFileName);
	if (count($aFileParts) > 1) {
		$aParams['ext'] = array_pop($aFileParts);
	}
}
if (isset($_GET['size'])) {
	$aParts = explode('x', strip_tags($_GET['size']));
	$aParams['width'] = (int)$aParts[0];
	$aParams['height'] = (int)$aParts[1];
}
if (isset($_GET['margin'])) {
	$aParams['margin'] = strip_tags($_GET['margin']);
}
if (isset($_GET['x'])) {
	$aParams['x'] = strip_tags($_GET['x']);
}
if (isset($_GET['y'])) {
	$aParams['y'] = strip_tags($_GET['y']);
}

$sFileHash = md5($aParams['path']);
// $sFileExt = $aParams['ext'];
header('Content-type: image/jpg');

if (isset($aParams['width']) && isset($aParams['height'])) {
	if (isset($aParams['asset'])) {
		$sTmpFile = APP_DIR . '/tmp/'.$aParams['asset'].'/'.$sFileHash.'-'.$aParams['width'].'-'.$aParams['width'].'.'.$aParams['ext'];
	} else {
		$sTmpFile = APP_DIR . '/tmp/'.$sFileHash.'-'.$aParams['width'].'-'.$aParams['width'].'.'.$aParams['ext'];
	}

	// echo $sTmpFile;
	
	if (file_exists($sTmpFile)) {
		echo file_get_contents($sTmpFile);
	} else {
		$sUrl = getImageUrl($sImageName, $aParams);
		echo file_get_contents(APP_DIR . '/' . $sUrl);
		// echo '<img src="'.$sUrl.'">';
	}
} else {
	if (substr($sImageName, 0, 7) == '/assets') {
		echo file_get_contents(APP_DIR . '/' . $sImageName);
	} else {
		echo file_get_contents($sImageName);
	}
}
// echo file_get_contents(APP_DIR . '/' . $sUrl);

function getImageUrl($sImageName, $aParams) {

	$sOriginImage = $aParams['path'];

	$sFileExt = isset($aParams['ext']) ? $aParams['ext'] : 'jpg';

	$iWidth = isset($aParams['width']) ? $aParams['width'] : 0;
	$iHeight = isset($aParams['height']) ? $aParams['height'] : 0;
	$bMargin = isset($aParams['margin']) ? $aParams['margin'] : true;
	$sCropX = isset($aParams['x']) ? $aParams['x'] : 'center';
	$sCropY = isset($aParams['y']) ? $aParams['y'] : 'center';


	$sFileHash = md5($sOriginImage);
	// $sFileName = $sFileHash.'-'.$iWidth.'-'.$iHeight.'-'.$bMargins.'.'.$sFileExt;
	$sFileName = $sFileHash.'-'.$iWidth.'-'.$iHeight.'.'.$sFileExt;

	if (isset($aParams['asset'])) {
		$sFilePath = APP_DIR.'/tmp/'.$aParams['asset'].'/'.$sFileName;
	} else {
		$sFilePath = APP_DIR.'/tmp/'.$sFileName;
	}
// echo $sFilePath;
	// if (file_exists($sFilePath)) {
	// 	echo 'file exists';
	// } else {
		//Console.log 'file does not exists';
		// require_once APP_DIR.'/php/ImageManipulator.php';
	require_once APP_DIR.'/../app/helpers/ImageManipulator.php';

		$oImageManipulator = new ImageManipulator();

		$oImageManipulator->loadImage($sOriginImage);

		$oImageManipulator->resize($iWidth, $iHeight, $bMargin, $sCropX, $sCropY);

		$oImageManipulator->save($sFilePath);
	// }

	// image source
	if (isset($aParams['asset'])) {
		return 'tmp/'.$aParams['asset'].'/'.$sFileName;
	} else {
		return 'tmp/'.$sFileName;
	}
}

$total = microtime(true) - $start;
// echo (int)($total * 1000).'ms';