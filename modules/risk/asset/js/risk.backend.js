"use strict";

var digi_risk = {
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_risk.$ = $;

		if ( event || event === undefined ) {
			window.digi_risk_comment.event( digi_risk.$ );
			window.digi_danger.init( event, digi_risk.$ );
			digi_risk.event();
		}

		this.old_date = digi_risk.$( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
		this.old_cotation = digi_risk.$( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html();
	},

	event: function() {
		digi_risk.$( document ).on( 'click', '.wp-digi-risk-item-new .wp-digi-action-new', function( event ) { digi_risk.create_risk( event, digi_risk.$( this ) ); } );
		digi_risk.$( document ).on( 'click', '.wp-digi-risk .wp-digi-action-delete', function( event ) { digi_risk.delete_risk( event, digi_risk.$( this ) ); } );
		digi_risk.$( document ).on( 'click', '.wp-digi-risk .wp-digi-action-load', function( event ) { digi_risk.load_risk( event, digi_risk.$( this ) ); } );
		digi_risk.$( document ).on( 'click', '.wp-digi-risk .wp-digi-action-edit', function( event ) { digi_risk.edit_risk( event, digi_risk.$( this ) ); } );
	},

	create_risk: function( event, element ) {
    digi_risk.$( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( digi_risk.$ ( element ).closest( 'form' ).find( 'input[name="method_evaluation_id"]' ).val() === '0' ) {
          digi_risk.$( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( digi_risk.$ ( element ).closest( 'form' ).find( 'input[name="danger_id"]' ).val() === '' ) {
          digi_risk.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !digi_risk.$ ( element ).closest( 'form' ).find( 'input[name="list_comment[0][comment_date]"]' ).val() ) {
          digi_risk.$( element ).closest( 'form' ).find( 'input[name="list_comment[0][comment_date]"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          return false;
        }

        digi_risk.$( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'none' );
        digi_risk.$( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        digi_risk.$( element ).closest( 'form' ).find( 'input[name="risk_comment_date"]' ).css( 'border', 'none' );
				digi_risk.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				digi_risk.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				digi_risk.$( '.wp-digi-content > :first-child' ).replaceWith( response.data.template );
				digi_risk.reset_create_form();
			}
		} );

		return false;
	},

	delete_risk: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var risk_id = digi_risk.$( element ).data( 'id' );

  		digi_risk.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-risk',
  			_wpnonce: digi_risk.$( element ).data( 'nonce' ),
  			global: digi_risk.$( element ).data( 'global' ),
  			risk_id: risk_id,
  		};

  		digi_risk.$.post( window.ajaxurl, data, function() {
  			digi_risk.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			digi_risk.$( '.wp-digi-list .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_risk: function( event, element ) {
		event.preventDefault();

    digi_risk.send_risk();

		var risk_id = digi_risk.$( element ).data( 'id' );
		digi_risk.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-load-risk',
			_wpnonce: digi_risk.$( element ).data( 'nonce' ),
			global: digi_risk.$( element ).data( 'global' ),
			risk_id: risk_id,
		};

		digi_risk.$.post( window.ajaxurl, data, function( response ) {
      digi_risk.$( '.wp-digi-list-item .dashicons-edit' ).hide();
			digi_risk.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			digi_risk.$( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).replaceWith( response.data.template );
			digi_risk.$( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			digi_risk.$( '.wpdigi_date' ).datepicker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_risk: function( event, element ) {
		event.preventDefault();

		var risk_id = digi_risk.$( element ).data( 'id' );
		digi_risk.$( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		digi_risk.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_risk.$( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
        digi_risk.$( '.wp-digi-list-item .dashicons-edit' ).show();
				digi_risk.$( '.wp-digi-content > :first-child' ).replaceWith( response.data.template );
			}
		} );
	},

	send_risk: function() {
		digi_risk.$( '.wp-digi-table-item-edit' ).each( function() {
			digi_risk.$( this ).find( '.dashicons-edit' ).click();
		} );
	},

	reset_create_form: function() {
		digi_risk.$( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html( digi_risk.old_cotation );

		var element_cotation = digi_risk.$( '.wp-digi-risk-item-new .wp-digi-risk-list-column-cotation div' )[0];
		element_cotation.className = element_cotation.className.replace( /wp-digi-risk-level-[0-4]/, 'wp-digi-risk-level-0' );

		digi_risk.$( '.wp-digi-risk-item-new input[name="risk_evaluation_level"]').val( '' );
		digi_risk.$( '.wp-digi-risk-item-new input[name="method_evaluation_id"]').val( '0' );

		window.digi_risk_comment.reset_create_form();
		window.digi_danger.reset_create_form();
	}
};
