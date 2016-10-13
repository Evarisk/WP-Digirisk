window.digirisk.request = {};

window.digirisk.request.init = function() {};

window.digirisk.request.send = function( element, data ) {
  jQuery.post( window.ajaxurl, data, function( response ) {
    if ( response && response.success ) {
      if ( response.data.module && response.data.callback_success ) {
        window.digirisk[response.data.module][response.data.callback_success]( element, response );
      }
    }
    else {
      alert('error');
      if ( response.data.module && response.data.callback_error ) {
        window.digirisk[response.data.module][response.data.callback_error]( element, response );
      }
    }
  }, "json" );
};
