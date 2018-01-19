<?php
require("php-lib/util.php");

$node = (isset($_REQUEST['nodeSelectData']))?$_REQUEST['nodeSelectData']:null;
$edge = (isset($_REQUEST['edgeSelectData']))?$_REQUEST['edgeSelectData']:null;
$demand = (isset($_REQUEST['demandSelectData']))?$_REQUEST['demandSelectData']:null;

if($node != null && $edge != null && demand != null){
	$data = array(
		'node' => $node,
		'edge' => $edge,
		'demand' => $demand
	);
	
	$ret = init($data);
	
} else {
	//
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Network Enhance Optimizer</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<link href="css/dashboard.css" rel="stylesheet">
	<link href="css/tabulator.min.css" rel="stylesheet">


  </head>

  <body>
    <?php include('menu.php') ?>

    <div class="container-fluid">
		<div class="row">
	    
			<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
				<ul class="nav nav-pills flex-column">

				</ul>
			</nav>
			
			<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
				<h1>Handle data</h1>
				
				<table class="table">
				  <thead class="thead-dark">
					<tr>
					  <th scope="col">#</th>
					  <th scope="col">Function</th>
					  <th scope="col">Status</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  <th scope="row">1</th>
					  <td>Prepare topology data</td>
					  <td id="step_1_stat">Progressing</td>
					</tr>
					<tr>
					  <th scope="row">2</th>
					  <td>Calculate SPF</td>
					  <td id="step_2_stat">waiting</td>
					</tr>
					<tr>
					  <th scope="row">3</th>
					  <td>Prepare Demand data</td>
					  <td id="step_3_stat">waiting</td>
					</tr>
					<tr>
					  <th scope="row">4</th>
					  <td>Calculate circuit utilization</td>
					  <td id="step_4_stat">waiting</td>
					</tr>
					<tr>
					  <th scope="row">5</th>
					  <td>Parse net json</td>
					  <td id="step_5_stat">waiting</td>
					</tr>
				  </tbody>
				</table>
			</main>
		</div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/tabulator.min.js"></script>
	<script>
	
	//step 1
		$.post( "api/getSPFTopo.php", function( data ) {
			
			$("#step_1_stat").html("done");
			step2();
		});
		
	//step 2
		var step2 = function() {
			
			$("#step_2_stat").html("progressing");
			
			$.post( "api/getCalSPF.php", function( data ) {
			
				$("#step_2_stat").html("done");
				step3();
			});
		
		}
	
		//step 3
		var step3 = function() {
			
			$("#step_3_stat").html("progressing");
			
			$.post( "api/getPreDemand.php", function( data ) {
			
				$("#step_3_stat").html("done");
				step4();
			});
		}
		
		//step 4
		var step4 = function() {
			
			$("#step_4_stat").html("progressing");
			
			$.post( "api/getCalCircuitUtilization.php", function( data ) {
			
				$("#step_4_stat").html("done");
				step5();
			});
		}
		
		//step 5
		var step5 = function() {
			
			$("#step_5_stat").html("progressing");
			
			$.post( "api/parseNetjson.php", function( data ) {
			
				$("#step_5_stat").html("done");
			});
		}
	</script>
	
  </body>
</html>