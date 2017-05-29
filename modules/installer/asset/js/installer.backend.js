/**
 * Initialise l'objet "installer" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.7.0
 */

window.eoxiaJS.digirisk.installer = {};
window.eoxiaJS.digirisk.installer.progressInterval = undefined;

window.eoxiaJS.digirisk.installer.init = function() {
	window.eoxiaJS.digirisk.installer.event();
};

window.eoxiaJS.digirisk.installer.event = function() {
	jQuery( document ).on( 'keyup', '.wpdigi-installer input[name="groupment[title]"]', window.eoxiaJS.digirisk.installer.key_up_groupment_title );
	jQuery( document ).on( 'click', '.wpdigi-installer input[name="groupment[title]"]', window.eoxiaJS.digirisk.installer.emptyPlaceHolder );
	jQuery( document ).on( 'blur', '.wpdigi-installer input[name="groupment[title]"]', window.eoxiaJS.digirisk.installer.fillPlaceHolder );
	jQuery( document ).on( 'keyup', '.wpdigi-installer input.input-domain-mail, .user-dashboard input.input-domain-mail', window.eoxiaJS.digirisk.installer.key_up_domain_mail );
	jQuery( '.owl-carousel' ).owlCarousel( {
		'items': 1,
		'nav': true,
		'navText': [],
		'pagination': true,
		'autoHeight': true,
		'autoplay': true,
		'autoplayTimeout': 25000
	} );
};

window.eoxiaJS.digirisk.installer.key_up_groupment_title = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.main-content.society .action-input' ).click();
	}

	if ( jQuery( this ).val() != '' ) {
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '12%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 12 );
	}	else {
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '0%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 0 );
	}
};

window.eoxiaJS.digirisk.installer.emptyPlaceHolder = function( event ) {
	if ( '' === jQuery( this ).val() ) {
		jQuery( this ).closest( '.society-form' ).find( 'label' ).hide();
	}
};

window.eoxiaJS.digirisk.installer.fillPlaceHolder = function( event ) {
	if ( '' === jQuery( this ).val() ) {
		jQuery( this ).closest( '.society-form' ).find( 'label' ).show();
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '0%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 0 );
	}
};

window.eoxiaJS.digirisk.installer.key_up_domain_mail = function( event ) {
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
window.eoxiaJS.digirisk.installer.beforeCreateSociety = function( element ) {
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
window.eoxiaJS.digirisk.installer.savedSociety = function( element, response ) {
	jQuery( '.wpdigi-installer .bloc-create-society' ).hide();
	jQuery( '.wpdigi-installer .wpdigi-components' ).show();
	jQuery( '.wpdigi-installer .button.blue' ).hide();
	jQuery( '.wpdigi-installer .button.green' ).show();
	jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '25%' );
	jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 25 );
	jQuery( '.wpdigi-installer .step-list .step[data-width="' + 25 + '"]' ).addClass( 'active' );
	window.eoxiaJS.digirisk.installer.requestInstallComponent();
};

/**
 * Envoie une requête pour installer les composants nécessaires à l'utilisation de DigiRisk.
 * @return {void}
 */
window.eoxiaJS.digirisk.installer.requestInstallComponent = function() {
	var _wpnonce = jQuery( '.wpdigi-installer .wpdigi-components .nonce-installer-components' ).val();
	window.eoxiaJS.request.get( ajaxurl + '?action=installer_components&_wpnonce=' + _wpnonce );
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
window.eoxiaJS.digirisk.installer.installedComponentSuccess = function( response ) {
	// Si l'installation n'est pas terminée, on relance une requête avec les prochains composants à installer.
	if ( ! response.data.core_option.installed ) {
		if ( ! response.data.core_option.recommendation_installed && response.data.core_option.danger_installed ) {
			window.eoxiaJS.digirisk.installer.progressBar( 55 );
		} else if ( response.data.core_option.recommendation_installed ) {
			window.eoxiaJS.digirisk.installer.progressBar( 80 );
		}
		window.eoxiaJS.digirisk.installer.requestInstallComponent();
	} else {
		window.eoxiaJS.digirisk.installer.progressBar( 100 );

		jQuery( '.wpdigi-installer .wpdigi-components .next' ).removeClass( 'disabled' );
		if ( 0 < jQuery( '#toplevel_page_digi-setup a' ).length ) {
			jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
		}
	}

	// jQuery( '.wpdigi-components progress' ).attr( 'value', progressValue );
};

window.eoxiaJS.digirisk.installer.progressBar = function( pourcent ) {
	clearInterval( window.eoxiaJS.digirisk.installer.progressInterval );
	window.eoxiaJS.digirisk.installer.progressInterval = undefined;

	window.eoxiaJS.digirisk.installer.progressInterval = setInterval( function() {
		var currentWidth = jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width' );
		currentWidth++;

		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width', currentWidth + '%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', currentWidth );

		jQuery( '.wpdigi-installer .step-list .step[data-width="' + currentWidth + '"]' ).addClass( 'active' );

		if ( jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width' ) >= pourcent ) {
			clearInterval( window.eoxiaJS.digirisk.installer.progressInterval );
			window.eoxiaJS.digirisk.installer.progressInterval = undefined;

			if ( pourcent === 100 ) {
				jQuery( '.wpdigi-installer .button.green.disable' ).removeClass( 'disable' );
			}
		}
	}, 100 );
};
