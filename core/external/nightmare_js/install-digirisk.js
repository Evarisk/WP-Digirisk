var user = require('./user');

module.exports = function() {
	return function (nightmare) {
		nightmare
			.goto('http://127.0.0.1/wordpress/wp-admin/admin.php?page=digi-setup')
			.wait('.wp-digi-form')
			.type('input[name="groupment[title]"]', 'Eoxia')
			.click('input[type="button"]')
			.wait(3000)
			.evaluate( function() {
				return window.__responses[window.currentAction];
			})
			.then(function(result) {
				if ( !result ) {
					console.error('error');
				}

				if ( !result.success ) {
					console.error('STOP');
				}

				nightmare.use(user.create_user("Amandineaaaaacadzad", "Gaudy"));
			})
			.catch(function(error) {
				console.error(error);
			})
	};
};
