"use strict";

var digi_epi = {
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_epi.$ = $;
		if ( event || event === undefined ) {
			digi_epi.event();
		}
		this.old_date = digi_epi.$( '.wp-digi-epi-item-new input[name="epi_comment_date"]' ).val();
		this.old_cotation = digi_epi.$( '.wp-digi-epi-item-new .wp-digi-epi-level-new' ).html();
		if ( digi_epi.$( '.wp-digi-epi-item-new button' ).length > 0 ) {
			this.button = new window.ProgressButton( digi_epi.$( '.wp-digi-epi-item-new button' )[0], {
				callback: digi_epi.create_epi,
			} );
		}
	},

	event: function() {
		digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-delete', function( event ) { digi_epi.delete_epi( event, digi_epi.$( this ) ); } );
		digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-load', function( event ) { digi_epi.load_epi( event, digi_epi.$( this ) ); } );
		digi_epi.$( document ).on( 'click', '.wp-digi-epi .wp-digi-action-edit', function( event ) { digi_epi.edit_epi( event, digi_epi.$( this ) ); } );
	},

	create_epi: function( instance ) {
    var element = instance.button;

    digi_epi.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( digi_epi.$ ( element ).closest( 'form' ).find( 'input[name="method_evaluation_id"]' ).val() === 0 ) {
          digi_epi.$( element ).closest( 'form' ).find( '.wp-digi-epi-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( digi_epi.$ ( element ).closest( 'form' ).find( 'input[name="danger_id"]' ).val() === '' ) {
          digi_epi.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !digi_epi.$ ( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).val() ) {
          digi_epi.$( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          instance._stop(-1);
          return false;
        }

        digi_epi.$( element ).closest( 'form' ).find( '.wp-digi-epi-list-column-cotation' ).css( 'border', 'none' );
        digi_epi.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        digi_epi.$( element ).closest( 'form' ).find( 'input[name="epi_comment_date"]' ).css( 'border', 'none' );
				digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_epi.$( '.wp-digi-epi.wp-digi-list' ).replaceWith( response.data.template );
				digi_epi.reset_create_form();
        instance._stop(1);
			}
		} );

		return false;
	},

	delete_epi: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var epi_id = digi_epi.$( element ).data( 'id' );

  		digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-epi',
  			_wpnonce: digi_epi.$( element ).data( 'nonce' ),
  			global: digi_epi.$( element ).data( 'global' ),
  			epi_id: epi_id,
  		};

  		digi_epi.$.post( window.ajaxurl, data, function() {
  			digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_epi.$( '.wp-digi-list .wp-digi-list-item[data-epi-id="' + epi_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_epi: function( event, element ) {
		event.preventDefault();

    digi_epi.send_epi();

		var epi_id = digi_epi.$( element ).data( 'id' );
		digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-load-epi',
			_wpnonce: digi_epi.$( element ).data( 'nonce' ),
			global: digi_epi.$( element ).data( 'global' ),
			epi_id: epi_id,
		};

		digi_epi.$.post( window.ajaxurl, data, function( response ) {
      digi_epi.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_epi.$( '.wp-digi-epi .wp-digi-list-item[data-epi-id="' + epi_id + '"]' ).replaceWith( response.data.template );
			digi_epi.$( '.wp-digi-epi .wp-digi-list-item[data-epi-id="' + epi_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			digi_epi.$( '.wpdigi_date' ).datepicker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_epi: function( event, element ) {
		event.preventDefault();

		var epi_id = digi_epi.$( element ).data( 'id' );
		digi_epi.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		digi_epi.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_epi.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
        digi_epi.$( '.wp-digi-list-item .dashicons-edit' ).show();
				digi_epi.$( '.wp-digi-epi.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	send_epi: function() {
		digi_epi.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_epi.$( this ).find( '.dashicons-edit' ).click();
		} );
	},

	reset_create_form: function() {
		digi_epi.$( '.wp-digi-epi-item-new .wp-digi-epi-level-new' ).html( digi_epi.old_cotation );
		var element_cotation = digi_epi.$( '.wp-digi-epi-item-new .wp-digi-epi-list-column-cotation div' )[0];
		element_cotation.className = element_cotation.className.replace( /wp-digi-epi-level-[0-4]/, 'wp-digi-epi-level-0' );
		digi_epi.$( '.wp-digi-epi-item-new input[name="epi_evaluation_level"]').val( '' );
		digi_epi.$( '.wp-digi-epi-item-new input[name="digi_method"]').val( '' );
	}
};
