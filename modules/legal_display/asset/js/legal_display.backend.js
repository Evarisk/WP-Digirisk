window.digirisk.legal_display = {};

window.digirisk.legal_display.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "save_legal_display".
 * Actualises la vue en cliquant sur l'onglet "Affichage légal".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.legal_display.generatedSuccess = function() {
	jQuery( '.tab-element[data-action="digi-legal_display"]' ).click();
};
