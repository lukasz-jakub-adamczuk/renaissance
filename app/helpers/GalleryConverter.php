<?php
require_once AYA_DIR.'/Core/Folder.php';

class GalleryConverter {

	// const 'SRV_URL';

	static public function check($iId, $sCategory, $aImages) {
		$sLocalPath = '/'.$sCategory.'/'.$iId;
		$sAssetsPath = '/assets/gallery' . $sLocalPath;
		$sCompletePath = ASSETS_DIR . $sAssetsPath;

		// create directory if does not exists
		if (!file_exists($sCompletePath)) {
			if (mkdir($sCompletePath, 0755, true)) {
				// maybe history log could be useful
				
				// make each directory is writable
				$aParts = explode('/', $sLocalPath);
				$sTmpPath = ASSETS_DIR . '/assets/gallery';
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

		$aAssets = array();

		// images download
		$i = 0;
		foreach ($aImages as $ik => $img) {
			$sSrvUrl = 'http://squarezone.pl/galeria';
			$sRemotePath = $sSrvUrl . '/' . $img['id_gallery_image'] . '.' . $img['mime'];

			$sImageName = '/img-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.' . $img['mime'];
			
			file_put_contents($sCompletePath . $sImageName, file_get_contents($sRemotePath));

			$aAssets[$ik] = $sAssetsPath . $sImageName;
			$i++;
		}
		return $aAssets;
	}
}