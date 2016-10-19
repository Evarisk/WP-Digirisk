window.digirisk.date = {};

window.digirisk.date.init = function() {
	jQuery( '.wpdigi_date' ).datepicker( { dateFormat: 'dd/mm/yy' } );
};

window.digirisk.date.tab_changed = function() {
  window.digirisk.date.init();
};
