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
	var parentElement = element;
	var loaderElement = element;
	var listInput = undefined;
	var data = {};
	var i = 0;
	var doAction = true;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	if ( element.data( 'parent' ) ) {
		parentElement = element.closest( '.' + element.data( 'parent' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
		loaderElement.addClass( 'loading' );

		listInput = window.eva_lib.array_form.get_input( parentElement );
		for ( i = 0; i < listInput.length; i++ ) {
			if ( listInput[i].name ) {
				data[listInput[i].name] = listInput[i].value;
			}
		}

		element.get_data( function( attrData ) {
			for ( key in attrData ) {
				data[key] = attrData[key];
			}

			window.digirisk.request.send( element, data );
		} );
	}
};

window.digirisk.action.exec_attribute = function( event ) {
  var element = jQuery( this );
	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	if ( jQuery( this ).data( 'confirm' ) ) {
		if ( window.confirm( jQuery( this ).data( 'confirm' ) ) ) {
			element.get_data( function( data ) {
				loaderElement.addClass( 'loading' );
				window.digirisk.request.send( element, data );
			} );
		}
	} else {
		element.get_data( function( data ) {
			loaderElement.addClass( 'loading' );
			window.digirisk.request.send( element, data );
		} );
	}
};

window.digirisk.action.delete = function( event ) {
  var element = jQuery( this );

	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	if ( window.confirm( window.digi_confirm_delete ) ) {
		loaderElement.addClass( 'loading' );
		element.get_data( function( data ) {
			window.digirisk.request.send( element, data );
		} );
	}
};
