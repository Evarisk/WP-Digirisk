/**
 * Initialise l'objet "societyAdvancedOptions" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.5.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.societyAdvancedOptions = {};

window.eoxiaJS.digirisk.societyAdvancedOptions.init = function() {};

/**
 * Callback en cas de réussite de la requête Ajax "advanced_options_move_to"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response            Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.2.5.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.societyAdvancedOptions.savedAdvancedOptionsMoveTo = function( element, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.view );
};
