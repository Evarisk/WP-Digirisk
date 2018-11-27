/**
 * Initialise l'objet "listingRisk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.5.0
 */

window.eoxiaJS.digirisk.listingRisk = {};

/**
 * Méthode obligatoire pour initialiser l'objet listingRisk avec EO-Framework.
 *
 * @since 6.5.0
 */
window.eoxiaJS.digirisk.listingRisk.init = function() {
	window.eoxiaJS.digirisk.listingRisk.event();
};

/**
 * Méthode pour initialiser tous les évènements.
 *
 * @since   6.5.0
 */
window.eoxiaJS.digirisk.listingRisk.event = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_listing_risk".
 * Cliques sur le bouton "Listing des risques" pour recharger la vue.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.5.0
 */
window.eoxiaJS.digirisk.listingRisk.generatedListingRiskSuccess = function( triggeredElement, response ) {
	if ( 'photos' === response.data.type ) {
		jQuery( '.tab-element[data-target="digi-listing-risk-photo"]' ).click();
	} else {
		jQuery( '.tab-element[data-target="digi-listing-risk-action-corrective"]' ).click();
	}
};
