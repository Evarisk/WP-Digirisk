/**
 * Initialise l'objet "evaluator" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.3.1
 */

window.eoxiaJS.digirisk.evaluator = {};

window.eoxiaJS.digirisk.evaluator.init = function() {
	window.eoxiaJS.digirisk.evaluator.event();
};

window.eoxiaJS.digirisk.evaluator.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap table.evaluators input[type="checkbox"]', window.eoxiaJS.digirisk.evaluator.setTime );
	jQuery( document ).on( 'click', '.form-edit-evaluator-assign .wp-digi-pagination a', window.eoxiaJS.digirisk.evaluator.pagination );
};

/**
* Après le changement d'onglet
*
* @since 6.3.1
* @version 6.3.1
*/
window.eoxiaJS.digirisk.evaluator.tabChanged = function() {
	// window.eoxiaJS.digirisk.search.renderChanged();
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_evaluator_assign".
 * Remplaces le contenu du tableau "affected-evaluator" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.4.0
 */
window.eoxiaJS.digirisk.evaluator.callback_edit_evaluator_assign_success = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row.evaluator-row.edit' ).before( response.data.view );
	triggeredElement.closest( '.table-row.evaluator-row.edit' ).find('.autocomplete-icon-after').click();
};
 
/**
 * Gestion de la suppression des évaluateurs.
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.2.5
 */
window.eoxiaJS.digirisk.evaluator.callback_detach_evaluator_success = function( element, response ) {
	element.closest( '.table-row' ).fadeOut();
};



