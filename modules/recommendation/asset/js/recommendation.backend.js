"use strict";

var digi_recommendation = {
	old_recommendation_name: undefined,
	old_thumbnail: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_recommendation.$ = $;
		digi_recommendation.old_recommendation_name = digi_recommendation.$( '.wp-digi-recommendation-item-new toggle' ).html();
		digi_recommendation.old_thumbnail = digi_recommendation.$( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html();

		if ( event || event === undefined ) {
			digi_recommendation.event();
		}
	},

	event: function() {
		digi_recommendation.$( document ).on( 'click', '.wp-digi-recommendation-item-new .wp-digi-select-list li', function( event ) { digi_recommendation.select_recommendation( event, digi_recommendation.$( this ) ); } );

		// Ajouter une recommendation
		digi_recommendation.$( document ).on( 'click', '.wp-digi-recommendation-item-new .dashicons-plus', function( event ) { digi_recommendation.add_recommendation( event, digi_recommendation.$( this ) ); } );
		// Charger une recommendation
		digi_recommendation.$( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-load', function( event ) { digi_recommendation.load_recommendation( event, digi_recommendation.$( this ) ); } );
		// Editer une recommendation
		digi_recommendation.$( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-edit', function( event ) { digi_recommendation.edit_recommendation( event, digi_recommendation.$( this ) ); } );
		// Supprimer une recommendation
		digi_recommendation.$( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-delete', function( event ) { digi_recommendation.delete_recommendation( event, digi_recommendation.$( this ) ); } );
	},

	select_recommendation: function( event, element ) {
		digi_recommendation.$( '.wp-digi-recommendation-item-new input[name=recommendation_id]' ).val( digi_recommendation.$( element ).data( 'id' ) );
		digi_recommendation.$( '.wp-digi-recommendation-item-new .wp-digi-select-list' ).toggle();
		digi_recommendation.$( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail i' ).hide();
		digi_recommendation.$( '.wp-digi-recommendation-item-new toggle' ).html( digi_recommendation.$( element ).data( 'name' ) );
		digi_recommendation.$( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail .attachment-digirisk-element-miniature' ).attr( 'src', digi_recommendation.$( element ).data( 'url' ) ).show();
	},

	add_recommendation: function( event, element ) {
		event.preventDefault();

		digi_recommendation.$( '.wp-digi-recommendation-item-new' ).addClass( 'wp-digi-bloc-loading' );

		digi_recommendation.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_recommendation.$( '.wp-digi-recommendation-item-new' ).removeClass( 'wp-digi-bloc-loading' );
				digi_recommendation.$( '.wp-digi-recommendation.wp-digi-list' ).append( response.data.template );

				// Clear form
				digi_recommendation.$( '.wp-digi-recommendation-item-new toggle' ).html( digi_recommendation.old_recommendation_name );
				digi_recommendation.$( '.wp-digi-recommendation-item-new input[name="recommendation_id"]' ).val( "" );
				digi_recommendation.$( '.wp-digi-recommendation-item-new input[name="recommendation_comment"]' ).val( "" );

				digi_recommendation.$( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html( digi_recommendation.old_thumbnail );

			}
		} );
	},

	load_recommendation: function( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi-load-recommendation',
			_wpnonce: digi_recommendation.$( element ).data( 'nonce' ),
			workunit_id: digi_recommendation.$( element ).data( 'workunit-id' ),
			term_id: digi_recommendation.$( element ).data( 'id' ),
			index: digi_recommendation.$( element ).data( 'index' ),
		};

		digi_recommendation.$.post( window.ajaxurl, data, function( response ) {
			digi_recommendation.$( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
		} );
	},

	edit_recommendation: function( event, element ) {
		digi_recommendation.$( element ).closest( '.wp-digi-recommendation-item' ).addClass( 'wp-digi-bloc-loading' );

		digi_recommendation.$( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				digi_recommendation.$( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
			}
		} );
	},

	delete_recommendation: function( event, element ) {
		event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
  		var workunit_id	= digi_recommendation.$( element ).data( 'workunit-id' );
  		var term_id 	= digi_recommendation.$( element ).data( 'id' );
  		var index 		= digi_recommendation.$( element ).data( 'index' );
  		var _wpnonce 	= digi_recommendation.$( element ).data( 'nonce' );
  		var data = {
  			action: 'wpdigi-delete-recommendation',
  			_wpnonce: _wpnonce,
  			workunit_id: workunit_id,
  			term_id: term_id,
  			index: index,
  		};

  		digi_recommendation.$( element ).closest( '.wp-digi-recommendation-item' ).fadeOut();

  		digi_recommendation.$.post( window.ajaxurl, data, function() {

  		} );
    }
	}
};
