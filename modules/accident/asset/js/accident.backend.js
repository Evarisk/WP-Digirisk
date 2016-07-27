"use strict";

var digi_accident = {
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_accident.$ = $;
		if ( event || event === undefined ) {
			digi_accident.event();
		}
		this.old_date = digi_accident.$( '.wp-digi-accident-item-new input[name="accident_comment_date"]' ).val();
		this.old_cotation = digi_accident.$( '.wp-digi-accident-item-new .wp-digi-accident-level-new' ).html();
		if ( digi_accident.$( '.wp-digi-accident-item-new button' ).length > 0 ) {
			this.button = new window.ProgressButton( digi_accident.$( '.wp-digi-accident-item-new button' )[0], {
				callback: digi_accident.create_accident,
			} );
		}
	},

	event: function() {
		digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-delete', function( event ) { digi_accident.delete_accident( event, digi_accident.$( this ) ); } );
		digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-load', function( event ) { digi_accident.load_accident( event, digi_accident.$( this ) ); } );
		digi_accident.$( document ).on( 'click', '.wp-digi-accident .wp-digi-action-edit', function( event ) { digi_accident.edit_accident( event, digi_accident.$( this ) ); } );
	},

	create_accident: function( instance ) {
    var element = instance.button;

    digi_accident.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( digi_accident.$ ( element ).closest( 'form' ).find( 'input[name="method_evaluation_id"]' ).val() === 0 ) {
          digi_accident.$( element ).closest( 'form' ).find( '.wp-digi-accident-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( digi_accident.$ ( element ).closest( 'form' ).find( 'input[name="danger_id"]' ).val() === '' ) {
          digi_accident.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !digi_accident.$ ( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).val() ) {
          digi_accident.$( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          instance._stop(-1);
          return false;
        }

        digi_accident.$( element ).closest( 'form' ).find( '.wp-digi-accident-list-column-cotation' ).css( 'border', 'none' );
        digi_accident.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        digi_accident.$( element ).closest( 'form' ).find( 'input[name="accident_comment_date"]' ).css( 'border', 'none' );
				digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_accident.$( '.wp-digi-accident.wp-digi-list' ).replaceWith( response.data.template );
				digi_accident.reset_create_form();
        instance._stop(1);
			}
		} );

		return false;
	},

	delete_accident: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var accident_id = digi_accident.$( element ).data( 'id' );

  		digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-accident',
  			_wpnonce: digi_accident.$( element ).data( 'nonce' ),
  			global: digi_accident.$( element ).data( 'global' ),
  			accident_id: accident_id,
  		};

  		digi_accident.$.post( window.ajaxurl, data, function() {
  			digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_accident.$( '.wp-digi-list .wp-digi-list-item[data-accident-id="' + accident_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_accident: function( event, element ) {
		event.preventDefault();

    digi_accident.send_accident();

		var accident_id = digi_accident.$( element ).data( 'id' );
		digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-load-accident',
			_wpnonce: digi_accident.$( element ).data( 'nonce' ),
			global: digi_accident.$( element ).data( 'global' ),
			accident_id: accident_id,
		};

		digi_accident.$.post( window.ajaxurl, data, function( response ) {
      digi_accident.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_accident.$( '.wp-digi-accident .wp-digi-list-item[data-accident-id="' + accident_id + '"]' ).replaceWith( response.data.template );
			digi_accident.$( '.wp-digi-accident .wp-digi-list-item[data-accident-id="' + accident_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			digi_accident.$( '.wpdigi_date' ).dataccidentcker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_accident: function( event, element ) {
		event.preventDefault();

		var accident_id = digi_accident.$( element ).data( 'id' );
		digi_accident.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		digi_accident.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_accident.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
        digi_accident.$( '.wp-digi-list-item .dashicons-edit' ).show();
				digi_accident.$( '.wp-digi-accident.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	send_accident: function() {
		digi_accident.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_accident.$( this ).find( '.dashicons-edit' ).click();
		} );
	},

	reset_create_form: function() {
		digi_accident.$( '.wp-digi-accident-item-new .wp-digi-accident-level-new' ).html( digi_accident.old_cotation );
		var element_cotation = digi_accident.$( '.wp-digi-accident-item-new .wp-digi-accident-list-column-cotation div' )[0];
		element_cotation.className = element_cotation.className.replace( /wp-digi-accident-level-[0-4]/, 'wp-digi-accident-level-0' );
		digi_accident.$( '.wp-digi-accident-item-new input[name="accident_evaluation_level"]').val( '' );
		digi_accident.$( '.wp-digi-accident-item-new input[name="digi_method"]').val( '' );
	}
};
