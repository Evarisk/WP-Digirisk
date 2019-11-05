/**
 * Initialise l'objet "core" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.3.0
 * @version 6.4.0
 */

window.eoxiaJS.digirisk.core = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.core.init = function() {
	window.eoxiaJS.digirisk.core.event();
};

/**
 * La méthode contenant tous les évènements pour la core.
 *
 * @since 6.3.0
 * @version 6.4.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.core.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap .wpeo-notification.patch-note.notification-active', window.eoxiaJS.digirisk.core.openPopup );
	jQuery( document ).on( 'click', '.digirisk-wrap .wpeo-notification.patch-note .notification-close', window.eoxiaJS.digirisk.core.closeNotification );
	jQuery( document ).on( 'click', '.popup-update-manager .back-update', window.eoxiaJS.digirisk.core.confirmBack );

	jQuery( document ).on( 'click', '.current-site .wpeo-dropdown .dropdown-toggle', window.eoxiaJS.digirisk.core.focusHeaderSearch );
	jQuery( document ).on( 'keyup', '.search-item input', window.eoxiaJS.digirisk.core.searchItems );

	jQuery( document ).on( 'click', '.nav-wrap .minimize-menu', window.eoxiaJS.digirisk.core.handleMinimizeMenu );


	var action = {
		action: 'have_patch_note',
	};

	jQuery.post( ajaxurl, action, function ( response ) {
		if ( response.data.status ) {
			jQuery( '.digirisk-wrap' ).append( response.data.view );
		}
	} );
};

/**
 * Ajoutes la classe 'active' dans l'élement 'popup.path-note'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs de l'évènement.
 * @return {void}
 */
window.eoxiaJS.digirisk.core.openPopup = function( event ) {
	event.stopPropagation();
	event.preventDefault();
	jQuery( '.digirisk-wrap .wpeo-modal.patch-note' ).addClass( 'modal-active' );
};

/**
 * Ajoutes la classe 'active' dans l'élement 'popup.path-note'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs de l'évènement.
 * @return {void}
 */
window.eoxiaJS.digirisk.core.closeNotification = function( event ) {
	event.stopPropagation();
	jQuery( this ).closest( '.wpeo-notification' ).removeClass( 'notification-active' );
};

/**
 * Demande à l'utilsateur la confirmation de revenir en arrière.
 *
 * @since 6.4.0
 * @version 6.4.0
 *
 * @param  {ClickEvent} event Les attributs de l'évènement.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.core.confirmBack = function( event ) {
	if ( ! confirm( "La mise à jour de vos données est requises. Êtes vous sur de vouloir annuler la mise à jour ?" ) ) {
		event.preventDefault();
		return false;
	}
};

window.eoxiaJS.digirisk.core.focusHeaderSearch = function (event) {
	jQuery( '.current-site .search-item input').focus()
}

window.eoxiaJS.digirisk.core.searchItems = function (event) {
	var sites = jQuery( '#top-header .dropdown-sites a' );

	sites.show();

	for ( var i = 0; i < sites.length; i++ ) {
		if ( jQuery( sites[i] ).text().toLowerCase().indexOf( jQuery( this ).val().toLowerCase() ) == -1 ) {
			jQuery( sites[i] ).hide();
		}
	}
};

window.eoxiaJS.digirisk.core.handleMinimizeMenu = function (event) {
	if ( jQuery( this ).find( 'i' ).hasClass( 'fa-arrow-left' ) ) {
		jQuery('.nav-wrap').addClass('wrap-reduce');
		jQuery( '.content-wrap' ).addClass( 'content-reduce' );
		jQuery(this).find( 'i' ).removeClass('fa-arrow-left').addClass('fa-arrow-right');
	} else {
		jQuery('.nav-wrap').removeClass('wrap-reduce');
		jQuery( '.content-wrap' ).removeClass( 'content-reduce' );
		jQuery(this).find( 'i' ).addClass('fa-arrow-left').removeClass('fa-arrow-right');
	}
};

