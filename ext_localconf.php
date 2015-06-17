<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.hook_tslib_fe.php']['connectToDB']['tx_flrealurlimage'] = 'FRUIT\\FlRealurlImage\\Hook\\TypoScriptFrontend->checkImageDecode';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fl_realurl_image'] = array('frontend' => 'FRUIT\\FlRealurlImage\\Cache\\UriFrontend');

$xClass = array(
	'TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'      => 'ContentObjectRenderer',
	'TYPO3\\CMS\\Frontend\\ContentObject\\ImageResourceContentObject' => 'ImageResource',
	'TYPO3\\CMS\\Fluid\\ViewHelpers\\ImageViewHelper'                 => 'ImageViewHelper',
	'TYPO3\\CMS\\Fluid\\ViewHelpers\\Uri\\ImageViewHelper'            => 'UriImageViewHelper',
);
foreach ($xClass as $source => $target) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$source] = array('className' => 'FRUIT\\FlRealurlImage\\Xclass\\' . $target);
}
