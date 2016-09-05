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
		digi_export.$( document ).on( 'submit', '#digi-import-form', function( event ) { digi_export.make_import( event, digi_export.$( this ) ); } );
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
	},

	make_import: function( event, element ) {
		event.preventDefault();

		var data = new FormData();
		data.append( 'file', digi_export.$( element ).find( 'input[type="file"]' )[0].files[0] );
		data.append( 'action', 'digi_import_data' );
		data.append( '_wpnonce', digi_export.$( element ).find( 'input[name="_wpnonce"]' ).val() );

		digi_export.$.ajax( {
			url: ajaxurl,
			data: data,
			processData: false,
			contentType: false,
			type: 'POST',
			beforeSend: function() {
				digi_installer.$( '#digi-data-export' ).addClass( "wp-digi-bloc-loading" );
			},
			success: function() {
				digi_installer.$( '#digi-data-export' ).removeClass( "wp-digi-bloc-loading" );
				digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href', digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
			}
		} );
	}

};

jQuery( document ).ready(function( $ ) {
	digi_export.init( true, $ );
});
