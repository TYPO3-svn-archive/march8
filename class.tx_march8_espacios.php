<?php


	require_once(PATH_tslib.'class.tslib_pibase.php');
	require_once(t3lib_extMgm::extPath('templavoila').'class.tx_templavoila_api.php');


	class tx_march8_espacios extends tslib_pibase {

		var $pi_checkCHash = true;


		function montar($content, $conf) {
			$containerWidth = intval($this->cObj->stdWrap($conf['containerWidth'], $conf['containerWidth.']));
			$GLOBALS["TSFE"]->register['containerWidth'] = $containerWidth;
			$GLOBALS["TSFE"]->register['maxImageWidth'] = $containerWidth;
			$GLOBALS["TSFE"]->register['originalContainerWidth']['data'] = $GLOBALS["TSFE"]->register['containerWidth'];
			$GLOBALS["TSFE"]->register['nestingLevel'] = 0;
			$pageUid = intval($this->cObj->stdWrap($conf['pageUid'], $conf['pageUid.']));
			$flexField = htmlspecialchars($this->cObj->stdWrap($conf['flexField'], $conf['flexField.']));
			$page = ($pageUid == $GLOBALS['TSFE']->id || $pageUid == 0) ? $GLOBALS['TSFE']->page : $this->pi_getRecord('pages', $pageUid);
			$uids = explode(',', $this->pi_getFFvalue(t3lib_div::xml2array($page['tx_templavoila_flex']), $flexField));
			foreach ($uids as $uid) {
				$content .= $this->cObj->RECORDS(array('source' => $uid, 'tables' => 'tt_content') );
			}
			return $content;
		}		
	}





?>
