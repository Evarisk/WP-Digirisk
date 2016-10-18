window.digirisk.export = {};

window.digirisk.export.init = function() {
	window.digirisk.export.event();
};

window.digirisk.export.event = function() {
	jQuery( document ).on( 'submit', '#digi-data-export #digi-export-form', window.digirisk.export.create_export );
	jQuery( document ).on( 'change', '#digi-data-export #digi-import-form input[type="file"]', window.digirisk.export.make_import );
};


window.digirisk.export.create_export = function( event ) {
	event.preventDefault();
	jQuery( this ).closest( 'form' ).ajaxSubmit( {
		'beforeSubmit': function() {
			jQuery( this ).closest( '.wp-digi-bloc-loader' ).addClass( "wp-digi-bloc-loading" );
		},
		success: function( response ) {
			jQuery( this ).closest( '.wp-digi-bloc-loader' ).removeClass( "wp-digi-bloc-loading" );
			window.digirisk.global.download_file( response.data.url_to_file, response.data.filename );
		}
	} );
},

window.digirisk.export.make_import = function( event ) {
	event.preventDefault();

	var data = new FormData();
	data.append( 'file', jQuery( this )[0].files[0] );
	data.append( 'action', 'digi_import_data' );
	data.append( '_wpnonce', jQuery( this ).closest('form').find( 'input[name="_wpnonce"]' ).val() );
	data.append( 'index_element', 0 );

	window.digirisk.export.request_import( data );
},

window.digirisk.export.request_import = function( data ) {
	jQuery.ajax( {
		url: ajaxurl,
		data: data,
		processData: false,
		contentType: false,
		type: 'POST',
		beforeSend: function() {
			jQuery('.digi-import-detail').html( window.digi_tools_in_progress );
		},
		success: function(response) {
			if ( response.success ) {
				jQuery('progress').attr( 'max', response.data.count_element );
				jQuery('progress').val( ( response.data.index_element / response.data.count_element ) * response.data.count_element );

				if ( !response.data.end ) {
					var data = new FormData();
					data.append( 'action', 'digi_import_data' );
					data.append( '_wpnonce', jQuery( '#digi-import-form' ).find( 'input[name="_wpnonce"]' ).val() );
					data.append( 'path_to_json', response.data.path_to_json );
					data.append( 'index_element', response.data.index_element );
					jQuery('.digi-import-detail').html( window.digi_tools_in_progress );
					digi_export.request_import(data);
				}
				else {
					jQuery('.digi-import-detail').html( window.digi_tools_done );
					if ( jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ) ) ) {
						jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
					}
				}

			}
			else {
				alert( 'Problème lors de l\'importation du modèle' );
				// digi_installer.$( '#digi-data-export' ).removeClass( "wp-digi-bloc-loading" );
			}
		}
	} );
}
