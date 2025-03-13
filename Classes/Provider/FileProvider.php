<?php
/**
 * FileProvider
 */

namespace FRUIT\FlRealurlImage\Provider;

/**
 * FileProvider
 */
class FileProvider extends AbstractProvider
{

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'file';
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
        if ($this->baseInformation['image'][$key] && strlen(trim((string) $this->baseInformation['image'][$key]))) {
            return trim((string) $this->baseInformation['image'][$key]);
        }
        return '';
    }
}
