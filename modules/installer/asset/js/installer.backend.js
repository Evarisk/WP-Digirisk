window .digirisk.installer = {};

window.digirisk.installer.init = function() {
	window.digirisk.installer.event();
};

window.digirisk.installer.event = function() {

};

window.digirisk.installer.save_society = function( element, response ) {
	element.closest( 'div' ).hide();
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
 * Le callback quand la requête pour installer les composants est terminée avec succés
 * Met le li active en statut "finit" et passes au suivant, tout en relancant la requête pour installer le composant suivant.
 * Si tous les li sont en statut "finit" passes à l'étape suivante qui est "Création des utilisateurs"
 * @param  {Object} response [description]
 * @return {void}
 */
window.digirisk.installer.install_component_success = function( response ) {
	jQuery( '.wpdigi-installer .wpdigi-components li.active img' ).hide();
	jQuery( '.wpdigi-installer .wpdigi-components li.active .dashicons' ).show();
	jQuery( '.wpdigi-installer .wpdigi-components li.active ').removeClass( 'active' );

	// Si l'installation n'est pas terminée, on relance une requête avec les prochains composants à installer.
	if ( !response.data.core_option.installed ) {
		jQuery( '.wpdigi-installer .wpdigi-components li.hidden:first' ).removeClass( 'hidden' ).addClass( 'active' );
		window.digirisk.installer.request_install_component();
	}
	else {
		// Si l'installation est terminée, nous passons à la prochaine étape.
		jQuery( '.wpdigi-installer .wpdigi-components' ).hide();
		jQuery( '.wpdigi-installer .step-create-components' ).removeClass( 'active' );
		jQuery( '.wpdigi-installer .step-create-users' ).addClass( 'active' );
		jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
	}
};
