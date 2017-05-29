/**
 * Initialise l'objet "navigation" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.6.0
 */

window.eoxiaJS.digirisk.navigation = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.navigation.init = function() {
	window.eoxiaJS.digirisk.navigation.event();
};

/**
 * La méthode contenant tous les évènements pour la navigation.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.navigation.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .content li span.action-attribute', window.eoxiaJS.digirisk.navigation.setItemActiveInToggle );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .workunit-list li span.action-attribute', window.eoxiaJS.digirisk.navigation.setItemActiveInWorkunitList );

	jQuery( document ).on( 'keyup', '.digirisk-wrap .navigation-container .workunit-add input.title', window.eoxiaJS.digirisk.navigation.keyUpOnWorkunitTitle );
};

/**
 * Ajoutes la classe "active" sur l'item cliqué dans le toggle de la navigation.
 *
 * @return {void}
 *
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.navigation.setItemActiveInToggle = function( event ) {
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
window.eoxiaJS.digirisk.navigation.setItemActiveInWorkunitList = function( event ) {
	jQuery( '.digirisk-wrap .navigation-container .workunit-list li.active' ).removeClass( 'active' );
	jQuery( this ).closest( 'li' ).addClass( 'active' );
};

/**
 * Ajoutes la classe "blue" sur l'input action dans l'ajout d'une unité de travail.
 *
 * @param  {KeyboardEvent} event L'état du clavier.
 * @return {void}
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.navigation.keyUpOnWorkunitTitle = function( event ) {
	if ( jQuery( this ).val().length > 0 ) {
		jQuery( '.digirisk-wrap .navigation-container .workunit-add .action-input.disable' ).removeClass( 'disable' ).addClass( 'blue' );
	} else {
		jQuery( '.digirisk-wrap .navigation-container .workunit-add .action-input' ).removeClass( 'blue' ).addClass( 'disable' );
	}
};

/**
 * Méthodes appelé avant la création d'un nouvelle unité de travail.
 * Vérifies si le champ de texte est vide. Si c'est le cas, affiches l'infobulle pour dire qu'il est obligatoire.
 *
 * @param  {ClickEvent} element L'élément déclenchant l'action.
 * @return {void}
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.navigation.beforeSaveWorkunit = function( element ) {
	if ( '' === element.closest( '.workunit-add' ).find( 'input.title' ).val() ) {
		element.closest( '.workunit-add' ).addClass( 'active' );
		return false;
	}

	element.closest( '.workunit-add.active' ).removeClass( 'active' );
	return true;
};
