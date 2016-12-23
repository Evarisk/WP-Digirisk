/**
 * Gères l'export et l'import des modèles de donnée de DigiRisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 *
 * @since 6.1.5.5
 * @version 6.2.1.2
 *
 * @memberof export
 */

/**
 * Initialise l'objet export dans l'objet digirisk
 * @memberof export
 * @type {Object}
 */
window.digirisk.export = {};

/**
 * La méthode init est appelé automatiquement
 *
 * @since 6.1.5.5
 * @version 6.2.1.2
 *
 * @memberof export
 *
 * @return {void}
 */
window.digirisk.export.init = function() {
	window.digirisk.export.event();
};

/**
 * Initialies les évènements submit et change
 *
 * @since 6.1.5.5
 * @version 6.2.1.2
 *
 * @memberof export
 *
 * @return {void}
 */
window.digirisk.export.event = function() {
	jQuery( document ).on( 'submit', '#digi-data-export #digi-export-form', window.digirisk.export.create_export );
	jQuery( document ).on( 'change', '#digi-data-export #digi-import-form input[type="file"]', window.digirisk.export.make_import );
};

/**
 * Lances la requête XHR pour créer le fichier .zip de l'export du modèle de donnée.
 *
 * @param  {Object} event [description]
 * @return {void}
 */
window.digirisk.export.create_export = function( event ) {
	var form = jQuery( this );
	event.preventDefault();
	jQuery( this ).closest( 'form' ).ajaxSubmit( {
		'beforeSubmit': function() {
			form.find( 'button' ).addClass( 'wp-digi-loading' );
		},
		success: function( response ) {
			form.find( 'button' ).removeClass( 'wp-digi-loading' );
			window.digirisk.global.download_file( response.data.url_to_file, response.data.filename );
		}
	} );
},

/**
 * Prépare la première requête pour importer un modèle de donnée.
 *
 * @param  {[type]} event [description]
 * @return {void}
 */
window.digirisk.export.make_import = function( event ) {
	var data = new FormData();

	event.preventDefault();

	data.append( 'file', jQuery( this )[0].files[0] );
	data.append( 'action', 'digi_import_data' );
	data.append( '_wpnonce', jQuery( this ).closest( 'form' ).find( 'input[name="_wpnonce"]' ).val() );
	data.append( 'index_element', 0 );

	window.digirisk.export.request_import( data );
},

/**
 * Lances la requête pour importer un modèle de donnée.
 * Modifie la barre de progression.
 *
 * @param  {[type]} data [description]
 * @return {void}
 */
window.digirisk.export.request_import = function( data ) {
	jQuery.ajax( {
		url: ajaxurl,
		data: data,
		processData: false,
		contentType: false,
		type: 'POST',
		beforeSend: function() {
			jQuery( '.digi-import-detail' ).html( window.digi_tools_in_progress );
		},
		success: function( response ) {
			var data = new FormData();

			if ( response.success ) {
				jQuery( 'progress' ).attr( 'max', response.data.count_element );
				jQuery( 'progress' ).val( ( response.data.index_element / response.data.count_element ) * response.data.count_element );

				if ( ! response.data.end ) {
					data.append( 'action', 'digi_import_data' );
					data.append( '_wpnonce', jQuery( '#digi-import-form' ).find( 'input[name="_wpnonce"]' ).val() );
					data.append( 'path_to_json', response.data.path_to_json );
					data.append( 'index_element', response.data.index_element );
					jQuery( '.digi-import-detail' ).html( window.digi_tools_in_progress );
					window.digirisk.export.request_import( data );
				} else {
					jQuery( '.digi-import-detail' ).html( window.digi_tools_done );
					if ( jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ) ) {
						jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
					}

					jQuery( 'progress' ).attr( 'max', 100 );
					jQuery( 'progress' ).val( 100 );
				}
			} else {
				alert( 'Problème lors de l\'importation du modèle' );
			}
		}
	} );
};
