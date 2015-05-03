<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$l10nFile = 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml';

return array(
	'ctrl'     => array(
		'title'             => $l10nFile . 'fl_realurl_image.tabletitle',
		'label'             => 'realurl_path',
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'rootLevel'         => 1,
		'dynamicConfigFile' => ExtensionManagementUtility::extPath('fl_realurl_image') . 'Configuration/TCA/Cache.php',
		'iconfile'          => ExtensionManagementUtility::extRelPath('fl_realurl_image') . 'ext_icon.gif',
	),
	'columns'  => array(
		'image_path'   => array(
			'exclude' => 0,
			'label'   => $l10nFile . 'fl_realurl_image.image_path',
			'config'  => array('type' => 'none')
		),
		'realurl_path' => array(
			'exclude' => 0,
			'label'   => $l10nFile . 'fl_realurl_image.realurl_path',
			'config'  => array('type' => 'none')
		),
		'crdate'       => array(
			'exclude' => 0,
			'label'   => $l10nFile . 'fl_realurl_image.crdate',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime'
			)
		),
		'page_id'      => array(
			'exclude' => 0,
			'label'   => $l10nFile . 'fl_realurl_image.page_id',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'db',
				'allowed'       => 'pages',
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			)
		),
	),
	'types'    => array(
		'0' => array('showitem' => 'realurl_path;;1,image_path;;;;1-1-1,page_id')
	),
	'palettes' => array(
		'1' => array('showitem' => 'crdate'),
	)
);