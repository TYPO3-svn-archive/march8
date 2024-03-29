<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2010 Christian Technology Ministries International Inc.
 * All rights reserved
 *
 * This file is part of the Web-Empowered Church (WEC)
 * (http://WebEmpoweredChurch.org) ministry of Christian Technology Ministries 
 * International (http://CTMIinc.org). The WEC is developing TYPO3-based
 * (http://typo3.org) free software for churches around the world. Our desire
 * is to use the Internet to help offer new life through Jesus Christ. Please
 * see http://WebEmpoweredChurch.org/Jesus.
 *
 * You can redistribute this file and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation;
 * either version 2 of the License, or (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This file is distributed in the hope that it will be useful for ministry,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the file!
 ***************************************************************/

/**
 * General purpose library for working with skins.
 *
 * @author Web-Empowered Church <developer@webempoweredchurch.org>
 * @package TYPO3
 * @subpackage tx_march8
 */
class tx_march8_lib {

	/**
	 * Gets the key for the skin applied on the specified page.
	 *
	 * @param	int		The page id.
	 * @return	string
	 */
	public static function getCurrentSkin($pageId) {
		$tmpl = t3lib_div::makeInstance("t3lib_tsparser_ext");
		$tmpl->tt_track = 0;
		$tmpl->init();
		$templateRow = $tmpl->ext_getFirstTemplate($pageId);

		return $templateRow['skin_selector'];
	}

	/**
	 * Gets an array of all skin keys available.
	 *
	 * @return	array
	 */
	public static function getSkinKeys() {
		return array_merge(self::getCustomSkinKeys(), self::getStandardSkinKeys());
	}

	/**
	 * Gets an array of standard skin keys.
	 *
	 * @return	array
	 */
	public static function getStandardSkinKeys() {
		$skinKeys = array();
		foreach ((array) $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['march8']['skins'] as $skin) {
			$skinKeys[] = 'EXT:' . $skin;
		}

		natsort($skinKeys);
		return $skinKeys;
	}

	/**
	 * Gets an array of custom skin keys.
	 *
	 * @return array
	 */
	public static function getCustomSkinKeys() {
		$skinKeys = array();
		$customSkinPath = self::getCustomSkinPath();
		$skins = t3lib_div::get_dirs(PATH_site . $customSkinPath);
		foreach ((array) $skins as $skin) {
			if (substr($skin, 0, 1) != '.') {
				$skinKeys[] = 'LOCAL:' . $skin;
			}
		}

		natsort($skinKeys);
		return $skinKeys;
	}

	/**
	 * Gets the site-relative path for the specified skin.
	 *
	 * @return	string	$skin: The skin key.
	 */
	public static function getSkinPath($skin) {
		$customSkinPath = self::getCustomSkinPath();
		list($skinType, $skinKey) = t3lib_div::trimExplode(':', $skin);
		switch ($skinType) {
			case 'EXT':
				if (t3lib_extMgm::isLoaded($skinKey)) {
					$relSkinPath = t3lib_extMgm::siteRelPath($skinKey);
				} else {
					$relSkinPath = FALSE;
				}
				break;
			case 'LOCAL':
				$relSkinPath = $customSkinPath . $skinKey . '/';
				if (!@is_dir(PATH_site . $relSkinPath)) {
					$relSkinPath = FALSE;
				}
				break;
		}
		return $relSkinPath;
	}

	/**
	 * Gets the info array on the specified skin. This includes title, description,
	 * and thumbnail path.
	 *
	 * @param	string		The skin key.
	 * @return	array
	 */
	public static function getSkinInfo($skin) {
		$infoArray = array();
		list($skinType, $skinKey) = t3lib_div::trimExplode(':', $skin);
		$relSkinPath = self::getSkinPath($skin);
		if ($relSkinPath) {
			$absSkinPath = PATH_site . $relSkinPath;

			$infoText = t3lib_div::getURL($absSkinPath . 'info.txt');
			if ($infoText) {
				//$infoLines = t3lib_div::trimExplode('\n', $infoText);
				$infoLines = preg_split('/[\r\n]+/', $infoText, -1, PREG_SPLIT_NO_EMPTY);
				foreach ($infoLines as $line) {
					list($key, $value) = t3lib_div::trimExplode(':', $line, false, 2);
					$key = t3lib_div::strtolower($key);
					if (($key == 'title') || ($key == 'description')) {
						$infoArray[$key] = $value;
					}
				}
			} else {
				$infoArray['title'] = $skinKey;
			}

			$infoArray['type'] = $skinType;
			$infoArray['path'] = $relSkinPath;

			if (@is_file($absSkinPath . 'screenshot.gif')) {
				$infoArray['icon'] = self::getPathForSkinThumbnail($relSkinPath . 'screenshot.gif');
			} elseif (@is_file($absSkinPath . 'screenshot.png')) {
				$infoArray['icon'] = self::getPathForSkinThumbnail($relSkinPath . 'screenshot.png');
			} elseif (@is_file($absSkinPath . 'screenshot.jpg')) {
				$infoArray['icon'] = self::getPathForSkinThumbnail($relSkinPath . 'screenshot.jpg');
			}
		} else {
			return FALSE;
		}

		return $infoArray;
	}

	/**
	 * Helper function that gets the skin thumbnail.
	 *
	 * @param	string	Path to the skin screenshot, relative to TYPO3 root.
	 * @param	int		Thumbnail width.
	 * @param	int		Thumbnail height.
	 * @return	string
	 */
	protected static function getPathForSkinThumbnail($relativeScreenshotPath, $width = 300, $height = 400) {
		$absoluteScreenshotPath = PATH_site . $relativeScreenshotPath;
		$screenshotSize = $width . 'x' . $height;
		$thumbScript = '../typo3/thumbs.php';

		$salt = basename($absoluteScreenshotPath) . ':' . filemtime($absoluteScreenshotPath) . ':' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
		$params  = '&file=' . rawurlencode($absoluteScreenshotPath);
		$params .= '&size=' . $width . 'x' . $height;
		$params .= '&md5sum=' . t3lib_div::shortMD5($salt);
		$url = $thumbScript . '?&dummy=' . $GLOBALS['EXEC_TIME'] . $params;
		return $url;
	}

	/**
	 * Gets the path (relative to TYPO3 root) where custom skins can be found. Defaults to fileadmin/templates/.
	 *
	 * @return string
	 */
	public static function getCustomSkinPath() {
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['march8']);
		if (!$extConf['customSkinPath']) {
			$extConf['customSkinPath'] = 'fileadmin/templates/';
		}

		return $extConf['customSkinPath'];
	}

	/**
	 * Includes static template records (from static_template table) and static template files (from extensions) for the input template record row.
	 *
	 * @param	array		Array of parameters from the parent class.  Includes idList, templateId, pid, and row.
	 * @param	object		Reference back to parent object, t3lib_tstemplate or one of its subclasses.
	 * @return	void
	 */
	public static function includeTypoScriptForFrameworkCoreAndSkins($params, $pObj) {
		$idList = $params['idList'];
		$templateID = $params['templateId'];
		$pid = $params['pid'];
		$row = $params['row'];

			// Call hook for possible manipulation of current skin.
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/march8/class.tx_march8_lib.php']['assignSkinKey'])) {
			$_params = array('skinKey' => &$row['skin_selector']);
			foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/march8/class.tx_march8_lib.php']['assignSkinKey'] as $userFunc) {
				$row['skin_selector'] = t3lib_div::callUserFunction($userFunc, $_params, $ref = NULL);
			}
		}

		if ($row['root'] && $row['skin_selector']) {
			$skin = $row['skin_selector'];
			list($skinType, $skinKey) = t3lib_div::trimExplode(':', $skin);
			switch ($skinType) {
				case 'EXT':
					if (t3lib_extMgm::isLoaded($skinKey)) {
						$relSkinPath = t3lib_extMgm::siteRelPath($skinKey);
					} else {
						$relSkinPath = FALSE;
					}
					break;
				case 'LOCAL':
					$relSkinPath = self::getCustomSkinPath() . $skinKey . '/';
					break;
			}

			if ($relSkinPath) {
				$relCorePath = t3lib_extMgm::siteRelPath('march8') . 'core_templates/';
				$absCorePath = PATH_site . $relCorePath;
				$coreSubrow = array(
					'constants' => t3lib_div::getUrl($absCorePath . 'typoscript/core_constants.ts'),
					'config' => t3lib_div::getUrl($absCorePath . 'typoscript/core_typoscript.ts'),
					'editorcfg' => '',
					'include_static' => '',
					'include_static_file' => '',
					'title' => 'TemplaVoila Framework Core',
					'uid' => md5($relCorePath)
				);

				// Set old bnTemplates prefix for backwards compatibility.
				$coreSubrow['constants'] .= chr(10) . 'bnTemplates.corePath = ' . $relCorePath;
				$coreSubrow['constants'] .= chr(10) . 'march8.corePath = ' . $relCorePath;
				$pObj->processTemplate($coreSubrow, $idList.',march8_core', $pid, 'march8_core', $templateID);

				$absSkinPath = PATH_site . $relSkinPath;
				$skinSubrow = array(
					'constants'=>	@is_file($absSkinPath . 'typoscript/skin_constants.ts') ? t3lib_div::getUrl($absSkinPath . 'typoscript/skin_constants.ts') : '',
					'config'=>		@is_file($absSkinPath . 'typoscript/skin_typoscript.ts') ? t3lib_div::getUrl($absSkinPath . 'typoscript/skin_typoscript.ts') : '',
					'editorcfg'=>	'',
					'include_static'=>	'',
					'include_static_file'=>	'',
					'title' =>	$skin,
					'uid' => md5($relSkinPath)
				);

	
				// Set old bnTemplates prefix for backwards compatibility.
				$skinSubrow['constants'] .= chr(10) . 'bnTemplates.skinPath = ' . $relSkinPath;
				$skinSubrow['constants'] .= chr(10) . 'march8.skinPath = ' . $relSkinPath;
				$pObj->processTemplate($skinSubrow, $idList . ',march8_skin_' . $skin, $pid, 'march8_skin_' . $skin, $templateID);
			}
		}
	}

	/**
	 * Makes a new, local copy of a given skin key.
	 *
	 * @param	string	$skinKey: The skin to copy.
	 * @return	void
	 */
	public static function copySkinToLocal($skinKey) {
		$copyFrom = self::getSkinPath($skinKey);
		$copyTo = self::getCustomSkinPath();

		$filemounts['1'] = array(
			'name' => $copyTo,
			'path' => PATH_site . $copyTo
		);
		$filemounts['2'] = array(
			'name' => 'typo3conf/ext/',
			'path' => PATH_site . 'typo3conf/ext/'
		);

		$fileCommands = array(
			'copy' => array(
				array(
					'data' => PATH_site . $copyFrom,
					'target' => PATH_site . $copyTo,
					'altName' => 1
				)
			)
		);

		$fileHandler = t3lib_div::makeInstance('t3lib_extFileFunctions');
		$fileHandler->init($filemounts, $TYPO3_CONF_VARS['BE']['fileExtensions']);
		$fileHandler->init_actionPerms($GLOBALS['BE_USER']->getFileoperationPermissions());
		$fileHandler->start($fileCommands);

		$fileHandler->processData();
		$fileHandler->printLogErrorMessages();
	}

	/**
	 * Gets the static data structure array.  This array changed in TemplaVoila 1.5.
	 * See ext_localconf.php and ext_tables.php for usage.
	 *
	 * @param	string	Path where page data structures are found.
	 * @param	string	Path where FCE data structures are found.
	 * @return	void
	 */
	public static function getStaticDataStructureArray($pageDSPath, $fceDSPath) {
		$staticDataStructureArray = array();

		$staticDataStructureArray[] = array(
			'title' => '001 - Areas ( un area )',
			'path' => $pageDSPath . 'area.xml',
			'icon' => '',
			'scope' => 1,
		);	
		$staticDataStructureArray[] = array(
			'title' => '002 - Areas ( dos areas )',
			'path' => $pageDSPath . '2areas.xml',
			'icon' => '',
			'scope' => 1,
		);					
		$staticDataStructureArray[] = array(
			'title' => '003 - Areas ( tres areas )',
			'path' => $pageDSPath . '3areas.xml',
			'icon' => '',
			'scope' => 1,
		);		
		$staticDataStructureArray[] = array(
			'title' => '004 - Master',
			'path' => $pageDSPath . 'master.xml',
			'icon' => '',
			'scope' => 1,
		);	
		$staticDataStructureArray[] = array(
			'title' => '005 - Tabla - Newsletter',
			'path' => $pageDSPath . 'table.xml',
			'icon' => '',
			'scope' => 1,
		);					
		$staticDataStructureArray[] = array(
			'title' => '006 - Tabla - Newsletter ( dos areas )',
			'path' => $pageDSPath . 'table2areas.xml',
			'icon' => '',
			'scope' => 1,
		);							
		$staticDataStructureArray[] = array(
			'title' => '007 - Tabla - Newsletter ( tres areas )',
			'path' => $pageDSPath . 'table3areas.xml',
			'icon' => '',
			'scope' => 1,
		);									
	
		


		// Add FCE Data Structures
	
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col2.title',
			'path' => $fceDSPath . '2col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col3.title',
			'path' => $fceDSPath . '3col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col4.title',
			'path' => $fceDSPath . '4col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col5.title',
			'path' => $fceDSPath . '5col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);	
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col6.title',
			'path' => $fceDSPath . '6col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
		
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col7.title',
			'path' => $fceDSPath . '7col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				

		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col8.title',
			'path' => $fceDSPath . '8col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
				
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col9.title',
			'path' => $fceDSPath . '9col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
				
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col10.title',
			'path' => $fceDSPath . '10col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
		
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col11.title',
			'path' => $fceDSPath . '11col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);			
			
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.col12.title',
			'path' => $fceDSPath . '12col (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
						
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.tabs.title',
			'path' => $fceDSPath . 'tabs (fce).xml',
			'icon' => '',
			'scope' => 2,
		);
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.accordion.title',
			'path' => $fceDSPath . 'accordion (fce).xml',
			'icon' => '',
			'scope' => 2,
		);
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.slider.title',
			'path' => $fceDSPath . 'slider (fce).xml',
			'icon' => '',
			'scope' => 2,
		);		
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.kwicks.title',
			'path' => $fceDSPath . 'kwicks (fce).xml',
			'icon' => '',
			'scope' => 2,
		);				
		
		$staticDataStructureArray[] = array(
			'title' => 'LLL:EXT:march8/lang/locallang.xml:fce.ds.html_wrapper.title',
			'path' => $fceDSPath . 'html_wrapper (fce).xml',
			'icon' => '',
			'scope' => 2,
		);

		return $staticDataStructureArray;
	}

	/**
	 * Gets the current version of TemplaVoila as an integer.
	 * For example, 1.15.3 = 1015003
	 *
	 * @return int
	 */
	public static function getTemplaVoilaVersionAsInt() {
		return t3lib_div::int_from_ver(self::getTemplaVoilaVersion()); 
	}


	/**
	 * Gets the current version of TemplaVoila as a string.
	 *
	 * @return string
	 */
	public static function getTemplaVoilaVersion() {
		$key = 'templavoila';
		if (method_exists('t3lib_extMgm', 'getExtensionVersion')) {
			$version = t3lib_extMgm::getExtensionVersion($key);
		} else {
			// Copy of the core method in TYPO3 4.5
			if (!is_string($key) || empty($key)) {
				throw new InvalidArgumentException('Extension key must be a non-empty string.');
			}
			if (!t3lib_extMgm::isLoaded($key)) {
				return '';
			}

			$_EXTKEY = $key;
			include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');

			$version = $EM_CONF[$key]['version'];
		}

		return $version;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/march8/class.tx_march8_lib.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/march8/class.tx_march8_lib.php']);
}

?>
