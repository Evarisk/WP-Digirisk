/**
 * Initialise l'objet "correctiveTask" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.4.4
 */

window.eoxiaJS.digirisk.correctiveTask = {};

window.eoxiaJS.digirisk.correctiveTask.init = function() {
	window.eoxiaJS.digirisk.correctiveTask.event();
};

/**
 * Les évènements
 *
 * @since 6.0.0
 * @version 6.4.4
 *
 * @return {void}
 *
 * @todo: En attente de la livraison 1.6.0 de Task Manager pour décommenter le code.
 */
window.eoxiaJS.digirisk.correctiveTask.event = function() {
	// jQuery( document ).on( 'change', '.popup.corrective-task .point[data-id="0"] input[name="content"]', window.eoxiaJS.digirisk.correctiveTask.listenAddSafeExit );
	// jQuery( document ).on( 'addedPointSuccess', '.popup.corrective-task .point[data-id="0"] .action-input', window.eoxiaJS.digirisk.correctiveTask.addedPointSuccess );
};

/**
 * Si le contenu du point à ajouter change, on ajoutes le "safeExit".
 *
 * @since 6.4.4
 * @version 6.4.4
 *
 * @param  {CustomEvent} event Evenement spécial envoyé par TaskManager lors de la modification d'un point.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.correctiveTask.listenAddSafeExit = function( event ) {
	if ( '' !== jQuery( this ).val() ) {
		jQuery( '.popup.corrective-task' ).addClass( 'no-close' );
		jQuery( '.popup.corrective-task .message' ).removeClass( 'hidden' );
		window.addEventListener( 'beforeunload', window.eoxiaJS.digirisk.correctiveTask.safeExit );
	} else {
		jQuery( '.popup.corrective-task' ).removeClass( 'no-close' );
		jQuery( '.popup.corrective-task .message' ).addClass( 'hidden' );
		window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.correctiveTask.safeExit );
	}
};

/**
 * Evenement envoyé par Task Manager lorsqu'un point est ajouté correctement.
 *
 * @since 6.4.4
 * @version 6.4.4
 *
 * @param  {CustomEvent} event Envoyé par Task Manager.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.correctiveTask.addedPointSuccess = function( event ) {
	jQuery( '.popup.corrective-task' ).removeClass( 'no-close' );
	jQuery( '.popup.corrective-task .message' ).addClass( 'hidden' );
	window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.correctiveTask.safeExit );
};

/**
 * Vérification avant la fermeture de la page si toutes les données sont enregistrées.
 *
 * @since 6.4.4
 * @version 6.4.4
 *
 * @param  {WindowEventHandlers} event L'évènement de la fenêtre.
 * @return {string}
 */
window.eoxiaJS.digirisk.correctiveTask.safeExit = function( event ) {
	var confirmationMessage = 'Vos données sont en attentes d\'enregistrement';

	event.returnValue = confirmationMessage;
	return confirmationMessage;
};

/**
 * Le callback en cas de réussite à la requête Ajax "open_task".
 * Remplaces le contenu de la popup "corrective-task" par la vue renvoyée par la réponse Ajax.
 *
 * @since 6.0.0
 * @version 6.4.4
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.correctiveTask.openedTaskPopup = function( triggeredElement, response ) {
	jQuery( '.popup.corrective-task .content' ).html( response.data.view );
	jQuery( '.popup.corrective-task .container.loading' ).removeClass( 'loading' );
};
