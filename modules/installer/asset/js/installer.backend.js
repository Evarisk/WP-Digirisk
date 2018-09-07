/**
 * Initialise l'objet "installer" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 */

window.eoxiaJS.digirisk.installer = {};
window.eoxiaJS.digirisk.installer.progressInterval = undefined;

/**
 * Méthodes obligatoire pour utiliser EO-JS.
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.installer.init = function() {
	window.eoxiaJS.digirisk.installer.event();
	window.eoxiaJS.digirisk.initOwlCarousel();
};

/**
 * Initialise tous les évènements pour la page "digi-setup".
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.installer.event = function() {
	jQuery( document ).on( 'keyup', '.wpdigi-installer input[name="title"]', window.eoxiaJS.digirisk.installer.keyUpGroupmentTitle );
	jQuery( document ).on( 'click', '.wpdigi-installer input[type="checkbox"]', window.eoxiaJS.digirisk.installer.toggleDefaultInstall );

	jQuery( document ).on( 'click', '.wpdigi-installer input[name="title"]', window.eoxiaJS.digirisk.installer.emptyPlaceHolder );
	jQuery( document ).on( 'blur', '.wpdigi-installer input[name="title"]', window.eoxiaJS.digirisk.installer.fillProgressBar );
};

/**
 * Initialise le "owlCarousel" sur l'élement "owl-carousel".
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.initOwlCarousel = function() {
	jQuery( '.owl-carousel' ).owlCarousel( {
		'items': 1,
		'nav': true,
		'navText': [],
		'pagination': true,
		'autoHeight': true,
		'autoplay': true,
		'autoplayTimeout': 25000
	} );
}

/**
 * Évènement lors du "keyup" sur le champ "Nom de ma société".
 *
 * @since 6.0.0
 *
 * @param  {KeyEvent} event L'état du clavier.
 */
window.eoxiaJS.digirisk.installer.keyUpGroupmentTitle = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.main-content .action-input:first' ).click();
	}

	if ( jQuery( this ).val() != '' ) {
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '12%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 12 );
	}	else {
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '0%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 0 );
	}
};

/**
 * Ouvre les détails des données par défaut lorsqu'on "check" la case à coché.
 *
 * @since 7.0.0
 *
 * @param  {MouseEvent} event L'état de la souri lors du clic.
 */
window.eoxiaJS.digirisk.installer.toggleDefaultInstall = function( event ) {
	jQuery( '.wpdigi-installer .bloc-create-society .default-data-details' ).toggleClass( 'hidden' );
};

/**
 * Enlèves le placeholder lors du "clic" sur le champ "Nom de ma société".
 *
 * @since 6.0.0
 *
 * @param  {ClickEvent} event L'état du clique.
 */
window.eoxiaJS.digirisk.installer.emptyPlaceHolder = function( event ) {
	if ( '' === jQuery( this ).val() ) {
		jQuery( this ).closest( '.society-form' ).find( 'label' ).hide();
	}
};

/**
 * Remplie la barre de progression.
 *
 * @since 6.0.0
 *
 * @param  {FocusEvent} event L'état du focus.
 */
window.eoxiaJS.digirisk.installer.fillProgressBar = function( event ) {
	if ( '' === jQuery( this ).val() ) {
		jQuery( this ).closest( '.society-form' ).find( 'label' ).show();
		jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '0%' );
		jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 0 );
	}
};

/**
 * Vérifie que le nom de la société ne soit pas vide.
 *
 * @since 6.0.0
 *
 * @param  {HTMLDivElement} element Le bouton déclenchant la création de la société
 */
window.eoxiaJS.digirisk.installer.beforeCreateSociety = function( element ) {
	if ( '' === element.closest( 'form' ).find( 'input[name="title"]' ).val() ) {
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
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.installer.savedSociety = function( element, response ) {
	jQuery( '.wpdigi-installer .bloc-create-society' ).hide();
	jQuery( '.wpdigi-installer .wpdigi-components' ).show();
	jQuery( '.wpdigi-installer .start-install' ).hide();
	jQuery( '.wpdigi-installer .end-install' ).show();
	jQuery( '.wpdigi-installer .bar .loader' ).css( 'width',  '30%' );
	jQuery( '.wpdigi-installer .bar .loader' ).attr( 'data-width', 25 );
	jQuery( '.wpdigi-installer .step-list .step[data-width="' + 25 + '"]' ).addClass( 'active' );

	window.eoxiaJS.loader.display( jQuery( '.wpdigi-installer a.end-install' ) );

	window.eoxiaJS.digirisk.installer.requestInstallComponent();
};

/**
 * Envoie une requête pour installer les composants nécessaires à l'utilisation de DigiRisk.
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.installer.requestInstallComponent = function() {
	var _wpnonce = jQuery( '.wpdigi-installer .wpdigi-components .nonce-installer-components' ).val();
	window.eoxiaJS.request.get( undefined, ajaxurl + '?action=installer_components&_wpnonce=' + _wpnonce );
};

/**
 * Le callback en cas de réussite à la requête Ajax "installer_components".
 * Met le li active en statut "finit" et passes au suivant, tout en relancant la requête pour installer le composant suivant.
 * Si tous les li sont en statut "finit" passes à l'étape suivante qui est "Création des utilisateurs"
 *
 * @since 6.0.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 */
window.eoxiaJS.digirisk.installer.installedComponentSuccess = function( triggeredElement, response ) {

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

		jQuery( '.wpdigi-installer .wpdigi-components .next' ).removeClass( 'button-disable' );
		if ( 0 < jQuery( '#toplevel_page_digi-setup a' ).length ) {
			jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
		}

		window.eoxiaJS.loader.remove( jQuery( '.wpdigi-installer a' ) );
	}
};

/**
 * Met à jour la barre de progression.
 *
 * @since 6.0.0
 *
 * @param  {integer} pourcent Le pourcentage courant.
 */
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
				jQuery( '.wpdigi-installer .end-install.button-disable' ).removeClass( 'button-disable' );
			}
		}
	}, 100 );
};
