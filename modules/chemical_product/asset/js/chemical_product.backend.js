"use strict";

var digi_chemical_product = {
	$: undefined,

	init: function( event, $ ) {
		digi_chemical_product.$ = $;
		if ( event || event === undefined ) {
			digi_chemical_product.event();
		}
	},

	event: function() {
		digi_chemical_product.$( document ).on( 'click', '.form-chemical-product .wp-digi-action-new', function( event ) { digi_chemical_product.edit_chemical_product( event, digi_chemical_product.$( this ) ); } );
		digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical-product .wp-digi-action-delete', function( event ) { digi_chemical_product.delete_chemical_product( event, digi_chemical_product.$( this ) ); } );
		digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical-product .wp-digi-action-load', function( event ) { digi_chemical_product.load_chemical_product( event, digi_chemical_product.$( this ) ); } );
		// digi_chemical_product.$( document ).on( 'click', '.wp-digi-chemical_product .wp-digi-action-edit', function( event ) { digi_chemical_product.edit_chemical_product( event, digi_chemical_product.$( this ) ); } );
	},

	edit_chemical_product: function( event, element ) {

    digi_chemical_product.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
				digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_chemical_product.$( '.wp-digi-chemical-product.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
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
  			digi_chemical_product.$( '.wp-digi-list .wp-digi-list-item[data-chemical-product-id="' + chemical_product_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_chemical_product: function( event, element ) {
		event.preventDefault();

    digi_chemical_product.send_chemical_product();

		var chemical_product_id = digi_chemical_product.$( element ).data( 'id' );
		digi_chemical_product.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_chemical_product',
			_wpnonce: digi_chemical_product.$( element ).data( 'nonce' ),
			chemical_product_id: chemical_product_id,
		};

		digi_chemical_product.$.post( window.ajaxurl, data, function( response ) {
      digi_chemical_product.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_chemical_product.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_chemical_product.$( '.wp-digi-chemical-product .wp-digi-list-item[data-chemical-product-id="' + chemical_product_id + '"]' ).replaceWith( response.data.template );
		} );
	},

	send_chemical_product: function() {
		digi_chemical_product.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_chemical_product.$( this ).find( '.dashicons-edit' ).click();
		} );
	}
};
