"use strict";

var digi_accident = {
	$: undefined,

	init: function( event, $ ) {
		digi_accident.$ = $;
		if ( event || event === undefined ) {
			digi_accident.event();
		}
	},

	event: function() {
		digi_accident.$( document ).on( 'click', '.form-accident .wp-digi-action-new', function( event ) { digi_accident.edit_accident( event, digi_accident.$( this ) ); } );
		digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-delete', function( event ) { digi_accident.delete_accident( event, digi_accident.$( this ) ); } );
		digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-load', function( event ) { digi_accident.load_accident( event, digi_accident.$( this ) ); } );
		// digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-edit', function( event ) { digi_accident.edit_accident( event, digi_accident.$( this ) ); } );
	},

	edit_accident: function( event, element ) {

    digi_accident.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
				digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_accident.$( '.wp-digi-accident.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	delete_accident: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var accident_id = digi_accident.$( element ).data( 'id' );

  		digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-accident',
  			_wpnonce: digi_accident.$( element ).data( 'nonce' ),
  			global: digi_accident.$( element ).data( 'global' ),
  			accident_id: accident_id,
  		};

  		digi_accident.$.post( window.ajaxurl, data, function() {
  			digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_accident.$( '.wp-digi-list .wp-digi-list-item[data-accident-id="' + accident_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_accident: function( event, element ) {
		event.preventDefault();

    digi_accident.send_accident();

		var accident_id = digi_accident.$( element ).data( 'id' );
		digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_accident',
			_wpnonce: digi_accident.$( element ).data( 'nonce' ),
			accident_id: accident_id,
		};

		digi_accident.$.post( window.ajaxurl, data, function( response ) {
      digi_accident.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_accident.$( '.wp-digi-accident .wp-digi-list-item[data-accident-id="' + accident_id + '"]' ).replaceWith( response.data.template );
		} );
	},

	send_accident: function() {
		digi_accident.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_accident.$( this ).find( '.dashicons-edit' ).click();
		} );
	}
};
