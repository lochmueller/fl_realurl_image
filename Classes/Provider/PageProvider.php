<?php
/**
 * PageProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * PageProvider
 */
class PageProvider extends AbstractProvider
{

    public static $pageInformation = null;

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
        if ($GLOBALS['TSFE']->sys_language_uid > 0) {
            $overlay = BackendUtility::getRecordLocalization('pages', $GLOBALS['TSFE']->id, $GLOBALS['TSFE']->sys_language_uid);
            if (!empty($overlay)) {
                self::$pageInformation = $overlay[0];
            }
        }
        return self::$pageInformation;
    }
}
