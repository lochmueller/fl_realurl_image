<?php
/**
 * Overwrite Uri/ImageViewHelper
 *
 * @author  Dennis Geldmacher
 */

namespace FRUIT\FlRealurlImage\Xclass;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;

/**
 * Overwrite Image ViewHelper
 *
 * @author Dennis Geldmacher
 */
class UriImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper
{

    /**
     * Resizes the image (if required) and returns its path. If the image was not resized, the path will be equal to $src
     *
     * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
     *
     * @param string                           $src
     * @param FileInterface|AbstractFileFolder $image
     * @param string                           $width              width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string                           $height             height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param integer                          $minWidth           minimum width of the image
     * @param integer                          $minHeight          minimum height of the image
     * @param integer                          $maxWidth           maximum width of the image
     * @param integer                          $maxHeight          maximum height of the image
     * @param boolean                          $treatIdAsReference given src argument is a sys_file_reference record
     *
     * @throws \Exception
     * @return string path to the image
     */
    public function render(
        $src = null,
        $image = null,
        $width = null,
        $height = null,
        $minWidth = null,
        $minHeight = null,
        $maxWidth = null,
        $maxHeight = null,
        $treatIdAsReference = false
    ) {
        $this->imageService = $this->objectManager->get('FRUIT\\FlRealurlImage\\Service\\ImageService');
        try {
            $return = parent::render($src, $image, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight,
                $treatIdAsReference);
        } catch (\Exception $ex) {
            throw $ex;
        }
        return $return;
    }
}
