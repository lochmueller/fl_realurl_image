<?php

/**
 * VHS PictureViewHelper
 */

namespace FRUIT\FlRealurlImage\Xclass\Vhs\ViewHelpers\Media;

use FRUIT\FlRealurlImage\Provider\VhsPictureProvider;

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
        VhsPictureProvider::setViewHelperInformation($properties);
        $return = parent::render();
        VhsPictureProvider::setViewHelperInformation([]);
        return $return;
    }
}
