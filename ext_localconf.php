<?php

use FRUIT\FlRealurlImage\Cache\UriFrontend;
use FRUIT\FlRealurlImage\Hook\TypoScriptFrontend;
use FRUIT\FlRealurlImage\Service\ImageService;
use FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject\ContentObjectRenderer;
use FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject\ImageResourceContentObject;

if (!defined('TYPO3'))
{
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.hook_tslib_fe.php']['connectToDB']['tx_flrealurlimage'] = TypoScriptFrontend::class . '->checkImageDecode';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fl_realurl_image'] = ['frontend' => UriFrontend::class];

$xClass = [
    \TYPO3\CMS\Extbase\Service\ImageService::class                      => ImageService::class,
    \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class      => ContentObjectRenderer::class,
    \TYPO3\CMS\Frontend\ContentObject\ImageResourceContentObject::class => ImageResourceContentObject::class,
];

foreach ($xClass as $source => $target)
{
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$source] = ['className' => $target];
}
