/**
 * Initialise l'objet "risk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.risk = {};

window.digirisk.risk.init = function() {};

window.digirisk.risk.deletedRiskSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

window.digirisk.risk.loadedRiskSuccess = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
	window.digirisk.date.init();
};

window.digirisk.risk.beforeSaveRisk = function( triggeredElement ) {

	// Remet à 0 les styles.
	triggeredElement.closest( '.risk-row' ).find( '.categorie-container.tooltip' ).removeClass( 'active' );
	triggeredElement.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).removeClass( 'active' );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.risk-row' ).find( 'input[name="risk[danger_id]"]' ).val() ) {
		triggeredElement.closest( '.risk-row' ).find( '.categorie-container.tooltip' ).addClass( 'active' );
		return false;
	}

	// Vérification de la cotation.
	if ( '-1' === triggeredElement.closest( '.risk-row' ).find( 'input[name="risk[evaluation][scale]"]' ).val() ) {
		triggeredElement.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).addClass( 'active' );
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
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.risk.savedRiskSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.risk' ).replaceWith( response.data.template );
	window.digirisk.date.init();
};
