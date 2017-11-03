<?php
/**
 * Overwrite Image ViewHelper
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers;

use FRUIT\FlRealurlImage\Provider\ViewHelperProvider;
use FRUIT\FlRealurlImage\Service\ImageService;

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
     * @return string
     * @throws \Exception
     */
    public function render()
    {
        $this->imageService = $this->objectManager->get(ImageService::class);
        ViewHelperProvider::setViewHelperInformation(['alt' => $this->arguments['alt']]);
        try {
            $return = parent::render();
        } catch (\Exception $ex) {
            ViewHelperProvider::resetViewHelperInformation();
            throw $ex;
        }
        ViewHelperProvider::resetViewHelperInformation();
        return $return;
    }
}
