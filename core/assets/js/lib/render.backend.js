window.digirisk.render = {};

window.digirisk.render.init = function() {
	window.digirisk.render.event();
};

window.digirisk.render.event = function() {
};

window.digirisk.render.call_render_changed = function() {
	for ( var key in window.digirisk ) {
		if (window.digirisk[key].render_changed) {
			window.digirisk[key].render_changed();
		}
	}
}
