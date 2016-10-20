window.digirisk.evaluator = {};

window.digirisk.evaluator.init = function() {
	window.digirisk.evaluator.event();
};

window.digirisk.evaluator.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', window.digirisk.evaluator.set_time );
	jQuery( document ).on( 'click', '.wp-form-evaluator-to-assign .wp-digi-pagination a', window.digirisk.evaluator.pagination );
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

window.digirisk.evaluator.pagination = function( event ) {
	event.preventDefault();

	jQuery( this ).closest( '.wp-digi-bloc-loader' ).addClass( 'wp-digi-bloc-loading' );

	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var next_page = href[1].replace('current_page=', '');
	var element_id = href[2].replace('element_id=', '');

	var data = {
		action: 'paginate_evaluator',
		element_id: element_id,
		next_page: next_page
	};

	jQuery( '.wp-digi-content' ).load( window.ajaxurl, data, function() {} );
};
