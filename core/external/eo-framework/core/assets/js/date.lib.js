/**
 * Handle date
 *
 * @since 1.0.0-easy
 * @version 1.1.0-easy
 */

if ( ! window.eoxiaJS.date ) {

	window.eoxiaJS.date = {};

	window.eoxiaJS.date.init = function() {
		jQuery( document ).on( 'click', '.group-date .date', function( e ) {
			jQuery( this ).closest( '.group-date' ).find( '.mysql-date' ).datetimepicker( {
				'lang': 'fr',
				'format': 'Y-m-d',
				timepicker: false,
				onChangeDateTime: function( dp, $input ) {
					$input.closest( '.group-date' ).find( '.date' ).val( window.eoxiaJS.date.convertMySQLDate( $input.val(), false ) );

					if ( $input.closest( '.group-date' ).attr( 'data-namespace' ) && $input.closest( '.group-date' ).attr( 'data-module' ) && $input.closest( '.group-date' ).attr( 'data-after-method' ) ) {
						window.eoxiaJS[$input.closest( '.group-date' ).attr( 'data-namespace' )][$input.closest( '.group-date' ).attr( 'data-module' )][$input.closest( '.group-date' ).attr( 'data-after-method' )]( $input );
					}
				}
			} ).datetimepicker( 'show' );
		} );

		jQuery( document ).on( 'click', '.group-date .date-time', function( e ) {
			jQuery( this ).closest( '.group-date' ).find( '.mysql-date' ).datetimepicker( {
				'lang': 'fr',
				'format': 'Y-m-d H:i:s',
				onChangeDateTime: function( dp, $input ) {
					if ( $input.closest( '.group-date' ).find( 'input[name="value_changed"]' ).length ) {
						$input.closest( '.group-date' ).find( 'input[name="value_changed"]' ).val( 1 );
					}
					$input.closest( '.group-date' ).find( '.date-time' ).val( window.eoxiaJS.date.convertMySQLDate( $input.val() ) );

					if ( $input.closest( '.group-date' ).attr( 'data-namespace' ) && $input.closest( '.group-date' ).attr( 'data-module' ) && $input.closest( '.group-date' ).attr( 'data-after-method' ) ) {
						window.eoxiaJS[$input.closest( '.group-date' ).attr( 'data-namespace' )][$input.closest( '.group-date' ).attr( 'data-module' )][$input.closest( '.group-date' ).attr( 'data-after-method' )]( $input );
					}

					$input.closest( '.group-date' ).find( 'div' ).attr( 'aria-label', window.eoxiaJS.date.convertMySQLDate( $input.val() ) );
					// $input.closest( '.group-date' ).find( 'span' ).css( 'background', '#389af6' );
				}
			} ).datetimepicker( 'show' );
		} );
	};

	window.eoxiaJS.date.convertMySQLDate = function( date, time = true ) {
		if ( ! time ) {
			date += ' 00:00:00';
		}
		var timestamp = new Date(date.replace(' ', 'T')).getTime();
		var d = new Date( timestamp );

		var day = d.getDate();
		if ( 1 === day.toString().length ) {
			day = '0' + day.toString();
		}

		var month = d.getMonth() + 1;
		if ( 1 === month.toString().length ) {
			month = '0' + month.toString();
		}

		if ( time ) {
			var hours = d.getHours();
			if ( 1 === hours.toString().length ) {
				hours = '0' + hours.toString();
			}

			var minutes = d.getMinutes();
			if ( 1 === minutes.toString().length ) {
				minutes = '0' + minutes.toString();
			}

			var seconds = d.getSeconds();
			if ( 1 === seconds.toString().length ) {
				seconds = '0' + seconds.toString();
			}

			return day + '/' + month + '/' + d.getFullYear() + ' ' + hours + ':' + minutes + ':' + seconds;
		} else {
			return day + '/' + month + '/' + d.getFullYear();
		}
	};
}
