window.digirisk.toggle = {};

window.digirisk.toggle.init = function() {
	window.digirisk.toggle.event();
};

window.digirisk.toggle.event = function() {
  jQuery( document ).on( 'click', 'toggle', window.digirisk.toggle.open );
  jQuery( document ).on( 'click', 'body', window.digirisk.toggle.close );
};

window.digirisk.toggle.open = function( event ) {
	var target = undefined;
  // Récupères la box de destination mis dans l'attribut du toggle
  if ( jQuery( this ).data( 'parent' ) ) {
	  target = jQuery( this ).closest( "." + jQuery( this ).data( 'parent' ) ).find( "." + jQuery( this ).data( 'target' ) );
	}
	else {
		target = jQuery( "." + jQuery( this ).data( 'target' ) );
	}

	if ( target ) {
	  target.toggle();
	  event.stopPropagation();
	}
};

window.digirisk.toggle.close = function( event ) {
  jQuery( '.digi-popup' ).hide();
}
