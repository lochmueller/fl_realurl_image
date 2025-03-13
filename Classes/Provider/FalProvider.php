<?php
/**
 * FalProvider
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Core\Resource\File;

/**
 * FalProvider
 */
class FalProvider extends AbstractProvider
{

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'fal';
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
        /** @var File $file */
        $information = $file->getProperties();
        return isset($information[$key]) ? trim((string) $information[$key]) : '';
    }
}
