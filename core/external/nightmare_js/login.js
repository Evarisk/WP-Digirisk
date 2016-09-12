module.exports = function() {
	return function (nightmare) {
		nightmare
			.goto('http://localhost/wordpress/wp-admin')
			.wait('#login')
			.type('input[name="log"]', 'a')
			.type('input[name="pwd"]', 'a')
			.click('input[type="submit"]')
			.wait('#adminmenu')
	};
}
