"use strict";

var digi_user_dashboard = {
	$: undefined,
	event: function($) {
		digi_user_dashboard.$ = $;
		digi_user_dashboard.email_event();

		digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .add-staff', function( event ) { digi_user_dashboard.edit_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-load', function( event ) { digi_user_dashboard.load_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-edit', function( event ) { digi_user_dashboard.edit_staff( event, digi_user_dashboard.$( this ) ); } );
    digi_user_dashboard.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-delete', function( event ) { digi_user_dashboard.delete_staff( event, digi_user_dashboard.$( this ) ); } );
  },

	email_event: function() {
		digi_user_dashboard.$( document ).on( 'keyup', '.user-dashboard .input-domain-mail', function( event ) { digi_user_dashboard.keyup_update_email( event, digi_user_dashboard.$( this ) ); } );
		digi_user_dashboard.$( document ).on( 'keyup', '.wp-digi-table-item-new input.lastname', function( event ) { digi_user_dashboard.keyup_update_email( event, digi_user_dashboard.$( this ) ); } );
		digi_user_dashboard.$( document ).on( 'keyup', '.wp-digi-table-item-new input.firstname', function( event ) { digi_user_dashboard.keyup_update_email( event, digi_user_dashboard.$( this ) ); } );
		digi_user_dashboard.$( document ).on( 'keyup', '.wp-digi-table-item-new input.email', function( event ) { digi_user_dashboard.key_enter_send_form( event, digi_user_dashboard.$( this ) ); } );
		digi_user_dashboard.$( document ).on( 'click', '.user-dashboard .wp-digi-action-save-domain-mail', function( event ) { digi_user_dashboard.save_domain_mail( event, digi_user_dashboard.$( this ) ); } );
	},

	keyup_update_email: function( event, element ) {
		var email = digi_user_dashboard.$( ".wp-digi-table-item-new .email" ).val();
		var firstname = digi_user_dashboard.$( ".wp-digi-table-item-new .firstname" ).val();
		var lastname = digi_user_dashboard.$( ".wp-digi-table-item-new .lastname" ).val();
		var domain_mail = digi_user_dashboard.$( '.input-domain-mail' ).val();

		var together = window.digi_global.remove_diacritics(firstname + '.' + lastname + '@' + domain_mail).toLowerCase();

		digi_user_dashboard.$( ".wp-digi-table-item-new input.email" ).val( together );
		digi_user_dashboard.key_enter_send_form( event, element );
	},

	key_enter_send_form: function( event, element ) {
		if( event.keyCode == 13 ) {
			digi_user_dashboard.$( "#wp-digi-form-add-staff .add-staff" ).click();
		}
	},

  save_domain_mail: function( event, element ) {
    event.preventDefault();

		digi_user_dashboard.$( element ).closest( 'li' ).addClass( 'wp-digi-bloc-loading' );

    var data = {
      action: 'save_domain_mail',
      _wpnonce: digi_user_dashboard.$( element ).data( 'nonce' ),
      domain_mail: digi_user_dashboard.$( element ).closest( '.form-element' ).find( 'input' ).val(),
    };

    digi_user_dashboard.$.post( window.ajaxurl, data, function() {
			digi_user_dashboard.$( element ).closest( 'li' ).removeClass( 'wp-digi-bloc-loading' );
		} );
  },

	edit_staff: function( event, element ) {
		event.preventDefault();
		digi_user_dashboard.$( '#wp-digi-form-add-staff' ).ajaxSubmit( {
			beforeSubmit: function() {
				digi_user_dashboard.$( '.wp-digi-list-staff' ).addClass( 'wp-digi-bloc-loading' );
			},
			success: function( response ) {
				digi_user_dashboard.$( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
				digi_user_dashboard.$( '.wp-digi-list-staff' ).html( response.data.template );
				digi_user_dashboard.$( '.wp-digi-list-staff .wp-digi-table-item-new .lastname' ).focus();
			}
		} );
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
