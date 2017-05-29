/**
 * Initialise l'objet "setting" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.9.0
 */
window.eoxiaJS.digirisk.setting = {};

window.eoxiaJS.digirisk.setting.init = function() {
	window.eoxiaJS.digirisk.setting.event();
};

window.eoxiaJS.digirisk.setting.event = function() {
	jQuery( document ).on( 'click', '#digi-danger-preset .save-all:not(.grey)', window.eoxiaJS.digirisk.setting.savePresetRisks );
	jQuery( document ).on( 'click', '#digi-danger-preset table tr input:not(input[type="checkbox"]), #digi-danger-preset tr .toggle, #digi-danger-preset tr textarea, #digi-danger-preset tr .popup, #digi-danger-preset tr .action', window.eoxiaJS.digirisk.setting.checkTheCheckbox );
};

window.eoxiaJS.digirisk.setting.savePresetRisks = function( event ) {
	if ( event ) {
		event.preventDefault();
	}

	jQuery( '#digi-danger-preset tr  .edit-risk.checked:first' ).click();
	jQuery( '#digi-danger-preset .save-all' ).removeClass( 'green' ).addClass( 'disable' );
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
window.eoxiaJS.digirisk.setting.checkTheCheckbox = function( event ) {
	jQuery( this ).closest( 'tr' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
	jQuery( this ).closest( 'tr' ).find( '.edit-risk' ).addClass( 'checked' );
	jQuery( '#digi-danger-preset .save-all' ).removeClass( 'disable' ).addClass( 'green' );
};

window.eoxiaJS.digirisk.setting.savedRiskSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
	// window.eoxiaJS.digirisk.setting.savePresetRisks( undefined );
};
