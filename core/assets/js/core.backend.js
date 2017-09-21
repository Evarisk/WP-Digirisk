/**
 * Initialise l'objet "core" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.3.0
 * @version 6.3.0
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
 * @version 6.3.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.core.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap .notification.patch-note .active', window.eoxiaJS.digirisk.core.openPopup );
	jQuery( document ).on( 'click', '.digirisk-wrap .notification.patch-note .close', window.eoxiaJS.digirisk.core.closeNotification );
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
	jQuery( '.digirisk-wrap .popup.patch-note' ).addClass( 'active' );
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
	jQuery( this ).closest( '.notification' ).removeClass( 'active' );
};
