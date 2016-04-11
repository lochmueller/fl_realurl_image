<?php
/**
 * TypoScriptProvider
 */

namespace FRUIT\FlRealurlImage\Provider;

/**
 * TypoScriptProvider
 */
class TypoScriptProvider extends AbstractProvider
{

    /**
     * Get the provider identifier
     *
     * @return string
     */
    public function getProviderIdentifier()
    {
        return 'ts';
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
        if ($this->baseInformation['IMAGE_conf'][$key] || $this->baseInformation['IMAGE_conf'][$key . '.']) {
            $tsResult = $this->baseInformation['cObj']->stdWrap($this->baseInformation['IMAGE_conf'][$key],
                $this->baseInformation['IMAGE_conf'][$key . '.']);
            if (strlen(trim($tsResult))) {
                return trim($tsResult);
            }
        }
        return '';
    }
}
