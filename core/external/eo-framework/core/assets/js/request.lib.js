/**
 * @namespace EO_Framework_Request
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion des requêtes XHR.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.request ) {

	/**
	 * [request description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.request = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.request.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element [description]
	 * @param  {void}   data    [description]
	 * @param  {Function} cb      [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.request.send = function( element, data, cb ) {
		return jQuery.post( window.ajaxurl, data, function( response ) {
			// Normal loader.
			if ( element instanceof jQuery ) {
				window.eoxiaJS.loader.remove( element.closest( '.wpeo-loader' ) );
			}

			// Handle button progress.
			if ( element instanceof jQuery && element.hasClass( 'button-progress' ) ) {
				element.removeClass( 'button-load' ).addClass( 'button-success' );
				setTimeout( function() {
					element.removeClass( 'button-success' );

					window.eoxiaJS.request.callCB( element, response, cb )
				}, 1000 );
			} else {
				window.eoxiaJS.request.callCB( element, response, cb )
			}
		}, 'json').fail( function() {
			window.eoxiaJS.request.fail( element );
		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element [description]
	 * @param  {void}   url     [description]
	 * @param  {void}   data    [description]
	 * @param  {Function} cb      [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.request.get = function( element, url, data, cb ) {
		jQuery.get( url, data, function( response ) {
			window.eoxiaJS.request.callCB( element, response, cb );
		}, 'json' ).fail( function() {
			window.eoxiaJS.request.fail( element );
		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element  [description]
	 * @param  {void}   response [description]
	 * @param  {Function} cb       [description]
	 * @returns {void}            [description]
	 */
	window.eoxiaJS.request.callCB = function( element, response, cb ) {
		if ( cb ) {
			cb( element, response );
		} else {
			if ( response && response.success ) {
				if ( response.data && response.data.namespace && response.data.module && response.data.callback_success ) {
					window.eoxiaJS[response.data.namespace][response.data.module][response.data.callback_success]( element, response );
				} else if ( response.data && response.data.module && response.data.callback_success ) {
					window.eoxiaJS[response.data.module][response.data.callback_success]( element, response );
				}
			} else {
				if ( response.data && response.data.namespace && response.data.module && response.data.callback_error ) {
					window.eoxiaJS[response.data.namespace][response.data.module][response.data.callback_error]( element, response );
				}
			}
		}
	}

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.request.fail = function( element ) {
		if ( element && element instanceof jQuery ) {
			window.eoxiaJS.loader.remove( element.closest( '.wpeo-loader' ) );

			if ( element.hasClass( 'button-progress' ) ) {
				element.removeClass( 'button-load' ).addClass( 'button-error' );
				setTimeout( function() {
					element.removeClass( 'button-error' );
				}, 1000 );
			}
		}
	}
}
