/**
 * Initialise l'objet "navigation" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */

window.digirisk.navigation = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.navigation.init = function() {
	window.digirisk.navigation.event();
};

/**
 * La méthode contenant tous les évènements pour la navigation.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.navigation.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .content li span.action-attribute', window.digirisk.navigation.setItemActiveInToggle );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .workunit-list li span.action-attribute', window.digirisk.navigation.setItemActiveInWorkunitList );
};

/**
 * Ajoutes la classe "active" sur l'item cliqué dans le toggle de la navigation.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.navigation.setItemActiveInToggle = function( event ) {
	jQuery( '.digirisk-wrap .navigation-container .content div.active' ).removeClass( 'active' );
	jQuery( this ).closest( 'div' ).addClass( 'active' );
};

/**
 * Ajoutes la classe "active" sur l'item cliqué dans la liste des unités de travail de la navigation.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.navigation.setItemActiveInInWorkunitList = function( event ) {
	jQuery( '.digirisk-wrap .navigation-container .workunit-list li.active' ).removeClass( 'active' );
	jQuery( this ).closest( 'li' ).addClass( 'active' );
};
