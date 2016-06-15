<?php
/**
 * FalReferenceProvider
 */

namespace FRUIT\FlRealurlImage\Provider;

use FRUIT\FlRealurlImage\Service\FileInformation;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * FalReferenceProvider
 */
class FalReferenceProvider extends AbstractProvider
{

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'falref';
    }

    /**
     * Get the provider information by the given configuration key
     *
     * @param string $key
     *
     * @return string
     */
    public function getProviderInformation($key)
    {
        $falReferenceInfo = $this->getFALReferenceInfo();
        if ($falReferenceInfo[$key] && strlen(trim($falReferenceInfo[$key]))) {
            return trim($falReferenceInfo[$key]);
        }
        return '';
    }

    /**
     * @return array
     */
    protected function getFALReferenceInfo()
    {
        if ($fileInformation = $this->getFileInformation()) {
            return $fileInformation->getByFalReference(
                $this->baseInformation['image'],
                $this->baseInformation['fileTypeInformation'],
                $this->baseInformation['IMAGE_conf'],
                $this->baseInformation['cObj']
            );
        }
        return array();
    }

    /**
     * @return FileInformation
     */
    protected function getFileInformation()
    {
        return GeneralUtility::makeInstance(FileInformation::class);
    }
}
