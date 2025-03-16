<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
defined('TYPO3') or die();

ExtensionManagementUtility::addStaticFile(
    'fl_realurl_image',
    'Configuration/TypoScript/',
    'RealURL Image'
);
