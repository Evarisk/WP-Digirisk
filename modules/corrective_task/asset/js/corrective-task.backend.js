/**
 * Initialise l'objet "correctiveTask" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */

window.eoxiaJS.digirisk.correctiveTask = {};

window.eoxiaJS.digirisk.correctiveTask.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "open_task".
 * Remplaces le contenu de la popup "corrective-task" par la vue renvoyée par la réponse Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.correctiveTask.openedTaskPopup = function( triggeredElement, response ) {
	jQuery( '.popup.corrective-task .content' ).html( response.data.view );
	jQuery( '.popup.corrective-task .container.loading' ).removeClass( 'loading' );
};
