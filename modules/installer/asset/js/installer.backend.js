/**
 * Initialise l'objet "installer" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.7.0
 */

window.digirisk.installer = {};

window.digirisk.installer.init = function() {
	window.digirisk.installer.event();
};

window.digirisk.installer.event = function() {
	jQuery( document ).on( 'keyup', '.wpdigi-installer input[name="groupment[title]"]', window.digirisk.installer.key_up_groupment_title );
	jQuery( document ).on( 'keyup', '.wpdigi-installer input.input-domain-mail, .user-dashboard input.input-domain-mail', window.digirisk.installer.key_up_domain_mail );
	jQuery( document ).on( 'click', '.wpdigi-installer .wpdigi-components .next:not(.disabled)', window.digirisk.installer.nextScreenUser );
	jQuery( '.owl-carousel' ).owlCarousel( {
		'items': 1,
		'loop': true,
		'nav': true
	} );
};

window.digirisk.installer.key_up_groupment_title = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.main-content.society .action-input' ).click();
	}
};

window.digirisk.installer.key_up_domain_mail = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.wp-digi-action-save-domain-mail' ).click();
	}
};

/**
 * Vérifie que le nom de la société ne soit pas vide.
 *
 * @param  {HTMLDivElement} element Le bouton déclenchant la création de la société
 * @return {void}
 *
 * @since 6.2.5.0
 * @version 6.2.5.0
 */
window.digirisk.installer.beforeCreateSociety = function( element ) {
	if ( '' === element.closest( 'form' ).find( 'input[name="groupment[title]"]' ).val() ) {
		element.closest( 'form' ).find( 'span.tooltip' ).addClass( 'active' );
		return false;
	}

	element.closest( 'form' ).find( 'span.tooltip.active' ).removeClass( 'active' );

	return true;
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_society".
 * Ferme la div "society". Changes l'étape de "Votre société" en "Composants".
 * Ouvre la div "wpdigi-components".
 * Appel la méthode "requestInstallComponent".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.installer.savedSociety = function( element, response ) {
	element.closest( 'div.society' ).hide();
	jQuery( '.wpdigi-installer .step-create-society' ).removeClass( 'active' );
	jQuery( '.wpdigi-installer .step-create-components' ).addClass( 'active' );
	jQuery( '.wpdigi-installer .wpdigi-components' ).fadeIn();
	window.digirisk.installer.requestInstallComponent();
};

/**
 * Envoie une requête pour installer les composants nécessaires à l'utilisation de DigiRisk.
 * @return {void}
 */
window.digirisk.installer.requestInstallComponent = function() {
	var _wpnonce = jQuery( '.wpdigi-installer .wpdigi-components .nonce-installer-components' ).val();
	window.digirisk.request.get( ajaxurl + '?action=installer_components&_wpnonce=' + _wpnonce );
};

/**
 * Le callback en cas de réussite à la requête Ajax "installer_components".
 * Met le li active en statut "finit" et passes au suivant, tout en relancant la requête pour installer le composant suivant.
 * Si tous les li sont en statut "finit" passes à l'étape suivante qui est "Création des utilisateurs"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.7.0
 */
window.digirisk.installer.installedComponentSuccess = function( response ) {
	var progressValue = 0;

	// Si l'installation n'est pas terminée, on relance une requête avec les prochains composants à installer.
	if ( ! response.data.core_option.installed ) {
		if ( ! response.data.core_option.recommendation_installed && response.data.core_option.danger_installed ) {
			progressValue = 33;
		} else if ( response.data.core_option.recommendation_installed ) {
			progressValue = 66;
		}
		window.digirisk.installer.requestInstallComponent();
	} else {
		progressValue = 100;

		jQuery( '.wpdigi-installer .wpdigi-components .next' ).removeClass( 'disabled' );
		if ( 0 < jQuery( '#toplevel_page_digi-setup a' ).length ) {
			jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
		}
	}

	jQuery( '.wpdigi-components progress' ).attr( 'value', progressValue );
};

/**
 * Passes au prochain écran "Utilisateur" lors du clique sur le bouton "Suivant".
 *
 * @param  {ClickEvent} event Le clique sur le bouton
 * @return {void}
 *
 * @since 6.2.7.0
 * @version 6.2.7.0
 */
window.digirisk.installer.nextScreenUser = function( event ) {
	jQuery( '.wpdigi-installer .wpdigi-components' ).hide();
	jQuery( '.wpdigi-installer .step-create-components' ).removeClass( 'active' );
	jQuery( '.wpdigi-installer .step-create-users' ).addClass( 'active' );
	jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
};
