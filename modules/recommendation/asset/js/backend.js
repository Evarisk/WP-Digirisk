"use strict"

jQuery( document ).ready( function () {
	digi_recommendation.init();
});

var digi_recommendation = {
	old_recommendation_name: undefined,
	old_thumbnail: undefined,

	init: function() {
		digi_recommendation.old_recommendation_name = jQuery( '.wp-digi-recommendation-item-new toggle' ).html();
		digi_recommendation.old_thumbnail = jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html();

		digi_recommendation.event();
	},

	tab_changed: function() {
		digi_recommendation.old_recommendation_name = jQuery( '.wp-digi-recommendation-item-new toggle' ).html();
		digi_recommendation.old_thumbnail = jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html();
	},

	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item-new .wp-digi-select-list li', function( event ) { digi_recommendation.select_recommendation( event, jQuery( this ) ); } );

		// Ajouter une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item-new .dashicons-plus', function( event ) { digi_recommendation.add_recommendation( event, jQuery( this ) ); } );
		// Charger une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-load', function( event ) { digi_recommendation.load_recommendation( event, jQuery( this ) ); } );
		// Editer une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .dashicons-edit', function( event ) { digi_recommendation.edit_recommendation( event, jQuery( this ) ); } );
		// Supprimer une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-delete', function( event ) { digi_recommendation.delete_recommendation( event, jQuery( this ) ); } );
	},

	select_recommendation: function( event, element ) {
		jQuery( '.wp-digi-recommendation-item-new input[name=recommendation_id]' ).val( jQuery( element ).data( 'id' ) );
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-select-list' ).toggle();
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail i' ).hide();
		jQuery( '.wp-digi-recommendation-item-new toggle' ).html( jQuery( element ).data( 'name' ) );
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail .attachment-digirisk-element-miniature' ).attr( 'src', jQuery( element ).data( 'url' ) ).show();
	},

	add_recommendation: function( event, element ) {
		event.preventDefault();

		jQuery( '.wp-digi-recommendation-item-new' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( '.wp-digi-recommendation-item-new' ).removeClass( 'wp-digi-bloc-loading' );
				jQuery( '.wp-digi-recommendation.wp-digi-list' ).append( response.data.template );

				// Clear form
				jQuery( '.wp-digi-recommendation-item-new toggle' ).html( digi_recommendation.old_recommendation_name );
				jQuery( '.wp-digi-recommendation-item-new input[name="recommendation_id"]' ).val( "" );
				jQuery( '.wp-digi-recommendation-item-new input[name="recommendation_comment"]' ).val( "" );

				jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html( digi_recommendation.old_thumbnail );

			}
		} );
	},

	load_recommendation: function( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi-load-recommendation',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			workunit_id: jQuery( element ).data( 'workunit-id' ),
			term_id: jQuery( element ).data( 'id' ),
			index: jQuery( element ).data( 'index' ),
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
		} );
	},

	edit_recommendation: function( event, element ) {
		jQuery( element ).closest( '.wp-digi-recommendation-item' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
			}
		} );
	},

	delete_recommendation: function( event, element ) {
		event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var workunit_id	= jQuery( element ).data( 'workunit-id' );
  		var term_id 	= jQuery( element ).data( 'id' );
  		var index 		= jQuery( element ).data( 'index' );
  		var _wpnonce 	= jQuery( element ).data( 'nonce' );
  		var data = {
  			action: 'wpdigi-delete-recommendation',
  			_wpnonce: _wpnonce,
  			workunit_id: workunit_id,
  			term_id: term_id,
  			index: index,
  		};

  		jQuery( element ).closest( '.wp-digi-recommendation-item' ).fadeOut();

  		jQuery.post( ajaxurl, data, function() {

  		} );
    }
	}
};
