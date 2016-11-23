window.digirisk.request = {};

window.digirisk.request.init = function() {};

window.digirisk.request.send = function( element, data ) {
  jQuery.post( window.ajaxurl, data, function( response ) {
		element.closest( '.wp-digi-bloc-loader' ).removeClass( 'wp-digi-bloc-loading' );

    if ( response && response.success ) {
      if ( response.data.module && response.data.callback_success ) {
        window.digirisk[response.data.module][response.data.callback_success]( element, response );
      }
    }
    else {
      if ( response.data.module && response.data.callback_error ) {
        window.digirisk[response.data.module][response.data.callback_error]( element, response );
      }
    }
  }, "json" );
};

window.digirisk.request.get = function( url, data ) {
  jQuery.get( url, data, function( response ) {

    if ( response && response.success ) {
      if ( response.data.module && response.data.callback_success ) {
        window.digirisk[response.data.module][response.data.callback_success]( response );
      }
    }
    else {
      if ( response.data.module && response.data.callback_error ) {
        window.digirisk[response.data.module][response.data.callback_error]( response );
      }
    }
  }, "json" );
};
