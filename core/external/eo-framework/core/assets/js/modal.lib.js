/**
 * Gestion de la modal.
 *
 * La modal peut être ouverte par deux moyens:
 * -Avec une requête AJAX.
 * -En plaçant la vue directement dans le DOM.
 *
 * Dans tous les cas, il faut placer un élément HTML avec la classe ".wpeo-modal-event".
 *
 * Cette élement doit contenir différent attributs.
 *
 * Les attributs pour ouvrir la popup avec une requête AJAX:
 * - data-action: Le nom de l'action WordPress.
 * - data-title : Le titre de la popup.
 * - data-class : Pour ajouter une classe dans le contenaire principale de la popup.
 *
 * Les attributs pour ouvrir la popup avec une vue implémentée directement dans le DOM:
 * - data-parent: La classe de l'élement parent contenant la vue de la popup
 * - data-target: La classe de la popup elle même.
 *
 * La modal généré en AJAX est ajouté dans la balise <body> temporairement. Une fois celle-ci fermée
 * elle se détruit du DOM.
 *
 * La modal implémentée dans le DOM (donc non généré en AJAX) reste dans le DOM une fois fermée.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.modal  ) {
	window.eoxiaJS.modal = {};

	/**
	 * La vue de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal.view.php
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.popupTemplate = wpeo_framework.modalView;
	/**
	 * Les boutons par défault de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal-buttons.view.php
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.defaultButtons = wpeo_framework.modalDefautButtons;

	window.eoxiaJS.modal.init = function() {
		window.eoxiaJS.modal.event();
	};

	window.eoxiaJS.modal.event = function() {
		jQuery( document ).on( 'keyup', window.eoxiaJS.modal.keyup );
		jQuery( document ).on( 'click', '.wpeo-modal-event', window.eoxiaJS.modal.open );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-container', window.eoxiaJS.modal.stopPropagation );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-close', window.eoxiaJS.modal.close );
		jQuery( document ).on( 'click', 'body', window.eoxiaJS.modal.close );
	};

	window.eoxiaJS.modal.keyup = function( event ) {
		if ( 27 === event.keyCode ) {
			jQuery( '.wpeo-modal.modal-active:not(.no-close) .modal-close:first' ).click();
		}
	};

	window.eoxiaJS.modal.open = function( event ) {
		var triggeredElement = jQuery( this );
		var callbackData = {};
		var key = undefined;

		// Si data-action existe, ce script ouvre la popup en lançant une requête AJAX.
		if ( triggeredElement.attr( 'data-action' ) ) {
			triggeredElement.get_data( function( data ) {
				for ( key in callbackData ) {
					if ( ! data[key] ) {
						data[key] = callbackData[key];
					}
				}

				var el = jQuery( document.createElement( 'div' ) );
				el[0].className = 'wpeo-modal modal-active';
				el[0].innerHTML = window.eoxiaJS.modal.popupTemplate;
				el[0].typeModal = 'ajax';
				triggeredElement[0].modalElement = el;

				if ( triggeredElement.attr( 'data-title' ) ) {
					el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
				}

				if ( triggeredElement.attr( 'data-class' ) ) {
					el[0].className += ' ' + triggeredElement.attr( 'data-class' );
				}

				jQuery( 'body' ).append( triggeredElement[0].modalElement );

				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
					if ( response.data.view ) {
						el[0].innerHTML = el[0].innerHTML.replace( '{{content}}', response.data.view );

						if ( response.data.buttons_view ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', response.data.buttons_view );
						} else {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', window.eoxiaJS.modal.defaultButtons );
						}
					}
				} );
			});
		} else {
			// Stop le script si un de ses deux attributs n'est pas déclaré.
			if ( ! triggeredElement.attr( 'data-parent' ) || ! triggeredElement.attr( 'data-target' ) ) {
				event.stopPropagation();
				return;
			}

			var target = triggeredElement.closest( '.' + triggeredElement.attr( 'data-parent' ) ).find( '.' + triggeredElement.attr( 'data-target' ) );
			target.addClass( 'modal-active' );
			target[0].typeModal = 'default';
			triggeredElement[0].modalElement = target;
		}

		event.stopPropagation();
	};

	window.eoxiaJS.modal.stopPropagation = function( event ) {
		event.stopPropagation();
	};

	window.eoxiaJS.modal.close = function( event ) {
		jQuery( '.wpeo-modal.modal-active:not(.no-close)' ).each( function() {
			var popup = jQuery( this );
			popup.removeClass( 'modal-active' );
			if ( 'default' !== popup[0].typeModal ) {
				setTimeout( function() {
					popup.remove();
				}, 200 );
			}
		} );
	};
}
