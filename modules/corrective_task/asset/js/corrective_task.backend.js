"use strict";

var digi_corrective_task = {
	$: undefined,

	event: function( $ ) {
		digi_corrective_task.$ = $;
		digi_corrective_task.$( document ).on( 'click', '.wp-digi-risk .wp-digi-action-open-task', function( event ) { digi_corrective_task.open_task( event, digi_corrective_task.$( this ) ); } );
	},

	open_task: function( event, element ) {
		event.preventDefault();

		alert('ok');
	}
};
