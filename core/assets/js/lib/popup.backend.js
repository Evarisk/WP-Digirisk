window.digirisk.popup = {};

window.digirisk.popup.init = function() {
	window.digirisk.popup.event();
};

window.digirisk.popup.event = function() {
  jQuery( document ).on( 'click', '.open-popup', window.digirisk.popup.open );
  jQuery( document ).on( 'click', '.digi-popup-propagation', window.digirisk.popup.stop );
  jQuery( document ).on( 'click', 'body', window.digirisk.popup.close );
};

window.digirisk.popup.open = function( event ) {
  // Récupères la box de destination mis dans l'attribut du popup
  var target = jQuery( this ).closest(  "." + jQuery( this ).data( 'parent' ) ).find( "." + jQuery( this ).data( 'target' ) );
	target.toggle();
  event.stopPropagation();
};

window.digirisk.popup.stop = function( event ) {
	event.stopPropagation();
};

window.digirisk.popup.close = function( event ) {
  jQuery( '.digi-popup' ).hide();
}
