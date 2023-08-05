var options = {
	chart: {
		width: 400,
		type: 'donut',
	},
	labels: ['Title A', 'Title B', 'Title C'],
	series: [20,20,20],
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				width: 200
			},
			legend: {
				position: 'bottom'
			}
		}
	}],
	stroke: {
		width: 0,
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 1,
			opacityTo: 1,	
			stops: [70, 100]
		}
	},
	colors: ['#FF0000', '#FFFF00', '#23AC1F'],
}
var chart = new ApexCharts(
	document.querySelector("#basic-donut-graph-gradient"),
	options
);
chart.render();