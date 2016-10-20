window.digirisk.user = {};

window.digirisk.user.init = function() {
	window.digirisk.user.event();
};

window.digirisk.user.event = function() {
	jQuery( document ).on ('click', '.wp-form-user-to-assign input[type="submit"]', window.digirisk.user.add );
	jQuery( document ).on ('click', '.wp-digi-list-affected-user .wp-digi-action-user-delete', window.digirisk.user.delete );
	jQuery( document ).on( 'click', '.wp-form-user-to-assign .wp-digi-pagination a', window.digirisk.user.pagination );
};


window.digirisk.user.add = function( event ) {
	event.preventDefault();

	jQuery( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

	jQuery( this ).closest( 'form' ).ajaxSubmit( function( response ) {
		window.digirisk.user.render( response );
	} );
};

window.digirisk.user.delete = function( event ) {
    event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
      jQuery( '.wp-digi-content' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_user',
        id: jQuery( this ).data( 'id' ),
        user_id: jQuery( this ).data( 'user-id' ),
        affectation_id: jQuery( this ).data( 'affectation-data-id' ),
      };

			jQuery.post( window.ajaxurl, data, function( response ) {
				window.digirisk.user.render( response );
			} );
    }
  };

window.digirisk.user.render = function( response ) {
	jQuery( '.wp-digi-content' ).removeClass( 'wp-digi-bloc-loading' );
	jQuery( '.wp-digi-content' ).html( response.data.template );
};

window.digirisk.user.pagination = function( event ) {
	event.preventDefault();

	jQuery( this ).closest( '.wp-digi-bloc-loader' ).addClass( 'wp-digi-bloc-loading' );

	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var next_page = href[1].replace('current_page=', '');
	var element_id = href[2].replace('element_id=', '');

	var data = {
		action: 'paginate_user',
		element_id: element_id,
		next_page: next_page
	};

	jQuery( '.wp-form-user-to-assign' ).load( window.ajaxurl, data, function() {
		jQuery( '.wp-form-user-to-assign' ).removeClass( 'wp-digi-bloc-loading' );
	} );
};
