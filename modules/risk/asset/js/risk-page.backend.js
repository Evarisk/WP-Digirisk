/**
 * Initialise l'objet "risk_page" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.3.0
 * @version 6.2.4.0
 */

window.eoxiaJS.digirisk.risk_page = {};

window.eoxiaJS.digirisk.risk_page.init = function() {
	window.eoxiaJS.digirisk.risk_page.event();
};

window.eoxiaJS.digirisk.risk_page.event = function() {
	jQuery( document ).on( 'click', '.risk-page .save-all:not(.grey)', window.eoxiaJS.digirisk.risk_page.saveRisks );
	jQuery( document ).on( 'click', '.risk-page table tr input:not(input[type="checkbox"]), .risk-page tr .toggle, .risk-page tr textarea, .risk-page tr .popup, .risk-page tr .action', window.eoxiaJS.digirisk.risk_page.checkTheCheckbox );

	jQuery( document ).on( 'click', '.risk-page .wp-digi-pagination a', window.eoxiaJS.digirisk.risk_page.pagination );
};

window.eoxiaJS.digirisk.risk_page.saveRisks = function( event ) {
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
window.eoxiaJS.digirisk.risk_page.checkTheCheckbox = function( event ) {
	jQuery( this ).closest( 'tr' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
	jQuery( this ).closest( 'tr' ).find( '.edit-risk' ).addClass( 'checked' );
	jQuery( '.risk-page .save-all' ).removeClass( 'disable' ).addClass( 'green' );
};

window.eoxiaJS.digirisk.risk_page.savedRiskSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
	window.eoxiaJS.digirisk.risk_page.saveRisks( undefined );
};


/**
 * Gestion de la pagination des risques dans la page "Risques".
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.risk_page.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var nextPage = href[1].replace( 'current_page=', '' );

	jQuery( '.risk-page' ).addClass( 'loading' );

	var data = {
		action: 'paginate_risk',
		next_page: nextPage
	};

	event.preventDefault();

	jQuery.post( window.ajaxurl, data, function( view ) {
		jQuery( '.risk-page' ).replaceWith( view );
	} );
};
