/**
 * @namespace EO_Framework_Tooltip
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.tooltip ) {

	/**
	 * [tooltip description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.tooltip = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tooltip.init = function() {
		window.eoxiaJS.tooltip.event();
	};

	window.eoxiaJS.tooltip.tabChanged = function() {
		jQuery( '.wpeo-tooltip' ).remove();
	}

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tooltip.event = function() {
		jQuery( document ).on( 'mouseenter', '.wpeo-tooltip-event:not([data-tooltip-persist="true"])', window.eoxiaJS.tooltip.onEnter );
		jQuery( document ).on( 'mouseleave', '.wpeo-tooltip-event:not([data-tooltip-persist="true"])', window.eoxiaJS.tooltip.onOut );
	};

	window.eoxiaJS.tooltip.onEnter = function( event ) {
		window.eoxiaJS.tooltip.display( jQuery( this ) );
	};

	window.eoxiaJS.tooltip.onOut = function( event ) {
		window.eoxiaJS.tooltip.remove( jQuery( this ) );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.tooltip.display = function( element ) {
		var direction = ( jQuery( element ).data( 'direction' ) ) ? jQuery( element ).data( 'direction' ) : 'top';
		var el = jQuery( '<span class="wpeo-tooltip tooltip-' + direction + '">' + jQuery( element ).attr( 'aria-label' ) + '</span>' );
		var pos = jQuery( element ).position();
		var offset = jQuery( element ).offset();
		jQuery( element )[0].tooltipElement = el;
		jQuery( 'body' ).append( jQuery( element )[0].tooltipElement );

		if ( jQuery( element ).data( 'color' ) ) {
			el.addClass( 'tooltip-' + jQuery( element ).data( 'color' ) );
		}

		var top = 0;
		var left = 0;

		switch( jQuery( element ).data( 'direction' ) ) {
			case 'left':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( element ).outerHeight() / 2 ) ) + 'px';
				left = ( offset.left - el.outerWidth() - 10 ) + 3 + 'px';
				break;
			case 'right':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( element ).outerHeight() / 2 ) ) + 'px';
				left = offset.left + jQuery( element ).outerWidth() + 8 + 'px';
				break;
			case 'bottom':
				top = ( offset.top + jQuery( element ).height() + 10 ) + 10 + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
			case 'top':
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
			default:
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
		}

		el.css( {
			'top': top,
			'left': left,
			'opacity': 1
		} );

		jQuery( element ).on("remove", function() {
			jQuery( jQuery( element )[0].tooltipElement ).remove();

		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.tooltip.remove = function( element ) {
		if ( jQuery( element )[0] && jQuery( element )[0].tooltipElement ) {
			jQuery( jQuery( element )[0].tooltipElement ).remove();
		}
	};
}
