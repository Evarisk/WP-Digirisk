window.digirisk.risk_page = {};

window.digirisk.risk_page.init = function() {
	window.digirisk.risk_page.event();
};

window.digirisk.risk_page.event = function() {
	jQuery( document ).on( 'click', '.risk-page .button', window.digirisk.risk_page.send_all_risk );

	jQuery( document ).on( 'click', '.wp-digi-list-item input:not(input[type="checkbox"]), .wp-digi-list-item toggle, .wp-digi-list-item textarea, .wp-digi-list-item .open-popup', window.digirisk.risk_page.check_the_checkbox );
};

window.digirisk.risk_page.send_all_risk = function(event) {
	if (event) {
		event.preventDefault();
	}

	jQuery( '.risk-page .wp-digi-list-item  .wp-digi-action-edit.checked:first' ).click();
}

window.digirisk.risk_page.check_the_checkbox = function(event) {
	jQuery( this ).closest( 'li.wp-digi-list-item' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
	jQuery( this ).closest( 'li.wp-digi-list-item' ).find( '.wp-digi-action-edit' ).addClass( 'checked' );
}

window.digirisk.risk_page.save_risk_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).replaceWith( response.data.template );
	window.digirisk.risk_page.send_all_risk(undefined);
}
