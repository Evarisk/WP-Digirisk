/**
 * Initialise l'objet "sheet_workunit" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 * Gères le callback en cas de réussite de la génération d'une fiche de poste.
 *
 * @since 6.2.4
 */

window.eoxiaJS.digirisk.sheet_workunit = {};

window.eoxiaJS.digirisk.sheet_workunit.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_fiche_de_poste".
 * Clic sur le bouton "Fiche de poste" pour recharger la vue.
 *
 * @param  {HTMLAnchorElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.2.4
 */
window.eoxiaJS.digirisk.sheet_workunit.generatedFicheDePosteSuccess = function() {
	jQuery( '.tab-element[data-target="digi-fiche-de-poste"]' ).click();
};
