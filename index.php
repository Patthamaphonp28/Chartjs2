<?php
ob_start();
error_reporting(0);
// connection
$db_conx = mysqli_connect("localhost", "root", "", "chatjs2");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error("Our database server is down at the moment. :(");
    exit();
} 
//initialize variables
$month = '';
$amount = '';
//Get lists from db
$sql = mysqli_query($db_conx, "SELECT month(purchase_date) as month, COUNT(product_id) as amount
FROM purchase_history
group BY month(purchase_date)");
while($row = mysqli_fetch_array($sql)){
	$month	= $row['month'];
	$amount	= $row['amount'];
	
	$month = $month.$month.',';
	$amount = $amount.$amount.',';
}
$month = trim($month, ",");
$amount = trim($amount, ",");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Budget Document</title>
</head>

<body>

<h1>Budget Charts</h1>

<div style="width:60%">
<canvas id="Chart" ></canvas>
</div>
    <!-- jQuery cdn -->
   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
    <!-- Chart.js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    
</body>
</html><script>

      // chart DOM Element
      var ctx = document.getElementById("Chart");
      var data = {
        datasets: [{
          data: [<?php echo $amount; ?>],
		  backgroundColor: 'transparent',
		  //backgroundColor: 'rgba(69, 92, 115, 0.5)',
		  //backgroundColor: 'rgba(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ', 0.4)',
          //backgroundColor: "#455C73",
		  borderColor: "#39a",
		  borderWidth: 5,
          label: 'Revenue' // for legend
        },{
          data: [<?php echo $month; ?>],
		  backgroundColor: 'transparent',
		  borderColor: "#9BB6ff",
		  borderWidth: 5,
		  // Changes this dataset to become a line
          //type: 'line',
          label: 'Expense' // for legend
        }],
        labels: [
          <?php echo $data; ?>
        ]
      };

      var xChart = new Chart(ctx, {
		 // The type of chart we want to create
        type: 'line',
		 // The data for our dataset
        data: data,
		 // Configuration options go here
		options: {
			 legend: {
				display: true,
				position: 'left',
				labels: {
					fontColor: 'black'
					//fontColor: 'rgb(255, 99, 132)'
				}
			  },
			  tooltips: {
				  mode: 'y'
			  },
		    scales: {
				yAxes: [{
				  ticks: {
					beginAtZero: true
				  }
				}],
				xAxes: [{
				  ticks: {
					autoskip: true,
					maxTicksLimit:6
				  }
				}]
			  }
			}
		  });
</script>