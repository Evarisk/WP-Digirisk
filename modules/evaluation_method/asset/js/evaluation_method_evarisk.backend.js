/**
 * Initialise l'objet "evaluationMethodEvarisk" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.evaluationMethodEvarisk = {};

window.digirisk.evaluationMethodEvarisk.init = function() {
	window.digirisk.evaluationMethodEvarisk.event();
};

window.digirisk.evaluationMethodEvarisk.event = function() {
	jQuery( document ).on( 'click', '.popup.popup-evaluation.active tr td', window.digirisk.evaluationMethodEvarisk.select_variable );
	jQuery( document ).on( 'click', '.popup.popup-evaluation.active .button.green', window.digirisk.evaluationMethodEvarisk.close_modal );
};

window.digirisk.evaluationMethodEvarisk.select_variable = function( event ) {
	var element = jQuery( this );
	if ( '' !== element.data( 'seuil-id' ) ) {
		jQuery( '.popup.popup-evaluation.active tr td[data-variable-id="' + element.data( 'variable-id' ) + '"]' ).removeClass( 'active' );
		element.addClass( 'active' );
		jQuery( '.popup.popup-evaluation.active input.variable-' + element.data( 'variable-id' ) ).val( element.data( 'seuil-id' ) );
	}
};

window.digirisk.evaluationMethodEvarisk.close_modal = function( event ) {
	var element = jQuery( this );

  var listVariable = {};
	var length = 0;

	var data = {
		action: 'get_scale',
		_wpnonce: element.data( 'nonce' ),
		list_variable: listVariable
	};

	element.closest( '.risk-row' ).find( '.popup.popup-evaluation:visible input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
		listVariable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		if ( '' !== jQuery( f ).val() ) {
			length++;
		}
	} );

	jQuery( '.cotation-container .content.active' ).removeClass( 'active' );
	if ( 5 === length ) {
		element.closest( '.risk-row' ).find( '.cotation' ).addClass( 'loading' );
		element.closest( '.risk-row' ).find( '.cotation-container.tooltip' ).removeClass( 'active' );

		jQuery.post( window.ajaxurl, data, function( response ) {
			element.closest( '.popup.popup-evaluation' ).removeClass( 'active' );

			element.closest( '.risk-row' ).find( 'input.input-hidden-method-id' ).val( element.closest( '.popup.popup-evaluation' ).find( 'input.digi-method-evaluation-id' ).val() );
			element.closest( '.risk-row' ).find( 'input[name="risk[evaluation][scale]"]' ).val( response.data.scale );

			element.closest( '.risk-row' ).find( '.cotation-container .action span' ).html( response.data.equivalence );
			element.closest( '.risk-row' ).find( '.cotation-container .action i' ).hide();
			element.closest( '.risk-row' ).find( '.cotation' ).removeClass( 'loading' );

			element.closest( '.risk-row' ).find( '.cotation-container .action' )[0].className = element.closest( '.risk-row' ).find( '.cotation-container .action' )[0].className.replace( /level[-1]?[0-4]/, 'level' + response.data.scale );
			element.closest( '.risk-row' ).find( 'input[name="risk_evaluation_level"]' ).val( response.data.scale );
		} );
	} else {
		jQuery( '.popup.popup-evaluation' ).removeClass( 'active' );
	}
	return false;
};
