/**
 * Initialise l'objet "risk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.risk = {};

window.eoxiaJS.digirisk.risk.init = function() {};

window.eoxiaJS.digirisk.risk.deletedRiskSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

window.eoxiaJS.digirisk.risk.loadedRiskSuccess = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
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
