window.digirisk.action = {};

window.digirisk.action.init = function() {
	window.digirisk.action.event();
};

window.digirisk.action.event = function() {
	jQuery( document ).on( 'click', '.action-input:not(.no-action)', window.digirisk.action.execInput );
	jQuery( document ).on( 'click', '.action-attribute:not(.no-action)', window.digirisk.action.execAttribute );
	jQuery( document ).on( 'click', '.action-delete:not(.no-action)', window.digirisk.action.execDelete );
};

window.digirisk.action.execInput = function( event ) {
	var element = jQuery( this );
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

		listInput = window.eoxiaJS.arrayForm.get_input( parentElement );
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

window.digirisk.action.execAttribute = function( event ) {
  var element = jQuery( this );
	var doAction = true;
	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
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
	}
};

window.digirisk.action.execDelete = function( event ) {
  var element = jQuery( this );
	var doAction = true;
	var loaderElement = element;

	if ( element.data( 'loader' ) ) {
		loaderElement = element.closest( '.' + element.data( 'loader' ) );
	}

	/** Méthode appelée avant l'action */
	if ( element.data( 'module' ) && element.data( 'before-method' ) ) {
		doAction = false;
		doAction = window.digirisk[element.data( 'module' )][element.data( 'before-method' )]( element );
	}

	if ( doAction ) {
		if ( window.confirm( 'Confirm delete ?' ) ) {
			element.get_data( function( data ) {
				window.digirisk.request.send( element, data );
			} );
		}
	}
};
