/**
 * Initialise l'objet "risk_page" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.3
 */

window.eoxiaJS.digirisk.risk_page = {};

window.eoxiaJS.digirisk.risk_page.init = function() {
	window.eoxiaJS.digirisk.risk_page.event();
};

window.eoxiaJS.digirisk.risk_page.refresh = function() {
	autosize(document.querySelectorAll('textarea'));
};

window.eoxiaJS.digirisk.risk_page.event = function() {
	jQuery( document ).on( 'click', '.risk-page .save-all:not(.grey)', window.eoxiaJS.digirisk.risk_page.saveRisks );
	jQuery( document ).on( 'click', '.risk-page table tr input:not(input[type="checkbox"]), .risk-page .table-row .group-date, .risk-page .table-row .wpeo-dropdown .dropdown-toggle, .risk-page .table-row textarea, .risk-page .table-row .popup, .risk-page .table-row .action, .risk-page .cotation', window.eoxiaJS.digirisk.risk_page.checkTheCheckbox );
	jQuery( document ).on( 'click', '.risk-page .wp-digi-pagination a', window.eoxiaJS.digirisk.risk_page.pagination );
};

window.eoxiaJS.digirisk.risk_page.saveRisks = function( event ) {
	if ( event ) {
		event.preventDefault();
	}

	jQuery( '.risk-page .table-row .edit-risk.checked:first' ).click();
	jQuery( '.risk-page .save-all' ).addClass( 'button-disable' );
};

/**
 * Coches la case à cocher lors de l'action dans une ligne du tableau.
 *
 * @param  {ClickEvent} event L'état du clic.
 * @return {void}
 *
 * @since 6.2.3
 */
window.eoxiaJS.digirisk.risk_page.checkTheCheckbox = function( event ) {
	jQuery( this ).closest( 'tr, .table-row' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
	jQuery( this ).closest( 'tr, .table-row' ).find( '.edit-risk' ).addClass( 'checked' );
	jQuery( '.risk-page .save-all' ).removeClass( 'button-disable' );
};

window.eoxiaJS.digirisk.risk_page.savedRiskSuccess = function( Trigelement, response ) {
	Trigelement.closest( '.table-row' ).replaceWith( response.data.template );
	window.eoxiaJS.digirisk.risk_page.saveRisks();
};

/**
 * Gestion de la pagination des risques dans la page "Risques".
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 6.2.6
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
		window.eoxiaJS.digirisk.risk_page.refresh();
	} );
};
