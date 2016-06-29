"use strict"

jQuery( document ).ready( function() {
	digi_risk.init();
});


var digi_risk = {

	old_danger: undefined,
	old_date: undefined,
  button: undefined,
  old_cotation: undefined,

	init: function() {

		digi_risk.event();
		this.old_danger = jQuery( '.wp-digi-risk-item-new toggle' ).html();
		this.old_date = jQuery( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
		this.old_cotation = jQuery( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html();
		if ( jQuery( '.wp-digi-risk-item-new button' ).length > 0 ) {
		    this.button = new ProgressButton( jQuery( '.wp-digi-risk-item-new button' )[0], {
		      callback: digi_risk.create_risk,
		    } );
		}
	},

	tab_changed: function() {
		if ( jQuery( '.wp-digi-risk-item-new button' ).length > 0 ) {
		    this.button = new ProgressButton( jQuery( '.wp-digi-risk-item-new button' )[0], {
		      callback: digi_risk.create_risk,
		    } );
		}

		this.old_danger = jQuery( '.wp-digi-risk-item-new toggle' ).html();
		this.old_date = jQuery( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
	},

	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-risk-item-new button', function( event ) { return false; } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-delete', function( event ) { digi_risk.delete_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-load', function( event ) { digi_risk.load_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-edit', function( event ) { digi_risk.edit_risk( event, jQuery( this ) ); } );

		// Methode digirisk
		jQuery( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li:not(.open-method-evaluation-render)', function( event ) { digi_risk.select_cotation( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk-item-new .wp-digi-select-list li', function( event ) { digi_risk.select_danger( event, jQuery( this ) ); } );

		// Methode evarisk
		jQuery( document ).on( 'click', '.open-method-evaluation-render', function( event ) { digi_risk.open_modal( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', function( event ) { digi_risk.select_variable( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .dashicons-no-alt', function( event ) { digi_risk.close_modal( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', function( event ) { digi_risk.close_modal( event, jQuery( this ) ); } );

    jQuery( document ).on( 'click', '.wp-digi-action-comment-delete', function( event ) { digi_risk.delete_comment( event, jQuery( this ) ); } );
	},

	create_risk: function( instance ) {
    var element = instance.button;

    jQuery( element ).closest( 'form' ).ajaxSubmit( {
      'beforeSubmit': function() {
        var element_required = false;

        if ( jQuery ( element ).closest( 'form' ).find( 'input[name="digi_method"]' ).val() == 0 ) {
          jQuery( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( jQuery ( element ).closest( 'form' ).find( 'input[name="risk_danger_id"]' ).val() == '' ) {
          jQuery( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( !jQuery ( element ).closest( 'form' ).find( 'input[name="risk_comment_date"]' ).val() ) {
          jQuery( element ).closest( 'form' ).find( 'input[name="risk_comment_date"]' ).css( 'border', 'solid red 2px' );
          element_required = true;
        }

        if ( element_required ) {
          instance._stop(-1);
          return false;
        }
        jQuery( element ).closest( 'form' ).find( '.wp-digi-risk-list-column-cotation' ).css( 'border', 'none' );
        jQuery( element ).closest( 'form' ).find( '.wp-digi-summon-list' ).css( 'border', '1px solid rgba(0,0,0,.2)' );
        jQuery( element ).closest( 'form' ).find( 'input[name="risk_comment_date"]' ).css( 'border', 'none' );
      },
			success: function( response ) {
				jQuery( '.wp-digi-risk.wp-digi-list' ).html( response.data.template );
        jQuery( '.wp-digi-risk-item-new toggle' ).html( digi_risk.old_danger );
        jQuery( '.wp-digi-risk-item-new .wp-digi-risk-level-new' ).html( digi_risk.old_cotation );

				var element_cotation = jQuery( '.wp-digi-risk-item-new .wp-digi-risk-list-column-cotation div' )[0];
        element_cotation.className = element_cotation.className.replace(/wp-digi-risk-level-[1-4]/, '');

        jQuery( '.wp-digi-risk-item-new input[name="risk_danger_id"]').val( '' );
        jQuery( '.wp-digi-risk-item-new input[name="risk_evaluation_level"]').val( '' );
        jQuery( '.wp-digi-risk-item-new input[name="digi_method"]').val( '' );
        instance._stop(1);
				// digi_global.init();
        // digi_risk.init();
			}
		} );
	},

	delete_risk: function( event, element ) {
		event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var risk_id = jQuery( element ).data( 'id' );

  		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

  		var data = {
  			action: 'wpdigi-delete-risk',
  			_wpnonce: jQuery( element ).data( 'nonce' ),
  			global: jQuery( element ).data( 'global' ),
  			risk_id: risk_id,
  		};

  		jQuery.post( ajaxurl, data, function() {
  			jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
  			jQuery( '.wp-digi-list .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_risk: function( event, element ) {
		event.preventDefault();

    digi_risk.send_risk();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'wpdigi-load-risk',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			global: jQuery( element ).data( 'global' ),
			risk_id: risk_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
      jQuery( '.wp-digi-list-item .dashicons-edit' ).hide();
			jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).replaceWith( response.data.template );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			jQuery( '.wpdigi_date' ).datepicker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_risk: function( event, element ) {
		event.preventDefault();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
        jQuery( '.wp-digi-list-item .dashicons-edit' ).show();
				jQuery( '.wp-digi-risk.wp-digi-list' ).closest( 'div' ).replaceWith( response.data.template );
			}
		} );
	},

	select_cotation: function( event, element ) {
		event.preventDefault();

		var span = jQuery( element ).closest( "span" );
		var level = jQuery( element ).attr( 'data-level' );
		var digi_method_id = jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input.digi-method-simple' ).val();
		var div = span.find( 'div' );
		var div_element = div[0];
		div_element.className = div_element.className.replace( /wp-digi-risk-level-[1-4]/, 'wp-digi-risk-level-' + level );
		div.html( '' );

		jQuery( element ).closest( 'form' ).find( '.risk-level' ).val( level );
		jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="digi_method"]' ).val( digi_method_id );
	},

	send_risk: function() {
		jQuery( '.wp-digi-table-item-edit' ).each( function() {
			jQuery( this ).find( '.dashicons-edit' ).click();
		} );
	},

	select_danger: function( event, element ) {
		jQuery( '.wp-digi-risk-item-new input[name="risk_danger_id"]' ).val( jQuery( element ).data( 'id' ) );
		jQuery( '.wp-digi-risk-item-new toggle span' ).html( jQuery( element ).find( 'img' ).attr( 'title' ) );
	},

	select_variable: function( event, element ) {
		if ( jQuery( element ).data( 'seuil-id' ) != 'undefined' ) {
			jQuery( '.wpdigi-method-evaluation-render .row li[data-variable-id="' + jQuery( element ).data( 'variable-id' ) + '"]' ).removeClass( 'active' );
			jQuery( element ).addClass( 'active' );
			jQuery( '.wpdigi-method-evaluation-render input[name="variable[' + jQuery( element ).data( 'variable-id' ) + ']"]' ).val( jQuery( element ).data( 'seuil-id' ) );
		}
	},

	open_modal: function( event, element ) {
		jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk' ).show( function() {
			jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk' ).animate({
				'opacity': 1,
			}, 400);
		} );
		jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk > div' ).show( function() {
			jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk > div' ).animate( {
				'top': '50%',
				'opacity': 1,
			}, 400 );
		} );
	},

	close_modal: function( event, element ) {
		event.preventDefault();

		var list_variable = {};
		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk:visible').find( 'input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
			list_variable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		} );

		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk > div ' ).animate( {
			'top': '30%',
			'opacity': 0,
		}, 400, function() { jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk > div ' ).hide(); } );
		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk' ).animate({
			'opacity': 0,
		}, 400, function() { jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk' ).hide(); } );

		var data = {
			action: 'get_value_threshold',
			list_variable: list_variable,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="digi_method"]' ).val( jQuery( element ).closest( '.wpdigi-method-evaluation-render' ).find( 'input.digi-method-evaluation-id' ).val() );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).html( '&nbsp;' );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-risk-level-' + response.data.scale );
		} );
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
  }
};
