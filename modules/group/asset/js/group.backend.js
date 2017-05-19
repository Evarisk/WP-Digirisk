/**
 * Initialise l'objet "group" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */

window.eoxiaJS.digirisk.group = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.group.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "create_group".
 * Remplaces le contenu de toute l'application par la vue renvoyé par la requête Ajax.
 * Clic ensuite sur le nouveau groupement pour lancer la requête "load_society".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.group.createdGroupSuccess = function( element, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
	jQuery( '.workunit-navigation span.action-attribute[data-groupment-id="' + response.data.groupment_id + '"]' ).click();
};
