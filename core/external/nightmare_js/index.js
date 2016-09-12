var path = require('path');
var Nightmare = require('nightmare');
var login = require('./login');
var install_wordpress = require('./install-wordpress');
var install_digirisk = require('./install-digirisk');
var user = require('./user');

var nigthmare = Nightmare({
	show:false,
	typeInterval: 50,
	webPreferences: {
    preload: path.resolve("custom-script.js")
  }
});

nigthmare
	.use(install_wordpress())
	.wait(50000)
	.use(login())
	.wait(3000)
	.use(install_digirisk())
	.wait()
