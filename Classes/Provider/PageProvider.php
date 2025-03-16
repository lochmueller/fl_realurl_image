<?php
/**
 * PageProvider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
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
        return isset($pageInformation[$key]) ? trim((string) $pageInformation[$key]) : '';
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
        if (($sys_language_uid = GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('language', 'id')) > 0) {
            $overlay = BackendUtility::getRecordLocalization('pages', $GLOBALS['TSFE']->id, $sys_language_uid);
            if (!empty($overlay)) {
                self::$pageInformation = $overlay[0];
            }
        }
        return self::$pageInformation;
    }
}
