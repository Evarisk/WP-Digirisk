$(document).ready(function() {
	w3.includeHTML(function() {
		Prism.highlightAll();
	});

	$('.scroll-to').on('click', function() { // Au clic sur un élément
		var page = $(this).attr('href'); // Page cible
		var speed = 750; // Durée de l'animation (en ms)
		$('html, body').animate( { scrollTop: $(page).offset().top - 80 }, speed ); // Go
		return false;
	});

	$('body').on('click','#button-load', function() {
		setTimeoutClass( $(this), 'button-load' );
	});
	$('body').on('click','#button-success', function() {
		setTimeoutClass( $(this), 'button-success' );
	});
	$('body').on('click','#button-error', function() {
		setTimeoutClass( $(this), 'button-error' );
	});

	$('body').on('click','.box-animate-click', function() {
		setTimeoutClass( $(this), 'animate-on' );
	});

	$('body').on('click','.wpeo-dropdown', function() {
		$(this).toggleClass('dropdown-active');
	});

	$('body').on('click','#box-loader', function() {
		setTimeoutClass( $(this), 'wpeo-loader' );
	});

	$('body').on('click','#modal-opener', function() {
		$( '.wpeo-modal' ).addClass( 'modal-active' );
	});

	$('body').on('click','.modal-close', function() {
		$( '.wpeo-modal' ).removeClass( 'modal-active' );
	});

	$('body').on('click','#notification-opener', function() {
		$( '.wpeo-notification' ).addClass( 'notification-active' );
	});

	$('body').on('click','.notification-close', function() {
		$( '.wpeo-notification' ).removeClass( 'notification-active' );
	});

});

function setTimeoutClass( element, className ) {
	element.addClass( className );
	setTimeout( function() {
		element.removeClass( className );
	}, 2000 );
}
