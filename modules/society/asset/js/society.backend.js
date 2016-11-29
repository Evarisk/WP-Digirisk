window.digirisk.society = {};

window.digirisk.society.init = function() {
	window.digirisk.society.event();
};

window.digirisk.society.event = function() {
	jQuery( document ).on( 'keyup', 'input[name="title"]', window.digirisk.society.display_save_button );
};

window.digirisk.society.callback_load_society = function( element, response ) {
	jQuery( '.wp-digi-societytree-main-container' ).replaceWith( response.data.template );
}

window.digirisk.society.display_save_button = function( event ) {
	jQuery( this ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
	jQuery( this ).addClass( "active" );
	jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
}

window.digirisk.society.delete_success = function( event, response ) {
	jQuery( '.wp-digi-develop-list ul.parent:not(.sub-menu) span:first-child' ).click();
}
