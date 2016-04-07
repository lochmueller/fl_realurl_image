<?php


$tempColumns = array(
    'realurl_image_name' => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:fl_realurl_image/Resources/Private/Language/locallang.xml:sys_file_metadata.realurl_image_name',
        'config'  => array(
            'type' => 'input',
            'eval' => 'alphanum_x,nospace,trim,unique',
        )
    ),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_metadata', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', 'realurl_image_name', '',
    'after:alternative');
