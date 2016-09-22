"use strict";

var digi_epi = {
	$: undefined,

	init: function( event, $ ) {
		digi_epi.$ = $;
		if ( event || event === undefined ) {
			digi_epi.event();
		}
	},

	event: function() {
		digi_epi.$( document ).on( 'click', '.form-epi .wp-digi-action-new', function( event ) { digi_epi.edit_epi( event, digi_epi.$( this ) ); } );
		digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-delete', function( event ) { digi_epi.delete_epi( event, digi_epi.$( this ) ); } );
		digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-load', function( event ) { digi_epi.load_epi( event, digi_epi.$( this ) ); } );
		// digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-edit', function( event ) { digi_epi.edit_epi( event, digi_epi.$( this ) ); } );
	},

	edit_epi: function( event, element ) {

    digi_epi.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
				digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_epi.$( '.wp-digi-epi.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	delete_epi: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var epi_id = digi_epi.$( element ).data( 'id' );

  		digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-epi',
  			_wpnonce: digi_epi.$( element ).data( 'nonce' ),
  			global: digi_epi.$( element ).data( 'global' ),
  			epi_id: epi_id,
  		};

  		digi_epi.$.post( window.ajaxurl, data, function() {
  			digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_epi.$( '.wp-digi-list .wp-digi-list-item[data-epi-id="' + epi_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_epi: function( event, element ) {
		event.preventDefault();

    digi_epi.send_epi();

		var epi_id = digi_epi.$( element ).data( 'id' );
		digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_epi',
			_wpnonce: digi_epi.$( element ).data( 'nonce' ),
			epi_id: epi_id,
		};

		digi_epi.$.post( window.ajaxurl, data, function( response ) {
      digi_epi.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_epi.$( '.wp-digi-epi .wp-digi-list-item[data-epi-id="' + epi_id + '"]' ).replaceWith( response.data.template );
		} );
	},

	send_epi: function() {
		digi_epi.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_epi.$( this ).find( '.dashicons-edit' ).click();
		} );
	}
};
