<?php

/**
 * ContentObjectRenderer Xclass
 *
 * @author Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject;

use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Imaging\GraphicalFunctions;
use TYPO3\CMS\Core\Resource\Exception;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extends tslib_cObj to change the path for the images
 */
class ContentObjectRenderer extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
{
    /**
     * Skips RealUrlImage execution in getImgResource method.
     * Otherwise RealUrlImage is executed twice in IMG_RESOURCE, cImage and cImage7AndUp
     *
     * @var boolean
     */
    protected $skipRealUrlImageInGetImgResource = false;

    /**
     * Rendering the cObject, IMG_RESOURCE
     *
     * @param    array $conf
     *
     * @return    string        Output
     * @link http://typo3.org/doc.0.html?&tx_extrepmgm_pi1[extUid]=270&tx_extrepmgm_pi1[tocEl]=354&cHash=46f9299706
     * @see  getImgResource()
     */
    public function IMG_RESOURCE($conf)
    {
        $this->setSkipRealUrlImageInGetImgResource(true);
        $GLOBALS['TSFE']->lastImgResourceInfo = $this->getImgResource($conf['file'], $conf['file.']);

        // ###################################
        // ## Here begins RealUrl_image ######
        // ###################################
        /** @var RealUrlImage $tx_flrealurlimage */
        $tx_flrealurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
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
    public function cImage($file, $conf)
    {
        if (GeneralUtility::compat_version('7.0')) {
            return $this->cImage7AndUp($file, $conf);
        }

        $this->setSkipRealUrlImageInGetImgResource(true);
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
            $tx_flrealurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
            $tx_flrealurlimage->start($this->data, $this->table);
            $new_fileName = $tx_flrealurlimage->main($conf, $info, $file, $this);
            $imageTagValues['src'] = $tx_flrealurlimage->addAbsRefPrefix($new_fileName);
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

    /**
     * Returns a <img> tag with the image file defined by $file and processed according to the properties in the TypoScript array.
     * Mostly this function is a sub-function to the IMAGE function which renders the IMAGE cObject in TypoScript.
     * This function is called by "$this->cImage($conf['file'], $conf);" from IMAGE().
     *
     * @param string $file File TypoScript resource
     * @param array  $conf TypoScript configuration properties
     *
     * @return string <img> tag, (possibly wrapped in links and other HTML) if any image found.
     * @access private
     * @see    IMAGE()
     */
    public function cImage7AndUp($file, $conf)
    {
        $tsfe = $this->getTypoScriptFrontendController();
        $this->setSkipRealUrlImageInGetImgResource(true);
        $info = $this->getImgResource($file, $conf['file.']);
        $tsfe->lastImageInfo = $info;
        if (!is_array($info)) {
            return '';
        }
        if (is_file(PATH_site . $info['3'])) {
            $source = $tsfe->absRefPrefix . GeneralUtility::rawUrlEncodeFP($info['3']);
        } else {
            $source = $info[3];
        }

        $layoutKey = $this->stdWrap($conf['layoutKey'], $conf['layoutKey.']);
        $imageTagTemplate = $this->getImageTagTemplate($layoutKey, $conf);
        $sourceCollection = $this->getImageSourceCollection($layoutKey, $conf, $file);

        // This array is used to collect the image-refs on the page...
        $tsfe->imagesOnPage[] = $source;
        $altParam = $this->getAltParam($conf);
        $params = $this->stdWrapValue('params', $conf);
        if ($params !== '' && $params[0] !== ' ') {
            $params = ' ' . $params;
        }

        $imageTagValues = array(
            'width'               => (int)$info[0],
            'height'              => (int)$info[1],
            'src'                 => htmlspecialchars($source),
            'params'              => $params,
            'altParams'           => $altParam,
            'border'              => $this->getBorderAttr(' border="' . (int)$conf['border'] . '"'),
            'sourceCollection'    => $sourceCollection,
            'selfClosingTagSlash' => (!empty($tsfe->xhtmlDoctype) ? ' /' : ''),
        );

        // ###################################
        // ## Here begins RealUrl_image ######
        // ###################################
        $tx_flrealurlimage = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\RealUrlImage');
        $tx_flrealurlimage->start($this->data, $this->table);
        $new_fileName = $tx_flrealurlimage->main($conf, $info, $file, $this);
        $imageTagValues['src'] = $tx_flrealurlimage->addAbsRefPrefix($new_fileName);
        // ##################################
        // ### Here ends RealURL_Image ######
        // ##################################

        $theValue = $this->substituteMarkerArray($imageTagTemplate, $imageTagValues, '###|###', true, true);

        $linkWrap = isset($conf['linkWrap.']) ? $this->stdWrap($conf['linkWrap'], $conf['linkWrap.']) : $conf['linkWrap'];
        if ($linkWrap) {
            $theValue = $this->linkWrap($theValue, $linkWrap);
        } elseif ($conf['imageLinkWrap']) {
            $originalFile = !empty($info['originalFile']) ? $info['originalFile'] : $info['origFile'];
            $theValue = $this->imageLinkWrap($theValue, $originalFile, $conf['imageLinkWrap.']);
        }
        $wrap = isset($conf['wrap.']) ? $this->stdWrap($conf['wrap'], $conf['wrap.']) : $conf['wrap'];
        if ((string)$wrap !== '') {
            $theValue = $this->wrap($theValue, $conf['wrap']);
        }
        return $theValue;
    }

    /**
     * Creates and returns a TypoScript "imgResource".
     * The value ($file) can either be a file reference (TypoScript resource) or the string "GIFBUILDER".
     * In the first case a current image is returned, possibly scaled down or otherwise processed.
     * In the latter case a GIFBUILDER image is returned; This means an image is made by TYPO3 from layers of elements as GIFBUILDER defines.
     * In the function IMG_RESOURCE() this function is called like $this->getImgResource($conf['file'], $conf['file.']);
     *
     * Structure of the returned info array:
     *  0 => width
     *  1 => height
     *  2 => file extension
     *  3 => file name
     *  origFile => original file name
     *  origFile_mtime => original file mtime
     *  -- only available if processed via FAL: --
     *  originalFile => original file object
     *  processedFile => processed file object
     *  fileCacheHash => checksum of processed file
     *
     * @param string|File|FileReference $file      A "imgResource" TypoScript data type. Either a TypoScript file resource, a file or a file reference object or the string GIFBUILDER. See description above.
     * @param array                     $fileArray TypoScript properties for the imgResource type
     *
     * @return array|NULL Returns info-array
     * @see IMG_RESOURCE(), cImage(), \TYPO3\CMS\Frontend\Imaging\GifBuilder
     */
    public function getImgResource($file, $fileArray)
    {
        $result = parent::getImgResource($file, $fileArray);
        if (!is_array($result)) {
            return $result;
        }

        if(!$this->skipRealUrlImageInGetImgResource){
            // ###################################
            // ## Here begins RealUrl_image ######
            // ###################################
            $tx_flrealurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
            /** @var $tx_flrealurlimage \FRUIT\FlRealurlImage\RealUrlImage */
            $tx_flrealurlimage->start($this->data, $this->table);
            $new_fileName = $tx_flrealurlimage->main([], $result, $file, $this);
            $result[3] = $tx_flrealurlimage->addAbsRefPrefix($new_fileName);
            // ##################################
            // ### Here ends RealURL_Image ######
            // ##################################
        }

        return $result;
    }

    /**
     * Set skipRealUrlImageInGetImgResource
     * @param $skipRealUrlImageInGetImgResource
     */
    public function setSkipRealUrlImageInGetImgResource($skipRealUrlImageInGetImgResource){
        $this->skipRealUrlImageInGetImgResource = $skipRealUrlImageInGetImgResource;
    }
}
