<?php

/**
 * ContentObjectRenderer Xclass
 *
 * @author Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Imaging\GraphicalFunctions;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends tslib_cObj to change the path for the images
 */
class ContentObjectRenderer extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
{

    /**
     * Rendering the cObject, IMG_RESOURCE
     *
     * @param    array        Array of TypoScript properties
     *
     * @return    string        Output
     * @link http://typo3.org/doc.0.html?&tx_extrepmgm_pi1[extUid]=270&tx_extrepmgm_pi1[tocEl]=354&cHash=46f9299706
     * @see  getImgResource()
     */
    function IMG_RESOURCE($conf)
    {
        $GLOBALS['TSFE']->lastImgResourceInfo = $this->getImgResource($conf['file'], $conf['file.']);

        // ###################################
        // ## Here begins RealUrl_image ######
        // ###################################
        /** @var RealUrlImage $tx_flrealurlimage */
        $tx_flrealurlimage = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\RealUrlImage');
        $tx_flrealurlimage->start($this->data, $this->table);
        $new_fileName = $tx_flrealurlimage->main($conf, $GLOBALS['TSFE']->lastImgResourceInfo);
        $imageResource = $tx_flrealurlimage->addAbsRefPrefix($new_fileName);
        // ##################################
        // ### Here ends RealURL_Image ######
        // ##################################

        $theValue = isset($conf['stdWrap.']) ? $this->stdWrap($imageResource, $conf['stdWrap.']) : $imageResource;
        return $theValue;
    }

    /**
     * @param string $file
     * @param array  $conf
     *
     * @return string
     */
    function cImage($file, $conf)
    {
        $info = $this->getImgResource($file, $conf['file.']);
        $GLOBALS['TSFE']->lastImageInfo = $info;

        if (is_array($info)) {
            if (is_file(PATH_site . $info['3'])) {
                $graphicalFunctionsClass = 'TYPO3\\CMS\\Core\\Imaging\\GraphicalFunctions';
                if (class_exists($graphicalFunctionsClass) && method_exists($graphicalFunctionsClass, 'pngToGifByImagemagick')) {
                    // modern
                    $return = GraphicalFunctions::pngToGifByImagemagick($info[3]);
                } else {
                    // deprecated
                    $return = GeneralUtility::png_to_gif_by_imagemagick($info[3]);
                }
                $source = GeneralUtility::rawUrlEncodeFP($return);
                $source = $GLOBALS['TSFE']->absRefPrefix . $source;
            } else {
                $source = $info[3];
            }

            if (isset($conf['ignoreManipulation'])) {
                $source = $info['origFile'];
            }

            $layoutKey = $this->stdWrap($conf['layoutKey'], $conf['layoutKey.']);
            $imageTagTemplate = $this->getImageTagTemplate($layoutKey, $conf);
            $sourceCollection = $this->getImageSourceCollection($layoutKey, $conf, $file);

            // This array is used to collect the image-refs on the page...
            $GLOBALS['TSFE']->imagesOnPage[] = $source;
            $altParam = $this->getAltParam($conf);
            $params = $this->stdWrapValue('params', $conf);
            if ($params !== '' && $params{0} !== ' ') {
                $params = ' ' . $params;
            }

            $imageTagValues = array(
                'width'               => $info[0],
                'height'              => $info[1],
                'src'                 => htmlspecialchars($source),
                'params'              => $params,
                'altParams'           => $altParam,
                'border'              => $this->getBorderAttr(' border="' . (int)$conf['border'] . '"'),
                'sourceCollection'    => $sourceCollection,
                'selfClosingTagSlash' => (!empty($GLOBALS['TSFE']->xhtmlDoctype) ? ' /' : ''),
            );

            // ###################################
            // ## Here begins RealUrl_image ######
            // ###################################
            $tx_flrealurlimage = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\RealUrlImage');
            $tx_flrealurlimage->start($this->data, $this->table);
            $new_fileName = $tx_flrealurlimage->main($conf, $info, $file, $this);
            $imageTagValues['src'] = htmlspecialchars($GLOBALS['TSFE']->absRefPrefix) . $new_fileName;
            // ##################################
            // ### Here ends RealURL_Image ######
            // ##################################


            $theValue = $this->substituteMarkerArray($imageTagTemplate, $imageTagValues, '###|###', true, true);

            $linkWrap = isset($conf['linkWrap.']) ? $this->stdWrap($conf['linkWrap'], $conf['linkWrap.']) : $conf['linkWrap'];
            if ($linkWrap) {
                $theValue = $this->linkWrap($theValue, $linkWrap);
            } elseif ($conf['imageLinkWrap']) {
                $theValue = $this->imageLinkWrap($theValue, $info['originalFile'], $conf['imageLinkWrap.']);
            }
            $wrap = isset($conf['wrap.']) ? $this->stdWrap($conf['wrap'], $conf['wrap.']) : $conf['wrap'];
            if ($wrap) {
                $theValue = $this->wrap($theValue, $conf['wrap']);
            }
            return $theValue;
        }

        return parent::cImage($file, $conf);
    }

}
