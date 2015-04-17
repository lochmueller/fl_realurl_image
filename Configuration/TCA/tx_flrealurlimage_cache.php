<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

return array(
	'ctrl'        => array(
		'title'             => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:fl_realurl_image.tabletitle',
		'label'             => 'realurl_path',
		'tstamp'            => 'tstamp',
		'crdate'            => 'crdate',
		'rootLevel'         => 1,
		'dynamicConfigFile' => t3lib_extMgm::extPath('fl_realurl_image') . 'Configuration/TCA/Cache.php',
		'iconfile'          => t3lib_extMgm::extRelPath('fl_realurl_image') . 'ext_icon.gif',
	),
	'interface'   => Array(
		'showRecordFieldList' => ''
	),
	'feInterface' => $GLOBALS['TCA']['tx_flrealurlimage_cache']['feInterface'],
	'columns'     => Array(
		'image_path'   => Array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:fl_realurl_image.image_path',
			'config'  => Array('type' => 'none')
		),
		'realurl_path' => Array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:fl_realurl_image.realurl_path',
			'config'  => Array('type' => 'none')
		),
		'crdate'       => Array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:fl_realurl_image.crdate',
			'config'  => Array(
				'type' => 'input',
				'eval' => 'datetime'
			)
		),
		'page_id'      => Array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:fl_realurl_image.page_id',
			'config'  => Array(
				'type'          => 'group',
				'internal_type' => 'db',
				'allowed'       => 'pages',
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			)
		),
	),
	'types'       => Array(
		'0' => Array('showitem' => 'realurl_path;;1,image_path;;;;1-1-1,page_id')
	),
	'palettes'    => Array(
		'1' => Array('showitem' => 'crdate'),
	)
);