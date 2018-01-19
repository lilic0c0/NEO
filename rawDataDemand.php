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
				<form>
					<div class="form-group">
						<label for="exampleFormControlInput1">File Name</label>
						<input type="text" class="form-control" id="fileName" value="">
					</div>
					<button type="button" class="btn btn-primary mb-2" id="sts">Save to server</button>
					<button type="button" class="btn btn-primary mb-2" id="stl">Save to local</button>
				</form>
				</ul>
			</nav>
			
			<main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
				<h1>Demand</h1>
				<div id="demandCSV""></div>
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
		$("#demandCSV").tabulator({
			height:"500px",
			layout:"fitColumns",
			placeholder:"No Data Set",
			columns:[
				{title:"Source", field:"src", sorter:"string", editor:"input", headerFilter:"input"},
				{title:"Destination", field:"dst", sorter:"string", editor:"input", headerFilter:"input"},
				{title:"Traffic", field:"traff", sorter:"string", editor:"input", headerFilter:"input"},	
			],
		});
		$("#demandCSV").tabulator("setData", "getRawDataDemand.php");
		
		//trigger download of data.csv file
		$("#sts").click(function(){
			
			if(confirm('確定')){
				var rs = $("#demandCSV").tabulator("getData");
				var fileName = $("#fileName").val();
				
				$.post( "updaterawDataDemand.php", {"demands":JSON.stringify(rs), "filename": fileName})
					.done(function( data ) {
					console.log( "Data Loaded: " + data );
				});
			}
		});
		
		//trigger download of data.csv file
		$("#stl").click(function(){
			var fileName = $("#fileName").val();
			$("#demandCSV").tabulator("download", "csv", fileName + "_demand.csv"); 
		});

	</script>
	
  </body>
</html>
