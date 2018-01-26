var expect = require('chai').expect;
var fs = require("fs");
var tab = require('./../tab');

var societyInformationsData = fs.readFileSync("./test/module/society/data/society_informations.json");
var societyInformationsData = JSON.parse(societyInformationsData);

var societyLegalDisplayData = fs.readFileSync("./test/module/society/data/society_legal_display.json");
var societyLegalDisplayData = JSON.parse(societyLegalDisplayData);

var societyDiffusionInformationsData = fs.readFileSync("./test/module/society/data/society_diffusion_informations.json");
var societyDiffusionInformationsData = JSON.parse(societyDiffusionInformationsData);

var duerDATA = fs.readFileSync("./test/module/society/data/duer_data.json");
var duerDATA = JSON.parse(duerDATA);

module.exports = function(nightmare, cb) {
	describe('Societé', function() {
		it('Open society', function(done) {
			open_society(nightmare, done);
		});

		it('Go to tab information', function(done) {
			tab.goToInformations(nightmare, done);
		});

		it('Society: Form information', function(done) {
			form_information(nightmare, done);
		});

		it('Go to tab registre at bénins', function(done) {
			tab.goToRegistreATBenins(nightmare, done);
		});

		it('Society: Registre AT Benin (no-data)', function(done) {
			generate_registre_at_benin(nightmare, done);
		});

		it('Go to tab Légal display', function(done) {
			tab.goToLegalDisplay(nightmare, done);
		});

		it('Society: Legal display', function(done) {
			generate_legal_display(nightmare, done);
		});

		it('Go to tab Diffusion informations', function(done) {
			tab.goToDiffusionInformations(nightmare, done);
		});

		it('Society: Diffusion informations', function(done) {
			generate_diffusion_informations(nightmare, done);
		});

		it('Go to tab DUER', function(done) {
			tab.goToDUER(nightmare, done);
		});

		it('Society: DUER', function(done) {
			generate_DUER(nightmare, done);
			cb(nightmare);
		});
	});
};

function open_society(nightmare, done) {
	nightmare
		.click( '.navigation-container .society-header' )
		.wait(function() {
			if (window.currentResponse['loadedSocietySuccess']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedSocietySuccess'];
			delete window.currentResponse['loadedSocietySuccess'];
			var title = document.querySelector( '.main-header .title input[name="title"]' );
			if ( 'Evarisk' == title.value ) {
				return response;
			}

			return false;
		})
		.then(function(response) {
			if ( ! response ) {
				done(false);
			} else {
				expect(response.data.callback_success).to.equal( 'loadedSocietySuccess' );
				expect(response.success).to.equal(true);
			}
		})
		.then(done, done);
}

function form_information(nightmare, done) {
	for( var key in societyInformationsData ) {
		nightmare.type( '.society-informations *[name="' + key + '"]', '' );
		nightmare.type( '.society-informations *[name="' + key + '"]', societyInformationsData[key] );
	}

	nightmare
		.wait(1000)

		.click( '.society-informations .action-input' )
		.wait(function() {
			if (window.currentResponse['savedSocietyConfiguration']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['savedSocietyConfiguration'];
			delete window.currentResponse['savedSocietyConfiguration'];

			var success = true;
			var errors = [];

			for( var key in window.societyInformationsData ) {
				if ( window.societyInformationsData[key] !== document.querySelector( '.society-informations *[name="' + key + '"]' ).value ) {
					errors.push( key + '.value "' + window.societyInformationsData[key] + '" est différent de ' + document.querySelector( '.society-informations *[name="' + key + '"]' ).value );
					success = false;
				}
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then(function(response) {
			expect(response.success).to.equal(true);

			if ( response.success ) {
				expect(response.data.callback_success).to.equal('savedSocietyConfiguration');
			}
		})
		.then(done, done)
}

function generate_registre_at_benin(nightmare, done) {
	nightmare
		.click( '.document-accident-benins .action-input' )
		.wait(function() {
			if (window.currentResponse['generatedRegistreAccidentBenin']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['generatedRegistreAccidentBenin'];
			delete window.currentResponse['generatedRegistreAccidentBenin'];

			if ( ! document.body.contains( document.querySelector( '.document-accident-benins tr[data-id="' + response.data.result.creation_response.id + '"]' ) ) ) {
				response.success = false;
			}

			return response;
		})
		.then(function(response) {
			expect(response.success).to.equal(true);
			expect(response.data.result.success).to.equal(true);
			expect(response.data.callback_success).to.equal('generatedRegistreAccidentBenin');

		})
		.then(done, done);
}

function generate_legal_display(nightmare, done) {
	for( var key in societyLegalDisplayData ) {
		nightmare.type( '.main-content .form input[name="' + key + '"]', '' );
		nightmare.type( '.main-content .form input[name="' + key + '"]', societyLegalDisplayData[key] );
	}

	nightmare
		.wait(1000)
		.click( '.main-content .form .action-input' )
		.wait(function() {
			if (window.currentResponse['generatedSuccess']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['generatedSuccess'];
			delete window.currentResponse['generatedSuccess'];


			var success = true;
			var errors = [];

			for( var key in window.societyLegalDisplayData ) {
				if ( window.societyLegalDisplayData[key] !== document.querySelector( '.main-content .form input[name="' + key + '"]' ).value ) {
					errors.push( key + '.value "' + window.societyLegalDisplayData[key] + '" est différent de ' + document.querySelector( '.main-content .form input[name="' + key + '"]' ).value );
					success = false;
				}
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then(function(response) {
			expect(response.success).to.equal(true);
			expect(response.data.callback_success).to.equal('generatedSuccess');
		})
		.then(done, done)
}

function generate_diffusion_informations(nightmare, done) {
	for( var key in societyDiffusionInformationsData ) {
		nightmare.type( '.main-content .form-generate *[name="' + key + '"]', '' );
		nightmare.type( '.main-content .form-generate *[name="' + key + '"]', societyDiffusionInformationsData[key] );
	}

	nightmare
		.wait(1000)
		.click( '.main-content .form-generate .action-input' )
		.wait(function() {
			if (window.currentResponse['generatedDiffusionInformationSuccess']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['generatedDiffusionInformationSuccess'];
			delete window.currentResponse['generatedDiffusionInformationSuccess'];


			var success = true;
			var errors = [];

			for( var key in window.societyDiffusionInformationsData ) {
				if ( window.societyDiffusionInformationsData[key] !== document.querySelector( '.main-content .form-generate *[name="' + key + '"]' ).value ) {
					errors.push( key + '.value "' + window.societyDiffusionInformationsData[key] + '" est différent de ' + document.querySelector( '.main-content .form *[name="' + key + '"]' ).value );
					success = false;
				}
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then(function(response) {
			expect(response.success).to.equal(true);
			expect(response.data.callback_success).to.equal('generatedDiffusionInformationSuccess');
		})
		.then(done, done)
}

function generate_DUER(nightmare, done) {
	for( var key in duerDATA ) {
		nightmare.wait(2000);
		nightmare.click( '.main-content tfoot .open-popup[data-src="' + key  + '"]' );
		nightmare.wait( '.main-content .popup.active .button.green[data-target="' + key +'"]' );
		nightmare.type( '.main-content .popup.active textarea', '' );
		nightmare.type( '.main-content .popup.active textarea', duerDATA[key] );
		nightmare.click( '.main-content .popup.active .button.green[data-target="' + key +'"]' );
	}

	nightmare
		.wait(5000)
		.click( '.main-content .open-popup[data-cb-func="popup_for_generate_DUER"]' )
		.wait(function() {
			if (window.currentResponse['generatedDUERSuccess'] && window.currentResponse['generatedDUERSuccess'].data.end) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['generatedDUERSuccess'];
			delete window.currentResponse['generatedDUERSuccess'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then(function(response) {
			expect(response.success).to.equal(true);
			expect(response.data.callback_success).to.equal('generatedDUERSuccess');
		})
		.then(done, done)
}
