window.eva_lib.array_form = function() {
	window.eva_lib.array_form.init();
	window.eva_lib.array_form.event();
}

window.eva_lib.array_form.init = function() {};

window.eva_lib.array_form.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-table .wp-digi-list-item .wp-digi-action-edit', window.eva_lib.array_form.send_form );
};

window.eva_lib.array_form.get_input = function( parent ) {
	return parent.find('input');
};

window.eva_lib.array_form.send_form = function( event ) {
	var parent = jQuery( this ).closest( '.wp-digi-list-item' );
	var list_input = window.eva_lib.array_form.get_input( parent );

	var data = {};
	for (var i = 0; i < list_input.length; i++) {
		if ( list_input[i].name ) {
			data[list_input[i].name] = list_input[i].value;
		}
	}

	jQuery.post( window.ajaxurl, data, window.eva_lib.array_form.success, "json" )
};

window.eva_lib.array_form.success = function( response ) {
	console.log(response);
};

window.eva_lib.array_form.error = function() {
};
