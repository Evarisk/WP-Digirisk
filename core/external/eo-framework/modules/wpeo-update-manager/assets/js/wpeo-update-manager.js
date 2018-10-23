/**
 * Initialise l'objet "updateManager" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
window.eoxiaJS.updateManager = {};
window.eoxiaJS.updateManager.completed = false;

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 1.0.0
 * @version 1.0.0
 */
window.eoxiaJS.updateManager.init = function() {
	if ( 0 < jQuery( '.wpeo-update-waiting-item' ).length ) {
		window.eoxiaJS.updateManager.declareUpdateForm();
		window.eoxiaJS.updateManager.requestUpdate();
		window.addEventListener( 'beforeunload', window.eoxiaJS.updateManager.safeExit );
	}
};

/**
 * Déclare les formulaires pour les mises à jour et leur fonctionnement.
 *
 * @type {void}
 */
window.eoxiaJS.updateManager.declareUpdateForm = function() {
	jQuery( '.wpeo-update-item, #wpeo-update-redirect-to-application' ).find( 'form' ).ajaxForm({
		dataType: 'json',
		success: function( responseText, statusText, xhr, $form ) {
			if ( ! responseText.data.updateComplete ) {
				$form.find( '.wpeo-update-item-stats' ).html( responseText.data.progression );
				$form.find( 'input[name="done_number"]' ).val( responseText.data.doneElementNumber );
				$form.find( '.wpeo-update-item-progression' ).css( 'width', responseText.data.progressionPerCent + '%' );

				if ( responseText.data.done ) {
					$form.closest( '.wpeo-update-item' ).removeClass( 'wpeo-update-waiting-item' );
					$form.closest( '.wpeo-update-item' ).removeClass( 'wpeo-update-in-progress-item' );
					$form.closest( '.wpeo-update-item' ).addClass( 'wpeo-update-done-item' );
					$form.find( '.wpeo-update-item-stats' ).html( responseText.data.doneDescription );
				}
			} else {
				if ( ! window.eoxiaJS.updateManager.completed ) {
					window.eoxiaJS.updateManager.completed = true;
					jQuery( '.wpeo-update-general-message' ).html( responseText.data.doneDescription );
					window.removeEventListener( 'beforeunload', window.eoxiaJS.updateManager.safeExit );
					setTimeout( function() {
						window.location = responseText.data.url;
					}, 1500 );
				}
			}

			window.eoxiaJS.updateManager.requestUpdate();
		}
	});
};

/**
 * Lancement du processus de mixe à jour: On prned le premier formulaire ayant la classe 'wpeo-update-waiting-item'
 *
 * @return {void}
 */
window.eoxiaJS.updateManager.requestUpdate = function() {
	if ( ! window.eoxiaJS.updateManager.completed ) {
		var currentUpdateItemID = '#' + jQuery( '.wpeo-update-waiting-item:first' ).attr( 'id' );

		jQuery( currentUpdateItemID ).addClass( 'wpeo-update-in-progress-item' );
		jQuery( currentUpdateItemID ).find( 'form' ).submit();

	}
};

/**
 * Vérification avant la fermeture de la page si la mise à jour est terminée.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @param  {WindowEventHandlers} event L'évènement de la fenêtre.
 * @return {string}
 */
window.eoxiaJS.updateManager.safeExit = function( event ) {
	var confirmationMessage = taskManager.updateManagerconfirmExit;
	if ( taskManager.updateManagerUrlPage === event.currentTarget.adminpage ) {
		event.returnValue = confirmationMessage;
		return confirmationMessage;
	}
};

/**
 * @todo: voir processus de MAJ des MU.
 *
 * @type {Object}
 */
window.eoxiaJS.updateManager.requestUpdateFunc = {
	endMethod: []
};
