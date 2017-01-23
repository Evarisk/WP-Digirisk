'use strict';

window.eoxiaJS = {};
window.digirisk = {};

window.eoxiaJS.init = function() {
	window.eoxiaJS.loadScripts();
	window.eoxiaJS.initArrayForm();
	window.eoxiaJS.initToolTip();
};

window.eoxiaJS.loadScripts = function() {
	var key;
	for ( key in window.digirisk ) {
		window.digirisk[key].init();
	}
};

window.eoxiaJS.initArrayForm = function() {
	 window.eoxiaJS.arrayForm.init();
};

window.eoxiaJS.initToolTip = function() {
	window.eoxiaJS.tooltip.init();
};

jQuery( document ).ready( window.eoxiaJS.init );
