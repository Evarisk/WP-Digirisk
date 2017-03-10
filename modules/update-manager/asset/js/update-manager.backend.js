/**
 * Initialise l'objet "updateManager" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.8.0
 * @version 6.2.8.0
 */

window.digirisk.updateManager = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 6.2.8.0
 * @version 6.2.8.0
 */
window.digirisk.updateManager.init = function() {
	// window.digirisk.updateManager.requestUpdate();
};

window.digirisk.updateManager.requestUpdate = function( args ) {
	var versionToUpdate = jQuery( 'input[name="version_available[]"]:first' ).val();
	var action = jQuery( 'input[name="version[' + versionToUpdate + '][action]' ).val();
	var description = jQuery( 'input[name="version[' + versionToUpdate + '][description]' ).val();
	var multipleRequest = jQuery( 'input[name="version[' + versionToUpdate + '][multiple_request]' ).val();

	var data = {
		action: action,
		versionToUpdate: versionToUpdate,
		multipleRequest: multipleRequest,
		args: args
	};

	jQuery( '.log' ).append( '<li>' + description + '</li>' );

	jQuery.post( ajaxurl, data, function( response ) {
		if ( response.data.done ) {
			jQuery( '.log' ).append( '<li>Done</li>' );
		} else {
			window.digirisk.updateManager.requestUpdate( response.data.args );
		}
	} );
};
