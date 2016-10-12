"use strict";

window.eva_lib = {};
window.digirisk = {};

window.eva_lib.init = function() {
	window.eva_lib.load_list_script();
	window.eva_lib.init_array_form();
}

window.eva_lib.load_list_script = function() {
	for ( var key in window.digirisk ) {
		console.log('Initialisation de l\'objet: ' + key);
		new window.digirisk[key]();
	}
}

window.eva_lib.init_array_form = function() {
	console.log('Init array form');
	new window.eva_lib.array_form();
}

window.onload = window.eva_lib.init;
