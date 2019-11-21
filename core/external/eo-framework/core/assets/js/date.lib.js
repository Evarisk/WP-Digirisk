/**
 * @namespace EO_Framework_Date
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Handle date
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! window.eoxiaJS.date ) {

	/**
	 * [date description]
	 *
	 * @memberof EO_Framework_Date
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.date = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Date
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.date.init = function() {
		jQuery( document ).on ('click', '.group-date .date', function( e ) {
			var format = 'd/m/Y';
			var timepicker = false;

			if ( jQuery( this ).closest( '.group-date' ).data( 'time' ) ) {
				format += ' H:i:s';
				timepicker = true;
			}

			jQuery( this ).datetimepicker( {
				lang: 'fr',
				format: format,
				mask: true,
				timepicker: timepicker,
				closeOnDateSelect: true,
				onChangeDateTime : function(ct, $i) {
					if ( $i.closest( '.group-date' ).data( 'time' ) ) {
						$i.closest( '.group-date' ).find( '.mysql-date' ).val( ct.dateFormat('Y-m-d H:i:s') );
					} else {
						$i.closest( '.group-date' ).find( '.mysql-date' ).val( ct.dateFormat('Y-m-d') );
					}

					if ( $i.closest( '.group-date' ).attr( 'data-namespace' ) && $i.closest( '.group-date' ).attr( 'data-module' ) && $i.closest( '.group-date' ).attr( 'data-after-method' ) ) {
						window.eoxiaJS[$i.closest( '.group-date' ).attr( 'data-namespace' )][$i.closest( '.group-date' ).attr( 'data-module' )][$i.closest( '.group-date' ).attr( 'data-after-method' )]( $i );
					}
				}
			} ).datetimepicker( 'show' );
		});
	};
}
