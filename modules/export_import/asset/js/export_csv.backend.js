/**
 * Gères l'export en CSV
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 *
 * @memberof export
 */

/**
 * Initialise l'objet exportCSV dans l'objet digirisk
 * @memberof export
 * @type {Object}
 */
window.eoxiaJS.digirisk.exportCSV = {};

/**
 * La méthode init est appelé automatiquement
 *
 * @since 6.1.5.5
 * @version 6.2.1.2
 *
 * @memberof exportCSV
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.exportCSV.init = function() {
	window.eoxiaJS.digirisk.exportCSV.event();
};

/**
 * Initialies les évènements submit et change
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 *
 * @memberof exportCSV
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.exportCSV.event = function() {
	jQuery( document ).on( 'click', '#digi-export-csv-form button.blue', window.eoxiaJS.digirisk.exportCSV.makeExport );
};

/**
 * Utilises ajaxSubmit pour envoyer le formulaire en AJAX.
 *
 * @param  {ClickEvent} event L'évènement du clic.
 * @return {void}
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.exportCSV.makeExport = function( event ) {
	var button = jQuery( this );
	event.preventDefault();
	jQuery( this ).closest( 'form' ).ajaxSubmit( {
		'beforeSubmit': function() {
			button.addClass( 'loading' );
		},
		success: function( response ) {
			button.closest( 'form' ).find( 'progress' ).attr( 'max', response.data.number_risks );
			button.closest( 'form' ).find( 'progress' ).val( ( response.data.offset / response.data.number_risks ) * response.data.number_risks );
			if ( response.data.end ) {
				button.removeClass( 'loading' );
				window.eoxiaJS.global.downloadFile( response.data.url_to_file, response.data.filename );
				jQuery( '#digi-export-csv-form input[name="offset"]' ).val( 0 );
				jQuery( '#digi-export-csv-form input[name="filepath"]' ).val( '' );
				jQuery( '#digi-export-csv-form input[name="filename"]' ).val( '' );
				jQuery( '#digi-export-csv-form input[name="number_risks"]' ).val( 0 );
				jQuery( '#digi-export-csv-form input[name="url_to_file"]' ).val( '' );
			} else {
				jQuery( '#digi-export-csv-form input[name="offset"]' ).val( response.data.offset );
				jQuery( '#digi-export-csv-form input[name="filepath"]' ).val( response.data.filepath );
				jQuery( '#digi-export-csv-form input[name="filename"]' ).val( response.data.filename );
				jQuery( '#digi-export-csv-form input[name="number_risks"]' ).val( response.data.number_risks );
				jQuery( '#digi-export-csv-form input[name="url_to_file"]' ).val( response.data.url_to_file );

				jQuery( '#digi-export-csv-form button.blue' ).click();
			}
		}
	} );
};
