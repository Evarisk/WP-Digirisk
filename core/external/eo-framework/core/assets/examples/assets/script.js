jQuery(document).ready(function() {
	w3.includeHTML(function() {
		Prism.highlightAll();
	});

	$(document).on("scroll", onScroll); /** Menu active au scroll */

	jQuery('.scroll-to').on('click', function() { // Au clic sur un élément
		$('#page-sidebar a').removeClass('active');
		$(this).addClass('active');

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

	/* Tab temporaire en attendant le framework */
	jQuery('body').on('click','.tab-element:not(.wpeo-dropdown)', function() {
		jQuery( this ).closest( '.wpeo-tab' ).find( '.tab-content' ).removeClass( 'tab-active' );
		jQuery( this ).closest( '.wpeo-tab' ).find( '.tab-element' ).removeClass( 'tab-active' );
		jQuery( this ).addClass( 'tab-active' );
		jQuery( this ).closest( '.wpeo-tab' ).find( '#' + jQuery(this).data('id') ).addClass( 'tab-active' );
	});

});

function setTimeoutClass( element, className ) {
	element.addClass( className );
	setTimeout( function() {
		element.removeClass( className );
	}, 2000 );
}

function onScroll(event) {
	var scrollPos = $(document).scrollTop();
	$('#page-sidebar a').each(function () {
		var currLink = $(this);
		var refElement = $(currLink.attr("href"));
		if (refElement && refElement.position() && refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
			$('#page-sidebar a').removeClass("active");
			$(currLink).addClass("active");
		}
		// else {
		// 	currLink.removeClass("active");
		// }
	});
}
