/**
 * @namespace EO_Framework_Form
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */
/*

 */

if ( ! window.eoxiaJS.form ) {

	/**
	 * [form description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.form = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.form.init = function() {
	    window.eoxiaJS.form.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.form.event = function() {
	    jQuery( document ).on( 'click', '.submit-form', window.eoxiaJS.form.submitForm );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.form.submitForm = function( event ) {
		var element = jQuery( this );
		var doAction = true;

		event.preventDefault();

	/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( doAction ) {
			element.closest( 'form' ).ajaxSubmit( {
				success: function( response ) {
					if ( response && response.data.module && response.data.callback ) {
						window.eoxiaJS[response.data.module][response.data.callback]( element, response );
					}

					if ( response && response.success ) {
						if ( response.data.module && response.data.callback_success ) {
							window.eoxiaJS[response.data.module][response.data.callback_success]( element, response );
						}
					} else {
						if ( response.data.module && response.data.callback_error ) {
							window.eoxiaJS[response.data.module][response.data.callback_error]( element, response );
						}
					}
				}
			} );
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @param  {void} formElement [description]
	 * @returns {void}             [description]
	 */
	window.eoxiaJS.form.reset = function( formElement ) {
		var fields = formElement.find( 'input, textarea, select' );

		fields.each(function () {
			switch( jQuery( this )[0].tagName ) {
				case 'INPUT':
				case 'TEXTAREA':
					jQuery( this ).val( jQuery( this )[0].defaultValue );
					break;
				case 'SELECT':
					// 08/03/2018: En dur pour TheEPI il faut absolument le changer
					jQuery( this ).val( 'OK' );
					break;
				default:
					jQuery( this ).val( jQuery( this )[0].defaultValue );
					break;
			}
		} );
	};
}
