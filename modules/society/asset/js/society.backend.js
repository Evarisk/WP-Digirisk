window.digirisk.society = {};

window.digirisk.society.init = function() {
	window.digirisk.society.event();
};

window.digirisk.society.event = function() {
<<<<<<< HEAD
	jQuery( document ).on( 'keyup', 'input[name="title"]', window.digirisk.society.keyUpSaveIdentity );
=======
	jQuery( document ).on( 'keyup', 'input[name="title"]', window.digirisk.society.display_save_button );
	jQuery( document ).on( 'change', 'select[name="parent_id"]', window.digirisk.society.display_save_button );
>>>>>>> master
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

/**
 * Lorsque qu'on lache une touche dans le champ de texte "title", on fait apparaitre le bouton "Enregistrer".
 * Si la touche laché est "entrée" on appuie sur le bouton "Enregistrer".
 *
 * @param  {KeyboardEvent} event L'état du clavier lors du "keyup"
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.5.0
 */
window.digirisk.society.keyUpSaveIdentity = function( event ) {
	jQuery( '.digirisk-wrap .main-container .main-header .unit-header .action-input.save' ).addClass( 'active' );

<<<<<<< HEAD
	if ( 13 === event.keyCode ) {
		jQuery( '.digirisk-wrap .main-container .main-header .unit-header .action-input.save' ).click();
	}
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
=======
window.digirisk.society.update_society_success = function( element, response ) {
	jQuery( '.wp-digi-societytree-main-container' ).replaceWith( response.data.template );
	// jQuery( element ).closest( '.wp-digi-global-sheet-header' ).find( '.wp-digi-global-action-container' ).addClass( 'hidden' );
	//
	// if ( 'digi-group' === response.data.society.type ) {
	// 	jQuery( '.wp-digi-societytree-left-container span.title' ).text( ' - ' + response.data.society.title );
	// 	jQuery( '.wp-digi-societytree-left-container li[data-groupment-id="' + response.data.society.id + '"] span[data-groupment-id="' + response.data.society.id + '"]' ).text( response.data.society.unique_identifier + ' - ' + response.data.society.title );
	// }
	// else {
	// 	jQuery( '.wp-digi-societytree-left-container span[data-workunit-id="' + response.data.society.id + '"]' ).text( response.data.society.unique_identifier + ' - ' + response.data.society.title );
	// }
}
>>>>>>> master

	jQuery( '.digirisk-wrap .main-content h1' ).text( 'Configuration de ' + response.data.society.unique_identifier + ' - ' + response.data.society.title );
	jQuery( '.digirisk-wrap .main-container .main-header input[name="title"]' ).val( response.data.society.title );
};
