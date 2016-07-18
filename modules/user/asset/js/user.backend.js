"use strict";

var digi_user = {
	old_affected_user: undefined,
	$: undefined,

	event: function( $ ) {
		digi_user.$ = $;

		digi_user.$( document ).on( 'keyup', '.wp-list-search input[name="user_name_affected"]', function() { digi_user.search_affected_user( digi_user.$( this ) ); } );
		digi_user.$( document ).on ('click', '.wp-form-user-to-assign input[type="submit"]', function( evt ) { digi_user.add_user( evt, digi_user.$( this ) ); } );
		digi_user.$( document ).on ('click', '.wp-digi-list-affected-user .wp-digi-action-delete', function( evt ) { digi_user.delete_user( evt, digi_user.$( this ) ); } );
		digi_user.$( document ).on( 'click', '.wp-form-user-to-assign .wp-digi-pagination a', function( event ) { digi_user.pagination( event, digi_user.$( this ) ); } );
	},

	search_affected_user: function( element ) {
		if ( digi_user.old_affected_user != digi_user.$( element ).val() ) {
			digi_user.old_affected_user = digi_user.$( element ).val();
			if ( digi_user.$( element ).val().length > 2 ) {
				var new_search = digi_user.$( element ).val();

				digi_user.$( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					digi_user.$( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
			else if ( digi_user.$( element ).val().length <= 0 ) {
				digi_user.$( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					digi_user.$( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
		}
	},

	add_user: function( event, element ) {
		event.preventDefault();

		digi_user.$( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

		digi_user.$( element ).closest( 'form' ).ajaxSubmit( function( response ) {
			digi_user.render( response );
		} );
	},

	delete_user: function( event, element ) {
    event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
      digi_user.$( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_user',
        id: digi_user.$( element ).data( 'id' ),
        user_id: digi_user.$( element ).data( 'user-id' ),
        affectation_id: digi_user.$( element ).data( 'affectation-data-id' ),
      };

			digi_user.$.post( window.ajaxurl, data, function( response ) {
				digi_user.render( response );
			} );
    }
  },

	render: function( response ) {
		digi_user.$( '.wp-digi-content' ).removeClass( 'wp-digi-bloc-loading' );
		digi_user.$( '.wp-digi-content' ).html( response.data.template );
	},

	pagination: function( event, element ) {
		event.preventDefault();

		var href = digi_user.$( element ).attr( 'href' ).split( '&' );
		var next_page = href[1].replace('current_page=', '');
		var element_id = href[2].replace('element_id=', '');

		var data = {
			action: 'paginate_user',
			element_id: element_id,
			next_page: next_page
		};

		digi_user.$( '.wp-form-user-to-assign' ).load( window.ajaxurl, data, function() {} );
	}
};
