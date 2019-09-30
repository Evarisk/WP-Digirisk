/**
 * Initialise l'objet "evaluationMethodDropdown" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.evaluationMethodDropdown = {};

window.eoxiaJS.digirisk.evaluationMethodDropdown.init = function() {
	window.eoxiaJS.digirisk.evaluationMethodDropdown.event();
};

window.eoxiaJS.digirisk.evaluationMethodDropdown.event = function() {
	jQuery( document ).on( 'click', '.table.risk .dropdown-list li.dropdown-item:not(.open-popup)', window.eoxiaJS.digirisk.evaluationMethodDropdown.selectSeuil );
};

/**
 * Clique sur une des cotations simples.
 *
 * @param  {ClickEvent} event L'état du clic.
 * @return {void}
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.evaluationMethodDropdown.selectSeuil = function( event ) {
	var element      = jQuery( this );
	var riskID       = element.data( 'id' );
	var seuil        = element.data( 'seuil' );
	var variableID   = element.data( 'variable-id' );
	var evaluationID = element.data( 'evaluation-id' );

	jQuery( '.risk-row.edit[data-id="' + riskID + '"] .cotation-container .dropdown-toggle.cotation span' ).text( jQuery( this ).text() );
	jQuery( '.risk-row.edit[data-id="' + riskID + '"] .cotation-container .dropdown-toggle.cotation' ).attr( 'data-scale', seuil );


	if ( variableID && evaluationID && seuil ) {
		window.eoxiaJS.digirisk.evaluationMethod.updateInputVariables( riskID, evaluationID, variableID, seuil );
	}
};
