/**
 * Initialise l'objet "legalDisplay" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.4.4
 */

window.eoxiaJS.digirisk.legalDisplay = {};

window.eoxiaJS.digirisk.legalDisplay.init = function() {};

/**
 * Le callback en cas de réussite à la requête Ajax "save_legal_display".
 * Actualises la vue en cliquant sur l'onglet "Affichage légal".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.legalDisplay.generatedSuccess = function( triggeredElement, response ) {
	jQuery( '.table.documents' ).replaceWith( response.data.view );
	window.scrollTo( 0, 0 );
};

window.eoxiaJS.digirisk.legalDisplay.generateSocietyIndicator = function( focus = "" ) {
	jQuery( '.main-information-society .bloc-information-society' ).each( function( index ){
		if( jQuery( this ).find( 'input[name="indicator-id"]' ).length == 0 || jQuery( this ).find( 'input[name="indicator-id"]' ).val() == "" ){
			return;
		}else{
			var id_indicator = jQuery( this ).find( 'input[name="indicator-id"]' ).val();
		}

		var nbr_total = 1;
		if( jQuery( this ).find( 'input[name="indicator-nbr-total"]' ).length > 0 ){
			nbr_total = jQuery( this ).find( 'input[name="indicator-nbr-total"]' ).val();
		}

		var nbr_valid = 0;
		if( jQuery( this ).find( 'input[name="indicator-nbr-valid"]' ).length > 0 ){
			nbr_valid = jQuery( this ).find( 'input[name="indicator-nbr-valid"]' ).val();
		}
		var nbr_unvalid = nbr_total - nbr_valid;

		var percent = 0;
		if( jQuery( this ).find( '.bloc-indicator' ).length > 0 ){
			percent = jQuery( this ).find( '.bloc-indicator' ).attr( 'data-percent' );
		}


		// RED, ORANGE, YELLOW, GREEN
		var color = window.eoxiaJS.digirisk.legalDisplay.getColorFromPercent( percent );

		var canvasDonut = document.getElementById( id_indicator ).getContext('2d');
		var data_canvas_donut = {
			labels : [ window.indicatorString.completed, window.indicatorString.uncompleted ],
			datasets: [
					{
						backgroundColor: [ color, "rgb(230,230,230)" ],
						data: [ nbr_valid, nbr_unvalid ],
					}
				],
		};

		var option = {
			title: {},
			tooltips: {
				custom: function(tooltip) {
				}
			},
			legend: {
				display: false
			},
			elements: {
				center: {
					text: percent + '%',
					}
			},
			animation:{

			}
		};
		if( focus != "" ){
			option.animation.duration = 0;
		}

		canvasDonut.canvas.width = 80;
		canvasDonut.canvas.height = 80;

		new Chart( canvasDonut, {
		    type: 'doughnut',
		    data: data_canvas_donut,
		    options: option
		});

		Chart.pluginService.register({ // ------------

		  beforeDraw: function(chart) {
		    var width = chart.chart.width,
		        height = chart.chart.height,
		        ctx = chart.chart.ctx;

		    ctx.restore();
		    // var fontSize = (height / 114).toFixed(2);
		    ctx.font = 'italic 20px -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
		    ctx.textBaseline = "middle";

			var centerConfig = chart.config.options.elements.center;
		    var text = centerConfig.text,
		        textX = Math.round((width - ctx.measureText(text).width) / 2),
		        textY = height / 2;

		    ctx.fillText(text, textX, textY);
		    ctx.save();
		  }
		}); // ------------
	} );
};

var color =



window.eoxiaJS.digirisk.legalDisplay.getColorFromPercent = function ( percent ){
	var color = [ 'rgb(255,1,1)', 'rgb(255,153,0)', 'rgb(255,213,0)', 'rgb(71,229,142)' ];

	if( percent > 75 ){
		return color[3];
	}else if( percent > 50 ){
		return color[2];
	}else if( percent > 25 ){
		return color[1];
	}else{
		return color[0];
	}
}
