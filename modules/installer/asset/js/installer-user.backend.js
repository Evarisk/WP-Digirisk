"use strict";

var digi_installer_user = {
	$: undefined,
	event: function($) {
		digi_installer_user.$ = $;
		digi_installer_user.$( document ).on( 'click', '.wpdigi-staff .add-staff', function( event ) { digi_installer_user.add_staff( event, digi_installer_user.$( this ) ); } );
    digi_installer_user.$( document ).on( 'click', '.wpdigi-staff .wp-digi-action-load', function( event ) { digi_installer_user.load_staff( event, digi_installer_user.$( this ) ); } );
    digi_installer_user.$( document ).on( 'click', '.wpdigi-staff .wp-digi-action-edit', function( event ) { digi_installer_user.edit_staff( event, digi_installer_user.$( this ) ); } );
    digi_installer_user.$( document ).on( 'click', '.wpdigi-staff .wp-digi-action-delete', function( event ) { digi_installer_user.delete_staff( event, digi_installer_user.$( this ) ); } );
  },

	add_staff: function( event, element ) {
		event.preventDefault();
		if( digi_installer_user.$( '.wpdigi-staff input[name="user[lastname]"]' ).val() !== '') {
			digi_installer_user.$( '.wp-digi-list-staff' ).addClass( 'wp-digi-bloc-loading' );
			digi_installer_user.$( '#wp-digi-form-add-staff' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !window.regex.validateEmail( digi_installer_user.$( '.wpdigi-staff input[name="user[email]"]' ).val() ) ) {
						digi_installer_user.$( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
					digi_installer_user.$( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
					digi_installer_user.$( '.wp-digi-list-staff' ).append( response.data.template );
					digi_installer_user.$( '.wpdigi-staff input[name="user[firstname]"]' ).val( "" );
					digi_installer_user.$( '.wpdigi-staff input[name="user[lastname]"]' ).val( "" );
					digi_installer_user.$( ".wpdigi-staff input[name='user[email]']" ).val( digi_installer_user.$( '.wpdigi-staff input[name="user[firstname]"]' ).val() + '.' + digi_installer_user.$( '.wpdigi-staff input[name="user[lastname]"]' ).val() + '@' + digi_installer_user.$( '.wpdigi-staff .input-domain-mail' ).val() );
					digi_installer_user.$( '.wpdigi-staff input[name="user[lastname]"]' ).focus();
				}
			} );
		}
	},

  load_staff: function( event, element ) {
    event.preventDefault();

		var user_id = digi_installer_user.$( element ).data( 'id' );
		digi_installer_user.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'load_user',
			_wpnonce: digi_installer_user.$( element ).data( 'nonce' ),
			user_id: user_id,
		};

		digi_installer_user.$.post( window.ajaxurl, data, function( response ) {
			digi_installer_user.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
		} );
  },

  edit_staff: function( event, element ) {
    var user_id = digi_installer_user.$( element ).closest( 'form' ).data( 'id' );
		if( digi_installer_user.$( element ).closest( 'form' ).find( 'input[name="option[user_info][lastname]"]' ).val() !== '') {
			digi_installer_user.$( element ).closest( 'form' ).addClass( 'wp-digi-bloc-loading' );
			digi_installer_user.$( element ).closest( 'form' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !window.regex.validateEmail( digi_installer_user.$( element ).closest( 'form' ).find( 'input[name="user[email]"]' ).val() ) ) {
						digi_installer_user.$( element ).closest( 'form' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
    			digi_installer_user.$( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
				}
			} );
		}
  },

  delete_staff: function( event, element ) {
    event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var user_id = digi_installer_user.$( element ).data( 'id' );

  		digi_installer_user.$( '.wp-digi-list-staff .wp-digi-list-item[data-id="'+ user_id +'"]' ).fadeOut();

  		var data = {
  			action: 'delete_user',
  			_wpnonce: digi_installer_user.$( element ).data( 'nonce' ),
  			user_id: user_id,
  		};

  		digi_installer_user.$.post( window.ajaxurl, data, function() {} );
    }
  }
};
