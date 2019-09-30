/**
 * Initialise l'objet "evaluationMethodEvarisk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.evaluationMethodEvarisk = {};

window.eoxiaJS.digirisk.evaluationMethodEvarisk.init = function() {
	window.eoxiaJS.digirisk.evaluationMethodEvarisk.event();
};

window.eoxiaJS.digirisk.evaluationMethodEvarisk.event = function() {
	jQuery( document ).on( 'click', '.wpeo-modal.evaluation-method .wpeo-table.evaluation-method .table-cell.can-select', window.eoxiaJS.digirisk.evaluationMethodEvarisk.selectSeuil );
	jQuery( document ).on( 'click', '.wpeo-modal.evaluation-method .wpeo-button.button-main', window.eoxiaJS.digirisk.evaluationMethodEvarisk.save );
	jQuery( document ).on( 'click', '.wpeo-modal.evaluation-method .wpeo-button.button-secondary', window.eoxiaJS.digirisk.evaluationMethodEvarisk.close_modal );
};

window.eoxiaJS.digirisk.evaluationMethodEvarisk.selectSeuil = function( event ) {
	jQuery( this ).closest( '.table-row' ).find( '.active' ).removeClass( 'active' );
	jQuery( this ).addClass( 'active' );

	var element      = jQuery( this );
	var riskID       = element.data( 'id' );
	var seuil        = element.data( 'seuil' );
	var variableID   = element.data( 'variable-id' );
	var evaluationID = element.data( 'evaluation-id' );

	window.eoxiaJS.digirisk.evaluationMethod.updateInputVariables( riskID, evaluationID, variableID, seuil, jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' textarea' ) );

	var data = {
		action: 'get_scale',
		method_evaluation_id: evaluationID,
		variables: jQuery( '.wpeo-modal.modal-risk-' + riskID + ' textarea' ).val()
	};

	var currentVal    = JSON.parse(jQuery( '.wpeo-modal.modal-risk-' + riskID + ' textarea' ).val());
	var canGetDetails = true;
	for (var key in currentVal) {
		if (currentVal[key] == '') {
			canGetDetails = false;
		}
	}

	if ( jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .table-cell.active' ).length == 5 ) {
		if ( jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ).length ) {
			window.eoxiaJS.loader.display( jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ) );
			jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ).addClass( 'disabled' );
		}
		jQuery.post( window.ajaxurl, data, function( response ) {
			if ( response.data.details ) {
				if ( jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ).length ) {
					window.eoxiaJS.loader.remove( jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ) );
					jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .button-main' ).removeClass( 'disabled' );
				}
				jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .cotation' ).attr( 'data-scale', response.data.details.scale );
				jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .cotation span' ).text( response.data.details.equivalence );
				jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .wpeo-button.button-disable' ).removeClass( 'button-disable' ).addClass( 'button-main' );
			}
		} );
	}
};


window.eoxiaJS.digirisk.evaluationMethodEvarisk.save = function( event ) {
	var riskID       = jQuery( this ).data( 'id' );
	var evaluationID = jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' .digi-method-evaluation-id' ).val();
	var value        = jQuery( '.wpeo-modal.modal-active.modal-risk-' + riskID + ' textarea' ).val();

	jQuery( '.risk-row.edit[data-id="' + riskID + '"] textarea[name="evaluation_variables"]' ).val( value );
	jQuery( '.risk-row.edit[data-id="' + riskID + '"] input[name="evaluation_method_id"]' ).val( evaluationID );

	// On met à jour l'affichage de la cotation.
	jQuery( '.risk-row.edit[data-id="' + riskID + '"] .cotation:first' ).attr( 'data-scale', jQuery( '.wpeo-modal.modal-risk-' + riskID + ' .cotation' ).attr( 'data-scale' ) );
	jQuery( '.risk-row.edit[data-id="' + riskID + '"] .cotation:first span' ).text( jQuery( '.wpeo-modal.modal-risk-' + riskID + ' .cotation span' ).text() );

	window.eoxiaJS.digirisk.evaluationMethodEvarisk.close_modal( undefined, riskID );
};

window.eoxiaJS.digirisk.evaluationMethodEvarisk.close_modal = function( event, riskID ) {
	if ( ! riskID ) {
		riskID = jQuery( this ).data( 'id' );
	}

	jQuery( '.wpeo-modal.modal-active .modal-close' ).click();
};

window.eoxiaJS.digirisk.evaluationMethodEvarisk.fillVariables = function( element ) {
	element.attr( 'data-variables', element.closest( 'td' ).find( 'textarea[name="evaluation_variables"]' ).val() );
}
