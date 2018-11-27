/**
 * @namespace EO_Framework_Global
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.global ) {

	/**
	 * [global description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.global = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.global.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @param  {void} urlToFile [description]
	 * @param  {void} filename  [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.global.downloadFile = function( urlToFile, filename ) {
		var alink = document.createElement( 'a' );
		alink.setAttribute( 'href', urlToFile );
		alink.setAttribute( 'download', filename );
		if ( document.createEvent ) {
			var event = document.createEvent( 'MouseEvents' );
			event.initEvent( 'click', true, true );
			alink.dispatchEvent( event );
		} else {
			alink.click();
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @param  {void} input [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.global.removeDiacritics = function( input ) {
		var output = '';
		var normalized = input.normalize( 'NFD' );
		var i = 0;
		var j = 0;

		while ( i < input.length ) {
			output += normalized[j];

			j += ( input[i] == normalized[j] ) ? 1 : 2;
			i++;
		}

		return output;
	};

	}
