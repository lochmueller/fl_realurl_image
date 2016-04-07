<?php

/**
 * VHS SourceViewHelper
 */

namespace FRUIT\FlRealurlImage\Xclass\Vhs\ViewHelpers\Media;

use FRUIT\FlRealurlImage\Provider\VhsPictureProvider;

/**
 * VHS SourceViewHelper
 */
class SourceViewHelper extends \FluidTYPO3\Vhs\ViewHelpers\Media\SourceViewHelper
{

    /**
     * @return string
     */
    public function render()
    {
        $before = VhsPictureProvider::getViewHelperInformation();
        $setup = array(
            'width'  => $this->arguments['width'],
            'height' => $this->arguments['height'],
            'minW'   => $this->arguments['minW'],
            'minH'   => $this->arguments['minH'],
            'maxW'   => $this->arguments['maxW'],
            'maxH'   => $this->arguments['maxH']
        );
        VhsPictureProvider::setViewHelperInformation(array_merge($before, $setup));
        $return = parent::render();
        VhsPictureProvider::setViewHelperInformation($before);
        return $return;
    }

}
