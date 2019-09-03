/**
 * Initialise l'objet "evaluationMethod" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 7.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.evaluationMethod = {};

window.eoxiaJS.digirisk.evaluationMethod.init = function() {
	window.eoxiaJS.digirisk.evaluationMethod.event();
};

window.eoxiaJS.digirisk.evaluationMethod.event = function() {};

window.eoxiaJS.digirisk.evaluationMethod.updateInputVariables = function( riskID, evaluationID, variableID, value, field ) {
	var updateEvaluationID = false;

	if ( ! field ) {
		updateEvaluationID = true;
		field = jQuery( '.risk-row.edit[data-id="' + riskID + '"] textarea[name="evaluation_variables"]' );
	}

	var currentVal = JSON.parse(field.val());

	currentVal[variableID] = value;

	field.val( JSON.stringify( currentVal ) );

	if ( updateEvaluationID ) {
		jQuery( '.risk-row.edit[data-id="' + riskID + '"] input[name="evaluation_method_id"]' ).val( evaluationID );
	}

	// Rend le bouton "active".
	if ( '-1' !== jQuery( '.risk-row.edit[data-id="' + riskID + '"]' ).find( 'input[name="risk_category_id"]' ).val() ) {
		jQuery( '.risk-row.edit[data-id="' + riskID + '"]' ).find( '.action .wpeo-button.button-disable' ).removeClass( 'button-disable' );
	}
};
