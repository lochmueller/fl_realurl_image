<?php
/**
 * UriFrontendTest
 */

namespace FRUIT\FlRealurlImage\Tests\Unit\Cache;

use FRUIT\FlRealurlImage\Cache\UriFrontend;
use TYPO3\CMS\Core\Tests\UnitTestCase;

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
        $cacheFrontend = new UriFrontend('test');
        $this->assertEquals(true, $cacheFrontend->isValidEntryIdentifier('Strange code here'));
    }
}
