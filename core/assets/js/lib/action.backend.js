window.digirisk.action = {};

window.digirisk.action.init = function() {
	window.digirisk.action.event();
};

window.digirisk.action.event = function() {
  jQuery( document ).on( 'click', '.action-input', window.digirisk.action.exec_input );
  jQuery( document ).on( 'click', '.action-attribute', window.digirisk.action.exec_attribute );
  jQuery( document ).on( 'click', '.action-delete', window.digirisk.action.delete );
};

window.digirisk.action.exec_input = function( event ) {
  var element = jQuery( this );
	var key = undefined;
	var parent_element = element;

	if ( element.data( 'parent' ) ) {
			parent_element = element.closest( '.' + element.data( 'parent' ) );
	}

	var list_input = window.eva_lib.array_form.get_input( parent_element );
	var data = {};
	for (var i = 0; i < list_input.length; i++) {
		if ( list_input[i].name ) {
			data[list_input[i].name] = list_input[i].value;
		}
	}

	element.get_data( function( attrData ) {
		for ( key in attrData ) {
			data[key] = attrData[key];
		}

		window.digirisk.request.send( element, data );
	} );
};

window.digirisk.action.exec_attribute = function(event) {
  var element = jQuery( this );

	if ( !element[0].getAttribute(' disabled' ) ) {
		element[0].setAttribute( 'disabled', true );

		if ( jQuery( this ).data( 'confirm' ) ) {
			if ( window.confirm( jQuery( this ).data( 'confirm' ) ) ) {
				element.get_data( function ( data ) {
					window.digirisk.request.send( element, data );
				} );
			}
		}
		else {
			element.get_data( function ( data ) {
				window.digirisk.request.send( element, data );
			} );
		}
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
