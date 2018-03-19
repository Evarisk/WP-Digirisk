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
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.evaluationMethodDropdown.selectSeuil = function( event ) {
	var element = jQuery( this );
	var level = element.data( 'level' );
	var methodEvaluationId = element.closest( 'tr' ).find( 'input.digi-method-simple' ).val();
	var div = element.closest( '.cotation-container' );

	div.find( '.dropdown-toggle span' ).html( element.text() );
	div.find( '.dropdown-toggle i' ).hide();
	element.closest( '.content' ).removeClass( 'active' );

	div.find( '.dropdown-toggle' )[0].className = div.find( '.dropdown-toggle' )[0].className.replace( /level[-1]?[0-4]/, 'level' + level );
	event.stopPropagation();

	element.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).removeClass( 'active' );

	element.closest( '.risk-row' ).find( 'input[name="evaluation_variables[' + element.data( 'evaluation-id' ) + ']"]' ).val( level );

	// Rend le bouton "active".
	if ( -1 != element.closest( 'tr' ).find( 'input.input-hidden-danger' ).val() ) {
		element.closest( 'tr' ).find( '.action .button.disable' ).removeClass( 'disable' ).addClass( 'blue' );
	}
};
