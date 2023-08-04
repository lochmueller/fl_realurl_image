<?php
/**
 * Replace the image service for the view helpers
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Service;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use FRUIT\FlRealurlImage\RealUrlImage;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Replace the image service for the view helpers
 *
 * @author Tim Lochmüller
 */
class ImageService extends \TYPO3\CMS\Extbase\Service\ImageService
{

    /**
     * @var null
     */
    protected $imageForRealName = null;

    /**
     * @param File|FileReference $image
     * @param array $processingInstructions
     *
     * @return ProcessedFile
     */
    public function applyProcessingInstructions($image, $processingInstructions): ProcessedFile
    {
        $this->imageForRealName = $image;
        return parent::applyProcessingInstructions($image, $processingInstructions);
    }

    /**
     * Get public url of image depending on the environment
     *
     * @param FileInterface $image
     * @param bool|FALSE $absolute Force absolute URL
     * @return string
     * @api
     */
    public function getImageUri(FileInterface $image, $absolute = false): string
    {
        if ($image->getStorage()->getDriverType() === 'Local' && !$image->getStorage()->isPublic() && $this->environmentService->isEnvironmentInFrontendMode()) {
            $imageUrl = $image->getForLocalProcessing(false);
        } else {
            $imageUrl = $image->getPublicUrl();
        }

        // call fl_realurl_image to generate $new_fileName
        /** @var RealUrlImage $tx_flrealurlimage */
        $tx_flrealurlimage = GeneralUtility::makeInstance(RealUrlImage::class);
        $tx_flrealurlimage->start([]);
        if ($image instanceof ProcessedFile) {
            $info = [3 => $imageUrl];
            $imageUrl = $tx_flrealurlimage->main([], $info, $this->imageForRealName);
        }
        $this->imageForRealName = null;

        $parsedUrl = parse_url($imageUrl);
        // no prefix in case of an already fully qualified URL
        if (isset($parsedUrl['host'])) {
            $uriPrefix = '';
        } elseif ($this->environmentService->isEnvironmentInFrontendMode()) {
            $imageUrl = $tx_flrealurlimage->addAbsRefPrefix($imageUrl);
            $uriPrefix = '';
            $parsedUrl = parse_url($imageUrl);
        } else {
            $uriPrefix = GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');
        }

        if ($absolute) {
            // If full URL has no scheme we add the same scheme as used by the site
            // so we have an absolute URL also usable outside of browser scope (e.g. in an email message)
            if (isset($parsedUrl['host']) && !isset($parsedUrl['scheme'])) {
                $uriPrefix = (GeneralUtility::getIndpEnv('TYPO3_SSL') ? 'https:' : 'http:') . $uriPrefix;
            }
            return GeneralUtility::locationHeaderUrl($uriPrefix . $imageUrl);
        } else {
            return $uriPrefix . $imageUrl;
        }
    }
}
