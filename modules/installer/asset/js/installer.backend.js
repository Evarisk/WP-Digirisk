window.digirisk.installer = {};

window.digirisk.installer.init = function() {
	window.digirisk.installer.event();
};

window.digirisk.installer.event = function() {

};

window.digirisk.installer.save_society = function( element, response ) {
	element.closest( 'div' ).hide();
	jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
	jQuery( '.wpdigi-installer ul.step li:first' ).removeClass( 'active' );
	jQuery( '.wpdigi-installer ul.step li:last' ).addClass( 'active' );
  jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
};
