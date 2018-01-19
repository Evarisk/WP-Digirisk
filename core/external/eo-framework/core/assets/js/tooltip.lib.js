if ( ! window.eoxiaJS.tooltip ) {
	window.eoxiaJS.tooltip = {};

	window.eoxiaJS.tooltip.init = function() {
		window.eoxiaJS.tooltip.event();
	};

	window.eoxiaJS.tooltip.event = function() {
		jQuery( document ).on( 'mouseenter', '.wpeo-tooltip-event', window.eoxiaJS.tooltip.display );
		jQuery( document ).on( 'mouseleave', '.wpeo-tooltip-event', window.eoxiaJS.tooltip.remove );
	};

	window.eoxiaJS.tooltip.display = function( event ) {
		var direction = ( jQuery( this ).data( 'direction' ) ) ? jQuery( this ).data( 'direction' ) : 'top';
		var el = jQuery( '<span class="wpeo-tooltip tooltip-' + direction + '">' + jQuery( this ).attr( 'aria-label' ) + '</span>' );
		var pos = jQuery( this ).position();
		var offset = jQuery( this ).offset();
		jQuery( this )[0].tooltipElement = el;
		jQuery( 'body' ).append( jQuery( this )[0].tooltipElement );

		if ( jQuery( this ).data( 'color' ) ) {
			el.addClass( 'tooltip-' + jQuery( this ).data( 'color' ) );
		}

		var top = 0;
		var left = 0;

		switch( jQuery( this ).data( 'direction' ) ) {
			case 'left':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( this ).outerHeight() / 2 ) ) + 'px';
				left = ( offset.left - el.outerWidth() - 10 ) + 3 + 'px';
				break;
			case 'right':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( this ).outerHeight() / 2 ) ) + 'px';
				left = offset.left + jQuery( this ).outerWidth() + 8 + 'px';
				break;
			case 'bottom':
				top = ( offset.top + jQuery( this ).height() + 10 ) + 10 + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( this ).outerWidth() / 2 ) ) + 'px';
				break;
			case 'top':
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( this ).outerWidth() / 2 ) ) + 'px';
				break;
			default:
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( this ).outerWidth() / 2 ) ) + 'px';
				break;
		}

		el.css( {
			'top': top,
			'left': left,
			'opacity': 1
		} );
	};

	window.eoxiaJS.tooltip.remove = function( event ) {
		jQuery( jQuery( this )[0].tooltipElement ).remove();
	};
}
