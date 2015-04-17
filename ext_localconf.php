<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['fl_realurl_image'] = unserialize($_EXTCONF);

// Generate RealURL Image Paths - XCLASS: tslib_content  (Datei: typo3/syext/cms/tslib/class.tslib_content.php)
// the essential part

// Decode the RealURLs - HOOK: tslib_fe
// this is just necessary if the option linkStatic is not activated.
// if linkStatic is activated this is just a back up in case a link got lost.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.hook_tslib_fe.php']['connectToDB']['tx_flrealurlimage'] = 'EXT:fl_realurl_image/Classes/class.hook_tslib_fe.php:&hook_tslib_fe->checkImageDecode';

// @deprecated
$GLOBALS['TYPO3_CONF_VARS']['FE']['XCLASS']['tslib/content/class.tslib_content_imageresource.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Xclass/ImageResource.php';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'] = array(
	'className' => 'FRUIT\\FlRealurlImage\\Xclass\\ContentObjectRenderer',
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ImageResourceContentObject'] = array(
	'className' => 'ux_tslib_content_ImageResource',
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'FRUIT\\FlRealurlImage\\Command\\CleanCommandController';