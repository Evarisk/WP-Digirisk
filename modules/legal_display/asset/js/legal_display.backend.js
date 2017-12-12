/**
 * Initialise l'objet "legalDisplay" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.4.4
 */

window.eoxiaJS.digirisk.legalDisplay = {};

window.eoxiaJS.digirisk.legalDisplay.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "save_legal_display".
 * Actualises la vue en cliquant sur l'onglet "Affichage légal".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.4.4
 */
window.eoxiaJS.digirisk.legalDisplay.generatedSuccess = function( triggeredElement, response ) {
	jQuery( '.table' ).replaceWith( response.data.view );
	window.scrollTo( 0, 0 );
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_diffusion_information".
 * Actualises la vue en cliquant sur l'onglet "Informations".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.2.4
 */
window.eoxiaJS.digirisk.legalDisplay.generatedDiffusionInformationSuccess = function( triggeredElement, response ) {
	jQuery( '.tab-element[data-action="digi-legal_display"]' ).click();
	window.scrollTo( 0, 0 );
};
