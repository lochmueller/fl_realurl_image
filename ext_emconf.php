<?php

$EM_CONF[$_EXTKEY] = array(
	'title'            => 'Image RealURL',
	'description'      => 'Add the RealURL functionality to image files. "typo3temp/2d972d5c89b5.jpg" goes "nice-name.jpg"! Many different fallbacks like file reference, file, content element or page settings to get the right file name.',
	'category'         => 'fe',
	'version'          => '3.1.2',
	'state'            => 'stable',
	'author'           => 'Tim Lochmueller, Sareen Millet, Dr. Ronald P. Steiner',
	'author_email'     => 'webmaster@fruit-lab.de',
	'author_company'   => 'typo3.fruit-lab.de',
	'constraints'      => array(
		'depends' => array(
			'typo3' => '6.2.0-7.1.99',
		),
	),
);

