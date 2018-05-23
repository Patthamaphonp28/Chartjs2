$(document).ready(function(){
	$.ajax({
		url: "http://localhost/chartjs2/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var Month = [];
			var amount = [];
			for(var i in data) {
				Month.push("Month " + data[i].month);
				amount.push(data[i].amount);
			}

			var chartdata = {
				labels: mouth,
				datasets : [
					{
						label: 'mouth amount',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: amount
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});
