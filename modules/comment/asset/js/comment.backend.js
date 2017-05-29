window.eoxiaJS.digirisk.comment = {};

window.eoxiaJS.digirisk.comment.init = function() {
	window.eoxiaJS.digirisk.comment.event();
};

window.eoxiaJS.digirisk.comment.event = function() {};

window.eoxiaJS.digirisk.comment.delete_success = function( element, response ) {
	jQuery( element ).closest( 'li' ).fadeOut();
};

window.eoxiaJS.digirisk.comment.saved_comment_success = function( element, response ) {
	element.closest( '.comment-container' ).replaceWith( response.data.view );
};
