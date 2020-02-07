/**
 * Initialise l'objet "statistics" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 7.5.3
 * @version 7.5.3
 */
window.eoxiaJS.digirisk.statistics = {};

window.eoxiaJS.digirisk.statistics.init = function() {
	window.eoxiaJS.digirisk.statistics.event();
};

window.eoxiaJS.digirisk.statistics.event = function() {
	window.eoxiaJS.digirisk.statistics.loadChart();
};

window.eoxiaJS.digirisk.statistics.loadChart = function ( event ) {
	let data = {
		action: 'load_data_chart',
		id: jQuery( '.statistics-chart' ).attr( 'data-id' ),
	};

	//window.eoxiaJS.loader.display( jQuery( '.statistics-chart' ) );
	jQuery.post(
		ajaxurl,
		data,
		function ( response ) {
			console.log( response.data );
			for ( var i = 0; i < 5; i++ ) {
				var background_color_rgba = [];
				var border_color_rgba = [];
				for ( var a = 0; a < response.data.chart[i].data.datasets.data.length; a++ ) {
					 background_color_rgba[a] = 'rgba('
						+ response.data.chart[i].data.datasets.backgroundColor[0] + ','
						+ response.data.chart[i].data.datasets.backgroundColor[1] + ','
						+ response.data.chart[i].data.datasets.backgroundColor[2] + ','
						+ response.data.chart[i].data.datasets.backgroundColor[3] +
					')';

					border_color_rgba[a] = 'rgba('
						+ response.data.chart[i].data.datasets.borderColor[0] + ','
						+ response.data.chart[i].data.datasets.borderColor[1] + ','
						+ response.data.chart[i].data.datasets.borderColor[2] + ','
						+ response.data.chart[i].data.datasets.borderColor[3] +
					')';
				}
				console.log( background_color_rgba );
				console.log( border_color_rgba );

				var ctx = document.getElementById('myChart[' + i + ']' ).getContext( '2d' );
				var myChart = new Chart(ctx, {
					type: response.data.chart[i].type,
					data: {
						labels: response.data.chart[i].data.labels,
						datasets: [{
							label: response.data.chart[i].data.datasets.label,
							data: response.data.chart[i].data.datasets.data,
							backgroundColor: background_color_rgba,
							borderColor: border_color_rgba,
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							xAxes: [{
								stacked: true,
							}],
							yAxes: [{
								stacked: true,
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});
			}
		}
	);
};

/**
 * Le callback en cas de réussite à la requête Ajax "export_epi".
 * Exporte la fiche de vie d'un EPI au format ODT.
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.statistics.exportedCSVFileSuccess = function ( triggeredElement, response ) {
	console.log( response );
	var element = document.createElement('a');
	element.setAttribute('href', response.data.link );
	element.setAttribute('download', response.data.filename);

	element.style.display = 'none';
	document.body.appendChild(element);

	element.click();

	document.body.removeChild(element);
};
