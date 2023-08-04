<?php
/**
 * UriFrontendTest
 */

namespace FRUIT\FlRealurlImage\Tests\Unit\Cache;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use FRUIT\FlRealurlImage\Cache\UriFrontend;
use TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend;

/**
 * UriFrontendTest
 */
class UriFrontendTest extends UnitTestCase
{

    /**
     * @test
     */
    public function cacheIdentifierIsAlwaysValid()
    {
        $dbBackend = new Typo3DatabaseBackend('Production');
        $cacheFrontend = new UriFrontend('test', $dbBackend);
        $this->assertEquals(true, $cacheFrontend->isValidEntryIdentifier('Strange code here'));
    }
}
