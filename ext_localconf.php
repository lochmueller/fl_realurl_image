<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.hook_tslib_fe.php']['connectToDB']['tx_flrealurlimage'] = 'FRUIT\\FlRealurlImage\\Hook\\TypoScriptFrontend->checkImageDecode';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'] = array(
	'className' => 'FRUIT\\FlRealurlImage\\Xclass\\ContentObjectRenderer',
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ImageResourceContentObject'] = array(
	'className' => 'FRUIT\\FlRealurlImage\\Xclass\\ImageResource',
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'FRUIT\\FlRealurlImage\\Command\\CleanCommandController';