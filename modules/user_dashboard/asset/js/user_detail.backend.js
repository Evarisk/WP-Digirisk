"use strict";

var digi_user_detail = {
	$: undefined,
	event: function($) {
		digi_user_detail.$ = $;
    digi_user_detail.$( document ).on( 'click', '#wp-digi-form-add-staff .wp-digi-action-view-detail', function( event ) { digi_user_detail.load_staff_detail( event, digi_user_detail.$( this ) ); } );
		digi_user_detail.$( document ).on( 'click', '.user-detail .load-data', function (event ) { digi_user_detail.load_data( event, digi_user_detail.$( this ) ); } );
  },

	load_staff_detail: function( event, element ) {
		event.preventDefault();

		var user_id = digi_user_detail.$( element ).data( 'id' );
		var _wpnonce = digi_user_detail.$( element ).data( 'nonce' );

		var data = {
			action: 'load_user_detail',
			_wpnonce: _wpnonce,
			user_id: user_id
		};

		digi_user_detail.$( '.user-detail' ).addClass( 'wp-digi-bloc-loading' );

		digi_user_detail.$.post( window.ajaxurl, data, function( response ) {
			digi_user_detail.$( '.user-detail' ).replaceWith( response.data.template );
		});
	},

	load_data: function( event, element ) {
		var user_id = digi_user_detail.$( element ).closest( 'ul' ).data( 'user-id' );
		var _wpnonce = digi_user_detail.$( element ).closest( 'ul' ).data( 'nonce' );
		var data_name = digi_user_detail.$ (element ).data( 'name' );

		var data = {
			action: 'load_data',
			_wpnonce: _wpnonce,
			user_id: user_id,
			data_name: data_name
		};

		digi_user_detail.$( '.user-detail .wp-digi-list' ).addClass( 'wp-digi-bloc-loading' );

		digi_user_detail.$.post( window.ajaxurl, data, function( response ) {
			digi_user_detail.$( '.user-detail .wp-digi-list' ).replaceWith( response.data.template );
		});
	}
};
