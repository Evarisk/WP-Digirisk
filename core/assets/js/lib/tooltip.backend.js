window.eva_lib.tooltip = {};

window.eva_lib.tooltip.init = function() {
	window.eva_lib.tooltip.event();
};

window.eva_lib.tooltip.event = function() {
	jQuery( document ).on( 'mouseover', '.digirisk-wrap .tooltip:not(.red)', window.eva_lib.tooltip.mouseEnter );
	jQuery( document ).on( 'mouseout', '.digirisk-wrap .tooltip:not(.red)', window.eva_lib.tooltip.mouseOut );
};

window.eva_lib.tooltip.mouseEnter = function() {
	jQuery( this ).addClass( 'active' );
};

window.eva_lib.tooltip.mouseOut = function() {
	jQuery( this ).removeClass( 'active' );
};
