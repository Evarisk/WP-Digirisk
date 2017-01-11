window.digirisk.society = {};

window.digirisk.society.init = function() {
	window.digirisk.society.event();
};

window.digirisk.society.event = function() {
	jQuery( document ).on( 'keyup', 'input[name="title"]', window.digirisk.society.display_save_button );
};

/**
 * Callback en cas de réussite de la requête Ajax "load_society"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLSpanElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.society.loadedSocietySuccess = function( element, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
};

window.digirisk.society.display_save_button = function( event ) {
	jQuery( this ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
	jQuery( this ).addClass( "active" );
	jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
};

window.digirisk.society.update_society_success = function( element, response ) {
	jQuery( element ).closest( '.wp-digi-global-sheet-header' ).find( '.wp-digi-global-action-container' ).addClass( 'hidden' );

	if ( 'digi-group' === response.data.society.type ) {
		jQuery( '.wp-digi-societytree-left-container span.title' ).text( ' - ' + response.data.society.title );
		jQuery( '.wp-digi-societytree-left-container li[data-groupment-id="' + response.data.society.id + '"] span[data-groupment-id="' + response.data.society.id + '"]' ).text( response.data.society.unique_identifier + ' - ' + response.data.society.title );
	}
	else {
		jQuery( '.wp-digi-societytree-left-container span[data-workunit-id="' + response.data.society.id + '"]' ).text( response.data.society.unique_identifier + ' - ' + response.data.society.title );
	}
};

/**
 * Callback en cas de réussite de la requête Ajax "delete_society"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLLiElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.society.deletedSocietySuccess = function( triggeredElement, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
};
