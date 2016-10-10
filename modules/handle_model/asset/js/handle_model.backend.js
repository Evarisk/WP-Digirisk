"use strict";

var handle_model = {
	$: undefined,

	init: function( event, $ ) {
		handle_model.$ = $;
		if ( event || event === undefined ) {
			handle_model.event();
		}
	},

	event: function() {
	}
};

jQuery( document ).ready(function( $ ) {
	handle_model.init( true, $ );
});
