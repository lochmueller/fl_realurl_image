<?php
/**
 * Configuration handling
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Configuration handling
 *
 * @author Tim Lochmüller
 */
class Configuration
{

    /**
     * Get the configuration with the given name
     *
     * @param string $name
     *
     * @return mixed|bool
     */
    public function get($name)
    {
        $extensionConfiguration = $this->getExtensionConfiguration();
        if (isset($extensionConfiguration[$name])) {
            return $extensionConfiguration[$name];
        }
        return false;
    }

    /**
     * Get the extension configuration variables
     *
     * @return array|mixed
     */
    protected function getExtensionConfiguration()
    {
        static $extensionConfiguration = null;
        if ($extensionConfiguration !== null) {
            return $extensionConfiguration;
        }
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('fl_realurl_image');

        if (!is_array($extensionConfiguration)) {
            $extensionConfiguration = [];
        }
        return $extensionConfiguration;
    }
}
