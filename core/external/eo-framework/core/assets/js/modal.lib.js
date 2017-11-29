/**
 * Gestion de la modal.
 *
 * La modal est créer dynamiquement en JS lors du clic sur le bouton ".wpeo-modal-event".
 * Le template créer dynamiquement est défini en DUR dans le code JS.
 * @todo: Voir pour faire plus propre. Peut être avoir une vrai vue pour le template de la popup ?
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.modal  ) {
	window.eoxiaJS.modal = {};

	/**
	 * Le template de la modal.
	 * Voir le fichier /core/view/modal.view.php
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.popupTemplate = wpeo_framework.modalView;

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

	window.eoxiaJS.modal.open = function( event ) {
		var triggeredElement = jQuery( this );
		var callbackData = {};
		var key = undefined;

		/** Méthode appelée avant l'action */
		if ( triggeredElement.attr( 'dataCallback' ) ) {
			// callbackData = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		var el = jQuery( document.createElement( 'div' ) );
		el[0].className = 'wpeo-modal modal-active';
		el[0].innerHTML = window.eoxiaJS.modal.popupTemplate;
		triggeredElement[0].modalElement = el;

		if ( triggeredElement.attr( 'data-title' ) ) {
			el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
		}

		if ( triggeredElement.attr( 'data-class' ) ) {
			el[0].className += ' ' + triggeredElement.attr( 'data-class' );
		}

		jQuery( 'body' ).append( triggeredElement[0].modalElement );

		// Si data-action existe, cette méthode lances une requête AJAX.
		if ( triggeredElement.attr( 'data-action' ) ) {
			triggeredElement.get_data( function( data ) {
				for ( key in callbackData ) {
					if ( ! data[key] ) {
						data[key] = callbackData[key];
					}
				}

				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
					if ( response.data.view ) {
						el[0].innerHTML = el[0].innerHTML.replace( '{{content}}', response.data.view );
						el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', response.data.buttons_view );
					}
				} );
			});
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
			setTimeout( function() {
				popup.remove();
			}, 200 );
		} );
	};
}
