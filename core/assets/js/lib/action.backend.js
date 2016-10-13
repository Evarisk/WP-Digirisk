window.digirisk.action = {};

window.digirisk.action.init = function() {
	window.digirisk.action.event();
};

window.digirisk.action.event = function() {
  jQuery( '.wp-digi-societytree-main-container' ).on( 'click', '.wp-digi-action-delete', window.digirisk.action.delete );
};

window.digirisk.action.delete = function(event) {
  var element = jQuery( this );
  if ( window.confirm( window.digi_confirm_delete ) ) {
    element.get_data( function (data) {
      window.digirisk.request.send(element, data);
    } );
  }
};
