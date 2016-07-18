"use strict"

var digi_user = {
	old_affected_user: undefined,

	event: function() {
		jQuery( document ).on( 'keyup', '.wp-list-search input[name="user_name_affected"]', function() { digi_user.search_affected_user( jQuery( this ) ); } );
		jQuery( document ).on ('click', '.wp-form-user-to-assign input[type="submit"]', function( evt ) { digi_user.add_user( evt, jQuery( this ) ); } );
		jQuery( document ).on ('click', '.wp-digi-list-affected-user .wp-digi-action-delete', function( evt ) { digi_user.delete_user( evt, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-form-user-to-assign .wp-digi-pagination a', function( event ) { digi_user.pagination( event, jQuery( this ) ); } );
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

		jQuery( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
			jQuery( '.wp-digi-content' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.wp-digi-content' ).html( response.data.template );
		} );
	},

	delete_user: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
      jQuery( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_user',
        id: jQuery( element ).data( 'id' ),
        user_id: jQuery( element ).data( 'user-id' ),
        affectation_id: jQuery( element ).data( 'affectation-data-id' ),
      };

      jQuery.post( ajaxurl, data, function( response ) {
				jQuery( '.wp-digi-content' ).removeClass( 'wp-digi-bloc-loading' );
				jQuery( '.wp-digi-content' ).html( response.data.template );
      } );
    }
  },

	pagination: function( event, element ) {
		event.preventDefault();

		var href = jQuery( element ).attr( 'href' ).split( '&' );
		var next_page = href[1].replace('current_page=', '');
		var element_id = href[2].replace('element_id=', '');

		var data = {
			action: 'paginate_user',
			element_id: element_id,
			next_page: next_page
		};

		jQuery( '.wp-form-user-to-assign' ).load( ajaxurl, data, function() {} );
	}
};
