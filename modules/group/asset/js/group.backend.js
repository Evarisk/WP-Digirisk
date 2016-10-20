window.digirisk.group = {};

window.digirisk.group.init = function() {
	window.digirisk.group.event();
};

window.digirisk.group.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-duer-form-display', window.digirisk.group.display_form_duer );
};

window.digirisk.group.callback_create_group = function( element, response ) {
	jQuery( ".wp-digi-societytree-left-container" ).replaceWith( response.data.template_left );
	jQuery( ".wp-digi-societytree-right-container" ).html( response.data.template_right );
}

window.digirisk.group.display_form_duer = function( event ) {
	event.preventDefault();
	/**
	 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
	 */
	jQuery( ".wp-digi-societytree-right-container" ).addClass( "wp-digi-bloc-loading" );

	var data = {
		action: 'load_society',
		id: jQuery( this ).data( 'id' ),
		tab_to_display: 'digi-generate-sheet',
	};

	jQuery.post( window.ajaxurl, data, function( response ) {
		jQuery( ".wp-digi-societytree-right-container" ).html( response.data.template );
		jQuery( ".wp-digi-societytree-right-container" ).removeClass( "wp-digi-bloc-loading" );
	} );
};

window.digirisk.group.callback_generate_duer_success = function() {
	jQuery( '.wp-digi-global-sheet-tab .wp-digi-list-item[data-action="digi-sheet"]' ).click();
}
