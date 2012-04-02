<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Includejs',
	array(
		'IncludeJs' => 'includeJs',
		
	),
	// non-cacheable actions
	array(
		'IncludeJs' => 'includeJs',
		
	)
);

?>