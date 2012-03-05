<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// Define the TCA for the access control calendar selector.
$skinSelector = array(
	'skin_selector' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:march8/locallang_db.php:skinSelectorLabel',
		'displayCond' => 'FIELD:root:REQ:true',
		'config' => array(
			'type' => 'user',
			'userFunc' => 'tx_march8_skinselector->display',
		)
	),
);

// Add the skin selector for backend users.
t3lib_div::loadTCA('sys_template');
t3lib_extMgm::addTCAcolumns('sys_template', $skinSelector);
t3lib_extMgm::addToAllTCAtypes('sys_template', '--div--;LLL:EXT:march8/locallang_db.php:skinSelectorTab, skin_selector');



t3lib_div::loadTCA('pages');
 
$TCA['pages']['columns']['tx_templavoila_to']['config']['size'] = 1;
$TCA['pages']['columns']['tx_templavoila_next_to']['config']['size'] = 1;
$TCA['pages']['columns']['tx_templavoila_to']['config']['selicon_cols'] = 4;
$TCA['pages']['columns']['tx_templavoila_next_to']['config']['selicon_cols'] = 4;
unset($TCA['pages']['columns']['tx_templavoila_to']['config']['suppress_icons']);
unset($TCA['pages']['columns']['tx_templavoila_next_to']['config']['suppress_icons']);

$TCA['pages']['palettes']['layout']['showitem'] = str_replace('tx_templavoila_next_to', '--linebreak--, tx_templavoila_next_to', $TCA['pages']['palettes']['layout']['showitem']);



foreach ($TCA['tt_content']['types'] as $type => $tmpConf) {
	$TCA['tt_content']['types'][$type]['showitem'] = str_replace(
		'LLL:EXT:cms/locallang_ttc.xml:palette.header;header',
		'LLL:EXT:cms/locallang_ttc.xml:palette.headers;headers',
		$tmpConf['showitem']
	);
}


$TCA['pages']['columns']['module']['config']['items'][] = array('Plantilla Maestra', 'master', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/overlays.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Buscador', 'buscador', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/find.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Mapa Web', 'mapaweb', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/sitemap_color.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Formulario de Registro', 'registro', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/vcard_add.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Edición de Perfil', 'ediciondeperfil', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/vcard_edit.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Perfil', 'perfil', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/vcard.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Formulario de Contacto', 'contacto', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/email.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Home', 'home', '../typo3conf/ext/' . $_EXTKEY .'/resources/famfamfam/house.png');



t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-master', '../typo3conf/ext/march8/resources/famfamfam/overlays.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-buscador', '../typo3conf/ext/march8/resources/famfamfam/find.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-mapaweb', '../typo3conf/ext/march8/resources/famfamfam/sitemap_color.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-registro', '../typo3conf/ext/march8/resources/famfamfam/vcard_add.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-ediciondeperfil', '../typo3conf/ext/march8/resources/famfamfam/vcard_edit.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-perfil', '../typo3conf/ext/march8/resources/famfamfam/vcard.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-contacto', '../typo3conf/ext/march8/resources/famfamfam/email.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-home', '../typo3conf/ext/march8/resources/famfamfam/house.png');


//Con este unset elimino elementos de la lista desplegable en la que pone el tipo de elemento que es 
//unset($TCA['tt_content']['columns']['CType']['config']['items'][21]);


//unset($TCA['tt_content']['types']['div']);



					
					
	$TCA['tt_content']['columns']['imageorient']['config']['items']=array(
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.2', 2, 'EXT:march8/resources/selicons/above_left.png'),
	Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.0', 0, 'EXT:march8/resources/selicons/above_center.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.1', 1, 'EXT:march8/resources/selicons/above_right.png'),
array('LLL:EXT:march8/locallang_db.xml:tl',	7,'EXT:march8/resources/selicons/above_left_bottom.png'),
array('LLL:EXT:march8/locallang_db.xml:tc',	5,'EXT:march8/resources/selicons/above_center_bottom.png'),
array('LLL:EXT:march8/locallang_db.xml:tr',	6,'EXT:march8/resources/selicons/above_right_bottom.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.5', 10, 'EXT:march8/resources/selicons/below_left.png'),
array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.3', 8, 'EXT:march8/resources/selicons/below_center.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.4', 9, 'EXT:march8/resources/selicons/below_right.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.6', 17, 'EXT:march8/resources/selicons/intext_right.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.7', 18, 'EXT:march8/resources/selicons/intext_left.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.8', '--div--',''),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.9', 25, 'EXT:march8/resources/selicons/intext_right_nowrap.png'),
Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.10', 26, 'EXT:march8/resources/selicons/intext_left_nowrap.png')		
	);
					
					
					
					
					
					
			
					
					
					
					
$TCA['tt_content']['columns']['imageorient']['config']['selicon_cols'] = 3; 
				
				//'default' => '0',



$TCA['tt_content']['types']['media']=array(
			'showitem' =>
					'--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.headers;headers,
					bodytext;Text;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],
					rte_enabled;LLL:EXT:cms/locallang_ttc.xml:rte_enabled_formlabel,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media,
					pi_flexform; ;,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,

					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imageblock;imageblock,

				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended',
		);



?>
