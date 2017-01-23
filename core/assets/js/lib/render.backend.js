window.digirisk.render = {};

window.digirisk.render.init = function() {
	window.digirisk.render.event();
};

window.digirisk.render.event = function() {};

window.digirisk.render.callRenderChanged = function() {
	var key = undefined;

	for ( key in window.digirisk ) {
		if ( window.digirisk[key].renderChanged ) {
			window.digirisk[key].renderChanged();
		}
	}
};
