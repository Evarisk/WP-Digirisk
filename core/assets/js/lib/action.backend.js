if ( ! window.eoxiaJS.action ) {
	window.eoxiaJS.action = {};

	window.eoxiaJS.action.init = function() {
		window.eoxiaJS.action.event();
	};

	window.eoxiaJS.action.event = function() {
		jQuery( document ).on( 'click', '.action-input:not(.no-action)', window.eoxiaJS.action.execInput );
		jQuery( document ).on( 'click', '.action-attribute:not(.no-action)', window.eoxiaJS.action.execAttribute );
		jQuery( document ).on( 'click', '.action-delete:not(.no-action)', window.eoxiaJS.action.execDelete );
	};

	window.eoxiaJS.action.execInput = function( event ) {
		var element = jQuery( this );
		var parentElement = element;
		var loaderElement = element;
		var listInput = undefined;
		var data = {};
		var i = 0;
		var doAction = true;
		var key = undefined;

		event.preventDefault();

		if ( element.attr( 'data-loader' ) ) {
			loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
		}

		if ( element.attr( 'data-parent' ) ) {
			parentElement = element.closest( '.' + element.attr( 'data-parent' ) );
		}

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-namespace' ) && element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( element.hasClass( '.grey' ) ) {
			doAction = false;
		}

		if ( doAction ) {
			loaderElement.addClass( 'loading' );

			listInput = window.eoxiaJS.arrayForm.getInput( parentElement );
			for ( i = 0; i < listInput.length; i++ ) {
				if ( listInput[i].name ) {
					data[listInput[i].name] = listInput[i].value;
				}
			}

			element.get_data( function( attrData ) {
				for ( key in attrData ) {
					data[key] = attrData[key];
				}

				window.eoxiaJS.request.send( element, data );
			} );
		}
	};

	window.eoxiaJS.action.execAttribute = function( event ) {
	  var element = jQuery( this );
		var doAction = true;
		var loaderElement = element;

		event.preventDefault();

		if ( element.data( 'loader' ) ) {
			loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
		}

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( element.hasClass( '.grey' ) ) {
			doAction = false;
		}

		if ( doAction ) {
			if ( jQuery( this ).attr( 'data-confirm' ) ) {
				if ( window.confirm( jQuery( this ).attr( 'data-confirm' ) ) ) {
					element.get_data( function( data ) {
						loaderElement.addClass( 'loading' );
						window.eoxiaJS.request.send( element, data );
					} );
				}
			} else {
				element.get_data( function( data ) {
					loaderElement.addClass( 'loading' );
					window.eoxiaJS.request.send( element, data );
				} );
			}
		}

		event.stopPropagation();
	};

	window.eoxiaJS.action.execDelete = function( event ) {
	  var element = jQuery( this );
		var doAction = true;
		var loaderElement = element;

		event.preventDefault();

		if ( element.attr( 'data-loader' ) ) {
			loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
		}

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-namespace' ) && element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( element.hasClass( '.grey' ) ) {
			doAction = false;
		}

		if ( doAction ) {
			if ( window.confirm( window.digi_confirm_delete ) ) {
				element.get_data( function( data ) {
					loaderElement.addClass( 'loading' );
					window.eoxiaJS.request.send( element, data );
				} );
			}
		}
	};
}
