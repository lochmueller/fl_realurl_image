<?php


$tempColumns = [
    'realurl_image_name' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:sys_file_metadata.realurl_image_name',
        'config'  => [
            'type' => 'input',
            'eval' => 'trim',
        ]
    ],
];


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_metadata', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_file_metadata',
    'realurl_image_name',
    '',
    'after:alternative'
);
