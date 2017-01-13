window .digirisk.installer = {};

window.digirisk.installer.init = function() {
	window.digirisk.installer.event();
};

window.digirisk.installer.event = function() {
	jQuery( '.wpdigi-installer .btn-more-option' ).click( window.digirisk.installer.more_options );
	jQuery( document ).on( 'keyup', '.wpdigi-installer input[name="groupment[title]"]', window.digirisk.installer.key_up_groupment_title );
	jQuery( document ).on( 'keyup', '.wpdigi-installer input.input-domain-mail, .user-dashboard input.input-domain-mail', window.digirisk.installer.key_up_domain_mail );
};

window.digirisk.installer.more_options = function( event ) {
	event.preventDefault();
	jQuery( '.wpdigi-installer .form-more-option' ).toggle();
};

window.digirisk.installer.key_up_groupment_title = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.submit-form' ).click();
	}
};

window.digirisk.installer.key_up_domain_mail = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.wp-digi-action-save-domain-mail' ).click();
	}
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_society".
 * Ferme la div "society". Changes l'étape de "Votre société" en "Composants".
 * Ouvre la div "wpdigi-components".
 * Appel la méthode "request_install_component".
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
	window.digirisk.installer.request_install_component();
};

/**
 * Envoie une requête pour installer les composants nécessaires à l'utilisation de DigiRisk.
 * @return {void}
 */
window.digirisk.installer.request_install_component = function() {
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
 * @version 6.2.4.0
 */
window.digirisk.installer.installedComponentSuccess = function( response ) {
	jQuery( '.wpdigi-installer .wpdigi-components li.active img' ).hide();
	jQuery( '.wpdigi-installer .wpdigi-components li.active .dashicons' ).show();
	jQuery( '.wpdigi-installer .wpdigi-components li.active' ).removeClass( 'active' );

	// Si l'installation n'est pas terminée, on relance une requête avec les prochains composants à installer.
	if ( ! response.data.core_option.installed ) {
		jQuery( '.wpdigi-installer .wpdigi-components li.hidden:first' ).removeClass( 'hidden' ).addClass( 'active' );
		window.digirisk.installer.request_install_component();
	} else {
		if ( 0 < jQuery( '#toplevel_page_digi-setup a' ).length ) {
			jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
		}

		// Si l'installation est terminée, nous passons à la prochaine étape.
		jQuery( '.wpdigi-installer .wpdigi-components' ).hide();
		jQuery( '.wpdigi-installer .step-create-components' ).removeClass( 'active' );
		jQuery( '.wpdigi-installer .step-create-users' ).addClass( 'active' );
		jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
	}
};
