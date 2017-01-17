/**
 * Initialise l'objet "risk_page" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.3.0
 * @version 6.2.4.0
 */

window.digirisk.risk_page = {};

window.digirisk.risk_page.init = function() {
	window.digirisk.risk_page.event();
};

window.digirisk.risk_page.event = function() {
	jQuery( document ).on( 'click', '.risk-page .button', window.digirisk.risk_page.send_all_risk );

	jQuery( document ).on( 'click', 'table tr input:not(input[type="checkbox"]), tr .toggle, tr textarea, tr .popup', window.digirisk.risk_page.checkTheCheckbox );
};

window.digirisk.risk_page.send_all_risk = function( event ) {
	if ( event ) {
		event.preventDefault();
	}

	jQuery( '.risk-page tr  .edit-risk.checked:first' ).click();
};

/**
 * Coches la case à cocher lors de l'action dans une ligne du tableau.
 *
 * @param  {ClickEvent} event L'état du clic.
 * @return {void}
 *
 * @since 6.2.3.0
 * @version 6.2.4.0
 */
window.digirisk.risk_page.checkTheCheckbox = function( event ) {
	jQuery( this ).closest( 'tr' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
	jQuery( this ).closest( 'tr' ).find( '.edit-risk' ).addClass( 'checked' );
};

window.digirisk.risk_page.savedRiskSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
	window.digirisk.risk_page.send_all_risk( undefined );
};
