"use strict"

var digi_risk = {

	old_danger: undefined,
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,

	init: function( event ) {
		if ( event || event == undefined ) {
			digi_risk.event();
		}

		this.old_danger = jQuery( '.wp-digi-risk-item-new toggle' ).html();
		this.old_date = jQuery( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
		this.old_cotation = jQuery( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html();
		if ( jQuery( '.wp-digi-risk-item-new button' ).length > 0 ) {
				this.button = new ProgressButton( jQuery( '.wp-digi-risk-item-new button' )[0], {
					callback: digi_risk.create_risk,
				} );
		}
	},

	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-delete', function( event ) { digi_risk.delete_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-load', function( event ) { digi_risk.load_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-edit', function( event ) { digi_risk.edit_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk-item-new .wp-digi-select-list li', function( event ) { digi_risk.select_danger( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wp-digi-action-comment-delete', function( event ) { digi_risk.delete_comment( event, jQuery( this ) ); } );
	},

	create_risk: function( instance ) {
    var element = instance.button;

    jQuery( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( jQuery ( element ).closest( 'form' ).find( 'input[name="method_evaluation_id"]' ).val() == 0 ) {
          jQuery( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( jQuery ( element ).closest( 'form' ).find( 'input[name="danger_id"]' ).val() == '' ) {
          jQuery( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !jQuery ( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).val() ) {
          jQuery( element ).closest( 'form' ).find( 'input[name="comment_date[]"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          instance._stop(-1);
          return false;
        }

        jQuery( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'none' );
        jQuery( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        jQuery( element ).closest( 'form' ).find( 'input[name="risk_comment_date"]' ).css( 'border', 'none' );
				jQuery( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );
      },
			success: function( response ) {
				jQuery( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
				jQuery( '.wp-digi-risk.wp-digi-list' ).replaceWith( response.data.template );
				digi_risk.reset_create_form();
        instance._stop(1);
			}
		} );

		return false;
	},

	delete_risk: function( event, element ) {
		event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var risk_id = jQuery( element ).data( 'id' );

  		jQuery( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

  		var data = {
  			action: 'wpdigi-delete-risk',
  			_wpnonce: jQuery( element ).data( 'nonce' ),
  			global: jQuery( element ).data( 'global' ),
  			risk_id: risk_id,
  		};

  		jQuery.post( ajaxurl, data, function() {
  			jQuery( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
  			jQuery( '.wp-digi-list .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_risk: function( event, element ) {
		event.preventDefault();

    digi_risk.send_risk();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-load-risk',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			global: jQuery( element ).data( 'global' ),
			risk_id: risk_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
      jQuery( '.wp-digi-list-item .dashicons-edit' ).hide();
			jQuery( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).replaceWith( response.data.template );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			jQuery( '.wpdigi_date' ).datepicker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_risk: function( event, element ) {
		event.preventDefault();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-content' ).addClass( "wp-digi-bloc-loading" );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( '.wp-digi-content' ).removeClass( "wp-digi-bloc-loading" );
        jQuery( '.wp-digi-list-item .dashicons-edit' ).show();
				jQuery( '.wp-digi-risk.wp-digi-list' ).replaceWith( response.data.template );
			}
		} );
	},

	send_risk: function() {
		jQuery( '.wp-digi-table-item-edit' ).each( function() {
			jQuery( this ).find( '.dashicons-edit' ).click();
		} );
	},

	select_danger: function( event, element ) {
		jQuery( '.wp-digi-risk-item-new input[name="danger_id"]' ).val( jQuery( element ).data( 'id' ) );
		jQuery( '.wp-digi-risk-item-new toggle span' ).html( jQuery( element ).find( 'img' ).attr( 'title' ) );
	},

  delete_comment: function( event, element ) {
    if( confirm( digi_confirm_delete ) ) {
      var data = {
        action: 'delete_comment',
        _wpnonce: jQuery( element ).data( 'nonce' ),
        risk_id: jQuery( element ).data( 'risk-id' ),
        id: jQuery( element ).data( 'id' ),
      };

      jQuery( element ).closest( 'li' ).remove();

      jQuery.post( ajaxurl, data, function() {} );
    }
  },

	reset_create_form: function() {
		jQuery( '.wp-digi-risk-item-new toggle' ).html( digi_risk.old_danger );
		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html( digi_risk.old_cotation );

		var element_cotation = jQuery( '.wp-digi-risk-item-new .wp-digi-risk-list-column-cotation div' )[0];
		element_cotation.className = element_cotation.className.replace( /wp-digi-risk-level-[0-4]/, 'wp-digi-risk-level-0' );

		jQuery( '.wp-digi-risk-item-new input[name="danger_id"]').val( '' );
		jQuery( '.wp-digi-risk-item-new input[name="risk_evaluation_level"]').val( '' );
		jQuery( '.wp-digi-risk-item-new input[name="digi_method"]').val( '' );
	}
};
