"use strict"

jQuery( document ).ready( function () {
	digi_user.event();
} );


var digi_user = {
	old_affected_user,

	event: function() {
		jQuery( document ).on( 'keyup', '.wp-list-search input[name="user_name_affected"]', function() { digi_user.search_affected_user( jQuery( this ) ); } );
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
	}
};
