window.digirisk.action = {};

window.digirisk.action.init = function() {
	window.digirisk.action.event();
};

window.digirisk.action.event = function() {
  jQuery( '.wp-digi-societytree-main-container' ).on( 'click', '.action', window.digirisk.action.exec );
  jQuery( '.wp-digi-societytree-main-container' ).on( 'click', '.wp-digi-action-delete', window.digirisk.action.delete );
};

window.digirisk.action.exec = function(event) {
  var element = jQuery( this );

	if ( !element[0].getAttribute(' disabled' ) ) {
		element[0].setAttribute( 'disabled', true );
	  element.get_data( function ( data ) {
    	window.digirisk.request.send( element, data );
  	} );
	}
};

window.digirisk.action.delete = function(event) {
  var element = jQuery( this );

	if ( !element[0].getAttribute( 'disabled' ) ) {
  	if ( window.confirm( window.digi_confirm_delete ) ) {
			element[0].setAttribute( 'disabled', true );
	    element.get_data( function ( data ) {
	      window.digirisk.request.send( element, data );
	    } );
	  }
	}
};
