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
		digi_export.$( document ).on( 'change', '#digi-import-form input[type="file"]', function( event ) { digi_export.make_import( event, digi_export.$( this ) ); } );
	},

	create_export: function( event, element ) {
		event.preventDefault();
		digi_export.$( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				digi_export.$( element ).closest( '.wp-digi-bloc-loader' ).addClass( "wp-digi-bloc-loading" );
			},
			success: function( response ) {
				digi_export.$( element ).closest( '.wp-digi-bloc-loader' ).removeClass( "wp-digi-bloc-loading" );
				window.digi_global.download_file( response.data.url_to_file, response.data.filename );
			}
		} );
	},

	make_import: function( event, element ) {
		event.preventDefault();

		var data = new FormData();
		data.append( 'file', digi_export.$( element )[0].files[0] );
		data.append( 'action', 'digi_import_data' );
		data.append( '_wpnonce', digi_export.$( element ).closest('form').find( 'input[name="_wpnonce"]' ).val() );
		data.append( 'index_element', 0 );

		digi_export.request_import( data );
	},

	request_import: function( data ) {
		digi_export.$.ajax( {
			url: ajaxurl,
			data: data,
			processData: false,
			contentType: false,
			type: 'POST',
			beforeSend: function() {
				digi_export.$('.digi-import-detail').html( window.digi_tools_in_progress );
			},
			success: function(response) {
				if ( response.success ) {
					if ( !response.data.end ) {
						var data = new FormData();
						data.append( 'action', 'digi_import_data' );
						data.append( '_wpnonce', digi_export.$( '#digi-import-form' ).find( 'input[name="_wpnonce"]' ).val() );
						data.append( 'path_to_json', response.data.path_to_json );
						data.append( 'index_element', response.data.index_element );
						digi_export.$('.digi-import-detail').html( window.digi_tools_in_progress );
						digi_export.request_import(data);
					}
					else {
						digi_export.$('.digi-import-detail').html( window.digi_tools_done );
					}

					digi_export.$('progress').attr( 'max', response.data.count_element );
					digi_export.$('progress').val( ( response.data.index_element / response.data.count_element ) * response.data.count_element );

				}
				else {
					alert( 'Problème lors de l\'importation du modèle' );
					digi_installer.$( '#digi-data-export' ).removeClass( "wp-digi-bloc-loading" );
				}
			}
		} );
	}
};

jQuery( document ).ready(function( $ ) {
	digi_export.init( true, $ );
});
