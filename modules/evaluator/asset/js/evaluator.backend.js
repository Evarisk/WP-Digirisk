window.digirisk.evaluator = {};

window.digirisk.evaluator.init = function() {
	window.digirisk.evaluator.event();
};

window.digirisk.evaluator.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', window.digirisk.evaluator.set_time );
	// jQuery( document ).on ('click', '.wp-form-evaluator-to-assign input[type="submit"]', function( evt ) { window.digirisk.evaluator.add_evaluator } );
	// jQuery( document ).on ('click', '.wp-digi-list-evaluator .wp-digi-action-delete', function( evt ) { window.digirisk.evaluator.delete_evaluator } );
};

window.digirisk.evaluator.set_time = function(event) {
	var element = jQuery( this );
	element.closest( 'li' ).find( '.period-assign input' ).val( jQuery( '.wp-digi-evaluator-list .wp-digi-table-header input[type="text"]' ).val() );
};
