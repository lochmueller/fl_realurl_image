<?php
/**
 * Configuration handling
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage;

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
        $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fl_realurl_image']);
        if (!is_array($extensionConfiguration)) {
            $extensionConfiguration = array();
        }
        return $extensionConfiguration;

    }

}
