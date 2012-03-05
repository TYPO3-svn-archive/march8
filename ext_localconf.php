<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tstemplate.php']['includeStaticTypoScriptSourcesAtEnd'][] = 'EXT:march8/class.tx_march8_lib.php:&tx_march8_lib->includeTypoScriptForFrameworkCoreAndSkins';
	$backendStylesheet = 'backend.css';





// Update TemplaVoila with special stylesheet and Javascript
t3lib_extMgm::addPageTSConfig('
	#Include js file for backend styling
	mod.web_txtemplavoilaM1.javascript.file1 = ' . t3lib_extMgm::extRelPath('march8') . 'core_templates/js/backend.js

	#Include css file for backend styling
	mod.web_txtemplavoilaM1.stylesheet = ' . t3lib_extMgm::extRelPath('march8') . 'core_templates/css/' . $backendStylesheet . '

	<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/core_templates/typoscript/pageTSconfig.txt">

');


 
$staticDataStructures = tx_march8_lib::getStaticDataStructureArray(
	'EXT:' . $_EXTKEY . '/core_templates/datastructures/page/',
	'EXT:' . $_EXTKEY . '/core_templates/datastructures/fce/'
);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['templavoila']['staticDataStructures'] = array_merge(
	(array) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['templavoila']['staticDataStructures'],
	$staticDataStructures
);


$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = t3lib_extMgm::extPath($_EXTKEY). 'class.tx_march8_html.php:&tx_march8_html->noCache'; 
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = t3lib_extMgm::extPath($_EXTKEY). 'class.tx_march8_html.php:&tx_march8_html->cache';


//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/hooks/class.tx_cms_mediaitems.php']['customMediaRenderTypes'][]='EXT:' . $_EXTKEY . '/class.tx_march8_media.php:&tx_march8_media->hook1';
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/hooks/class.tx_cms_mediaitems.php']['customMediaRender'][]='EXT:' . $_EXTKEY . '/class.tx_march8_media.php:tx_march8_media';




//$TYPO3_CONF_VARS["FE"]["XCLASS"]["tslib/content/class.tslib_content_media.php"]= 'EXT:' . $_EXTKEY . '/class.ux_tslib_content_media.php';
$TYPO3_CONF_VARS['FE']['XCLASS']['tslib/content/class.tslib_content_media.php'] = t3lib_extMgm::extPath($_EXTKEY).'class.ux_tslib_content_media.php'; 




/* Quizá con esto pueda meter configuración en el RTE directamente
if ($_EXTCONF['setPageTSconfig'] || !$_EXTCONF)	{
	t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:css_styled_content/pageTSconfig.txt">');
}

if ($_EXTCONF['removePositionTypes'] || !$_EXTCONF)	{
	t3lib_extMgm::addPageTSConfig('
		TCEFORM.tt_content.imageorient.types.image.removeItems = 8,9,10,17,18,25,26
	');
}*/

?>