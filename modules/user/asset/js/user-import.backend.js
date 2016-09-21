"use strict";

var digi_user_import = {
	$: undefined,

	init: function( event, $ ) {
		digi_user_import.$ = $;
		if ( event || event === undefined ) {
			digi_user_import.event();
		}
	},

	event: function() {
		digi_user_import.$( document ).on( 'submit', '#digi-data-import-user #digi-export-form', function( event ) { digi_user_import.create_export( event, digi_user_import.$( this ) ); } );
		digi_user_import.$( document ).on( 'change', '#digi-data-import-user #digi-import-form input[type="file"]', function( event ) { digi_user_import.make_import( event, digi_user_import.$( this ) ); } );
	},

	create_export: function( event, element ) {
		event.preventDefault();
		digi_user_import.$( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				digi_user_import.$( element ).closest( '.wp-digi-bloc-loader' ).addClass( "wp-digi-bloc-loading" );
			},
			success: function( response ) {
				digi_user_import.$( element ).closest( '.wp-digi-bloc-loader' ).removeClass( "wp-digi-bloc-loading" );
				window.digi_global.download_file( response.data.url_to_file, response.data.filename );
			}
		} );
	},

	make_import: function( event, element ) {
		event.preventDefault();

		var data = new FormData();
		data.append( 'file', digi_user_import.$( element )[0].files[0] );
		data.append( 'action', 'digi_import_user' );
		data.append( '_wpnonce', digi_user_import.$( element ).closest('form').find( 'input[name="_wpnonce"]' ).val() );
		data.append( 'index_element', 0 );

		digi_user_import.request_import( data );
	},

	request_import: function( data ) {
		digi_user_import.$.ajax( {
			url: ajaxurl,
			data: data,
			processData: false,
			contentType: false,
			type: 'POST',
			beforeSend: function() {
				digi_user_import.$('.digi-import-detail').html( window.digi_tools_in_progress );
			},
			success: function(response) {
				if ( response.success ) {
					if ( !response.data.end ) {
						var data = new FormData();
						data.append( 'action', 'digi_import_user' );
						data.append( '_wpnonce', digi_user_import.$( '#digi-data-import-user #digi-import-form' ).find( 'input[name="_wpnonce"]' ).val() );
						data.append( 'index_element', response.data.index_element );
						data.append( 'count_element', response.data.count_element );
						data.append( 'path_to_csv', response.data.path_to_csv );
						digi_user_import.$('.digi-import-detail').html( window.digi_tools_in_progress );
						digi_user_import.request_import(data);
					}
					else {
						digi_user_import.$('.digi-import-detail').html( window.digi_tools_done );
					}

					digi_user_import.$('progress').attr( 'max', response.data.count_element );
					digi_user_import.$('progress').val( ( response.data.index_element / response.data.count_element ) * response.data.count_element );

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
	digi_user_import.init( true, $ );
});
