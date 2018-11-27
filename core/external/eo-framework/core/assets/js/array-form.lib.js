/**
 * @namespace EO_Framework_Array_Form
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Action for make request AJAX.
 *
 * @since 1.0.0-easy
 * @version 1.0.0-easy
 */

if ( ! window.eoxiaJS.arrayForm ) {
	/**
	 * Declare the object arrayForm.
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @since 1.0.0-easy
	 * @version 1.0.0-easy
	 * @type {Object}
	 */
	window.eoxiaJS.arrayForm = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.arrayForm.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.arrayForm.event = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @param  {void} parent [description]
	 * @returns {void}        [description]
	 */
	window.eoxiaJS.arrayForm.getInput = function( parent ) {
		return parent.find( 'input, textarea, select' );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @param  {void} input [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.arrayForm.getInputValue = function( input ) {
		switch ( input.getAttribute( 'type' ) ) {
			case 'checkbox':
				return input.checked;
				break;
			case 'radio':
				return jQuery( 'input[name="' + jQuery( input ).attr( 'name' ) + '"]:checked' ).val();
				break;
			default:
				return input.value;
				break;
		}
	};
}
