<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2011 Kasper Skårhøj (kasperYYYY@typo3.com)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin 'Content rendering' for the 'march8' extension.
 *
 * @author	Kasper Skårhøj <kasperYYYY@typo3.com>
 */
/**
 * Plugin class - instantiated from TypoScript.
 * Rendering some content elements from tt_content table.
 *
 * @author	Kasper Skårhøj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage tx_cssstyledcontent
 */
class tx_march8_media extends tslib_pibase {

		// Default plugin variables:
	var $prefixId = 'tx_march8_media';		// Same as class name
	var $scriptRelPath = 'class.tx_march8_media.php';	// Path to this script relative to the extension dir.
	var $extKey = 'march8';		// The extension key.
	var $conf = array();

	/**
	 * Rendering the IMGTEXT content element, called from TypoScript (tt_content.textpic.20)
	 *
	 * @param	string		Content input. Not used, ignore.
	 * @param	array		TypoScript configuration. See TSRef "IMGTEXT". This function aims to be compatible.
	 * @return	string		HTML output.
	 * @access private
	 * @coauthor	Ernesto Baschny <ernst@cron-it.de>
	 */
	 function render_media($content, $conf)	{
			// Look for hook before running default code for function
		if (method_exists($this, 'hookRequest') && $hookObj = $this->hookRequest('render_media')) {
			return $hookObj->render_media($content,$conf);
		}

		$renderMethod = $this->cObj->stdWrap($conf['renderMethod'], $conf['renderMethod.']);



			// Specific configuration for the chosen rendering method
		if (is_array($conf['rendering.'][$renderMethod . '.']))	{
			$conf = $this->cObj->joinTSarrays($conf, $conf['rendering.'][$renderMethod . '.']);
		}

			// Image or Text with Image?
		if (is_array($conf['text.']))	{
			$content = $this->cObj->stdWrap($this->cObj->cObjGet($conf['text.'], 'text.'), $conf['text.']);
		}
			$flexField = $this->cObj->stdWrap($conf['video.']['flexParams.'], $conf['video.']['flexParams.']);
			$width=$this->pi_getFFvalue(t3lib_div::xml2array($flexField), 'mmWidth');
			$textMargin = intval($this->cObj->stdWrap($conf['textMargin'],$conf['textMargin.']));
			
			
			if($width!=''){
				$GLOBALS['TSFE']->register['rowWidthPlusTextMargin'] = $width+$textMargin;
			}else{
				$position = $this->cObj->stdWrap($conf['textPos'], $conf['textPos.']);
				$contentPosition = $position&24;	
				if ($contentPosition>=16)	{
					$GLOBALS['TSFE']->register['rowWidthPlusTextMargin']= round($GLOBALS["TSFE"]->register['maxImageWidth']/100*50)+$textMargin;
				}else{
					$GLOBALS['TSFE']->register['rowWidthPlusTextMargin'] = $GLOBALS["TSFE"]->register['maxImageWidth']+$textMargin;
				}					

			}
	
		/*$xml=new SimpleXMLElement($flexField);
$xml->data->sheet->language->field[3]->value='960';
$flexField=$xml->asXML();
$conf['video.']['flexParams.']=$flexField;*/
//$TCA['tt_content']['columns']['pi_flexform']['config']['ds'][',media']=$xml->asXML();	
	//	*/	
			
			//$H=$this->pi_setFFvalue(t3lib_div::xml2array($flexField), 'mmWidth','222');
			
			
 //t3lib_div::devLog('[write message in english here]', 'march8',0,array(0=>$flexField ));

			// Positioning
		$position = $this->cObj->stdWrap($conf['textPos'], $conf['textPos.']);

		$imagePosition = $position&7;	// 0,1,2 = center,right,left
		$contentPosition = $position&24;	// 0,8,16,24 (above,below,intext,intext-wrap)
		$align = $this->cObj->align[$imagePosition];



			// Apply optionSplit to the list of classes that we want to add to each image
		$addClassesImage = $conf['addClassesImage'];
		if ($conf['addClassesImage.'])	{
			$addClassesImage = $this->cObj->stdWrap($addClassesImage, $conf['addClassesImage.']);
		}
		$addClassesImageConf = $GLOBALS['TSFE']->tmpl->splitConfArray(array('addClassesImage' => $addClassesImage), $colCount);




		$output = $this->cObj->cObjGetSingle($conf['layout'], $conf['layout.']);
		$output = str_replace('###TEXT###', $content, $output);
		
		$output = str_replace('###CLASSES###', $class, $output);

		if ($conf['stdWrap.'])	{
			$output = $this->cObj->stdWrap($output, $conf['stdWrap.']);
		}

		return $output;
	}
	
	function customMediaRender($renderType, $conf, $obj, $conf)	{
		t3lib_div::devLog('[write message in english here]', 'march8',0,array(0=>'h' ));
	}
}



if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/march8/class.tx_march8_media.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/march8/class.tx_march8_media.php']);
}

?>