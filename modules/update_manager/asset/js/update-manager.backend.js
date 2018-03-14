/**
 * Initialise l'objet "updateManager" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.8
 * @version 6.5.0
 */

window.eoxiaJS.digirisk.updateManager = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 6.2.8
 * @version 6.4.0
 */
window.eoxiaJS.digirisk.updateManager.init = function() {
	window.eoxiaJS.digirisk.updateManager.requestUpdate();
	window.addEventListener( 'beforeunload', window.eoxiaJS.digirisk.updateManager.safeExit );
};

window.eoxiaJS.digirisk.updateManager.requestUpdateFunc = {
	endMethod: []
};
window.eoxiaJS.digirisk.updateManager.requestUpdate = function( args ) {
	var key             = jQuery( 'input.current-key' ).val();
	var versionToUpdate = jQuery( 'input[name="version_available[]"]:first' ).val();
	var action          = jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).val();
	var description     = jQuery( 'input[name="version[' + versionToUpdate + '][description][]"]:first' ).val();

	if ( versionToUpdate ) {
		if ( ( args && ! args.more ) || ! args ) {
			jQuery( '.log' ).append( '<li><h2>Mise à jour <strong>' + versionToUpdate + '</strong> en cours...</h2></li>' );
		}

		var data = {
			action: action,
			versionToUpdate: versionToUpdate,
			args: args
		};

		if ( action ) {

			if ( args && args.moreDescription ) {
				description += args.moreDescription;
			}

			jQuery( '.log' ).append( '<li>' + description + window.digi_loader + '</li>' );

			jQuery.post( ajaxurl, data, function( response ) {
				jQuery( '.log img' ).remove();

				if ( response.data.done ) {

					jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).remove();
					jQuery( 'input[name="version[' + versionToUpdate + '][description][]"]:first' ).remove();

					if ( 0 == jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).length ) {
						delete response.data.args;

						jQuery( 'input[name="version_available[]"]:first' ).remove();
					}
					if ( 0 == jQuery( 'input[name="version_available[]"]:first' ).length ) {
						delete response.data.args;

						jQuery.post( ajaxurl, { action: 'digi_redirect_to_dashboard', key: key }, function( response ) {
							jQuery( '.log' ).append( '<li>' + response.data.message + '</li>' );
							window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.updateManager.safeExit );
							window.location = response.data.url;
						});
					} else {
						window.eoxiaJS.digirisk.updateManager.requestUpdate( response.data.args );
					}
				} else {
					window.eoxiaJS.digirisk.updateManager.requestUpdate( response.data.args );
				}
			} )
			.fail( function( error, t, r ) {
				jQuery( '.log' ).append( '<li>Erreur: veuillez consulter les logs de la version: ' + versionToUpdate + '</li>' );
				jQuery.post( ajaxurl, { action: 'digi_redirect_to_dashboard', key: key, error_version: versionToUpdate, error_status: error.status, error_text: error.responseText }, function( response ) {
					jQuery( '.log' ).append( '<li>' + response.data.message + '</li>' );
					window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.updateManager.safeExit );
					window.location = response.data.url;
				});
			} );
		}
	}

	if ( jQuery( '.no-update' ).length ) {
		jQuery.post( ajaxurl, { action: 'digi_redirect_to_dashboard', key: key }, function( response ) {
			jQuery( '.log' ).append( '<li>' + response.data.message + '</li>' );
			window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.updateManager.safeExit );
			window.location = response.data.url;
		});
	}
};

/**
 * Vérification avant la fermeture de la page si la mise à jour est terminée.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  {WindowEventHandlers} event L'évènement de la fenêtre.
 * @return {string}
 */
window.eoxiaJS.digirisk.updateManager.safeExit = function( event ) {
	if ( 'admin_page_digirisk-update' === event.currentTarget.adminpage ) {
		var confirmationMessage = 'Vos données sont en cours de mise à jour, elles risque d\'être corrompues si vous quittez la page de mise à jour.';

		event.returnValue = confirmationMessage;
		return confirmationMessage;
	}
};
