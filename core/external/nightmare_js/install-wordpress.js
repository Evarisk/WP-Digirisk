module.exports = function() {
	return function (nightmare) {
		nightmare
			.goto('http://127.0.0.1/wordpress/wp-login.php')
			.wait('#setup')
			.click('#language-continue')
			.wait(3000)
			.evaluate(function() {
				document.querySelector('input[name="pass1-text"]').value = '';
			})
			.wait(1000)
			.type('input[name="weblog_title"]', 'A')
			.type('input[name="user_name"]', 'a')
			.type('input[name="pass1-text"]', 'a')
			.click('.pw-checkbox')
			.type('input[name="admin_email"]', 'a@a.com')
			.click('input[type="submit"]')
	};
};
