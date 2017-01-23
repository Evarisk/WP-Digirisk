window.eoxiaJS.arrayForm = {};

window.eoxiaJS.arrayForm.init = function() {
	window.eoxiaJS.arrayForm.event();
};

window.eoxiaJS.arrayForm.event = function() {
	jQuery( document ).on( 'click', '.submit-fake-form', window.eoxiaJS.arrayForm.sendForm );
};

window.eoxiaJS.arrayForm.getInput = function( parent ) {
	return parent.find( 'input, textarea' );
};

window.eoxiaJS.arrayForm.getInputValue = function( input ) {
	switch ( input.getAttribute( 'type' ) ) {
		case 'checkbox':
			return input.checked;
			break;
		default:
			return input.value;
			break;
	}
};

window.eoxiaJS.arrayForm.sendForm = function( event ) {
	var element = jQuery( this );
	var parent = element.closest( '.form' );
	var listInput = window.eoxiaJS.arrayForm.getInput( parent );
	var data = {};
	var i = 0;

	event.preventDefault();

	for ( i = 0; i < listInput.length; i++ ) {
		if ( listInput[i].name ) {
			data[listInput[i].name] = window.eoxiaJS.arrayForm.get_input_value( listInput[i] );
		}
	}

	window.digirisk.request.send( element, data );
};
