window.eoxiaJS.digirisk.sheet_groupment = {};

window.eoxiaJS.digirisk.sheet_groupment.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_fiche_de_groupement".
 * Cliques sur le bouton "Fiche de groupement" pour recharger la vue.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.sheet_groupment.generatedSheetGroupment = function( triggeredElement, response ) {
	jQuery( '.tab-element[data-action="digi-fiche-de-groupement"]' ).click();
};
