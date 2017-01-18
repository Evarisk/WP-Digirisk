window.digirisk.form = {};

window.digirisk.form.init = function() {
  window.digirisk.form.event();
};
window.digirisk.form.event = function() {
  jQuery( document ).on( 'click', '.submit-form', window.digirisk.form.sumbit_form );
};

window.digirisk.form.sumbit_form = function( event ) {
	var element = jQuery( this );

	element.closest( 'form' ).addClass( 'loading' );

  element.closest( 'form' ).ajaxSubmit( {

    success: function( response ) {
			element.closest( 'form' ).removeClass( 'loading' );
      if ( response && response.success ) {
        if ( response.data.module && response.data.callback_success ) {
          window.digirisk[response.data.module][response.data.callback_success]( element, response );
        }
      } else {
        if ( response.data.module && response.data.callback_error ) {
          window.digirisk[response.data.module][response.data.callback_error]( element, response );
        }
      }
    }
  } );

	event.preventDefault();
};
