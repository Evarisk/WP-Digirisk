window.digirisk.DUER = {};

window.digirisk.DUER.init = function() {
	window.digirisk.DUER.event();
};

window.digirisk.DUER.event = function() {
};

window.digirisk.DUER.fill_textarea_in_popup = function( triggered_element, popup_element, event, args ) {
	if (args) {
		popup_element.find( 'h2' ).text( args.title );
		// On récupères le textarea caché avec le contenu actuel.
		var textarea_content = triggered_element.closest( '.wp-digi-list-item' ).find( '.textarea-content-' + args['src'] ).text();
		popup_element.find( 'textarea' ).val( textarea_content );
		popup_element.find( '.button-primary' ).attr( 'data-target', args['src'] );
	}
};

window.digirisk.DUER.set_textarea_content = function( triggered_element, event, args ) {
	if ( args && args['target'] ) {
		var textarea_content = jQuery( '.popup textarea' ).val();
		jQuery( '.textarea-content-' + args['target'] ).val( textarea_content );
		jQuery( '.span-content-' + args['target'] ).text( textarea_content );
	}
};
