if ( ! window.eoxiaJS.date ) {

	window.eoxiaJS.date = {};

	window.eoxiaJS.date.init = function() {
		jQuery( document ).on( 'click', 'input.date', function( e ) {
			jQuery( this ).datetimepicker( {
				'lang': 'fr',
				'format': 'd/m/Y',
				timepicker: false
			} );
			jQuery( this ).datetimepicker( 'show' );
		} );

		jQuery( document ).on( 'click', 'input.date-time', function( e ) {
			jQuery( this ).datetimepicker( {
				'lang': 'fr'
			} ).datetimepicker( 'show' );
		} );

		jQuery( document ).on( 'click', '.group-date .date-time', function( e ) {
			jQuery( this ).closest( '.group-date' ).find( 'input[name="date"]' ).datetimepicker( {
				'lang': 'fr',
				onChangeDateTime: function( dp, $input ) {
					$input.closest( '.group-date' ).find( 'div' ).attr( 'aria-label', $input.val() );
					$input.closest( '.group-date' ).find( 'span' ).css( 'background', '#389af6' );
				}
			} ).datetimepicker( 'show' );
		} );
	};
}
