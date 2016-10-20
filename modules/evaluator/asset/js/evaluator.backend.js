window.digirisk.evaluator = {};

window.digirisk.evaluator.init = function() {
	window.digirisk.evaluator.event();
};

window.digirisk.evaluator.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', window.digirisk.evaluator.set_time );
};

window.digirisk.evaluator.set_time = function(event) {
	var element = jQuery( this );
	element.closest( 'li' ).find( '.period-assign input' ).val( jQuery( '.wp-digi-evaluator-list .wp-digi-table-header input[type="text"]' ).val() );
};

window.digirisk.evaluator.callback_edit_evaluator_assign_success = function( element, response ) {
	jQuery( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
};

window.digirisk.evaluator.callback_detach_evaluator_success = function( element, response ) {
	jQuery( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
};
