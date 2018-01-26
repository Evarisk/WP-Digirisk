var Nightmare = require('nightmare');
var path = require('path');

const nightmare = Nightmare({
	show: true,
	typeInterval: 150,
	width: 1300,
	height: 1000,
	waitTimeout: 200 * 1000,
	webPreferences: {
		preload: path.resolve("xhr.js")
	}
});

var login = require('./core/login');

login.goToLogin(nightmare, function() {
	require('./module/user/user')(nightmare, function() {
		login.goToApp(nightmare, function() {
			require('./module/navigation').navigation(nightmare, function() {
				require('./module/society/society')(nightmare, function() {
					require('./module/establishment/establishment')(nightmare, function() {
						require('./module/risk-page/risk-page')(nightmare, function() {
							nightmare.end();
						})
					});
				});
			});
		})
	});
});
