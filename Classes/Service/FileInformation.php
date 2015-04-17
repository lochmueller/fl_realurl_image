<?php
/**
 * @todo       General file information
 *
 * @category   Extension
 * @package    ...
 * @author     Tim Lochmüller <tim@fruit-lab.de>
 */

/**
 * @todo       General class information
 *
 * @package    ...
 * @subpackage ...
 * @author     Tim Lochmüller <tim@fruit-lab.de>
 */
class Tx_FlRealurlImage_Service_FileInformation {

	/**
	 * Get information from the fal record of the current rendering
	 *
	 * @param array $imageInformation
	 *
	 * @return array
	 */
	public function getByFal($imageInformation) {
		if ($imageInformation['originalFile'] instanceof \TYPO3\CMS\Core\Resource\File) {
			return $imageInformation['originalFile']->getProperties();
		}
		return array();
	}

	/**
	 * Get information from the fal record of the current rendering
	 *
	 * @param array          $imageInformation
	 *
	 * @param                $file
	 * @param                $conf
	 * @param  ux_tslib_cObj $cObj
	 *
	 * @return array
	 */
	public function getByFalReference($imageInformation, $file, $conf, $cObj) {
		if (!($cObj instanceof ux_tslib_cObj)) {
			return array();
		}
		$fileReference = NULL;
		$fileArray = $conf['file.'];
		if ($file instanceof \TYPO3\CMS\Core\Resource\FileReference) {
			$fileReference = $file;
		} else {
			try {
				if ($fileArray['import.']) {
					$importedFile = trim($cObj->stdWrap('', $fileArray['import.']));
					if (!empty($importedFile)) {
						$file = $importedFile;
					}
				}

				if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($file)) {
					if (!empty($fileArray['treatIdAsReference'])) {
						$fileReference = $cObj->getRFactory()
							->getFileReferenceObject($file);
					}
				}
			} catch (\Exception $exception) {
				return array();
			}
		}

		if ($fileReference instanceof \TYPO3\CMS\Core\Resource\FileReference) {
			return $fileReference->getProperties();
		}

		return array();
	}

	/**
	 * Get information about the media record including langauge overlay of the curent rendering
	 *
	 * @param $imageInformation
	 *
	 * @return array
	 * @deprected
	 */
	public function getByMedia($imageInformation) {
		return array();
		// the AssetRepository do not exists anymore

		if (!t3lib_extMgm::isLoaded('media')) {
			return array();
		}
		if (!($imageInformation['originalFile'] instanceof \TYPO3\CMS\Core\Resource\File)) {
			return array();
		}
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$assetRepository = $objectManager->get('TYPO3\\CMS\\Media\\Domain\\Repository\\AssetRepository');

		$asset = $assetRepository->findByUid($imageInformation['originalFile']->getUid());
		if (is_object($asset)) {
			return $asset->getProperties();
		}
		return array();

	}

} 