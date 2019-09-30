/**
 * Initialise l'objet "risk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.risk = {};

window.eoxiaJS.digirisk.risk.init = function() {
	window.eoxiaJS.digirisk.risk.refresh();
	window.eoxiaJS.digirisk.risk.event();
};

window.eoxiaJS.digirisk.risk.refresh = function() {
	autosize(document.querySelectorAll('textarea'));
};

window.eoxiaJS.digirisk.risk.event = function() {
	jQuery( document ).on( 'dropdown-before-close', '.risk-row .risk-options .dropdown-move-to .dropdown-item', window.eoxiaJS.digirisk.risk.beforeClose );
	jQuery( document ).on( 'keyup', '.dropdown-move-to input.form-field', window.eoxiaJS.digirisk.risk.searchMoveTo );
};

window.eoxiaJS.digirisk.risk.beforeClose = function( event, toggle, element, obj ) {
	obj.close = false;

	element.closest( '.wpeo-form' ).find( 'input[type="hidden"]' ).val( element.data( 'id' ) );
	element.closest( '.wpeo-form' ).find( 'input[type="text"]' ).val( element.text().trim() );

	element.closest( '.wpeo-dropdown' ).find( '.dropdown-content' ).addClass( 'hidden' );
};

window.eoxiaJS.digirisk.risk.searchMoveTo = function( event ) {
	jQuery( this ).closest( '.wpeo-dropdown' ).find( '.dropdown-content' ).removeClass( 'hidden' );

	var entries = jQuery( this ).closest( '.wpeo-dropdown' ).find( '.dropdown-content .dropdown-item' );
	entries.show();

	var val = jQuery( this ).val().toLowerCase();

	for ( var i = 0; i < entries.length; i++ ) {
		if ( jQuery( entries[i] ).text().toLowerCase().indexOf( val ) == -1 ) {
			jQuery( entries[i] ).hide();
		}
	}
};

window.eoxiaJS.digirisk.risk.deletedRiskSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

window.eoxiaJS.digirisk.risk.loadedRiskSuccess = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
  window.eoxiaJS.digirisk.risk.refresh();
};

window.eoxiaJS.digirisk.risk.beforeSaveRisk = function( triggeredElement ) {
	// Remet à 0 les styles.
	window.eoxiaJS.tooltip.remove( triggeredElement.closest( '.risk-row' ).find( '.category-danger.wpeo-tooltip-event' ) );
	window.eoxiaJS.tooltip.remove( triggeredElement.closest( '.risk-row' ).find( '.cotation-container.wpeo-tooltip-event' ) );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.risk-row' ).find( 'input[name="risk_category_id"]' ).val() && ! jQuery( '#digi-danger-preset' ).length ) {
		window.eoxiaJS.tooltip.display( triggeredElement.closest( '.risk-row' ).find( '.category-danger.wpeo-tooltip-event' ) );
		return false;
	}

	// Vérification de la cotation.
	if ( '{}' === triggeredElement.closest( '.risk-row' ).find( 'textarea[name="evaluation_variables"]' ).val() && ! jQuery( '#digi-danger-preset' ).length ) {
		window.eoxiaJS.tooltip.display( triggeredElement.closest( '.risk-row' ).find( '.cotation-container.wpeo-tooltip-event' ) );
		return false;
	}

	return true;
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_risk".
 * Remplaces le contenu du tableau "risk" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.risk.savedRiskSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.risk' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "check_predefined_danger".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.2.9
 */
window.eoxiaJS.digirisk.risk.checkedPredefinedDanger = function( triggeredElement, response ) {
	triggeredElement.closest( 'table' ).removeClass( 'loading' );
	triggeredElement.closest( '.risk-row' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "to_society_id".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 7.1.0
 */
window.eoxiaJS.digirisk.risk.movedRiskSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.risk-row' ).fadeOut();
};
