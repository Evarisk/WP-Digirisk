"use strict";

var digi_evaluation_method = {
	$: undefined,
	event: function( $ ) {
		digi_evaluation_method.$ = $;
		digi_evaluation_method.$( document ).on( 'keyup', function( event ) { digi_evaluation_method.keyup( event, digi_evaluation_method.$( this ) ); } );
    digi_evaluation_method.$( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li', function( event ) { digi_evaluation_method.select_cotation( event, digi_evaluation_method.$( this ) ); } );
  	digi_evaluation_method.$( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', function( event ) { digi_evaluation_method.select_variable( event, digi_evaluation_method.$( this ) ); } );
    digi_evaluation_method.$( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', function( event ) { digi_evaluation_method.close_modal( digi_evaluation_method.$( this ) ); } );
		digi_evaluation_method.$( document ).on( 'click', '.wpdigi-method-evaluation-render .dashicons-no-alt', function( event ) { digi_evaluation_method.close_modal( digi_evaluation_method.$( '.wpdigi-method-evaluation-render .wp-digi-bton-fourth' ).click() ); } );
	},

	keyup: function( event, element ) {
		if ( event.keyCode == 27 ) {
			digi_evaluation_method.$( '.wpdigi-method-evaluation-render .dashicons-no-alt' ).click();
		}
	},

  select_cotation: function( event, element ) {
		event.preventDefault();

		var span = digi_evaluation_method.$( element ).closest( "span" );
		var level = digi_evaluation_method.$( element ).attr( 'data-level' );
		var method_evaluation_id = digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( 'input.digi-method-simple' ).val();
		var div = span.find( 'div' );
		var div_element = div[0];
		div_element.className = div_element.className.replace( /wp-digi-risk-level-[0-4]/, 'wp-digi-risk-level-' + level );
		div.html( digi_evaluation_method.$( element ).text() );

		digi_evaluation_method.$( element ).closest( 'form' ).find( '.risk-level' ).val( level );
		digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( 'input[name="method_evaluation_id"]' ).val( method_evaluation_id );
  },

  select_variable: function( event, element ) {
		if ( digi_evaluation_method.$( element ).data( 'seuil-id' ) != 'undefined' ) {
			digi_evaluation_method.$( '.wpdigi-method-evaluation-render .row li[data-variable-id="' + digi_evaluation_method.$( element ).data( 'variable-id' ) + '"]' ).removeClass( 'active' );
			digi_evaluation_method.$( element ).addClass( 'active' );
			digi_evaluation_method.$( '.wpdigi-method-evaluation-render input[name="variable[' + digi_evaluation_method.$( element ).data( 'variable-id' ) + ']"]' ).val( digi_evaluation_method.$( element ).data( 'seuil-id' ) );
		}
  },

  close_modal: function( element ) {
    var list_variable = {};
		var length = 0;
		digi_evaluation_method.$( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk:visible').find( 'input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
			list_variable[digi_evaluation_method.$( f ).attr( 'variable-id' )] = digi_evaluation_method.$( f ).val();
			if ( digi_evaluation_method.$( f ).val() !== '' ) {
				length++;
			}
		} );

    var data = {
			action: 'get_scale',
      _wpnonce: digi_evaluation_method.$( element ).data( 'nonce' ),
			list_variable: list_variable,
		};

		if ( length === 5 ) {
			digi_evaluation_method.$( element ).addClass( 'wp-digi-loading' );
			digi_evaluation_method.$.post( window.ajaxurl, data, function( response ) {
	      digi_evaluation_method.$( '.wpdigi-method-evaluation-render' ).hide();

	      digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( 'input[name="method_evaluation_id"]' ).val( digi_evaluation_method.$( element ).closest( '.wpdigi-method-evaluation-render' ).find( 'input.digi-method-evaluation-id' ).val() );
	      digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-level-new' ).html( response.data.equivalence );
				digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-risk-level-new wp-digi-risk-level-' + response.data.scale );
	      digi_evaluation_method.$( element ).closest( '.wp-digi-list-item' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
				digi_evaluation_method.$( element ).removeClass( 'wp-digi-loading' );
	    } );
		}
		else {
			digi_evaluation_method.$( '.wpdigi-method-evaluation-render' ).hide();
		}
		return false;
  }
};
