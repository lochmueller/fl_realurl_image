<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "fl_realurl_image".
 *
 * Auto generated 17-04-2015 16:15
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Image RealURL',
	'description' => 'Add the RealURL functionality to image files. "typo3temp/2d972d5c89b5.jpg" goes "nice-name.jpg"! Many different fallbacks like file reference, file, content element or page settings to get the right file name.',
	'category' => 'fe',
	'version' => '3.1.2',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => NULL,
	'clearcacheonload' => false,
	'author' => 'Tim Lochmueller, Sareen Millet, Dr. Ronald P. Steiner',
	'author_email' => 'webmaster@fruit-lab.de',
	'author_company' => 'typo3.fruit-lab.de',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

