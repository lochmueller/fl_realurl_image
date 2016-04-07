<?php
/**
 * Abstract provider
 *
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Provider;

/**
 * Abstract provider
 */
abstract class AbstractProvider
{

    /**
     * Base information for information fetching
     *
     * @var array
     */
    protected $baseInformation = [];

    /**
     * AbstractProvider constructor.
     *
     * @param array $baseInformation
     */
    public function __construct(array $baseInformation)
    {
        $this->baseInformation = $baseInformation;
    }

    /**
     * Get the provider identifier
     *
     * @return string
     */
    abstract public function getProviderIdentifier();

    /**
     * Get the provider information by the given configuration key
     *
     * @param string $key
     *
     * @return string
     */
    abstract public function getProviderInformation($key);

}
