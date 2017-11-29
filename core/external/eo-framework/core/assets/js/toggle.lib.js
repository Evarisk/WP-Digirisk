if ( ! window.eoxiaJS.toggle ) {
	window.eoxiaJS.toggle = {};

	window.eoxiaJS.toggle.init = function() {
		window.eoxiaJS.toggle.event();
	};

	window.eoxiaJS.toggle.event = function() {
	  jQuery( document ).on( 'click', '.toggle:not(.disabled), .toggle:not(.disabled) i', window.eoxiaJS.toggle.open );
	  jQuery( document ).on( 'click', 'body', window.eoxiaJS.toggle.close );
	};

	window.eoxiaJS.toggle.open = function( event ) {
		var target = undefined;
		var data = {};
		var i = 0;
		var listInput = undefined;
		var key = undefined;
		var elementToggle = jQuery( this );

		if ( elementToggle.is( 'i' ) ) {
			elementToggle = elementToggle.parents( '.toggle' );
		}

		jQuery( '.toggle .content.active' ).removeClass( 'active' );
		jQuery( '.toggle' ).closest( '.mask' ).removeClass( 'mask' );

		if ( elementToggle.attr( 'data-parent' ) ) {
			target = elementToggle.closest( '.' + elementToggle.attr( 'data-parent' ) ).find( '.' + elementToggle.attr( 'data-target' ) );
		} else {
			target = jQuery( '.' + elementToggle.attr( 'data-target' ) );
		}

		if ( target ) {
			target.toggleClass( 'active' );

			if ( jQuery( event.currentTarget ).hasClass( 'toggle' ) ) {
				event.stopPropagation();
			}
		}

		if ( elementToggle.attr( 'data-mask' ) ) {
			target.closest( '.' + elementToggle.attr( 'data-mask' ) ).addClass( 'mask' );
		}

		if ( elementToggle.attr( 'data-action' ) ) {
			elementToggle.addClass( 'loading' );

			listInput = window.eoxiaJS.arrayForm.getInput( elementToggle );
			for ( i = 0; i < listInput.length; i++ ) {
				if ( listInput[i].name ) {
					data[listInput[i].name] = listInput[i].value;
				}
			}

			elementToggle.get_data( function( attrData ) {
				for ( key in attrData ) {
					data[key] = attrData[key];
				}

				window.eoxiaJS.request.send( elementToggle, data );
			} );
		}
	};

	window.eoxiaJS.toggle.close = function( event ) {
		jQuery( '.toggle .content' ).removeClass( 'active' );
		jQuery( '.toggle' ).closest( '.mask' ).removeClass( 'mask' );

		event.stopPropagation();
	};
}
