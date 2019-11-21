var eoMenu = {
	$,

	init: function( $ ) {
		eoMenu.$ = $;
		eoMenu.event();
	},

	event: function() {
		eoMenu.$( document ).on( 'click', '.nav-wrap .minimize-menu', eoMenu.handleMinimizeMenu );


		eoMenu.$( document ).on( 'click', '.current-site .wpeo-dropdown .dropdown-toggle', eoMenu.focusHeaderSearch );
		eoMenu.$( document ).on( 'keyup', '.search-item input', eoMenu.searchItems );

		eoMenu.$( document ).on( 'click', '.wpeo-screen-options .button-main', eoMenu.toggleScreenOptions );
	},

	handleMinimizeMenu: function (event) {
		if (eoMenu.$(this).find('i').hasClass('fa-arrow-left')) {
			eoMenu.$('.nav-wrap').addClass('wrap-reduce');
			eoMenu.$('.content-wrap').addClass('content-reduce');
			eoMenu.$(this).find('i').removeClass('fa-arrow-left').addClass('fa-arrow-right');
		} else {
			eoMenu.$('.nav-wrap').removeClass('wrap-reduce');
			eoMenu.$('.content-wrap').removeClass('content-reduce');
			eoMenu.$(this).find('i').addClass('fa-arrow-left').removeClass('fa-arrow-right');
		}

		event.preventDefault();
	},


	focusHeaderSearch: function (event) {
		jQuery( '.current-site .search-item input').focus()
	},

	searchItems: function (event) {
		var sites = jQuery( '#top-header .dropdown-sites a' );

		sites.show();

		for ( var i = 0; i < sites.length; i++ ) {
			if ( jQuery( sites[i] ).text().toLowerCase().indexOf( jQuery( this ).val().toLowerCase() ) == -1 ) {
				jQuery( sites[i] ).hide();
			}
		}
	},

	toggleScreenOptions: function( event ) {
		jQuery( this ).closest( '.wpeo-screen-options' ).find( '.content' ).slideToggle();
	}
};

jQuery( document ).ready(eoMenu.init);
