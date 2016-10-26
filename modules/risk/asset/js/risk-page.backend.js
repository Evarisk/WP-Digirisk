window.digirisk.risk_page = {};

window.digirisk.risk_page.init = function() {
	window.digirisk.risk_page.event();
};

window.digirisk.risk_page.event = function() {
	jQuery( document ).on( 'click', '.risk-page .button-primary', window.digirisk.risk_page.send_all_risk );
};

window.digirisk.risk_page.send_all_risk = function(event) {
	event.preventDefault();
	jQuery( '.risk-page .wp-digi-action-edit' ).click();

}

window.digirisk.risk_page.save_risk_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).replaceWith( response.data.template );
}
