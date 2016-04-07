<?php
/**
 * TypoScriptFrontend Hook
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Hook;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * TypoScriptFrontend Hook
 *
 * @author Tim Lochmüller
 */
class TypoScriptFrontend
{

    /**
     * Hook method for realurl image decode
     *
     * @param $params
     * @param $ref
     *
     * @return    void
     */
    function checkImageDecode(&$params, &$ref)
    {
        $realurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
        $realurlimage->showImage();
    }
}
