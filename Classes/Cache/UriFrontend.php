<?php
/**
 * Cache frontend for URIs
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Cache;

use TYPO3\CMS\Core\Cache\Frontend\StringFrontend;

/**
 * @author Tim Lochmüller
 */
class UriFrontend extends StringFrontend
{

    /**
     * Check if the identifier is a valid URI incl. host and path
     *
     * @param string $identifier
     *
     * @return bool
     */
    public function isValidEntryIdentifier($identifier)
    {
        return true;
    }

    /**
     * Saves the value of a PHP variable in the cache.
     *
     * @param string  $entryIdentifier An identifier used for this cache entry
     * @param string  $string          The variable to cache
     * @param array   $tags            Tags to associate with this cache entry
     * @param integer $lifetime        Lifetime of this cache entry in seconds. If NULL is specified, the default lifetime is used. "0" means unlimited liftime.
     *
     * @return void
     * @throws \InvalidArgumentException if the identifier or tag is not valid
     * @throws \TYPO3\CMS\Core\Cache\Exception\InvalidDataException if the variable to cache is not of type string
     * @api
     */
    public function set($entryIdentifier, $string, array $tags = [], $lifetime = null)
    {
        if (!$this->isValidEntryIdentifier($entryIdentifier)) {
            throw new \InvalidArgumentException('"' . $entryIdentifier . '" is not a valid cache entry identifier.', 1233057566);
        }
        foreach ($tags as $tag) {
            if (!$this->isValidTag($tag)) {
                throw new \InvalidArgumentException('"' . $tag . '" is not a valid tag for a cache entry.', 1233057512);
            }
        }
        $this->backend->set($entryIdentifier, $string, $tags, $lifetime);
    }
}
