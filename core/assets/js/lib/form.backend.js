window.digirisk.form = {};

window.digirisk.form.init = function() {
  window.digirisk.form.event();
};
window.digirisk.form.event = function() {
  jQuery( document ).on( 'click', '.submit-form', window.digirisk.form.sumbit_form );
};

window.digirisk.form.sumbit_form = function( event ) {
	event.preventDefault();
  var element = jQuery( this );
	element.closest( '.wp-digi-bloc-loader' ).addClass( 'wp-digi-bloc-loading' );
  element.closest( 'form' ).ajaxSubmit( {
    success: function( response ) {
			element.closest( '.wp-digi-bloc-loader' ).removeClass( 'wp-digi-bloc-loading' );
			
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
    }
  } );
}
