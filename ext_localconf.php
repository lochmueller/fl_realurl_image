<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.hook_tslib_fe.php']['connectToDB']['tx_flrealurlimage'] = \FRUIT\FlRealurlImage\Hook\TypoScriptFrontend::class . '->checkImageDecode';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fl_realurl_image'] = ['frontend' => \FRUIT\FlRealurlImage\Cache\UriFrontend::class];

$xClass = [
    \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class      => \FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject\ContentObjectRenderer::class,
    \TYPO3\CMS\Frontend\ContentObject\ImageResourceContentObject::class => \FRUIT\FlRealurlImage\Xclass\Frontend\ContentObject\ImageResourceContentObject::class,
    \TYPO3\CMS\Fluid\ViewHelpers\MediaViewHelper::class                 => \FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers\MediaViewHelper::class,
    \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper::class                 => \FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers\ImageViewHelper::class,
    \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper::class             => \FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers\Uri\ImageViewHelper::class,
];

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('vhs')) {
    $xClass[\FluidTYPO3\Vhs\ViewHelpers\Media\PictureViewHelper::class] = \FRUIT\FlRealurlImage\Xclass\Vhs\ViewHelpers\Media\PictureViewHelper::class;
    $xClass[\FluidTYPO3\Vhs\ViewHelpers\Media\SourceViewHelper::class] = \FRUIT\FlRealurlImage\Xclass\Vhs\ViewHelpers\Media\SourceViewHelper::class;
}

foreach ($xClass as $source => $target) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$source] = ['className' => $target];
}
