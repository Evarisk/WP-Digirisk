"use strict"

jQuery( document ).ready( function() {
  digi_evaluation_method.event();
} );

var digi_evaluation_method = {
	event: function() {
    jQuery( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li', function( event ) { digi_evaluation_method.select_cotation( event, jQuery( this ) ); } );
  	jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', function( event ) { digi_evaluation_method.select_variable( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', function( event ) { digi_evaluation_method.close_modal( jQuery( this ) ); } );
  },

  select_cotation: function( event, element ) {
    event.preventDefault();

    var current_level = jQuery( element ).closest( 'span' ).find( 'input[name="risk_evaluation_level"]' ).val();
    var new_level = jQuery( element ).data( 'risk-level' );
    jQuery( element ).closest( 'span' ).find( '.wp-digi-level'  ).removeClass( 'wp-digi-risk-level-' + current_level ).addClass( 'wp-digi-risk-level-' + new_level );
    jQuery( element ).closest( 'span' ).find( '.wp-digi-level'  ).html( jQuery( element ).data( 'risk-text' ) );
    jQuery( element ).closest( 'span' ).find( 'input[name="risk_evaluation_level"]' ).val( new_level );
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
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).html( response.data.equivalence );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-level wp-digi-risk-level-' + response.data.scale );
      jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
    } );

  }
}
