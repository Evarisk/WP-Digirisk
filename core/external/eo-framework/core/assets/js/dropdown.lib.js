/**
 * Gestion du dropdown.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.dropdown  ) {
	window.eoxiaJS.dropdown = {};

	window.eoxiaJS.dropdown.init = function() {
		window.eoxiaJS.dropdown.event();
	};

	window.eoxiaJS.dropdown.event = function() {
		jQuery( document ).on( 'keyup', window.eoxiaJS.dropdown.keyup );
		jQuery( document ).on( 'click', '.wpeo-dropdown .dropdown-toggle:not(.disabled)', window.eoxiaJS.dropdown.open );
		jQuery( document ).on( 'click', 'body', window.eoxiaJS.dropdown.close );
	};

	window.eoxiaJS.dropdown.keyup = function( event ) {
		if ( 27 === event.keyCode ) {
			window.eoxiaJS.dropdown.close();
		}
	};

	window.eoxiaJS.dropdown.open = function( event ) {
		window.eoxiaJS.dropdown.close();

		var triggeredElement = jQuery( this );

		triggeredElement.closest( '.wpeo-dropdown' ).toggleClass( 'dropdown-active' );
		event.stopPropagation();
	};

	window.eoxiaJS.dropdown.close = function( event ) {
		jQuery( '.wpeo-dropdown.dropdown-active:not(.no-close)' ).each( function() {
			var toggle = jQuery( this );
			toggle.removeClass( 'dropdown-active' );
		});
	};
}
