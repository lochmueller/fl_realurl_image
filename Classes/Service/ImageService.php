<?php
/**
 * Replace the image service for the view helpers
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Service;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Replace the image service for the view helpers
 *
 * @author Tim Lochmüller
 */
class ImageService extends \TYPO3\CMS\Extbase\Service\ImageService {

	/**
	 * @var null
	 */
	protected $imageForRealName = NULL;

	/**
	 * @param \TYPO3\CMS\Core\Resource\File|\TYPO3\CMS\Core\Resource\FileReference $image
	 * @param array                                                                $processingInstructions
	 *
	 * @return ProcessedFile
	 */
	public function applyProcessingInstructions($image, $processingInstructions) {
		$this->imageForRealName = $image;
		return parent::applyProcessingInstructions($image, $processingInstructions);
	}

	/**
	 * Get public url of image depending on the environment
	 *
	 * @param FileInterface $image
	 *
	 * @return string
	 * @api
	 */
	public function getImageUri(FileInterface $image) {
		$imageUrl = $image->getPublicUrl();

		// call fl_realurl_image to generate $new_fileName
		/** @var RealUrlImage $tx_flrealurlimage */
		$tx_flrealurlimage = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\RealUrlImage');
		$tx_flrealurlimage->start(NULL, NULL);
		if ($image instanceof ProcessedFile) {
			$info = array(3 => $imageUrl);
			$imageUrl = $tx_flrealurlimage->main(array(), $info, $this->imageForRealName);
		}
		$this->imageForRealName = NULL;

		// no prefix in case of an already fully qualified URL (having a schema)
		if (strpos($imageUrl, '://')) {
			$uriPrefix = '';
		} elseif ($this->environmentService->isEnvironmentInFrontendMode()) {
			$uriPrefix = $GLOBALS['TSFE']->absRefPrefix;
		} else {
			$uriPrefix = GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');
		}

		return $uriPrefix . $imageUrl;
	}
}
