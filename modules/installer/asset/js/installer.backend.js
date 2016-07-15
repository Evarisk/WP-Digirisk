"use strict"

jQuery( document ).ready( function () {
	digi_installer.event();
} );

var digi_installer = {
	event: function() {
		jQuery( document ).on( 'click', '.wpdigi-installer form input[type="button"]', function() { digi_installer.form_groupement( jQuery( this ) ); } );

		/** Ouvrir plus d'options */
		jQuery( document ).on( 'click', '.wpdigi-staff .more-option', function( event ) { digi_installer.toggle_form( event, jQuery( this ) ); } );

		jQuery( document ).on( 'keyup', '.wpdigi-staff .input-domain-mail', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
		jQuery( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][lastname]"]', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
		jQuery( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][firstname]"]', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wp-digi-action-save-domain-mail', function( event ) { digi_installer.save_domain_mail( event, jQuery( this ) ); } );

		/** Ajouter un personnel */
		jQuery( document ).on( 'click', '.wpdigi-staff .add-staff', function( event ) { digi_installer.add_staff( event, jQuery( this ) ); } );
    /** Modifier un personnel */
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-load', function( event ) { digi_installer.load_staff( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-edit', function( event ) { digi_installer.edit_staff( event, jQuery( this ) ); } );
    /** Supprimer un personnel */
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-delete', function( event ) { digi_installer.delete_staff( event, jQuery( this ) ); } );

		/** Enregister dernière étape */
		jQuery( document ).on( 'click', '.wpdigi-installer div:last a:last', function( event ) { digi_installer.save_last_step( event, jQuery( this ) ); } );

    jQuery( document ).on( 'click', '.btn-more-option', function( event) { digi_installer.toggle_form( event, jQuery( this ) ); } );
  },

	form_groupement: function( element ) {
		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				if ( jQuery( '.wpdigi-installer input[name="groupement[title]"]' ).val() === '' ) {
					jQuery( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', 'solid red 2px' );
					return false;
				}

				jQuery( element ).closest( 'div' ).addClass( "wp-digi-bloc-loading" );
				jQuery( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', '2px solid #272a35' );
			},
			'success': function( response ) {
				jQuery( element ).closest( 'div' ).hide();
				jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
				jQuery( '.wpdigi-installer ul.step li:first' ).removeClass( 'active' );
				jQuery( '.wpdigi-installer ul.step li:last' ).addClass( 'active' );

	      jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
	    }
		} );

  },

	add_staff: function( event, element ) {
		event.preventDefault();
		if( jQuery( '.wpdigi-staff input[name="option[user_info][lastname]"]' ).val() != '') {
			jQuery( '.wp-digi-list-staff' ).addClass( 'wp-digi-bloc-loading' );
			jQuery( '#wp-digi-form-add-staff' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !validateEmail( jQuery( '.wpdigi-staff input[name="user[email]"]' ).val() ) ) {
						jQuery( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
					jQuery( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
					jQuery( '.wp-digi-list-staff' ).append( response.data.template );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val( "" );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val( "" );
					jQuery( ".wpdigi-staff input[name='user[email]']" ).val( jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val() + '.' + jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val() + '@' + jQuery( '.wpdigi-staff .input-domain-mail' ).val() );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).focus();
				}
			} );
		}
	},

  load_staff: function( event, element ) {
    event.preventDefault();

		var user_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'load_user',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			user_id: user_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
		} );
  },

  edit_staff: function( event, element ) {
    var user_id = jQuery( element ).closest( 'form' ).data( 'id' );
		if( jQuery( element ).closest( 'form' ).find( 'input[name="option[user_info][lastname]"]' ).val() != '') {
			jQuery( element ).closest( 'form' ).addClass( 'wp-digi-bloc-loading' );
			jQuery( element ).closest( 'form' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !validateEmail( jQuery( element ).closest( 'form' ).find( 'input[name="user[email]"]' ).val() ) ) {
						jQuery( element ).closest( 'form' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
          jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
    			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
				}
			} );
		}
  },

  delete_staff: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var user_id = jQuery( element ).data( 'id' );

  		jQuery( '.wp-digi-list-staff .wp-digi-list-item[data-id="'+ user_id +'"]' ).fadeOut();

  		var data = {
  			action: 'delete_user',
  			_wpnonce: jQuery( element ).data( 'nonce' ),
  			user_id: user_id,
  		};

  		jQuery.post( ajaxurl, data, function() {} );
    }
  },

	toggle_form: function( event, element ) {
		event.preventDefault();
		jQuery( element ).find( '.dashicons' ).toggleClass( 'dashicons-plus dashicons-minus' );
		jQuery( element ).closest( 'div' ).find( 'ul:last' ).toggle();
		jQuery( '.wp-digi-add-staff-from-file' ).toggle();
	},

	keyp_update_email: function( event, element ) {
		jQuery( ".wpdigi-staff input[name='user[email]']" ).val( jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val() + '.' + jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val() + '@' + jQuery( '.wpdigi-staff .input-domain-mail' ).val() );

		if( event.keyCode == 13 ) {
			jQuery( ".wpdigi-staff .add-staff" ).click();
		}
	},

  save_domain_mail: function( event, element ) {
    event.preventDefault();

    var data = {
      action: 'save_domain_mail',
      _wpnonce: jQuery( element ).data( 'nonce' ),
      domain_mail: jQuery( element ).closest( '.form-element' ).find( 'input' ).val(),
    };

    jQuery.post( ajaxurl, data, function() { } );
  },

	save_last_step: function( event, element ) {
		jQuery( '.wpdigi-installer .dashicons-plus:last' ).click();
	},

  toggle_form: function( event, element ) {
    event.preventDefault();

    jQuery( element ).closest( 'form' ).find( '.form-more-option' ).toggle();
  }
};
