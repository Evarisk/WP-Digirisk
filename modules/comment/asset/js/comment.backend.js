window.digirisk.comment = {};

window.digirisk.comment.init = function() {
	window.digirisk.comment.event();
};

window.digirisk.comment.event = function() {};
window.digirisk.comment.delete_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).fadeOut();
};
