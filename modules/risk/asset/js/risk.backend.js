window.digirisk.risk = {};

window.digirisk.risk.init = function() {};

window.digirisk.risk.delete_success = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

window.digirisk.risk.load_success = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
	window.digirisk.date.init();
};

window.digirisk.risk.before_save_risk = function( triggeredElement ) {

	// Remet à 0 les styles.
	triggeredElement.closest( '.risk-row' ).find( '.categorie-container.tooltip' ).removeClass( 'active' );
	triggeredElement.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).removeClass( 'active' );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.risk-row' ).find( 'input[name="risk[danger_id]"]' ).val() ) {
		triggeredElement.closest( '.risk-row' ).find( '.categorie-container.tooltip' ).addClass( 'active' );
		return false;
	}

	// Vérification de la cotation.
	if ( '-1' === triggeredElement.closest( '.risk-row' ).find( 'input[name="risk[evaluation][scale]"]' ).val() ) {
		triggeredElement.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).addClass( 'active' );
		return false;
	}

	return true;
};

window.digirisk.risk.save_risk_success = function( element, response ) {
	element.closest( 'table.risk' ).replaceWith( response.data.template );
	window.digirisk.date.init();
};
