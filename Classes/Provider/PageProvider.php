<?php
/**
 * PageProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * PageProvider
 */
class PageProvider extends AbstractProvider
{

    static $pageInformation = null;

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'page';
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
        $pageInformation = $this->getPageInformation();
        return isset($pageInformation[$key]) ? trim($pageInformation[$key]) : '';
    }

    /**
     * Get information of the current page
     *
     * @return array
     */
    protected function getPageInformation()
    {
        if (self::$pageInformation !== null) {
            return self::$pageInformation;
        }
        if (!is_object($GLOBALS['TSFE'])) {
            self::$pageInformation = [];
            return self::$pageInformation;
        }

        self::$pageInformation = BackendUtility::getRecord('pages', $GLOBALS['TSFE']->id);
        return self::$pageInformation;
    }
}
