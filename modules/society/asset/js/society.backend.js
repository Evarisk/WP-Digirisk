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
 * @param  {Object}        response             Les données renvoyées par la requête Ajax.
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
	jQuery( this ).addClass( 'active' );
	jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
};

/**
 * Callback en cas de réussite de la requête Ajax "save_society"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response            Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.society.savedSocietySuccess = function( element, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
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

/**
 * Callback en cas de réussite de la requête Ajax "save_groupment_configuration".
 * Remplaces les titres dans la navigation et le header du contenu principale.
 *
 * @param  {HTMLLiElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.society.savedSocietyConfiguration = function( triggeredElement, response ) {
	if ( 'digi-group' === response.data.society.type ) {
		jQuery( '.digirisk-wrap .workunit-navigation .title' ).text( response.data.society.unique_identifier + ' - ' + response.data.society.title );
	} else {
		jQuery( '.digirisk-wrap .workunit-list span[data-workunit-id="' + response.data.society.id + '"] span' ).text( response.data.society.title );
		jQuery( '.digirisk-wrap .workunit-list span[data-workunit-id="' + response.data.society.id + '"] span' ).attr( 'title', response.data.society.title );
	}

	jQuery( '.digirisk-wrap .main-content h1' ).text( 'Configuration de ' + response.data.society.unique_identifier + ' - ' + response.data.society.title );
	jQuery( '.digirisk-wrap .main-container .main-header input[name="title"]' ).val( response.data.society.title );
};
