"use strict";

var digi_chemical_product = {
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_chemical_product.$ = $;
		if ( event || event === undefined ) {
			digi_chemical_product.event();
		}
		this.old_date = digi_chemical_product.$( '.wp-digi-chemical_product-item-new input[name="chemical_product_comment_date"]' ).val();
		this.old_cotation = digi_chemical_product.$( '.wp-digi-chemical_product-item-new .wp-digi-chemical_product-level-new' ).html();
		if ( digi_chemical_product.$( '.wp-digi-chemical_product-item-new button' ).length > 0 ) {
			this.button = new window.ProgressButton( digi_chemical_product.$( '.wp-digi-chemical_product-item-new button' )[0], {
				callback: digi_chemical_product.create_chemical_product,
			} );
		}
	},

	event: function() {
		digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical_product .wp-digi-action-delete', function( event ) { digi_chemical_product.delete_chemical_product( event, digi_chemical_product.$( this ) ); } );
		digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical_product .wp-digi-action-load', function( event ) { digi_chemical_product.load_chemical_product( event, digi_chemical_product.$( this ) ); } );
		digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical_product .wp-digi-action-edit', function( event ) { digi_chemical_product.edit_chemical_product( event, digi_chemical_product.$( this ) ); } );
	},

	create_chemical_product: function( instance ) {
    var element = instance.button;

    digi_chemical_product.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( digi_chemical_product.$ ( element ).closest( 'form' ).find( 'input[name="method_evaluation_id"]' ).val() === 0 ) {
          digi_chemical_product.$( element ).closest( 'form' ).find( '.wp-digi-chemical_product-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( digi_chemical_product.$ ( element ).closest( 'form' ).find( 'input[name="danger_id"]' ).val() === '' ) {
          digi_chemical_product.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !digi_chemical_product.$ ( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).val() ) {
          digi_chemical_product.$( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          instance._stop(-1);
          return false;
        }

        digi_chemical_product.$( element ).closest( 'form' ).find( '.wp-digi-chemical_product-list-column-cotation' ).css( 'border', 'none' );
        digi_chemical_product.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        digi_chemical_product.$( element ).closest( 'form' ).find( 'input[name="chemical_product_comment_date"]' ).css( 'border', 'none' );
				digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_chemical_product.$( '.wp-digi-chemical_product.wp-digi-list' ).replaceWith( response.data.template );
				digi_chemical_product.reset_create_form();
        instance._stop(1);
			}
		} );

		return false;
	},

	delete_chemical_product: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var chemical_product_id = digi_chemical_product.$( element ).data( 'id' );

  		digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-chemical_product',
  			_wpnonce: digi_chemical_product.$( element ).data( 'nonce' ),
  			global: digi_chemical_product.$( element ).data( 'global' ),
  			chemical_product_id: chemical_product_id,
  		};

  		digi_chemical_product.$.post( window.ajaxurl, data, function() {
  			digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_chemical_product.$( '.wp-digi-list .wp-digi-list-item[data-chemical_product-id="' + chemical_product_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_chemical_product: function( event, element ) {
		event.preventDefault();

    digi_chemical_product.send_chemical_product();

		var chemical_product_id = digi_chemical_product.$( element ).data( 'id' );
		digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-load-chemical_product',
			_wpnonce: digi_chemical_product.$( element ).data( 'nonce' ),
			global: digi_chemical_product.$( element ).data( 'global' ),
			chemical_product_id: chemical_product_id,
		};

		digi_chemical_product.$.post( window.ajaxurl, data, function( response ) {
      digi_chemical_product.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_chemical_product.$( '.wp-digi-chemical_product .wp-digi-list-item[data-chemical_product-id="' + chemical_product_id + '"]' ).replaceWith( response.data.template );
			digi_chemical_product.$( '.wp-digi-chemical_product .wp-digi-list-item[data-chemical_product-id="' + chemical_product_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			digi_chemical_product.$( '.wpdigi_date' ).datchemical_productcker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_chemical_product: function( event, element ) {
		event.preventDefault();

		var chemical_product_id = digi_chemical_product.$( element ).data( 'id' );
		digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		digi_chemical_product.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
        digi_chemical_product.$( '.wp-digi-list-item .dashicons-edit' ).show();
				digi_chemical_product.$( '.wp-digi-chemical_product.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	send_chemical_product: function() {
		digi_chemical_product.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_chemical_product.$( this ).find( '.dashicons-edit' ).click();
		} );
	},

	reset_create_form: function() {
		digi_chemical_product.$( '.wp-digi-chemical_product-item-new .wp-digi-chemical_product-level-new' ).html( digi_chemical_product.old_cotation );
		var element_cotation = digi_chemical_product.$( '.wp-digi-chemical_product-item-new .wp-digi-chemical_product-list-column-cotation div' )[0];
		element_cotation.className = element_cotation.className.replace( /wp-digi-chemical_product-level-[0-4]/, 'wp-digi-chemical_product-level-0' );
		digi_chemical_product.$( '.wp-digi-chemical_product-item-new input[name="chemical_product_evaluation_level"]').val( '' );
		digi_chemical_product.$( '.wp-digi-chemical_product-item-new input[name="digi_method"]').val( '' );
	}
};
