<?php

/**
 * VHS PictureViewHelper
 */

namespace FRUIT\FlRealurlImage\Xclass\Vhs\ViewHelpers\Media;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * VHS PictureViewHelper
 */
class PictureViewHelper extends \FluidTYPO3\Vhs\ViewHelpers\Media\PictureViewHelper
{

    public function render()
    {

        $properties = [
            'src'   => $this->arguments['src'],
            'alt'   => $this->arguments['alt'],
            'title' => $this->arguments['title'],
        ];
        RealUrlImage::setViewHelperInformation($properties);
        $return = parent::render();
        RealUrlImage::resetViewHelperInformation();
        return $return;
    }

}
