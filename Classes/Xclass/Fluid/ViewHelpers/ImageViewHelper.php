<?php
/**
 * Overwrite Image ViewHelper
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers;

use FRUIT\FlRealurlImage\Provider\ViewHelperProvider;
use FRUIT\FlRealurlImage\RealUrlImage;
use FRUIT\FlRealurlImage\Service\ImageService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;

/**
 * Overwrite Image ViewHelper
 *
 * @author Tim Lochmüller
 */
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper
{

    /**
     * Resizes a given image (if required) and renders the respective img tag
     *
     * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
     *
     * @param string                           $src                a path to a file, a combined FAL identifier or an uid (int). If $treatIdAsReference is set, the integer is considered the uid of the sys_file_reference record. If you already got a FAL object, consider using the $image parameter instead
     * @param string                           $width              width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string                           $height             height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param int                              $minWidth           minimum width of the image
     * @param int                              $minHeight          minimum height of the image
     * @param int                              $maxWidth           maximum width of the image
     * @param int                              $maxHeight          maximum height of the image
     * @param bool                             $treatIdAsReference given src argument is a sys_file_reference record
     * @param FileInterface|AbstractFileFolder $image              a FAL object
     * @param string|bool                      $crop               overrule cropping of image (setting to FALSE disables the cropping set in FileReference)
     * @param bool                             $absolute           Force absolute URL
     *
     * @return string
     * @throws \Exception
     */
    public function render(
        $src = null,
        $width = null,
        $height = null,
        $minWidth = null,
        $minHeight = null,
        $maxWidth = null,
        $maxHeight = null,
        $treatIdAsReference = false,
        $image = null,
        $crop = null,
        $absolute = false
    ) {
        $this->imageService = $this->objectManager->get(ImageService::class);
        ViewHelperProvider::setViewHelperInformation(array('alt' => $this->arguments['alt']));
        try {
            $return = parent::render(
                $src,
                $width,
                $height,
                $minWidth,
                $minHeight,
                $maxWidth,
                $maxHeight,
                $treatIdAsReference,
                $image,
                $crop,
                $absolute
            );
        } catch (\Exception $ex) {
            ViewHelperProvider::resetViewHelperInformation();
            throw $ex;
        }
        ViewHelperProvider::resetViewHelperInformation();
        return $return;
    }
}
