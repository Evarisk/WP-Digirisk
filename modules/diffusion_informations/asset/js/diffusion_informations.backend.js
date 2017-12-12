/**
 * Initialise l'objet "diffusionInformations" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.4.0
 * @version 6.4.4
 */

window.eoxiaJS.digirisk.diffusionInformations = {};

window.eoxiaJS.digirisk.diffusionInformations.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_diffusion_information".
 * Actualises la vue en cliquant sur l'onglet "Informations".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.4.0
 * @version 6.4.4
 */
window.eoxiaJS.digirisk.diffusionInformations.generatedDiffusionInformationSuccess = function( triggeredElement, response ) {
	jQuery( '.content-diffusions-information' ).replaceWith( response.data.view );
	window.scrollTo( 0, 0 );
};
