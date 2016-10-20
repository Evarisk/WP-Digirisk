window.digirisk.workunit = {};

window.digirisk.workunit.init = function() {
	window.digirisk.workunit.event();
};

window.digirisk.workunit.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-list-workunit span[data-action="load_society"]', window.digirisk.workunit.set_active );
};

window.digirisk.workunit.save_workunit = function( element, response ) {
	jQuery( '.wp-digi-societytree-left-container' ).removeClass( "wp-digi-bloc-loading" );
	jQuery( ".wp-digi-list-workunit" ).replaceWith( response.data.template );
	jQuery( ".wp-digi-workunit-" + response.data.id + " span[data-action='load_society']" ).click();
};

window.digirisk.workunit.set_active = function( event ) {
	jQuery( '.wp-digi-list-workunit li.active' ).removeClass( 'active' );
	jQuery( this ).closest( 'li' ).addClass( 'active' );
};
