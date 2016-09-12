var path = require('path');
var Nightmare = require('nightmare');
var login = require('./login');
var install_digirisk = require('./install-digirisk');
var user = require('./user');

var nigthmare = Nightmare({
	show:false,
	webPreferences: {
    preload: path.resolve("custom-script.js")
  }
});

nigthmare
	.use(login())
	.wait(3000)
	.use(install_digirisk())
	.wait()
