/**
 * Initialise l'objet "accident" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.3.0
 * @version 6.4.0
 */
window.eoxiaJS.digirisk.accident = {};
window.eoxiaJS.digirisk.accident.canvas = [];

window.eoxiaJS.digirisk.accident.init = function() {
	window.eoxiaJS.digirisk.accident.event();
	window.eoxiaJS.digirisk.accident.canvas = document.querySelectorAll("canvas");

	for( var i = 0; i < window.eoxiaJS.digirisk.accident.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.accident.canvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.accident.canvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}
};

window.eoxiaJS.digirisk.accident.event = function() {
	jQuery( document ).on( 'click', '.popup-edit', window.eoxiaJS.digirisk.accident.openPopupEditMode );
	jQuery( document ).on( 'change', '.accident-row select', window.eoxiaJS.digirisk.accident.changeSelectAccidentInvestigation );

	// window.addEventListener( "resize", window.eoxiaJS.digirisk.accident.resizeCanvas );
};

/**
 * Ouvres la popup en mode 'edition'.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  {MouseEvent} event L'état de la souris
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.openPopupEditMode = function( event ) {
	var element = jQuery( this );
	var buttonEdit = element.closest( '.accident-row' ).find( '.edit.action-attribute' );
	var id = buttonEdit.attr( 'data-id' );

	var data = {
		id: id,
		action: buttonEdit.attr( 'data-action' ),
		_wpnonce: buttonEdit.attr( 'data-nonce' ),
	};

	element.closest( '.table' ).addClass( 'loading' );

	jQuery.post( window.ajaxurl, data, function( response ) {
		element.closest( '.table' ).removeClass( 'loading' );
		element.closest( 'tr' ).replaceWith( response.data.view );
		window.eoxiaJS.digirisk.search.renderChanged();

		jQuery( '.accident-row.edit[data-id=' + id + '] .open-popup' ).click();
	} );
};

/**
 * Affiches le champs 'upload' quand la select box est sur 'true'.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  {Event} event L'évènement lors du changement de la select box.
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.changeSelectAccidentInvestigation = function( event ) {
	jQuery( this ).closest( 'td' ).find( 'span:first' ).addClass( 'hidden' );
	if ( 1 == jQuery( this ).val() ) {
		jQuery( this ).closest( 'td' ).find( 'span:first' ).removeClass( 'hidden' );
	}
};

/**
 * Quand on "resize" la fenêtre, adapte le canvas.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  {Event} event L'état de l'évènement à ce moment T.
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.resizeCanvas = function( event ) {
	var ratio =  Math.max( window.devicePixelRatio || 1, 1 );

	for( var i = 0; i < window.eoxiaJS.digirisk.accident.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.accident.canvas[i].width = window.eoxiaJS.digirisk.accident.canvas[i].offsetWidth * ratio;
		window.eoxiaJS.digirisk.accident.canvas[i].height = window.eoxiaJS.digirisk.accident.canvas[i].offsetHeight * ratio;
		window.eoxiaJS.digirisk.accident.canvas[i].getContext( "2d" ).scale( ratio, ratio );
		window.eoxiaJS.digirisk.accident.canvas[i].signaturePad.clear(); // otherwise isEmpty() might return incorrect value
	}


};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_accident".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.editedAccidentSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.accident' ).replaceWith( response.data.view );
	window.eoxiaJS.digirisk.search.renderChanged();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_accident".
 * Remplaces le contenu de la ligne du tableau "accident" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.loadedAccidentSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.view );
	window.eoxiaJS.digirisk.search.renderChanged();
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_accident".
 * Supprimes la ligne du tableau.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.deletedAccidentSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_accident".
 * Remplace la vue du tableau
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedAccidentBenin = function( element, response ) {
	jQuery( '.document-accident-benins' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_registre_accidents_travail_benins".
 * Cliques automatiquement sur l'onglet 'Registre accidents'
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedRegistreAccidentBenin = function( element, response ) {
	jQuery( '.tab-element[data-action="digi-registre-accident"]' ).click();
};
