window.digirisk.toggle = {};

window.digirisk.toggle.init = function() {
	window.digirisk.toggle.event();
};

window.digirisk.toggle.event = function() {
  jQuery( document ).on( 'click', 'toggle', window.digirisk.toggle.open );
  jQuery( document ).on( 'click', 'body', window.digirisk.toggle.close );
};

window.digirisk.toggle.open = function( event ) {
  // Récupères la box de destination mis dans l'attribut du toggle
  var target = jQuery( "." + jQuery( this ).data( 'target' ) );

  target.toggle();
  event.stopPropagation();
};

window.digirisk.toggle.close = function( event ) {
  jQuery( '.digi-popup' ).hide();
}
