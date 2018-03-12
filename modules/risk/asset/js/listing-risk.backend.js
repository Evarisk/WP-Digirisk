/**
 * Initialise l'objet "listingRisk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.5.0
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.listingRisk = {};

window.eoxiaJS.digirisk.listingRisk.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_listing_risk".
 * Cliques sur le bouton "Listing des risques" pour recharger la vue.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.5.0
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.listingRisk.generatedListingRiskSuccess = function( triggeredElement, response ) {
	jQuery( '.tab-element[data-action="digi-listing-risk"]' ).click();
};
