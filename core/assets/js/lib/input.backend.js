window.eoxiaJS.digirisk.input = {};

window.eoxiaJS.digirisk.input.init = function() {
	window.eoxiaJS.digirisk.input.event();
};

window.eoxiaJS.digirisk.input.event = function() {
  jQuery( document ).on( 'keyup', '.digirisk-wrap .form-element input, .digirisk-wrap .form-element textarea', window.eoxiaJS.digirisk.input.keyUp );
};

window.eoxiaJS.digirisk.input.keyUp = function( event ) {
	if ( 0 < jQuery( this ).val().length ) {
		jQuery( this ).closest( '.form-element' ).addClass( 'active' );
	} else {
		jQuery( this ).closest( '.form-element' ).removeClass( 'active' );
	}
};
