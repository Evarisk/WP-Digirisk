/**
 * Handle POPUP
 *
 * @since 1.0.0-easy
 * @version 1.1.0-easy
 */

if ( ! window.eoxiaJS.popup  ) {
	window.eoxiaJS.popup = {};

	window.eoxiaJS.popup.init = function() {
		window.eoxiaJS.popup.event();
	};

	window.eoxiaJS.popup.event = function() {
		jQuery( document ).on( 'keyup', window.eoxiaJS.popup.keyup );
	  jQuery( document ).on( 'click', '.open-popup, .open-popup i', window.eoxiaJS.popup.open );
	  jQuery( document ).on( 'click', '.open-popup-ajax', window.eoxiaJS.popup.openAjax );
	  jQuery( document ).on( 'click', '.popup .container, .digi-popup-propagation', window.eoxiaJS.popup.stop );
	  jQuery( document ).on( 'click', '.popup .container .button.green', window.eoxiaJS.popup.confirm );
	  jQuery( document ).on( 'click', '.popup .close', window.eoxiaJS.popup.close );
	  jQuery( document ).on( 'click', 'body', window.eoxiaJS.popup.close );
	};

	window.eoxiaJS.popup.keyup = function( event ) {
		if ( 27 === event.keyCode ) {
			jQuery( '.popup .close' ).click();
		}
	};

	window.eoxiaJS.popup.open = function( event ) {
		var triggeredElement = jQuery( this );

		if ( triggeredElement.is( 'i' ) ) {
			triggeredElement = triggeredElement.parents( '.open-popup' );
		}

		var target = triggeredElement.closest(  '.' + triggeredElement.data( 'parent' ) ).find( '.' + triggeredElement.data( 'target' ) + ':first' );
		var cbObject, cbNamespace, cbFunc = undefined;

		if ( target ) {
			target[0].className = 'popup';

			if ( triggeredElement.attr( 'data-class' ) ) {
				target.addClass( triggeredElement.attr( 'data-class' ) );
			}

			target.addClass( 'active' );
		}

		if ( target.is( ':visible' ) && triggeredElement.data( 'cb-namespace' ) && triggeredElement.data( 'cb-object' ) && triggeredElement.data( 'cb-func' ) ) {
			cbNamespace = triggeredElement.data( 'cb-namespace' );
			cbObject = triggeredElement.data( 'cb-object' );
			cbFunc = triggeredElement.data( 'cb-func' );

			// On récupères les "data" sur l'élement en tant qu'args.
			triggeredElement.get_data( function( data ) {
				window.eoxiaJS[cbNamespace][cbObject][cbFunc]( triggeredElement, target, event, data );
			} );
		}

	  event.stopPropagation();
	};

	/**
	 * Ouvre la popup en envoyant une requête AJAX.
	 * Les paramètres de la requête doivent être configurer directement sur l'élement
	 * Ex: data-action="load-workunit" data-id="190"
	 *
	 * @since 1.0.0-easy
	 * @version 1.1.0-easy
	 *
	 * @param  {[type]} event [description]
	 * @return {[type]}       [description]
	 */
	window.eoxiaJS.popup.openAjax = function( event ) {
		var element = jQuery( this );
		var callbackData = {};
		var key = undefined;
		var target = jQuery( this ).closest(  '.' + jQuery( this ).data( 'parent' ) ).find( '.' + jQuery( this ).data( 'target' ) + ':first' );

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			callbackData = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( target ) {
			target[0].className = 'popup';

			if ( element.attr( 'data-class' ) ) {
				target.addClass( element.attr( 'data-class' ) );
			}

			target.addClass( 'active' );
		}

		target.find( '.container' ).addClass( 'loading' );

		if ( jQuery( this ).data( 'title' ) ) {
			target.find( '.title' ).text( jQuery( this ).data( 'title' ) );
		}

		jQuery( this ).get_data( function( data ) {
			delete data.parent;
			delete data.target;

			for ( key in callbackData ) {
				if ( ! data[key] ) {
					data[key] = callbackData[key];
				}
			}

			window.eoxiaJS.request.send( element, data );
		});

		event.stopPropagation();
	};

	window.eoxiaJS.popup.confirm = function( event ) {
		var triggeredElement = jQuery( this );
		var cbNamespace, cbObject, cbFunc = undefined;

		if ( ! jQuery( '.popup' ).hasClass( 'no-close' ) ) {
			jQuery( '.popup' ).removeClass( 'active' );

			if ( triggeredElement.attr( 'data-cb-namespace' ) && triggeredElement.attr( 'data-cb-object' ) && triggeredElement.attr( 'data-cb-func' ) ) {
				cbNamespace = triggeredElement.attr( 'data-cb-namespace' );
				cbObject = triggeredElement.attr( 'data-cb-object' );
				cbFunc = triggeredElement.attr( 'data-cb-func' );

				// On récupères les "data" sur l'élement en tant qu'args.
				triggeredElement.get_data( function( data ) {
					window.eoxiaJS[cbNamespace][cbObject][cbFunc]( triggeredElement, event, data );
				} );
			}
		}
	};

	window.eoxiaJS.popup.stop = function( event ) {
		event.stopPropagation();
	};

	window.eoxiaJS.popup.close = function( event ) {
		if ( ! jQuery( 'body' ).hasClass( 'modal-open' ) ) {
			jQuery( '.popup:not(.no-close)' ).removeClass( 'active' );
			jQuery( '.digi-popup:not(.no-close)' ).removeClass( 'active' );
		}
	};
}
