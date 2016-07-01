"use strict"

jQuery( document ).ready( function () {
	digi_user.event();
} );


var digi_user = {
	old_affected_user: undefined,

	event: function() {
		jQuery( document ).on( 'keyup', '.wp-list-search input[name="user_name_affected"]', function() { digi_user.search_affected_user( jQuery( this ) ); } );
		jQuery( document ).on ('click', '.wp-form-user-to-assign input[type="submit"]', function( evt ) { digi_user.add_user( evt, jQuery( this ) ); } );
		jQuery( document ).on ('click', '.wp-digi-list-affected-user .wp-digi-action-delete', function( evt ) { digi_user.delete_user( evt, jQuery( this ) ); } );
	},

	search_affected_user: function( element ) {
		if ( digi_user.old_affected_user != jQuery( element ).val() ) {
			digi_user.old_affected_user = jQuery( element ).val();
			if ( jQuery( element ).val().length > 2 ) {
				var new_search = jQuery( element ).val();

				jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					jQuery( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
			else if ( jQuery( element ).val().length <= 0 ) {
				jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					jQuery( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
		}
	},

	add_user: function( event, element ) {
		event.preventDefault();

		jQuery( '.wp-digi-list-user' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
			jQuery( '.wp-digi-list-user' ).replaceWith( response.data.template );
		} );
	},

	delete_user: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
      jQuery( '.wp-digi-list-user' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_user',
        id: jQuery( element ).data( 'id' ),
        user_id: jQuery( element ).data( 'user-id' ),
        affectation_id: jQuery( element ).data( 'affectation-data-id' ),
      };

      jQuery.post( ajaxurl, data, function( response ) {
        jQuery( '.wp-digi-list-user' ).replaceWith( response.data.template );
      } );
    }
  }
};
