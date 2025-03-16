<?php
/**
 * FalMetaProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Core\Resource\File;

/**
 * FalMetaProvider
 */
class FalMetaProvider extends AbstractProvider
{

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'falmeta';
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
        if (isset($this->baseInformation['image']['originalFile']) && $this->baseInformation['image']['originalFile'] instanceof File) {
            $file = $this->baseInformation['image']['originalFile'];
        } elseif (isset($this->baseInformation['file']) && $this->baseInformation['file'] instanceof File) {
            $file = $this->baseInformation['file'];
        } else {
            return '';
        }
        /** @var $file File */
        $metaData = $file->getMetaData()->get();
        return isset($metaData[$key]) ? trim((string) $metaData[$key]) : '';
    }
}
