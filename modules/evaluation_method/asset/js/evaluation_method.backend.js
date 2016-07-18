"use strict"

var digi_evaluation_method = {
	event: function() {
    jQuery( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li', function( event ) { digi_evaluation_method.select_cotation( event, jQuery( this ) ); } );
  	jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', function( event ) { digi_evaluation_method.select_variable( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', function( event ) { digi_evaluation_method.close_modal( jQuery( this ) ); } );
  },

  select_cotation: function( event, element ) {
		event.preventDefault();

		var span = jQuery( element ).closest( "span" );
		var level = jQuery( element ).attr( 'data-level' );
		var method_evaluation_id = jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input.digi-method-simple' ).val();
		var div = span.find( 'div' );
		var div_element = div[0];
		div_element.className = div_element.className.replace( /wp-digi-risk-level-[0-4]/, 'wp-digi-risk-level-' + level );
		div.html( '' );

		jQuery( element ).closest( 'form' ).find( '.risk-level' ).val( level );
		jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="method_evaluation_id"]' ).val( method_evaluation_id );
  },

  select_variable: function( event, element ) {
		if ( jQuery( element ).data( 'seuil-id' ) != 'undefined' ) {
			jQuery( '.wpdigi-method-evaluation-render .row li[data-variable-id="' + jQuery( element ).data( 'variable-id' ) + '"]' ).removeClass( 'active' );
			jQuery( element ).addClass( 'active' );
			jQuery( '.wpdigi-method-evaluation-render input[name="variable[' + jQuery( element ).data( 'variable-id' ) + ']"]' ).val( jQuery( element ).data( 'seuil-id' ) );
		}
  },

  close_modal: function( element ) {
    var list_variable = {};
		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk:visible').find( 'input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
			list_variable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		} );

    var data = {
			action: 'get_scale',
      _wpnonce: jQuery( element ).data( 'nonce' ),
			list_variable: list_variable,
		};

		jQuery.post( ajaxurl, data, function( response ) {
      jQuery( '.wpdigi-method-evaluation-render' ).hide();

      jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="method_evaluation_id"]' ).val( jQuery( element ).closest( '.wpdigi-method-evaluation-render' ).find( 'input.digi-method-evaluation-id' ).val() );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-risk-level-new wp-digi-risk-level-' + response.data.scale );
      jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
    } );

  }
}
