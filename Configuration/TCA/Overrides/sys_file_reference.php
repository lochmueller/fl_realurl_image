<?php


$tempColumns = [
    'realurl_image_name' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:sys_file_metadata.realurl_image_name',
        'config'  => [
            'type'    => 'input',
            'eval'    => 'trim,null',
            'default' => '',
        ]
    ],
];


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $tempColumns);

$GLOBALS['TCA']['sys_file_reference']['palettes']['imageoverlayPalette']['showitem'] .= ',realurl_image_name';
