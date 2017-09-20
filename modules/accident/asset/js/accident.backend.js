/**
 * Initialise l'objet "accident" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident = {};

window.eoxiaJS.digirisk.accident.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_accident".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.editedAccidentSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.accident' ).replaceWith( response.data.view );
	window.eoxiaJS.digirisk.search.renderChanged();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_accident".
 * Remplaces le contenu de la ligne du tableau "accident" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.loadedAccidentSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.view );
	window.eoxiaJS.digirisk.search.renderChanged();
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_accident".
 * Supprimes la ligne du tableau.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.deletedAccidentSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_accident".
 * Remplace la vue du tableau
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedAccidentBenin = function( element, response ) {
	jQuery( '.document-accident-benins' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_registre_accidents_travail_benins".
 * Cliques automatiquement sur l'onglet 'Registre accidents'
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedRegistreAccidentBenin = function( element, response ) {
	jQuery( '.tab-element[data-action="digi-registre-accident"]' ).click();
};
