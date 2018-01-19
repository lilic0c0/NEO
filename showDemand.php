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
					<button id="sts" type="button" class="btn" >Download</button>
				</ul>
			</nav>
			
			<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
				<h1>Demand</h1>
				<div id="table"></div>
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
		$("#table").tabulator({
			height:"500px",
			layout:"fitColumns",
			placeholder:"No Data Set",
			columns:[
				{title:"source", field:"src", sorter:"string", editor:"input", headerFilter:"input" },
				{title:"Target", field:"dst", sorter:"string", editor:"input", headerFilter:"input"},
				{title:"Traffic (MB)", field:"traffic", sorter:"string",  editor:"input", headerFilter:"input"},
			],
		});
		$("#table").tabulator("setData", "getCalcDemand.php");
		
		//trigger download of data.csv file
		$("#sts").click(function(){
			$("#table").tabulator("download", "csv", "Demand.csv"); 
		});


	</script>
	
  </body>
</html>
