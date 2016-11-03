window.digirisk.date = {};

window.digirisk.date.init = function() {
	jQuery( '.eva-date' ).datepicker( { dateFormat: 'dd/mm/yy' } );
};

window.digirisk.date.tab_changed = function() {
  window.digirisk.date.init();
};
