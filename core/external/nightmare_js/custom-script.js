
 window.__nightmare = {};
	__nightmare.ipc = require('electron').ipcRenderer;

var open = window.XMLHttpRequest.prototype.open;
window.__responses = [];
window.currentAction = undefined;
window.XMLHttpRequest.prototype.open = function (method, url, async, user, pass) {
		this.addEventListener("readystatechange", function() {
			if (this.readyState === 4) {
				var responseJSON = JSON.parse(this.responseText);
				if ( responseJSON && responseJSON.data && responseJSON.data.template ) {
					delete responseJSON.data.template;
				}
				window.__responses[window.currentAction] = responseJSON;
			}
		}, false);
	open.apply(this, arguments);
};

window.XMLHttpRequest.prototype.realSend = XMLHttpRequest.prototype.send;
window.XMLHttpRequest.prototype.send = function(vData) {
	this.realSend(vData);
};

function getAction(data) {
	var post = data.split('&');
	var action = post[0].split('=');

	if ( action && action[0] && action[0] === 'action' && action[1] && action[1] != "heartbeat" ) {
		window.currentAction = action[1];
	}
}
