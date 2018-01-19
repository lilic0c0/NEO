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
				<h1>Node</h1>
				<div id="nodeCSV""></div>
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
		$("#nodeCSV").tabulator({
			height:"500px",
			layout:"fitColumns",
			placeholder:"No Data Set",
			columns:[
				{title:"Loopback", field:"loopback", sorter:"string", editor:"input", headerFilter:"input"},
				{title:"Name", field:"name", sorter:"string", editor:"input", headerFilter:"input"},
				{title:"Location", field:"location", sorter:"string",  editor:"input", headerFilter:"input"},
			],
		});
		$("#nodeCSV").tabulator("setData", "getRawDataNode.php");
		
		//trigger download of data.csv file
		$("#sts").click(function(){
			
			if(confirm('確定')){
				var rs = $("#nodeCSV").tabulator("getData");
				var fileName = $("#fileName").val();
				$.post( "updateRawDataNode.php", {"nodes": JSON.stringify(rs), "filename": fileName})
					.done(function( data ) {
					console.log( "Data Loaded: " + data );
				});
			}
		});
		
		//trigger download of data.csv file
		$("#stl").click(function(){
			var fileName = $("#fileName").val();
			$("#nodeCSV").tabulator("download", "csv", fileName + "_node.csv"); 
		});

	</script>
	
  </body>
</html>
