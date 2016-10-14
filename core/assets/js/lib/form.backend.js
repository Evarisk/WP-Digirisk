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
  jQuery( this ).closest( 'form' ).ajaxSubmit( {
    success: function( response ) {
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
