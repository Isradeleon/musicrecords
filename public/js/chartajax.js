$(document).ready(function(){
	var t=$('meta[name="tok"]').attr('content');
	$.ajax({
		url:'/stadistics',
		method:'post',
		data:{
			_token:t
		}
	}).done(function(response){
		$.each(response,function(index,kind){
			var container="container"+kind.id;
			var chart = new Highcharts.Chart({
	            chart: {
	                renderTo: container,
	                type: 'bar'
	            },
	            title: { text: 'Favorites'},
	            xAxis: {
	                categories: kind.categories
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Report'
	                }
	            },
	            legend: {
	                reversed: true
	            },
	            plotOptions: {
	                series: {
	                    stacking: 'normal'
	                }
	            },
	            series: [{
	                name: 'Number of favorites',
	                data: kind.data
	            }]
	        });
		});
		
	});
});