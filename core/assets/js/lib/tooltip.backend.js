window.digirisk.tooltip = {};

window.digirisk.tooltip.init = function() {
	window.digirisk.tooltip.event();
};

window.digirisk.tooltip.event = function() {
	jQuery( document ).on( 'mouseover', '.digirisk-wrap .tooltip:not(.red)', window.digirisk.tooltip.mouseEnter );
	jQuery( document ).on( 'mouseout', '.digirisk-wrap .tooltip:not(.red)', window.digirisk.tooltip.mouseOut );
};

window.digirisk.tooltip.mouseEnter = function() {
	jQuery( this ).addClass( 'active' );
};

window.digirisk.tooltip.mouseOut = function() {
	jQuery( this ).removeClass( 'active' );
};
