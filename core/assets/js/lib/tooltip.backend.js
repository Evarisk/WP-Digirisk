window.eoxiaJS.tooltip = {};

window.eoxiaJS.tooltip.init = function() {
	window.eoxiaJS.tooltip.event();
};

window.eoxiaJS.tooltip.event = function() {
	jQuery( document ).on( 'mouseover', '.digirisk-wrap .tooltip:not(.red)', window.eoxiaJS.tooltip.mouseEnter );
	jQuery( document ).on( 'mouseout', '.digirisk-wrap .tooltip:not(.red)', window.eoxiaJS.tooltip.mouseOut );
};

window.eoxiaJS.tooltip.mouseEnter = function() {
	jQuery( this ).addClass( 'active' );
};

window.eoxiaJS.tooltip.mouseOut = function() {
	jQuery( this ).removeClass( 'active' );
};
