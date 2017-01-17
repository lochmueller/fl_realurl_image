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
     *
     * @return string Rendered img tag
     * @throws \Exception
     */
    protected function renderImage(FileInterface $image, $width, $height)
    {
        $alt = isset($this->arguments['alt']) ? $this->arguments['alt'] : '';
        ViewHelperProvider::setViewHelperInformation(['alt' => $alt]);
        try {
            $return = parent::renderImage(
                $image,
                $width,
                $height
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
    protected function getImageService()
    {
        return $this->objectManager->get(ImageService::class);
    }
}
