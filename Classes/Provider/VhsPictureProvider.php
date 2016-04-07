<?php
/**
 * VhsPictureProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * VhsPictureProvider
 */
class VhsPictureProvider extends AbstractProvider
{

    /**
     * Store View Helper information
     *
     * @var array
     */
    protected static $viewHelperInformation = [];

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'vhs';
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
        if (self::$viewHelperInformation === []) {
            return '';
        }
        if (!isset($this->baseInformation['image']['originalFile']) || !is_object($this->baseInformation['image']['originalFile'])) {
            return '';
        }
        $file = $this->baseInformation['image']['originalFile'];

        list($source, $field) = explode(':', $key);
        if ($source === 'fal') {
            $provider = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\Provider\\FalProvider', ['file' => $file]);
        } elseif ($source === 'falmeta') {
            $provider = GeneralUtility::makeInstance('FRUIT\\FlRealurlImage\\Provider\\FalMetaProvider', ['file' => $file]);
        } else {
            return '';
        }

        /** @var $provider AbstractProvider */
        $value = $provider->getProviderInformation($field);
        return strlen($value) ? $value . $this->getDimensions() : '';
    }

    /**
     * Get dimensions
     *
     * @return string
     */
    protected function getDimensions()
    {
        if (!isset($this->baseInformation['image'][0])) {
            return '';
        }
        if (!isset($this->baseInformation['image'][1])) {
            return '';
        }
        return ' ' . $this->baseInformation['image'][0] . 'x' . $this->baseInformation['image'][1];
    }

    /**
     * @return array
     */
    public static function getViewHelperInformation()
    {
        return self::$viewHelperInformation;
    }

    /**
     * @param array $viewHelperInformation
     */
    public static function setViewHelperInformation($viewHelperInformation)
    {
        self::$viewHelperInformation = $viewHelperInformation;
    }

}
