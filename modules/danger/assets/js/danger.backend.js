window.digirisk.danger = {};

window.digirisk.danger.init = function() {
	window.digirisk.danger.event();
};

window.digirisk.danger.event = function() {
	jQuery( document ).on( 'click', '.table.risk .categorie-container.danger .item', window.digirisk.danger.select_danger );
};

window.digirisk.danger.select_danger = function( event ) {
	var element = jQuery( this );
	element.closest( '.content' ).removeClass( 'active' );
	element.closest( 'tr' ).find( 'input.input-hidden-danger' ).val( element.data( 'id' ) );
	element.closest( 'tr' ).find( '.action span' ).hide();
	element.closest( 'tr' ).find( '.action img' ).show();
	element.closest( 'tr' ).find( '.action img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	element.closest( 'tr' ).find( '.action img' ).attr( 'srcset', '' );
	element.closest( 'tr' ).find( '.action img' ).attr( 'sizes', '' );
	event.stopPropagation();
};
