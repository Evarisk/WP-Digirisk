/**
 * @namespace EO_Framework_Regex
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */

var regex = {
	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Regex
	 *
	 * @param  {void} email [description]
	 * @returns {void}       [description]
	 */
	validateEmail: function(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	},

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Regex
	 *
	 * @param  {void} endEmail [description]
	 * @returns {void}          [description]
	 */
	validateEndEmail: function( endEmail ) {
		var re = /^[a-zA-Z0-9]+\.[a-zA-Z0-9]+(\.[a-z-A-Z0-9]+)?$/;
		return re.test( endEmail );
	}
};
