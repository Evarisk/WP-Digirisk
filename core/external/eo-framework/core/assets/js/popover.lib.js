/**
 * @namespace EO_Framework_Popover
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.popover ) {

	/**
	 * [popover description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.popover = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.popover.init = function() {
		window.eoxiaJS.popover.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.popover.event = function() {
		jQuery( document ).on( 'click', '.wpeo-popover-event.popover-click', window.eoxiaJS.popover.click );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.popover.click = function( event ) {
		window.eoxiaJS.popover.toggle( jQuery( this ) );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.popover.toggle = function( element ) {
		var direction = ( element.data( 'direction' ) ) ? element.data( 'direction' ) : 'top';
		var el = jQuery( '<span class="wpeo-popover popover-' + direction + '">' + element.attr( 'aria-label' ) + '</span>' );
		var pos = element.position();
		var offset = element.offset();

		if ( element[0].popoverElement ) {
			jQuery( element[0].popoverElement ).remove();
			delete element[0].popoverElement;
		} else {
			element[0].popoverElement = el;
			jQuery( 'body' ).append( element[0].popoverElement );

			if ( element.data( 'color' ) ) {
				el.addClass( 'popover-' + element.data( 'color' ) );
			}

			var top = 0;
			var left = 0;

			switch( element.data( 'direction' ) ) {
				case 'left':
					top = ( offset.top - ( el.outerHeight() / 2 ) + ( element.outerHeight() / 2 ) ) + 'px';
					left = ( offset.left - el.outerWidth() - 10 ) + 3 + 'px';
					break;
				case 'right':
					top = ( offset.top - ( el.outerHeight() / 2 ) + ( element.outerHeight() / 2 ) ) + 'px';
					left = offset.left + element.outerWidth() + 8 + 'px';
					break;
				case 'bottom':
					top = ( offset.top + element.height() + 10 ) + 10 + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
				case 'top':
					top = offset.top - el.outerHeight() - 4  + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
				default:
					top = offset.top - el.outerHeight() - 4  + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
			}

			el.css( {
				'top': top,
				'left': left,
				'opacity': 1
			} );
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.popover.remove = function( element ) {
		if ( element[0].popoverElement ) {
			jQuery( element[0].popoverElement ).remove();
			delete element[0].popoverElement;
		}
	};
}
