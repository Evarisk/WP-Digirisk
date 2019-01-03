/**
 * Initialise l'objet "navigation" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 7.0.0
 */

window.eoxiaJS.digirisk.navigation = {};

/**
 * La méthode appelée automatiquement par la bibliothèque EoxiaJS.
 *
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.2.4
 */
window.eoxiaJS.digirisk.navigation.init = function() {
	window.eoxiaJS.digirisk.navigation.event();
};

/**
 * La méthode contenant tous les évènements pour la navigation.
 *
 * @since 6.0.0
 * @version 6.3.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .unit-container .toggle-unit', window.eoxiaJS.digirisk.navigation.switchToggle );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .add-container .wpeo-button, .digirisk-wrap .navigation-container .mobile-add-container .dropdown-item', window.eoxiaJS.digirisk.navigation.displayAddField );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .toolbar div', window.eoxiaJS.digirisk.navigation.toggleAll );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container .unit.new .placeholder-icon', window.eoxiaJS.digirisk.navigation.focusField );
	jQuery( document ).on( 'keyup', '.digirisk-wrap .navigation-container input[name="title"]', window.eoxiaJS.digirisk.navigation.triggerCreateSociety );

	jQuery( document ).on( 'click', '.digirisk-wrap .mobile-navigation', window.eoxiaJS.digirisk.navigation.openNavigationContainer );
	jQuery( document ).on( 'click', '.digirisk-wrap .navigation-container.active .close-popup', window.eoxiaJS.digirisk.navigation.closeNavigationContainer );
};

/**
 * Gestion du toggle dans la navigation.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs lors du clic.
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.switchToggle = function( event ) {
	event.preventDefault();

	jQuery( this ).closest( '.unit' ).toggleClass( 'toggled' );
	jQuery( this ).closest( '.unit' ).find( '.unit.new:first.active ' ).removeClass( 'active' );
};

/**
 * Affiches le champ pour créer un établissement.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs lors du clic.
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.displayAddField = function( event ) {
	var closest = jQuery( this ).closest( '.society-header' ).length ? jQuery( this ).closest( '.navigation-container' ) : jQuery( this ).closest( '.unit' );
	event.preventDefault();
	event.stopPropagation();

	// Mobile.
	jQuery( '.mobile-add-container .content.active' ).removeClass( 'active' );

	closest.addClass( 'toggled' );

	if ( 'Group_Class' === jQuery( this ).data( 'type' ) ) {
		closest.find( '.unit.new:first .placeholder-icon' ).removeClass( 'dashicons-admin-home' );
		closest.find( '.unit.new:first .placeholder-icon' ).addClass( 'dashicons-admin-multisite' );
	} else {
		closest.find( '.unit.new:first .placeholder-icon' ).removeClass( 'dashicons-admin-multisite' );
		closest.find( '.unit.new:first .placeholder-icon' ).addClass( 'dashicons-admin-home' );
	}

	if ( closest.find( '.unit.new:first' ).hasClass( 'active' ) && closest.find( '.unit.new:first input[name="class"]' ).val() != jQuery( this ).data( 'type' ) ) {
	} else {
		closest.find( '.unit.new:first' ).toggleClass( 'active' );
	}

	if ( closest.find( '.unit.new:first' ).hasClass( 'active' ) ) {
		closest.find( '.unit.new:first.active input[type="text"]' ).focus();
	}

	closest.find( '.unit.new:first input[name="class"]' ).val( jQuery( this ).data( 'type' ) );
};

/**
 * Focus le champ 'title' pour créer un établissement
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs lors du clic.
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.focusField = function( event ) {
	event.preventDefault();

	jQuery( this ).closest( '.unit.new' ).find( 'input[type="text"]' ).focus();
};

/**
 * Déplies ou replies tous les éléments enfants
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {MouseEvent} event Les attributs lors du clic
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.toggleAll = function( event ) {
	event.preventDefault();

	if ( jQuery( this ).hasClass( 'toggle-plus' ) ) {
		jQuery( '.digirisk-wrap .navigation-container .workunit-list .unit' ).addClass( 'toggled' );
	}

	if ( jQuery( this ).hasClass( 'toggle-minus' ) ) {
		jQuery( '.digirisk-wrap .navigation-container .workunit-list .unit.toggled' ).removeClass( 'toggled' );
	}
};

/**
 * Ajout la classe 'active' à l'élément.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {HTMLDivElement} element L'attribut de l'élement.
 * @return {boolean}
 */
window.eoxiaJS.digirisk.navigation.setUnitActive = function( element ) {
	jQuery( '.digirisk-wrap .navigation-container .unit.active' ).removeClass( 'active' );
	jQuery( element ).closest( '.unit' ).addClass( 'active' );
	return true;
};

/**
 * Clic automatiquement sur le 'action-input'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {KeyboardEvent} event Les attributs du clavier.
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.triggerCreateSociety = function( event ) {
	if ( event.ctrlKey && 13 === event.keyCode ) {
		jQuery( this ).closest( '.unit.new' ).find( '.action-input' ).click();
	}
};

/**
 * Ajout de la classe 'active' au bloc 'navigation-container'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {TouchEvent} event [description]
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.openNavigationContainer = function( event ) {
	jQuery( '.digirisk-wrap .navigation-container' ).addClass( 'active' );
};

/**
 * Enlève la classe 'active' au bloc 'navigation-container'.
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {TouchEvent} event [description]
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.closeNavigationContainer = function( event ) {
	event.stopPropagation();

	jQuery( '.digirisk-wrap .navigation-container' ).removeClass( 'active' );
};

/**
 * Callback en cas de réussite de la requête Ajax "create_society"
 *
 * @since 6.3.0
 * @version 6.3.0
 *
 * @param  {HTMLDivElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response {
 *     Les données renvoyées par la requête Ajax.
 *     @type {Object} data {
 *           @type {string} navigation_view La vue de la navigation.
 *           @type {string} content_view    La vue du contenu principale.
 *     }
 * }
 * @return {void}
 */
window.eoxiaJS.digirisk.navigation.createdSocietySuccess = function( triggeredElement, response ) {
	jQuery( '.workunit-list .unit.active' ).removeClass( 'active' );

	jQuery( triggeredElement ).closest( '.unit:not(.new)' ).find( '.spacer:first' ).removeClass( 'spacer' ).addClass( 'toggle-unit' );

	if ( jQuery( triggeredElement ).closest( '.sub-list' ).length ) {
		jQuery( triggeredElement ).closest( '.sub-list' ).replaceWith( response.data.navigation_view );
	} else {
		jQuery( triggeredElement ).closest( '.workunit-list' ).replaceWith( response.data.navigation_view );
	}

	jQuery( '.digirisk-wrap .main-container' ).replaceWith( response.data.content_view );
	window.eoxiaJS.digirisk.risk.refresh();
};

/**
 * Callback en cas de réussite de la requête Ajax "load_society"
 * Remplaces le template principale de l'application avec le template reçu dans la réponse de la requête Ajax.
 *
 * @param  {HTMLSpanElement} triggeredElement   L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}        response             Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.navigation.loadedSocietySuccess = function( element, response ) {
	jQuery( '.digirisk-wrap .main-container' ).replaceWith( response.data.view );
	jQuery( '.digirisk-wrap .navigation-container' ).removeClass( 'active' );
	window.eoxiaJS.digirisk.risk.refresh();
};
