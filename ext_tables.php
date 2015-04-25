<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fl_realurl_image', 'Configuration/TypoScript/', 'fl_realurlimage');