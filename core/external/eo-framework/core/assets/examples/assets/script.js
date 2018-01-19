jQuery(document).ready(function() {
	w3.includeHTML(function() {
		Prism.highlightAll();
	});

	jQuery('.scroll-to').on('click', function() { // Au clic sur un élément
		var page = jQuery(this).attr('href'); // Page cible
		var speed = 750; // Durée de l'animation (en ms)
		jQuery('html, body').animate( { scrollTop: jQuery(page).offset().top - 80 }, speed ); // Go
		return false;
	});

	jQuery('body').on('click','#button-load', function() {
		setTimeoutClass( jQuery(this), 'button-load' );
	});
	jQuery('body').on('click','#button-success', function() {
		setTimeoutClass( jQuery(this), 'button-success' );
	});
	jQuery('body').on('click','#button-error', function() {
		setTimeoutClass( jQuery(this), 'button-error' );
	});

	jQuery('body').on('click','.box-animate-click', function() {
		setTimeoutClass( jQuery(this), 'animate-on' );
	});

	jQuery('body').on('click','#box-loader', function() {
		setTimeoutClass( jQuery(this), 'wpeo-loader' );
	});

	jQuery('body').on('click','#notification-opener', function() {
		jQuery( '.wpeo-notification' ).addClass( 'notification-active' );
	});

	jQuery('body').on('click','.notification-close', function() {
		jQuery( '.wpeo-notification' ).removeClass( 'notification-active' );
	});

});

function setTimeoutClass( element, className ) {
	element.addClass( className );
	setTimeout( function() {
		element.removeClass( className );
	}, 2000 );
}
