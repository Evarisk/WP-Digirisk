"use strict";

var digi_export = {
	$: undefined,

	init: function( event, $ ) {
		digi_export.$ = $;
		if ( event || event === undefined ) {
			digi_export.event();
		}
	},

	event: function() {
		digi_export.$( document ).on( 'submit', '#digi-export-form', function( event ) { digi_export.create_export( event, digi_export.$( this ) ); } );
	},

	create_export: function( event, element ) {
		event.preventDefault();
		digi_export.$( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				digi_export.$( element ).closest( '.wp-digi-bloc-loader' ).addClass( "wp-digi-bloc-loading" );
			},
			success: function( response ) {
				digi_export.$( element ).closest( '.wp-digi-bloc-loader' ).removeClass( "wp-digi-bloc-loading" );
			}
		} );
	}

};

jQuery( document ).ready(function( $ ) {
	digi_export.init( true, $ );
});
