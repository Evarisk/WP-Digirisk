window.digirisk.evaluation_method_evarisk = {};

window.digirisk.evaluation_method_evarisk.init = function() {
	window.digirisk.evaluation_method_evarisk.event();
};

window.digirisk.evaluation_method_evarisk.event = function() {
	jQuery( document ).on( 'click', '.popup.popup-evaluation tr td', window.digirisk.evaluation_method_evarisk.select_variable );
	jQuery( document ).on( 'click', '.popup.popup-evaluation .button.green', window.digirisk.evaluation_method_evarisk.close_modal );
	jQuery( document ).on( 'click', '.popup.popup-evaluation .close', window.digirisk.evaluation_method_evarisk.close_model_mask );
};

window.digirisk.evaluation_method_evarisk.select_variable = function( event ) {
	var element = jQuery( this );
	if ( '' !== element.data( 'seuil-id' ) ) {
		jQuery( '.popup.popup-evaluation tr td[data-variable-id="' + element.data( 'variable-id' ) + '"]' ).removeClass( 'active' );
		element.addClass( 'active' );
		jQuery( '.popup.popup-evaluation input.variable-' + element.data( 'variable-id' ) ).val( element.data( 'seuil-id' ) );
	}
};

window.digirisk.evaluation_method_evarisk.close_modal = function( event ) {
	var element = jQuery( this );

  var listVariable = {};
	var length = 0;

	var data = {
		action: 'get_scale',
		_wpnonce: element.data( 'nonce' ),
		list_variable: listVariable
	};

	element.closest( '.risk-row' ).find( '.popup.popup-evaluation:visible input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
		listVariable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		if ( '' !== jQuery( f ).val() ) {
			length++;
		}
	} );

	jQuery( '.wp-digi-risk-cotation-chooser' ).removeClass( 'active' );
	if ( 5 === length ) {
		element.closest( '.wp-digi-bloc-loader' ).addClass( 'wp-digi-bloc-loading' );
		jQuery.post( window.ajaxurl, data, function( response ) {
			element.closest( '.wp-digi-bloc-loader' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.popup.popup-evaluation' ).removeClass( 'active' );

			element.closest( '.risk-row' ).find( 'input.input-hidden-method-id' ).val( element.closest( '.popup.popup-evaluation' ).find( 'input.digi-method-evaluation-id' ).val() );

			element.closest( '.risk-row' ).find( '.cotation-container .action span' ).html( response.data.equivalence );
			element.closest( '.risk-row' ).find( '.cotation-container .action i' ).hide();

			element.closest( '.risk-row' ).find( '.cotation-container .action' )[0].className = element.closest( '.risk-row' ).find( '.cotation-container .action' )[0].className.replace( /level[0-4]/, 'level' + response.data.scale );
			element.closest( '.risk-row' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
		} );
	} else {
		jQuery( '.popup.popup-evaluation' ).removeClass( 'active' );
	}
	return false;
};

window.digirisk.evaluation_method_evarisk.close_model_mask = function( event ) {
	var element = jQuery( this );
	jQuery( '.popup.popup-evaluation' ).hide();

};
