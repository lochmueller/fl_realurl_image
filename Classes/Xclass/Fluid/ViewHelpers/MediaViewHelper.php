<?php
/**
 * MediaViewHelper
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers;

use FRUIT\FlRealurlImage\Provider\ViewHelperProvider;
use FRUIT\FlRealurlImage\Service\ImageService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * MediaViewHelper
 */
class MediaViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\MediaViewHelper
{
    /**
     * Render img tag
     *
     * @param FileInterface $image
     * @param string $width
     * @param string $height
     * @param string|null $fileExtension
     * @return string Rendered img tag
     * @throws \Exception
     */
    protected function renderImage(FileInterface $image, $width, $height, ?string $fileExtension)
    {
        $alt = $this->arguments['alt'] ?? '';
        ViewHelperProvider::setViewHelperInformation(['alt' => $alt]);
        try {
            $return = parent::renderImage(
                $image,
                $width,
                $height,
                $fileExtension
            );
        } catch (\Exception $ex) {
            ViewHelperProvider::resetViewHelperInformation();
            throw $ex;
        }
        ViewHelperProvider::resetViewHelperInformation();

        return $return;
    }

    /**
     * Return an instance of ImageService
     *
     * @return ImageService
     */
    protected function getImageService():ImageService
    {
    	/** @var ImageService $imageService */
		$imageService = GeneralUtility::makeInstance(ImageService::class);
		return $imageService;
    }
}
