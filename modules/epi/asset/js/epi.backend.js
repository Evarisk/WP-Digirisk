"use strict";

window.digirisk.epi = {};

window.digirisk.epi.init = function() {
	window.digirisk.epi.event();
};

window.digirisk.epi.event = function() {};

window.digirisk.epi.save_epi_success = function( element, response ) {
  jQuery( '.wp-digi-epi' ).replaceWith( response.data.template );
}

window.digirisk.epi.load_epi_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).replaceWith( response.data.template );
}

window.digirisk.epi.delete_epi_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).fadeOut();
}
