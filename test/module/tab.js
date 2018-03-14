var expect = require('chai').expect;

var exportGoToInformations = function (nightmare, done) {
	goToInformations(nightmare, done);
}

var exportGoToRegistreATBenins = function (nightmare, done) {
	goToRegistreATBenins(nightmare, done);
}

var exportGoToLegalDisplay = function (nightmare, done) {
	goToLegalDisplay(nightmare, done);
}

var exportGoTDiffusionInformations = function (nightmare, done) {
	goToDiffusioninformations(nightmare, done);
}

var exportGoTDUER = function (nightmare, done) {
	goToDUER(nightmare, done);
}

var exportGoToRisk = function (nightmare, done) {
	goToRisk(nightmare, done);
}

var exportGoToEvaluator = function (nightmare, done) {
	goToEvaluator(nightmare, done);
}

var exportGoToRecommendation = function (nightmare, done) {
	goToRecommendation(nightmare, done);
}

function goToInformations( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-informations"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( 'Informations Evarisk' === title.innerHTML ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);

		})
		.then(done, done);
}

function goToRegistreATBenins( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-registre-accident"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( 'Les registres des AT bénins Evarisk' === title.innerHTML ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToLegalDisplay( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-legal_display"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( 'Les affichages légales Evarisk' === title.innerHTML ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToDiffusioninformations( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-diffusion-informations"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( 'Les diffusions informations Evarisk' === title.innerHTML ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToDUER( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-list-duer"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( 'DUER Evarisk' === title.innerHTML ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToRisk( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-risk"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];
			var title = document.querySelector( '.main-content h1' );

			if ( -1 !== title.innerHTML.indexOf( 'Les risques' ) ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToEvaluator( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-evaluator"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];

			var title = document.querySelector( '.main-content h1' );
			if ( -1 !== title.innerHTML.indexOf( 'Les évaluateurs' ) ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

function goToRecommendation( nightmare, done ) {
	nightmare
		.click( '.main-container .tab-element[data-action="digi-recommendation"]' )
		.wait(function() {
			if (window.currentResponse['loadedTabContent']) {
				return true;
			}
		})
		.evaluate(function() {
			var response = window.currentResponse['loadedTabContent'];
			delete window.currentResponse['loadedTabContent'];

			var title = document.querySelector( '.main-content h1' );
			if ( -1 !== title.innerHTML.indexOf( 'Les signalisations' ) ) {
				return response;
			}

			return false;
		})
		.then(function(result) {
			var response = {};

			if ( ! result ) {
				response.success = result;
			} else {
				response = result;
			}

			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.goToInformations          = exportGoToInformations;
module.exports.goToRegistreATBenins      = exportGoToRegistreATBenins;
module.exports.goToLegalDisplay          = exportGoToLegalDisplay;
module.exports.goToDiffusionInformations = exportGoTDiffusionInformations;
module.exports.goToDUER                  = exportGoTDUER;
module.exports.goToRisk                  = exportGoToRisk;
module.exports.goToEvaluator             = exportGoToEvaluator;
module.exports.goToRecommendation        = exportGoToRecommendation;
