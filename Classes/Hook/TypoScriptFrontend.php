<?php
/**
 * TypoScriptFrontend Hook
 *
 * @package ...
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Hook;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * TypoScriptFrontend Hook
 *
 * @author Tim Lochmüller
 */

class TypoScriptFrontend {

	/**
	 * Hook method for realurl image decode
	 *
	 * @param $params
	 * @param $ref
	 *
	 * @return    void
	 */
	function checkImageDecode(&$params, &$ref) {

		require_once(ExtensionManagementUtility::extPath('fl_realurl_image') . 'Classes/class.tx_flrealurlimage.php');
		$tx_flrealurlimage = new \tx_flrealurlimage();
		$tx_flrealurlimage->showImage();
	}
}