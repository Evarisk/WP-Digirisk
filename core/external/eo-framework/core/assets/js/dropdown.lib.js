/**
 * @namespace EO_Framework_Dropdown
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion du dropdown.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
 if ( ! window.eoxiaJS.dropdown  ) {

 	/**
 	 * [dropdown description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @type {Object}
 	 */
 	window.eoxiaJS.dropdown = {};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.dropdown.init = function() {
 		window.eoxiaJS.dropdown.event();
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.dropdown.event = function() {
 		jQuery( document ).on( 'keyup', window.eoxiaJS.dropdown.keyup );
 		jQuery( document ).on( 'click', '.wpeo-dropdown:not(.dropdown-active) .dropdown-toggle:not(.disabled)', window.eoxiaJS.dropdown.open );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active .dropdown-content', function(e) { e.stopPropagation() } );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active:not(.dropdown-force-display) .dropdown-content .dropdown-item', window.eoxiaJS.dropdown.close  );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active', function ( e ) { window.eoxiaJS.dropdown.close( e ); e.stopPropagation(); } );
 		jQuery( document ).on( 'click', 'body', window.eoxiaJS.dropdown.close );
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.keyup = function( event ) {
 		if ( 27 === event.keyCode ) {
 			window.eoxiaJS.dropdown.close();
 		}
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.open = function( event ) {
 		var triggeredElement = jQuery( this );
 		var angleElement = triggeredElement.find('[data-fa-i2svg]');
 		var callbackData = {};
 		var key = undefined;

 		window.eoxiaJS.dropdown.close( event, jQuery( this ) );

 		if ( triggeredElement.attr( 'data-action' ) ) {
 			window.eoxiaJS.loader.display( triggeredElement );

 			triggeredElement.get_data( function( data ) {
 				for ( key in callbackData ) {
 					if ( ! data[key] ) {
 						data[key] = callbackData[key];
 					}
 				}

 				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
 					triggeredElement.closest( '.wpeo-dropdown' ).find( '.dropdown-content' ).html( response.data.view );

 					triggeredElement.closest( '.wpeo-dropdown' ).addClass( 'dropdown-active' );

 					/* Toggle Button Icon */
 					if ( angleElement ) {
 						window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 					}
 				} );
 			} );
 		} else {
 			triggeredElement.closest( '.wpeo-dropdown' ).addClass( 'dropdown-active' );

 			/* Toggle Button Icon */
 			if ( angleElement ) {
 				window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 			}
 		}

 		event.stopPropagation();
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.close = function( event ) {
 		var _element = jQuery( this );
 		jQuery( '.wpeo-dropdown.dropdown-active:not(.no-close)' ).each( function() {
 			var toggle = jQuery( this );
 			var triggerObj = {
 				close: true
 			};

 			_element.trigger( 'dropdown-before-close', [ toggle, _element, triggerObj ] );

 			if ( triggerObj.close ) {
 				toggle.removeClass( 'dropdown-active' );

 				/* Toggle Button Icon */
 				var angleElement = jQuery( this ).find('.dropdown-toggle').find('[data-fa-i2svg]');
 				if ( angleElement ) {
 					window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 				}
 			} else {
 				return;
 			}
 		});
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} button [description]
 	 * @returns {void}        [description]
 	 */
 	window.eoxiaJS.dropdown.toggleAngleClass = function( button ) {
 		if ( button.hasClass('fa-caret-down') || button.hasClass('fa-caret-up') ) {
 			button.toggleClass('fa-caret-down').toggleClass('fa-caret-up');
 		}
 		else if ( button.hasClass('fa-caret-circle-down') || button.hasClass('fa-caret-circle-up') ) {
 			button.toggleClass('fa-caret-circle-down').toggleClass('fa-caret-circle-up');
 		}
 		else if ( button.hasClass('fa-angle-down') || button.hasClass('fa-angle-up') ) {
 			button.toggleClass('fa-angle-down').toggleClass('fa-angle-up');
 		}
 		else if ( button.hasClass('fa-chevron-circle-down') || button.hasClass('fa-chevron-circle-up') ) {
 			button.toggleClass('fa-chevron-circle-down').toggleClass('fa-chevron-circle-up');
 		}
 	}
 }
