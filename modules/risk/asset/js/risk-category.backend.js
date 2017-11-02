/**
 * Initialise l'objet "riskCategory" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.4.0
 */
window.eoxiaJS.digirisk.riskCategory = {};

window.eoxiaJS.digirisk.riskCategory.init = function() {
	window.eoxiaJS.digirisk.riskCategory.event();
};

window.eoxiaJS.digirisk.riskCategory.event = function() {
	jQuery( document ).on( 'click', '.table .categorie-container.danger .item', window.eoxiaJS.digirisk.riskCategory.selectDanger );
};

/**
 * Lors du clic sur un riskCategory, remplaces le contenu du toggle et met l'image du risque sélectionné.
 *
 * @param  {MouseEvent} event [description]
 * @return {void}
 *
 * @since 6.0.0
 * @version 6.4.0
 */
window.eoxiaJS.digirisk.riskCategory.selectDanger = function( event ) {
	var element = jQuery( this );
	var data = {};
	element.closest( '.content' ).removeClass( 'active' );
	element.closest( 'tr' ).find( 'input.input-hidden-danger' ).val( element.data( 'id' ) );
	element.closest( '.toggle' ).find( '.action span' ).hide();
	element.closest( '.toggle' ).find( '.action img' ).show();
	element.closest( '.toggle' ).find( '.action img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	element.closest( '.toggle' ).find( '.action img' ).attr( 'srcset', '' );
	element.closest( '.toggle' ).find( '.action img' ).attr( 'sizes', '' );
	element.closest( '.toggle' ).find( '.action img' ).attr( 'aria-label', element.closest( '.tooltip' ).attr( 'aria-label' ) );

	element.closest( '.row' ).find( '.categorie-container.tooltip' ).removeClass( 'active' );
	event.stopPropagation();

	// Rend le bouton "active".
	if ( -1 != element.closest( 'tr' ).find( 'input[name="risk[evaluation][scale]"]' ).val() ) {
		element.closest( 'tr' ).find( '.action .button.disable' ).removeClass( 'disable' ).addClass( 'blue' );
	}

	// Si aucune donnée est entrée, on lance la requête.
	if ( ! window.eoxiaJS.digirisk.riskCategory.haveDataInInput( element ) ) {

		data.action = 'check_predefined_danger';
		data._wpnonce = element.closest( '.toggle' ).data( 'nonce' );
		data.danger_id = element.data( 'id' );
		data.society_id = element.closest( '.row' ).find( 'input[name="parent_id"] ' ).val();

		jQuery( this ).closest( 'td' ).addClass( 'loading' );

		window.eoxiaJS.request.send( jQuery( this ).closest( '.toggle' ), data );
	}
};

window.eoxiaJS.digirisk.riskCategory.haveDataInInput = function( element ) {
	if ( -1 != element.closest( '.risk-row' ).find( 'input[name="risk[evaluation][scale]"]' ).val() ) {
		return true;
	}

	if ( '' != element.closest( '.risk-row' ).find( 'textarea[name="list_comment[0][content]"]' ).val() ) {
		return true;
	}

	return false;
};
