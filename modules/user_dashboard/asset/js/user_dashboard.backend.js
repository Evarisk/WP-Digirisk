"use strict";

var digi_user_dashboard = {
	$: undefined,
	event: function($) {
		digi_user_dashboard.$ = $;
		digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .add-staff', function( event ) { digi_user_dashboard.add_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-load', function( event ) { digi_user_dashboard.load_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-edit', function( event ) { digi_user_dashboard.edit_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-delete', function( event ) { digi_user_dashboard.delete_staff( event, digi_user_dashboard.$( this ) ); } );
  },

	add_staff: function( event, element ) {
		event.preventDefault();
		if( digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[lastname]"]' ).val() !== '') {
			digi_user_dashboard.$( '.wp-digi-list-staff' ).addClass( 'wp-digi-bloc-loading' );
			digi_user_dashboard.$( '#wp-digi-form-add-staff' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !window.regex.validateEmail( digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[email]"]' ).val() ) ) {
						digi_user_dashboard.$( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
					digi_user_dashboard.$( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
					digi_user_dashboard.$( '.wp-digi-list-staff' ).append( response.data.template );
					digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[firstname]"]' ).val( "" );
					digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[lastname]"]' ).val( "" );
					digi_user_dashboard.$( "#wp-digi-form-add-staff input[name='user[email]']" ).val( digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[firstname]"]' ).val() + '.' + digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[lastname]"]' ).val() + '@' + digi_user_dashboard.$( '#wp-digi-form-add-staff .input-domain-mail' ).val() );
					digi_user_dashboard.$( '#wp-digi-form-add-staff input[name="user[lastname]"]' ).focus();
				}
			} );
		}
	},

  load_staff: function( event, element ) {
    event.preventDefault();

		var user_id = digi_user_dashboard.$( element ).data( 'id' );
		digi_user_dashboard.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'load_user',
			_wpnonce: digi_user_dashboard.$( element ).data( 'nonce' ),
			user_id: user_id,
		};

		digi_user_dashboard.$.post( window.ajaxurl, data, function( response ) {
			digi_user_dashboard.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
		} );
  },

  edit_staff: function( event, element ) {
    var user_id = digi_user_dashboard.$( element ).closest( 'form' ).data( 'id' );
		if( digi_user_dashboard.$( element ).closest( 'form' ).find( 'input[name="option[user_info][lastname]"]' ).val() !== '') {
			digi_user_dashboard.$( element ).closest( 'form' ).addClass( 'wp-digi-bloc-loading' );
			digi_user_dashboard.$( element ).closest( 'form' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !window.regex.validateEmail( digi_user_dashboard.$( element ).closest( 'form' ).find( 'input[name="user[email]"]' ).val() ) ) {
						digi_user_dashboard.$( element ).closest( 'form' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
    			digi_user_dashboard.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
				}
			} );
		}
  },

  delete_staff: function( event, element ) {
    event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var user_id = digi_user_dashboard.$( element ).data( 'id' );

  		digi_user_dashboard.$( '.wp-digi-list-staff .wp-digi-list-item[data-id="'+ user_id +'"]' ).fadeOut();

  		var data = {
  			action: 'delete_user',
  			_wpnonce: digi_user_dashboard.$( element ).data( 'nonce' ),
  			user_id: user_id,
  		};

  		digi_user_dashboard.$.post( window.ajaxurl, data, function() {} );
    }
  }
};
