/**
 * Initialise l'objet "updateManager" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.8.0
 * @version 6.2.8.0
 */

window.eoxiaJS.digirisk.updateManager = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 6.2.8.0
 * @version 6.2.8.0
 */
window.eoxiaJS.digirisk.updateManager.init = function() {
	window.eoxiaJS.digirisk.updateManager.requestUpdate();
};

window.eoxiaJS.digirisk.updateManager.requestUpdate = function( args ) {
	var versionToUpdate = jQuery( 'input[name="version_available[]"]:first' ).val();
	var action = jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).val();
	var description = jQuery( 'input[name="version[' + versionToUpdate + '][description][]"]:first' ).val();

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
				jQuery( '.log' ).append( '<li>Terminé</li>' );

				jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).remove();
				jQuery( 'input[name="version[' + versionToUpdate + '][description][]"]:first' ).remove();

				if ( 0 == jQuery( 'input[name="version[' + versionToUpdate + '][action][]"]:first' ).length ) {
					jQuery( 'input[name="version_available[]"]:first' ).remove();
				}
				if ( 0 == jQuery( 'input[name="version_available[]"]:first' ).length ) {
					jQuery( '.log' ).append( '<li>Redirection vers l\'application en cours...</li>' );
					jQuery.post( ajaxurl, { 'action': 'digi_redirect_to_dashboard' }, function( response ) {
						window.location = response;
					});
				} else {
					window.eoxiaJS.digirisk.updateManager.requestUpdate( response.data.args );
				}
			} else {
				window.eoxiaJS.digirisk.updateManager.requestUpdate( response.data.args );
			}
		} );
	}
};
