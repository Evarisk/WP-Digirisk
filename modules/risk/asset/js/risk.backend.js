window.digirisk.risk = {};

window.digirisk.risk.init = function() {};

window.digirisk.risk.delete_success = function( element, response ) {
  element.closest( 'li' ).fadeOut();
}

window.digirisk.risk.load_success = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
	window.digirisk.date.init();
}

window.digirisk.risk.save_risk_success = function( element, response ) {
  jQuery( '.wp-digi-risk' ).replaceWith( response.data.template );
	window.digirisk.date.init();
}
