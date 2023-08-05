// Markers on the world map
$(function(){
	$('#bd-map').vectorMap({
		map: 'bd_mill',
		normalizeFunction: 'polynomial',
		hoverOpacity: 0.7,
		hoverColor: false,
		zoomOnScroll: false,
		markerStyle: {
			initial: {
				fill: '#333333',
				stroke: '#FFFFFF',
				r: 6
			}
		},
		zoomMin: 1,
		hoverColor: true,
		series: {
			regions: [{
				values: gdpData,
				scale: ['#17995e'],
				normalizeFunction: 'polynomial'
			}]
		},
		backgroundColor: 'transparent',
		markers: [
			{latLng: [23.810331, 90.412521]},
		]
	});
});