<?php

/**
 * ImageResource Xclass
 *
 * @author Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ImageResource
 *
 * @package FRUIT\FlRealurlImage\Xclass
 */
class ImageResourceContentObject extends \TYPO3\CMS\Frontend\ContentObject\ImageResourceContentObject
{

    /**
     * Overwrite render method
     *
     * @param array $conf
     *
     * @return string
     */
    public function render($conf = array())
    {
        $GLOBALS['TSFE']->lastImgResourceInfo = $this->cObj->getImgResource($conf['file'], $conf['file.']);

        // ###################################
        // ## Here begins RealUrl_image ######
        // ###################################
        if (is_array($GLOBALS['TSFE']->lastImgResourceInfo)) {
            // call fl_realurl_image to generate $new_fileName
            $tx_flrealurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
            $tx_flrealurlimage->start(null, null);
            $new_fileName = $tx_flrealurlimage->main($conf, $GLOBALS['TSFE']->lastImgResourceInfo);

            // generate the image URL
            $theValue = $tx_flrealurlimage->addAbsRefPrefix($new_fileName);
            // stdWrap and return
            return $this->getContentObject()
                ->stdWrap($theValue, $conf['stdWrap.']);
        }
        // ##################################
        // ### Here ends RealURL_Image ######
        // ##################################


        $imageResource = $GLOBALS['TSFE']->lastImgResourceInfo[3];

        $theValue = isset($conf['stdWrap.']) ? $this->cObj->stdWrap($imageResource, $conf['stdWrap.']) : $imageResource;

        return $theValue;
    }

}
