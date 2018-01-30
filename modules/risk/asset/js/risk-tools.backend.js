window.eoxiaJS.digirisk.riskTools = {};

window.eoxiaJS.digirisk.riskTools.init = function() {
	window.eoxiaJS.digirisk.riskTools.event();
};

window.eoxiaJS.digirisk.riskTools.event = function() {
	jQuery( document ).on( 'click', '.digi-risk-preset-reset', window.eoxiaJS.digirisk.riskTools.risk_preset_reset );
	jQuery( document ).on( 'click', '#digi-tools-fix-categories', window.eoxiaJS.digirisk.riskTools.categories_fixer );
};

window.eoxiaJS.digirisk.riskTools.categories_fixer = function( event ) {
  var data = {
    action: 'digi-fix-categories',
    _wpnonce: jQuery( '#digi-tools-fix-categories' ).data( 'nonce' )
  };
	event.preventDefault();
	if ( jQuery( '.digi-tools-category-fixer tr:not(.done):first' ).length ) {
		data.old_term_id = jQuery( '.digi-tools-category-fixer tr:not(.done):first' ).find( 'input[name=digi-danger-category]' ).val();
		data.new_term_id = jQuery( '.digi-tools-category-fixer tr:not(.done):first' ).find( 'select[name=digi-category-risk]' ).val();

		jQuery( '#digi-tools-fix-categories' ).addClass( 'loading' );

		jQuery.post( window.ajaxurl, data, function( response ) {
			if ( true == response.success ) {
				jQuery( '.digi-tools-category-fixer tr:not(.done):first' ).find( 'td.action-result' ).html( response.data.message );
				jQuery( '.digi-tools-category-fixer tr:not(.done):first' ).addClass( 'done' );
				window.eoxiaJS.digirisk.riskTools.categories_fixer( event );
			}
		} );
	} else {
		jQuery( '#digi-tools-fix-categories' ).removeClass( 'loading' );
	}

};

window.eoxiaJS.digirisk.riskTools.risk_preset_reset = function( event ) {
	var data = {
		action: 'digi-risk-preset-reset',
		_wpnonce: jQuery( this ).data( 'nonce' )
	};
	var li = document.createElement( 'li' );

	jQuery( this ).addClass( 'wp-digi-loading' );
	jQuery( this ).closest( 'div' ).find( 'ul' ).html( '' );

	li.innerHTML = window.digi_tools_in_progress;
	jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

	window.eoxiaJS.digirisk.riskTools.exec_request( li, data, this );
};
