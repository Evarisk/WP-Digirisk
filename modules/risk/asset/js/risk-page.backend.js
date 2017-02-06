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
	jQuery( document ).on( 'click', '.risk-page .save-all:not(.grey)', window.digirisk.risk_page.saveRisks );
	jQuery( document ).on( 'click', '.risk-page table tr input:not(input[type="checkbox"]), tr .toggle, tr textarea, tr .popup, tr .action', window.digirisk.risk_page.checkTheCheckbox );
};

window.digirisk.risk_page.saveRisks = function( event ) {
	if ( event ) {
		event.preventDefault();
	}

	jQuery( '.risk-page tr  .edit-risk.checked:first' ).click();
	jQuery( '.risk-page .save-all' ).removeClass( 'green' ).addClass( 'disable' );
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
	jQuery( '.risk-page .save-all' ).removeClass( 'disable' ).addClass( 'green' );
};

window.digirisk.risk_page.savedRiskSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
	window.digirisk.risk_page.saveRisks( undefined );
};
