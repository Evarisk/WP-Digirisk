window.digirisk.recommendation = {};

window.digirisk.recommendation.init = function() {
	window.digirisk.recommendation.event();
};

window.digirisk.recommendation.event = function() {
	jQuery( document ).on( 'click', '.wp-digi-recommendation .wp-digi-select-list li', window.digirisk.recommendation.select_recommendation );
};

window.digirisk.recommendation.select_recommendation = function( event ) {
	var element = jQuery( this );
	jQuery( '.wp-digi-recommendation input.input-hidden-recommendation' ).val( element.data( 'id' ) );
	jQuery( '.wp-digi-recommendation toggle span img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
};

window.digirisk.recommendation.save_recommendation_success = function( element, response ) {
  jQuery( '.wp-digi-recommendation' ).replaceWith( response.data.template );
	window.digirisk.date.init
}

window.digirisk.recommendation.load_recommendation_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).replaceWith( response.data.template );
	window.digirisk.date.init 
}

window.digirisk.recommendation.delete_recommendation_success = function( element, response ) {
  jQuery( element ).closest( 'li' ).fadeOut();
}
