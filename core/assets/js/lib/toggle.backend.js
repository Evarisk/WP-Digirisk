window.digirisk.toggle = {};

window.digirisk.toggle.init = function() {
	window.digirisk.toggle.event();
};

window.digirisk.toggle.event = function() {
  jQuery( document ).on( 'click', '.toggle:not(.disabled), .toggle:not(.disabled) i', window.digirisk.toggle.open );
  jQuery( document ).on( 'click', 'body', window.digirisk.toggle.close );
};

window.digirisk.toggle.open = function( event ) {
	var target = undefined;
	var elementToggle = jQuery( this );

	if ( elementToggle.is( 'i' ) ) {
		elementToggle = elementToggle.parent( '.toggle' );
	}

	jQuery( '.toggle .content.active' ).removeClass( 'active' );

	if ( elementToggle.data( 'parent' ) ) {
		target = elementToggle.closest( '.' + elementToggle.data( 'parent' ) ).find( '.' + elementToggle.data( 'target' ) );
	} else {
		target = jQuery( '.' + elementToggle.data( 'target' ) );
	}

	if ( target ) {
	  target.toggleClass( 'active' );
	  event.stopPropagation();
	}
};

window.digirisk.toggle.close = function( event ) {
	jQuery( '.toggle .content' ).removeClass( 'active' );
	event.stopPropagation();
};
