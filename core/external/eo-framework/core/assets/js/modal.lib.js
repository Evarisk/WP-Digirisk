/**
 * @namespace EO_Framework_Modal
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
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

	/**
	 * [modal description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.modal = {};

	/**
	 * La vue de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal.view.php
	 *
	 * @memberof EO_Framework_Modal
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
	 * @memberof EO_Framework_Modal
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.defaultButtons = wpeo_framework.modalDefaultButtons;

	/**
	 * Le titre par défault de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal-title.view.php
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.defaultTitle = wpeo_framework.modalDefaultTitle;

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.modal.init = function() {
		window.eoxiaJS.modal.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.modal.event = function() {
		jQuery( document ).on( 'keyup', window.eoxiaJS.modal.keyup );
		jQuery( document ).on( 'click', '.wpeo-modal-event', window.eoxiaJS.modal.open );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-container', window.eoxiaJS.modal.stopPropagation );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-close', window.eoxiaJS.modal.close );
		//  jQuery( document ).on( 'click', 'body', window.eoxiaJS.modal.close ); //09/07/2019
		jQuery( document ).on( 'mousedown', '.modal-active:not(.modal-container)', window.eoxiaJS.modal.close );
		jQuery( '#wpeo-task-metabox h2 span .wpeo-modal-event' ).click( window.eoxiaJS.modal.open );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.keyup = function( event ) {
		if ( 27 === event.keyCode ) {
			jQuery( '.wpeo-modal.modal-active:not(.no-close) .modal-close:first' ).click();
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.open = function( event ) {
		var triggeredElement = jQuery( this );
		var callbackData = {};
		var key = undefined;

		window.eoxiaJS.action.checkBeforeCB( triggeredElement );

		// Si data-action existe, ce script ouvre la popup en lançant une requête AJAX.
		if ( triggeredElement.attr( 'data-action' ) ) {
			window.eoxiaJS.loader.display( triggeredElement );

			triggeredElement.get_data( function( data ) {
				for ( key in callbackData ) {
					if ( ! data[key] ) {
						data[key] = callbackData[key];
					}
				}

				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
					window.eoxiaJS.loader.remove( triggeredElement );

					if ( response.data.view ) {
						var el = jQuery( document.createElement( 'div' ) );
						el[0].className = 'wpeo-modal modal-active';
						el[0].innerHTML = window.eoxiaJS.modal.popupTemplate;
						el[0].typeModal = 'ajax';
						triggeredElement[0].modalElement = el;

						if ( triggeredElement.attr( 'data-class' ) ) {
							el[0].className += ' ' + triggeredElement.attr( 'data-class' );
						}

						jQuery( 'body' ).append( triggeredElement[0].modalElement );

						el[0].innerHTML = el[0].innerHTML.replace( '{{content}}', response.data.view );

						if ( typeof response.data.buttons_view !== 'undefined' ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', response.data.buttons_view );
						} else {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', window.eoxiaJS.modal.defaultButtons );
						}

						if ( triggeredElement.attr( 'data-title' ) ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
						} else if ( response.data.modal_title ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', response.data.modal_title );
						} else if ( ! triggeredElement.attr( 'data-title' ) ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', window.eoxiaJS.modal.defaultTitle );
						}

						if ( window.eoxiaJS.refresh ) {
							window.eoxiaJS.refresh();
						}

						triggeredElement[0].modalElement.trigger( 'modal-opened', triggeredElement );
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

			jQuery( target ).find( 'h2.modal-title' ).text( '{{title}}' );

			if ( triggeredElement.attr( 'data-title' ) ) {
				target[0].querySelector( '.modal-title' ).innerHTML = target[0].querySelector( '.modal-title' ).innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
			}

			if ( triggeredElement.attr( 'data-class' ) ) {
				target[0].className += ' ' + triggeredElement.attr( 'data-class' );
			}

			target.addClass( 'modal-active' );
			target[0].typeModal = 'default';
			triggeredElement[0].modalElement = target;

			target.trigger( 'modal-opened', triggeredElement );

		}

		event.stopPropagation();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.stopPropagation = function( event ) {
		event.stopPropagation();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.close = function( event ) {
		if( ! jQuery( event.target ).hasClass( "wpeo-modal" ) && event.type == "mousedown" ){ // Si le click se situe dans la modal
			return;
		}
		jQuery( '.wpeo-modal.modal-active:last:not(.modal-force-display)' ).each( function() {
			var popup = jQuery( this );
			popup.removeClass( 'modal-active' );
			if ( popup[0].typeModal && 'default' !== popup[0].typeModal ) {
				setTimeout( function() {
					popup.remove();
				}, 200 );
			}
			popup.trigger( 'modal-closed', popup );
		} );
	};
}
