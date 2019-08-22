/**
 * Initialise l'objet "riskCategory" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.riskCategory = {};

window.eoxiaJS.digirisk.riskCategory.init = function() {
	window.eoxiaJS.digirisk.riskCategory.event();
};

window.eoxiaJS.digirisk.riskCategory.event = function() {
	jQuery( document ).on( 'click', '.table .category-danger .item, .wpeo-table .category-danger .item', window.eoxiaJS.digirisk.riskCategory.selectDanger );
};

/**
 * Lors du clic sur un riskCategory, remplaces le contenu du toggle et met l'image du risque sélectionné.
 *
 * @param  {MouseEvent} event [description]
 * @return {void}
 *
 * @since 6.0.0
 * @version 7.0.0
 */
window.eoxiaJS.digirisk.riskCategory.selectDanger = function( event ) {
	var element = jQuery( this );
	var data = {};
	element.closest( '.content' ).removeClass( 'active' );
	element.closest( 'tr' ).find( 'input.input-hidden-danger' ).val( element.data( 'id' ) );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle span' ).hide();
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).show();
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'srcset', '' );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'sizes', '' );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'aria-label', element.closest( '.tooltip' ).attr( 'aria-label' ) );

	window.eoxiaJS.tooltip.remove( element.closest( '.risk-row' ).find( '.category-danger.wpeo-tooltip-event' ) );

	// Rend le bouton "active".
	if ( '{}' !== element.closest( '.risk-row' ).find( 'textarea[name="evaluation_variables"]' ).val() ) {
		element.closest( 'tr' ).find( '.action .wpeo-button.button-disable' ).removeClass( 'button-disable' );
	}

	// Si aucune donnée est entrée, on lance la requête.
	if ( element.data( 'is-preset' ) && ! window.eoxiaJS.digirisk.riskCategory.haveDataInInput( element ) ) {
		data.action = 'check_predefined_danger';
		data._wpnonce = element.closest( '.wpeo-dropdown' ).data( 'nonce' );
		data.danger_id = element.data( 'id' );
		data.society_id = element.closest( '.risk-row' ).find( 'input[name="parent_id"] ' ).val();

		window.eoxiaJS.loader.display( jQuery( this ).closest( 'table' ) );

		window.eoxiaJS.request.send( jQuery( this ).closest( '.wpeo-dropdown' ), data );
	}
};

window.eoxiaJS.digirisk.riskCategory.haveDataInInput = function( element ) {
	if ( '{}' != element.closest( '.risk-row' ).find( 'textarea[name="evaluation_variables"]' ).val() ) {
		return true;
	}

	if ( '' != element.closest( '.risk-row' ).find( 'textarea[name="list_comment[0][content]"]' ).val() ) {
		return true;
	}

	return false;
};
