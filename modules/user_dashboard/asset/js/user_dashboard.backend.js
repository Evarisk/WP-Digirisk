window.digirisk.user_dashboard = {}

window.digirisk.user_dashboard.init = function() {
	window.digirisk.user_dashboard.event();
};

window.digirisk.user_dashboard.event = function() {
	jQuery( document ).on( 'keyup', '.user-dashboard .input-domain-mail', window.digirisk.user_dashboard.keyup_update_email );
	jQuery( document ).on( 'keyup', '.wp-digi-table-item-new input.lastname', window.digirisk.user_dashboard.keyup_update_email );
	jQuery( document ).on( 'keyup', '.wp-digi-table-item-new input.firstname', window.digirisk.user_dashboard.keyup_update_email );
	jQuery( document ).on( 'keyup', '.wp-digi-table-item-new input.email', window.digirisk.user_dashboard.key_enter_send_form );
	jQuery( document ).on( 'click', '.user-dashboard .wp-digi-action-save-domain-mail', window.digirisk.user_dashboard.save_domain_mail );
};

window.digirisk.user_dashboard.save_domain_mail = function( event ) {
  event.preventDefault();
	var element = jQuery( this );

	element.closest( 'li' ).addClass( 'wp-digi-bloc-loading' );

  var data = {
    action: 'save_domain_mail',
    _wpnonce: element.data( 'nonce' ),
    domain_mail: element.closest( '.form-element' ).find( 'input' ).val(),
  };

  jQuery.post( window.ajaxurl, data, function() {
		element.closest( 'li' ).removeClass( 'wp-digi-bloc-loading' );
	} );
},

window.digirisk.user_dashboard.keyup_update_email = function( event ) {
	var email = jQuery( ".wp-digi-table-item-new .email" ).val();
	var firstname = jQuery( ".wp-digi-table-item-new .firstname" ).val();
	var lastname = jQuery( ".wp-digi-table-item-new .lastname" ).val();
	var domain_mail = jQuery( '.input-domain-mail' ).val();

	var together = window.digirisk.global.remove_diacritics(firstname + '.' + lastname + '@' + domain_mail).toLowerCase();

	jQuery( ".wp-digi-table-item-new input[name='email']" ).val( together );

	// Vérifie que l'évènement n'est pas déclenché dans le champ de texte du domaine de l'email.
	if ( "input-domain-mail" !== event.target.className ) {
		window.digirisk.user_dashboard.key_enter_send_form( event, jQuery( this ) );
	}
};

window.digirisk.user_dashboard.key_enter_send_form = function( event ) {
	if( event.keyCode == 13 ) {
		jQuery( ".wp-digi-list-staff .wp-digi-action-edit" ).click();
	}
};

window.digirisk.user_dashboard.delete_success = function( element, response ) {
  element.closest( 'li' ).fadeOut();
}

window.digirisk.user_dashboard.load_success = function( element, response ) {
  element.closest( 'li' ).replaceWith( response.data.template );
}

window.digirisk.user_dashboard.save_user_success = function( element, response ) {
  jQuery( '.wp-digi-list-staff' ).html( response.data.template );
}
