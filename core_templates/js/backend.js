document.observe("dom:loaded", function() {
	mousedownStatus = 0;

	function getCookie( name ) {
		var start = document.cookie.indexOf( name + "=" );
		var len = start + name.length + 1;
		if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) {
			return null;
		}
		if ( start == -1 ) return null;
		var end = document.cookie.indexOf( ';', len );
		if ( end == -1 ) end = document.cookie.length;
		return unescape( document.cookie.substring( len, end ) );
	}

	function setCookie( name, value, expires, path, domain, secure ) {
		var today = new Date();
		today.setTime( today.getTime() );
		if ( expires ) {
			expires = expires * 1000 * 60 * 60 * 24;
		}
		var expires_date = new Date( today.getTime() + (expires) );
		document.cookie = name+'='+escape( value ) +
			( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) +
			( ( path ) ? ';path=' + path : '' ) +
			( ( domain ) ? ';domain=' + domain : '' ) +
			( ( secure ) ? ';secure' : '' );
	}

	function deleteCookie( name, path, domain ) {
		if ( getCookie( name ) ) document.cookie = name + '=' +
				( ( path ) ? ';path=' + path : '') +
				( ( domain ) ? ';domain=' + domain : '' ) +
				';expires=Thu, 01-Jan-1970 00:00:01 GMT';
	}

	function revealContentArea(contentTarget) {
		$$('.tvContentTab').invoke('removeClassName', 'tvfwActiveTab');
		$(contentTarget + 'Tab').addClassName('tvfwActiveTab');
		$$('.tvContent').invoke('hide');
		$$('#' + contentTarget).invoke('show');
		setCookie ("tvActiveTab", contentTarget + 'Tab');
	}

	if (getCookie("tvActiveTab") != null) {
		if (getCookie("tvCurrentPage") != top.fsMod.recentIds["web"]) {
			setCookie ("tvActiveTab","tvMainContentTab");
			setCookie ("tvCurrentPage",top.fsMod.recentIds["web"]);
		}
	}
	else {
		setCookie ("tvActiveTab","tvMainContentTab");
		setCookie ("tvCurrentPage",top.fsMod.recentIds["web"]);
	}
	if (getCookie("tvActiveTab") != null) {
	$(getCookie("tvActiveTab")).addClassName('tvfwActiveTab');
	}
	$$('.tvContent').invoke('hide');
	if (getCookie("tvActiveTab") == "tvTopFeatureContentTab") {
		$$('#tvTopFeatureContent').invoke('show');
	}
	else if (getCookie("tvActiveTab") == "tvBottomFeatureContentTab") {
		$$('#tvBottomFeatureContent').invoke('show');
	}
	else if (getCookie("tvActiveTab") == "tvColumn1ContentTab") {
		$$('#tvColumn1Content').invoke('show');
	}
	else if (getCookie("tvActiveTab") == "tvColumn2ContentTab") {
		$$('#tvColumn2Content').invoke('show');
		
	}else if (getCookie("tvActiveTab") == "tvOuterTopContentTab") {
		$$('#tvOuterTopContent').invoke('show');
		
	}else if (getCookie("tvActiveTab") == "tvOuterBottomContentTab") {
		$$('#tvOuterBottomContent').invoke('show');
		
	}else{
		$$('#tvMainContent').invoke('show');
	}	

	if ($('tvTopFeatureContentTab')) {
		$('tvTopFeatureContentTab').observe('click', function(event) {
			revealContentArea('tvTopFeatureContent');
		});
	}

	$$('.sortable_handle').invoke('observe', 'mousedown', function(event) {
		mousedownStatus = 1;
	});
	$$('.sortable_handle').invoke('observe', 'mouseup', function(event) {
		mousedownStatus = 0;
	});

	if ($('tvTopFeatureContentTab')) {
		$('tvTopFeatureContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvTopFeatureContent');
			}
			mousedownStatus = 0;
		});
		$('tvTopFeatureContentTab').observe('click', function(event) {
			revealContentArea('tvTopFeatureContent');
		});
	}

	if ($('tvBottomFeatureContentTab')) {
		$('tvBottomFeatureContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvBottomFeatureContent');
			}
			mousedownStatus = 0;
		});
		$('tvBottomFeatureContentTab').observe('click', function(event) {
			revealContentArea('tvBottomFeatureContent');
		});
	}	

	if ($('tvMainContentTab')) {
		$('tvMainContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvMainContent');
			}
			mousedownStatus = 0;
		});
		$('tvMainContentTab').observe('click', function(event) {
		
			revealContentArea('tvMainContent');
		});
	}

	if ($('tvColumn1ContentTab')) {
		$('tvColumn1ContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvColumn1Content');
			}
			mousedownStatus = 0;
		});
		$('tvColumn1ContentTab').observe('click', function(event) {
			revealContentArea('tvColumn1Content');
		});
	}

	if ($('tvColumn2ContentTab')) {
		$('tvColumn2ContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvColumn2Content');
			}
			mousedownStatus = 0;
		});
		$('tvColumn2ContentTab').observe('click', function(event) {
			revealContentArea('tvColumn2Content');
		});
	}
	
	if ($('tvOuterTopContentTab')) {
		$('tvOuterTopContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvOuterTopContent');
			}
			mousedownStatus = 0;
		});
		$('tvOuterTopContentTab').observe('click', function(event) {
			
			revealContentArea('tvOuterTopContent');
		});
	}
	if ($('tvOuterBottomContentTab')) {
		$('tvOuterBottomContentTab').observe('mouseover', function(event) {
			if (mousedownStatus == 1) {
				revealContentArea('tvOuterBottomContent');
			}
			mousedownStatus = 0;
		});
		$('tvOuterBottomContentTab').observe('click', function(event) {
			
			revealContentArea('tvOuterBottomContent');
		});
	}	
	
	
	
});