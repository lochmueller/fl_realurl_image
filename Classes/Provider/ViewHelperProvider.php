<?php
/**
 * ViewHelperProvider
 */

namespace FRUIT\FlRealurlImage\Provider;

/**
 * ViewHelperProvider
 */
class ViewHelperProvider extends AbstractProvider
{

    static protected $viewHelperInformation = null;

    /**
     * @param $information
     */
    public static function setViewHelperInformation(array $information)
    {
        self::$viewHelperInformation = $information;
    }

    /**
     *
     */
    public static function resetViewHelperInformation()
    {
        self::$viewHelperInformation = null;
    }

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'vh';
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
        if (self::$viewHelperInformation !== null && isset(self::$viewHelperInformation[$key]) && trim(self::$viewHelperInformation[$key]) !== '') {
            return trim(self::$viewHelperInformation[$key]);
        }
        return '';
    }
}
