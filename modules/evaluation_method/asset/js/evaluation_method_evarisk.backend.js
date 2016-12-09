window.digirisk.evaluation_method_evarisk = {};

window.digirisk.evaluation_method_evarisk.init = function() {
	window.digirisk.evaluation_method_evarisk.event();
};

window.digirisk.evaluation_method_evarisk.event = function() {
	jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', window.digirisk.evaluation_method_evarisk.select_variable );
	jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', window.digirisk.evaluation_method_evarisk.close_modal );
	jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .close', window.digirisk.evaluation_method_evarisk.close_model_mask );
};

window.digirisk.evaluation_method_evarisk.select_variable = function( event ) {
	var element = jQuery( this );
	if ( element.data( 'seuil-id' ) != 'undefined' ) {
		jQuery( '.wpdigi-method-evaluation-render .row li[data-variable-id="' + element.data( 'variable-id' ) + '"]' ).removeClass( 'active' );
		element.addClass( 'active' );
		jQuery( '.wpdigi-method-evaluation-render input.variable-' + element.data( 'variable-id' ) ).val( element.data( 'seuil-id' ) );
	}
};

window.digirisk.evaluation_method_evarisk.close_modal = function( event ) {
	var element = jQuery( this );

  var list_variable = {};
	var length = 0;
	jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk:visible').find( 'input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
		list_variable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		if ( jQuery( f ).val() !== '' ) {
			length++;
		}
	} );

  var data = {
		action: 'get_scale',
    _wpnonce: element.data( 'nonce' ),
		list_variable: list_variable,
	};

	jQuery( '.wp-digi-risk-cotation-chooser' ).hide();

	if ( length === 5 ) {
		element.closest( '.wp-digi-bloc-loader' ).addClass( 'wp-digi-bloc-loading' );
		jQuery.post( window.ajaxurl, data, function( response ) {
			element.closest( '.wp-digi-bloc-loader' ).removeClass( 'wp-digi-bloc-loading' );
      jQuery( '.wpdigi-method-evaluation-render' ).hide();

      element.closest( '.wp-digi-list-item' ).find( 'input.input-hidden-method-id' ).val( element.closest( '.wpdigi-method-evaluation-render' ).find( 'input.digi-method-evaluation-id' ).val() );
      element.closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-level-new' ).html( response.data.equivalence );
			element.closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-risk-level-new wp-digi-risk-level-' + response.data.scale );
      element.closest( '.wp-digi-list-item' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
    } );
	}
	else {
		jQuery( '.wpdigi-method-evaluation-render' ).hide();
	}
	return false;
};

window.digirisk.evaluation_method_evarisk.close_model_mask = function( event ) {
	var element = jQuery( this );
	jQuery( '.wpdigi-method-evaluation-render' ).hide();

};
