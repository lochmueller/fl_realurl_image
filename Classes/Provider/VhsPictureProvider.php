<?php
/**
 * VhsPictureProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

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
        //DebuggerUtility::var_dump($this->baseInformation);
        //DebuggerUtility::var_dump(self::$viewHelperInformation, 'VHS Information');
        return '';
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
