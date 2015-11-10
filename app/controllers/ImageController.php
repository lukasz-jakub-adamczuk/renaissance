<?php
// require_once APP_DIR.'/controllers/FrontController.php';
require_once ROOT_DIR.'/image-manipulator/ImageManipulator.php';
}

class ImageController extends FrontController {

    public function indexAction() {
        echo 'image-index...';
    }

	public function showAction() {
	    //require_once APP_DIR.'/ImageManipulator.php';
	    
	    $sFile = isset($_GET['name']) ? APP_DIR.'/pub/img/'.str_replace(',', '/', $_GET['name']) : APP_DIR.'/wall-1.jpg';

        $iWidth = isset($_GET['width']) ? (int)$_GET['width'] : 160;
        $iHeight = isset($_GET['height']) ? (int)$_GET['height'] : 120;
        
        $bMargins = isset($_GET['margins']) ? (int)$_GET['margins'] : 0;
        
        $sHorCrop = isset($_GET['crop_x']) ? (int)$_GET['crop_x'].'' : '50';
        $sVerCrop = isset($_GET['crop_y']) ? (int)$_GET['crop_y'].'' : '50';

//    echo $sFile;

    $sHash = md5_file($sFile);
    $sNewFile = APP_DIR.'/pub/tmp/'.$sHash.'-'.$iWidth.'-'.$iHeight.'-'.$bMargins.'-'.$sHorCrop.'-'.$sVerCrop.'.jpg';

    if (!file_exists($sNewFile)) {
        

    $oImageManipulator = new ImageManipulator();

    $oImageManipulator->loadImage($sFile);

    //$oImageManipulator->resize(320, 200, false, 'center', 'top');
    $oImageManipulator->resize($iWidth, $iHeight, $bMargins, $sHorCrop.'%', $sVerCrop.'%');
    //$oImageManipulator->resize(320, 200, false, 'center', 'top');
    
    //$oImageManipulator->resize(200, 500, true, '10%', 'top');

    //$oImageManipulator->resize(600, 960);
    //$oImageManipulator->resize(960, 600);
    //$oImageManipulator->resize(600, 600);
    //$oImageManipulator->show();
    
    
    //$sNewFile = APP_DIR.'/../ola/img/thumbs/'.(isset($_GET['image']['file']) ? $_GET['image']['file'] : 'result.jpg');
    //$sNewFile = APP_DIR.'/../pub/img/'.(isset($_GET['image']['file']) ? $_GET['image']['file'] : 'result.jpg');
    
//echo 'RESIZE';

//    $sHash = md5_file($sFile);

    //$sNewFile = APP_DIR.'/app/tmp/img-'.$sHash.'-'.$iWidth.'-'.$iHeight.'-'.$bMargins.'.jpg';
//    $sNewFile = APP_DIR.'/pub/tmp/'.$sHash.'-'.$iWidth.'-'.$iHeight.'-'.$bMargins.'-'.$sHorCrop.'-'.$sVerCrop.'.jpg';
    //$sNewFile = APP_DIR.'/app/tmp/image-test-'.$iWidth.'-'.$iHeight.'.jpg';
    //$sNewFile = APP_DIR.'/app/tmp/image-'.$iWidth.'-'.$iHeight.'.jpg';
    
    $oImageManipulator->save($sNewFile);
    
}


if (isset($_GET['serve'])) {
    // basic headers
    header("Content-type: image/jpg");
    header("Expires: Mon, 1 Jan 2099 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
     
    // get the file name
    //$file=@$_GET['file'];
    
    if (file_exists($sNewFile)) {
        $file=$sNewFile;
    } else {
        $file=$sNewFile;
    }
     
    // get the size for content length
    $size= filesize($file);
    header("Content-Length: $size bytes");
     
    // output the file contents
    readfile($file);
}    


//    $oImageManipulator->save(APP_DIR.'pub/tmp/obraz.jpg');
    
    
    	
	}
}

?>
