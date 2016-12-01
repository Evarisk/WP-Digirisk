window.digirisk.danger = {};

window.digirisk.danger.init = function() {
	window.digirisk.danger.event();
};

window.digirisk.danger.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-select-list li', window.digirisk.danger.select_danger );
};

window.digirisk.danger.select_danger = function( event ) {
	var element = jQuery( this );
	jQuery( '.wp-digi-risk input.input-hidden-danger' ).val( element.data( 'id' ) );
	jQuery( '.wp-digi-risk toggle span img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	jQuery( '.wp-digi-risk toggle span img' ).attr( 'srcset', "" );
	jQuery( '.wp-digi-risk toggle span img' ).attr( 'sizes', "" );
};
