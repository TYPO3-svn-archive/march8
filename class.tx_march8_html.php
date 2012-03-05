<?php
include_once('lib/simple_html_dom.php');
$w3ccss='';
$count = 0;  

class tx_march8_html {
  public function replaceContent(&$params, &$obj) {
	$html = new simple_html_dom();
	$html->load($params['pObj']->content);
	$e=$html->find('img');
	foreach($e as $s){
		$s->class=$s->class.' w3c'.$GLOBALS['count'];
		$GLOBALS['w3ccss'].=' .w3c'.$GLOBALS['count'].'{ '
	  		.$s->style.
	  			($s->height?(' height:'.$s->height.'px; '):'').
	   			($s->width?(' width:'.$s->width.'px; '):'').
	   			($s->border?(' border:'.$s->border.'px; '):'').'} ';
			$s->height= null;
	    	$s->width= null;
	      	$s->border= null;
		$GLOBALS['count']++;
	}
	$e=$html->find('[style]');
	foreach($e as $s){
		$s->class=$s->class.' w3c'.$GLOBALS['count'];
		$GLOBALS['w3ccss'].=' .w3c'.$GLOBALS['count'].'{ '.$s->style.' } ';
		$s->style= null;
		$GLOBALS['count']++;
	}
	$e=$html->find('head',0);
	$e->innertext=$e->innertext.'<style type="text/css">'.$GLOBALS['w3ccss'].'</style>'.'<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('march8').'/core_templates/js/modernizr-2.0.6.custom.min.js"></script>';
  	//Primera letra, palabra
	$e=$html->find('.csc-header h1,.csc-header h2,.csc-header h3,.csc-header h4,.csc-header h5,.csc-header h6');
	foreach($e as $s){
		$link=$s->find('a',0);
		if($link===NULL){
			$espacio=strpos($s->innertext,' ');
			if($espacio!=FALSE){
				$s->innertext='<span class="word1"><span class="character1">'.substr($s->innertext,0,1).'</span>'.substr($s->innertext,1,$espacio-1).'</span>'.substr($s->innertext,$espacio);
			}else{
				$s->innertext='<span class="word1"><span class="character1">'.substr($s->innertext,0,1).'</span>'.substr($s->innertext,1).'</span>';	
			}
		}else{
			$espacio=strpos($link->innertext,' ');
			if($espacio!=FALSE){
				$link->innertext='<span class="word1"><span class="character1">'.substr($link->innertext,0,1).'</span>'.substr($link->innertext,1,$espacio-1).'</span>'.substr($link->innertext,$espacio);
			}else{
				$link->innertext='<span class="word1"><span class="character1">'.substr($link->innertext,0,1).'</span>'.substr($link->innertext,1).'</span>';
			}
		}
	}
	//Implementar sistema de comportamiento de espacios	
	
  /*	$e=$html->find('#topNav nav,#header header,#mainMenu nav,#topFeature section,#topBreadcrumb nav, #mainCenterWrapper aside, #main #mainHeader, #main #mainContent, #main #mainFooter, #bottomBreadcrumb nav, #bottomFeature section, #bottomMenu nav, #footer footer, #bottomNav nav');
	foreach($e as $s){
		if(trim($s->innertext)=="")  
		$s->outertext="";
	}
  	$e=$html->find('#topNav, #header, #mainMenu,#topFeature,#topBreadcrumb, #main, #bottomBreadcrumb, #bottomFeature, #bottomMenu, #footer, #bottomNav');
	foreach($e as $s){
		if(trim($s->innertext)=="")  
		$s->outertext="";
	}
*/
	
	
	
	$params['pObj']->content = $html->save();
  }

  public function noCache(&$params, &$obj) {
    if (!$GLOBALS['TSFE']->isINTincScript()) { // If there are no INTincScripts to include
      return; // stop
    }
    $this->replaceContent($params, $obj); // call main replace function
  }

  public function cache(&$params, &$obj) {
    if ($GLOBALS['TSFE']->isINTincScript()) { // If there are any INTincScripts to include
      return; // stop
    }
    $this->replaceContent($params, $obj); // call main replace function
  }
}
?>
