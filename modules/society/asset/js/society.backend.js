/**
 * Initialise l'objet "society" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.0.0
 */
window.eoxiaJS.digirisk.society = {};

window.eoxiaJS.digirisk.society.init = function() {
	window.eoxiaJS.digirisk.society.event();
};

window.eoxiaJS.digirisk.society.event = function() {
	jQuery( document ).on( 'keyup', '.main-header input[name="title"]', window.eoxiaJS.digirisk.society.keyUpSaveIdentity );
	jQuery( document ).on( 'click', '.main-header .edit', window.eoxiaJS.digirisk.society.focusInputTitle );
	jQuery( document ).on( 'keyup', '.digirisk-wrap .form.society-informations .form-element input, .digirisk-wrap .form.society-informations .form-element textarea', window.eoxiaJS.digirisk.society.enableSaveButton );
	jQuery( document ).on( 'click', '.main-container .bloc-information-society', window.eoxiaJS.digirisk.society.requestGetViewEdit )
};

/**
 * Lorsque qu'on lache une touche dans le champ de texte "title", on fait apparaitre le bouton "Enregistrer".
 * Si la touche laché est "entrée" on appuie sur le bouton "Enregistrer".
 *
 * @param  {KeyboardEvent} event L'état du clavier lors du "keyup"
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.society.keyUpSaveIdentity = function( event ) {
	jQuery( '.digirisk-wrap .main-container .main-header .unit-header .edit' ).hide();
	jQuery( '.digirisk-wrap .main-container .main-header .unit-header .action-input.save' ).addClass( 'active' );

	if ( 13 === event.keyCode ) {
		jQuery( '.digirisk-wrap .main-container .main-header .unit-header .action-input.save' ).click();
	}
};

/**
 * Focus le titre de la société lors du clic sur le bouton "edit".
 *
 * @since 6.4.4
 *
 * @param  {ClickEvent} event L'état de la souris.
 */
window.eoxiaJS.digirisk.society.focusInputTitle = function( event ) {
	jQuery( this ).closest( '.main-header' ).find( 'input[name="title"]' ).focus().select();

	jQuery( this ).hide();
	jQuery( '.digirisk-wrap .main-container .main-header .unit-header .action-input.save' ).addClass( 'active' );
};

/**
 * Lorsque qu'on lache une touche dans les champs de texte de 'form society-informations', on rend le bouton 'enabled'
 *
 * @param  {KeyboardEvent} event L'état du clavier lors du "keyup"
 * @return {void}
 *
 * @since 6.3.0
 */
window.eoxiaJS.digirisk.society.enableSaveButton = function( event ) {
	jQuery( '.digirisk-wrap .form.society-informations button.green' ).removeClass( 'disable' );
};

/**
 * Callback en cas de réussite de la requête Ajax "save_society"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response            Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.society.savedSocietySuccess = function( element, response ) {
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
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.society.deletedSocietySuccess = function( triggeredElement, response ) {
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
 * @since   6.0.0
 */
window.eoxiaJS.digirisk.society.savedSocietyConfigurationSuccess = function( triggeredElement, response ) {
	if ( 'digi-group' === response.data.society.type ) {
		jQuery( '.digirisk-wrap .workunit-navigation .title' ).text( response.data.society.data.unique_identifier + ' - ' + response.data.society.data.title );
	} else if ( 'digi-workunit' === response.data.society.type ) {
		jQuery( '.digirisk-wrap .workunit-list span[data-workunit-id="' + response.data.society.data.id + '"] span' ).text( response.data.society.data.title );
		jQuery( '.digirisk-wrap .workunit-list span[data-workunit-id="' + response.data.society.data.id + '"] span' ).attr( 'title', response.data.society.data.title );
	} else {
		jQuery( '.digirisk-wrap .navigation-container .society-header .title' ).text( response.data.society.data.title );
	}

	jQuery( '.digirisk-wrap .main-container .main-header input[name="title"]' ).val( response.data.society.data.title );

	jQuery( '.digirisk-wrap .main-content' ).replaceWith( response.data.view );

	if( response.data.view_owner != "" ){
		triggeredElement.closest( '.wpeo-form' ).find( 'input[name="society[owner_id]"}' ).closest( '.form-element' ).html( '' );
	}
};

window.eoxiaJS.digirisk.society.deleteOwnerIdSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.form-element' ).replaceWith( response.data.view );
}

window.eoxiaJS.digirisk.society.findEditView = function( element ){
	var element = element.closest( '.tab-content' ).find( '.bloc-information-society[data-edit="true"]' );
	return element;
}

window.eoxiaJS.digirisk.society.requestGetViewEdit = function( event ){
	if( jQuery( this ).attr( 'data-edit' ) == "true" ){
		return;
	}

	var element_close = "";
	var element = window.eoxiaJS.digirisk.society.findEditView( jQuery( this ) );
	if( element.length > 0 ){
		element_close = element.attr( 'data-element' );
	}
	var data = {};
	data.action        = jQuery( this ).attr( 'data-action' );
	data._wpnonce      = jQuery( this ).attr( 'data-nonce' );
	data.element       = jQuery( this ).attr( 'data-element' );
	data.element_close = element_close;

	window.eoxiaJS.loader.display( jQuery( this ) );
	window.eoxiaJS.request.send( jQuery( this ), data );
}

window.eoxiaJS.digirisk.society.displayEditViewSuccess = function( triggeredElement, response ) {
	if( response.data.view_close != "" ){
		console.log( '---' );
		var element = window.eoxiaJS.digirisk.society.findEditView( triggeredElement );
		console.log( 'oui' );
		console.log( element );
		element.replaceWith( response.data.view_close );
	}
	triggeredElement.attr( 'data-edit', 'true' );
	triggeredElement.find( '.bloc-content' ).html( response.data.view );
	triggeredElement.css( 'border' , 'solid blue 1px' );
}
