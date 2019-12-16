window.eoxiaJS.digirisk.signature = {};

window.eoxiaJS.digirisk.signature.canvas;

window.eoxiaJS.digirisk.signature.init = function() {
	window.eoxiaJS.digirisk.signature.event();
};

window.eoxiaJS.digirisk.signature.event = function() {
	jQuery( document ).on( 'modal-opened', '.modal-signature', window.eoxiaJS.digirisk.signature.modalSignatureOpened );
};

window.eoxiaJS.digirisk.signature.modalSignatureOpened = function() {
	var ratio =  Math.max( window.devicePixelRatio || 1, 1 );

	window.eoxiaJS.digirisk.signature.canvas = document.querySelector('.modal-signature canvas' );

	window.eoxiaJS.digirisk.signature.canvas.signaturePad = new SignaturePad( window.eoxiaJS.digirisk.signature.canvas, {
		penColor: "rgb(66, 133, 244)"
	} );

	window.eoxiaJS.digirisk.signature.canvas.width = window.eoxiaJS.digirisk.signature.canvas.offsetWidth * ratio;
	window.eoxiaJS.digirisk.signature.canvas.height = window.eoxiaJS.digirisk.signature.canvas.offsetHeight * ratio;
	window.eoxiaJS.digirisk.signature.canvas.getContext( "2d" ).scale( ratio, ratio );
	window.eoxiaJS.digirisk.signature.canvas.signaturePad.clear();

	if ( jQuery( window.eoxiaJS.digirisk.signature.canvas ).closest( '.wpeo-modal' ).find( 'input.url' ).val() ) {
		window.eoxiaJS.digirisk.signature.canvas.signaturePad.fromDataURL( jQuery( window.eoxiaJS.digirisk.signature.canvas ).closest( '.wpeo-modal' ).find( 'input.url' ).val() );
	}
};

window.eoxiaJS.digirisk.signature.clearCanvas = function( event ) {
	var canvas = jQuery( this ).closest( '.wpeo-modal' ).find( 'canvas' );
	canvas[0].signaturePad.clear();
};

window.eoxiaJS.digirisk.signature.applySignature = function( triggeredElement ) {
	if ( ! triggeredElement.closest( '.wpeo-modal' ).find( 'canvas' )[0].signaturePad.isEmpty() ) {
		triggeredElement.closest( '.wpeo-modal' ).find( 'input[name="signature_data"]' ).val( triggeredElement.closest( '.wpeo-modal' ).find( 'canvas' )[0].toDataURL() );
	}

	return true;
};

window.eoxiaJS.digirisk.signature.savedSignatureSuccess = function( triggeredElement, response ) {
	jQuery( '.button-signature' ).replaceWith( response.data.view );
	jQuery( '.button-signature' ).trigger( 'saved-signature-success', triggeredElement, response );
	triggeredElement.closest( '.wpeo-modal' ).remove();

};
