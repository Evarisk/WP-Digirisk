/**
 * @namespace EO_Framework_Render
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */
/*

 */
if ( ! window.eoxiaJS.render ) {
	/**
	 * [render description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.render = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.init = function() {
		window.eoxiaJS.render.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.event = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.callRenderChanged = function() {
		var key = undefined;
		var slug = undefined;

		for ( key in window.eoxiaJS ) {
			if ( window.eoxiaJS[key].renderChanged ) {
				window.eoxiaJS[key].renderChanged();
			}

			for ( slug in window.eoxiaJS[key] ) {
				if ( window.eoxiaJS[key][slug].renderChanged ) {
					window.eoxiaJS[key][slug].renderChanged();
				}
			}
		}
	};
}
