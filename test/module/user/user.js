var expect = require('chai').expect;
var fs = require("fs");

var userData = fs.readFileSync("./test/module/user/data/user.json");
var userData = JSON.parse(userData);

module.exports = function(nightmare, cb) {
	describe('User', function() {
		it('GoTo User page', function(done) {
			goTo(nightmare, done);
		});

		it('Create user', function(done) {
			create(nightmare, done );
			cb();
		});
	});
};

function goTo(nightmare, done) {
	nightmare
		.goto('http://127.0.0.1/wordpress/wp-admin/users.php?page=digirisk-users')
		.wait('.user-dashboard')
		.then(done, done);
}

function create(nightmare, done) {
	for ( var key in userData.users ) {
		nightmare
			.type( ".user-row input[name='lastname']", userData.users[key].lastname )
			.type( ".user-row input[name='firstname']", userData.users[key].firstname )
			.click( ".user-row .action-input" )
			.wait(function() {
				if (window.currentResponse['savedUserSuccess']) {
					return true;
				}
			})
			.evaluate(() => {
				var response = window.currentResponse['savedUserSuccess'];
				delete window.currentResponse['savedUserSuccess'];

				var success = true;
				var errors = [];

				if ( ! document.body.contains( document.querySelector( 'tr.user-row[data-id="' + response.data.object.id + '"]' ) ) ) {
					response.success = false;
				}

				response.data.errors = errors;

				if ( response.data.errors.length ) {
					response.success = false;
				}

				window.allUsersResponses.push( response );
				return window.allUsersResponses;
			})

	}

	nightmare.then((response) => {
		for ( var i = 0; i < response.length; i++ ) {
			expect(response[i].data.callback_success).to.equal('savedUserSuccess');
			expect(response[i].data.object.email).to.equal( userData.users[i].email );
			expect(response[i].success).to.equal(true);
		}

	})
	.then(done, done);
}
