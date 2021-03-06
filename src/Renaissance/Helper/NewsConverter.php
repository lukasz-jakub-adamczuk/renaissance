<?php

namespace Renaissance\Helper;

use Aya\Core\Folder;

class NewsConverter {

    // const 'SRV_URL';

    static public function check($iId, $year, $month, $day, $aImages) {
        $sLocalPath = '/'.$year.'/'.$month.'/'.$day.'/'.$iId;
        $sAssetsPath = '/assets/news' . $sLocalPath;
        $sCompletePath = WEB_DIR . $sAssetsPath;
        // $sCompletePath = '/home/ash/domains/dev.squarezone.pl' . $sAssetsPath;
        // echo $sCompletePath;

        // create directory if does not exists
        if (!file_exists($sCompletePath)) {
            if (mkdir($sCompletePath, 0755, true)) {
                // maybe history log could be useful
                
                // make each directory is writable
                $aParts = explode('/', $sLocalPath);
                $sTmpPath = WEB_DIR . '/assets/news';
                // $sTmpPath = '/home/ash/domains/dev.squarezone.pl' . $sAssetsPath;
                foreach ($aParts as $dir) {
                    if ($dir) {
                        $sTmpPath .= '/' . $dir;
                        // echo substr(sprintf('%o', fileperms($sTmpPath)), -4);
                        chmod($sTmpPath, 0755);
                    }
                }
            }
        } else {
            // echo 'dir exists';
        }

        $aAssets = [];

        // images download
        $i = 0;
        foreach ($aImages as $ik => $img) {
            $sSrvUrl = 'http://squarezone.pl/galeria';
            $sRemotePath = $sSrvUrl . '/' . $img['id_news_image'] . '_news_big.' . $img['mime'];

            $sImageName = '/img-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.' . $img['mime'];
            
            file_put_contents($sCompletePath . $sImageName, file_get_contents($sRemotePath));

            $aAssets[$ik] = $sAssetsPath . $sImageName;
            $i++;
        }
        return $aAssets;

        // $aAllContent = Folder::getContent($sCompletePath, true);

        // return $commentsForm;
    }
}