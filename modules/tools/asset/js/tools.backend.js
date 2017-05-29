window.eoxiaJS.digirisk.tools = {};

window.eoxiaJS.digirisk.tools.init = function() {
	window.eoxiaJS.digirisk.tools.event();
};

window.eoxiaJS.digirisk.tools.event = function() {
	jQuery( document ).on( 'click', '.digi-tools-main-container .nav-tab', window.eoxiaJS.digirisk.tools.tab_switcher );
	jQuery( document ).on( 'click', '.reset-method-evaluation', window.eoxiaJS.digirisk.tools.reset_evaluation_method );
	jQuery( document ).on( 'click', '.element-risk-compilation', window.eoxiaJS.digirisk.tools.risk_fixer );
	jQuery( document ).on( 'click', '.fix-recommendation', window.eoxiaJS.digirisk.tools.recommendation_fixer );
	jQuery( document ).on( 'click', '.fix-doc', window.eoxiaJS.digirisk.tools.doc_fixer );
};

window.eoxiaJS.digirisk.tools.tab_switcher = function( event ) {
  event.preventDefault();

  /**	Remove all calss active on all tabs	*/
  jQuery( this ).closest( "h2" ).children( ".nav-tab" ).each( function(){
	  jQuery( this ).removeClass( "nav-tab-active" );
  });
  /**	Add the active class on clicked tab	*/
  jQuery( this ).addClass( "nav-tab-active" );

  /**	Hide the different container and display the selected container	*/
  jQuery( this ).closest( ".digi-tools-main-container" ).find( ".tab-content" ).each( function(){
	  jQuery( this ).hide();
  });

  jQuery( "#" + jQuery( this ).attr( "data-id" ) ).show();
},

window.eoxiaJS.digirisk.tools.reset_evaluation_method = function( event ) {
  event.preventDefault();

  if ( window.confirm( window.digi_tools_confirm ) ) {
    jQuery( this ).addClass( "wp-digi-loading" );
    jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

    var li = document.createElement( 'li' );
    li.innerHTML = window.digi_tools_in_progress;
    jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

    var data = {
      action: 'reset_method_evaluation',
      _wpnonce: jQuery( this ).data( 'nonce' )
    };

		window.eoxiaJS.digirisk.tools.exec_request( li, data, this );
  }
},

window.eoxiaJS.digirisk.tools.risk_fixer = function( event ) {
  event.preventDefault();

  jQuery( this ).addClass( "wp-digi-loading" );
  jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

  var li = document.createElement( 'li' );
  li.innerHTML = window.digi_tools_in_progress;
  jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

  var data = {
    action: 'compil_risk_list',
    _wpnonce: jQuery( this ).data( 'nonce' )
  };

  window.eoxiaJS.digirisk.tools.exec_request( li, data, this );
},

window.eoxiaJS.digirisk.tools.recommendation_fixer = function( event ) {
  event.preventDefault();

  jQuery( this ).addClass( "wp-digi-loading" );
  jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

  var li = document.createElement( 'li' );
  li.innerHTML = window.digi_tools_in_progress;
  jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

  var data = {
    action: 'transfert_recommendation',
    _wpnonce: jQuery( this ).data( 'nonce' )
  };

  window.eoxiaJS.digirisk.tools.exec_request( li, data, this );
},

window.eoxiaJS.digirisk.tools.doc_fixer = function( event ) {
  event.preventDefault();

  jQuery( this ).addClass( "wp-digi-loading" );
  jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

  var li = document.createElement( 'li' );
  li.innerHTML = window.digi_tools_in_progress;
  jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

  var data = {
    action: 'transfert_doc',
    _wpnonce: jQuery( this ).data( 'nonce' )
  };

  window.eoxiaJS.digirisk.tools.exec_request( li, data, this );
},

window.eoxiaJS.digirisk.tools.exec_request = function( li, data, element ) {
	jQuery.post( window.ajaxurl, data, function() {
		jQuery( element ).removeClass( "wp-digi-loading" );
		li.innerHTML += ' ' + window.digi_tools_done;
	} );
}
