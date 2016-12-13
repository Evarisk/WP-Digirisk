window.digirisk.handle_model = {};

window.digirisk.handle_model.init = function() {};

window.digirisk.handle_model.popup_historic_loaded = function( element, response ) {
	element.closest( '.block' ).find( '.popup .title' ).text( response.data.title );
	element.closest( '.block' ).find( '.popup .content' ).html( response.data.view );
};
