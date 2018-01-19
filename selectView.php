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
				<h1>Select data</h1>
				<form action="selectHandle.php" method="post">
				<?php
					$fileList = getfileList("uploads");
				?>
					<div class="form-group">
						<label for="nodeSelect">Node File</label>
						<select class="form-control" id="nodeSelect" name="nodeSelectData">
				<?php
					foreach($fileList['node'] as $filename){
						echo "<option>{$filename}</option>";
					}
				?>
						</select>
					 </div>
					 <div class="form-group">
						<label for="edgeSelect">Edge File</label>
						<select class="form-control" id="edgeSelect" name="edgeSelectData">
				<?php
					foreach($fileList['edge'] as $filename){
						echo "<option>{$filename}</option>";
					}
				?>
						</select>
					 </div>
					 <div class="form-group">
						<label for="demandSelect">Demand File</label>
						<select class="form-control" id="demandSelect" name="demandSelectData">
				<?php
					foreach($fileList['demand'] as $filename){
						echo "<option>{$filename}</option>";
					}
				?>
						</select>
					 </div>
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
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

	</script>
	
  </body>
</html>
<?php

function getfileList($targetFolder){
	
	
	$tmpArr = array(
		"node" => array(),
		"edge" => array(),
		"demand" => array()
	);
	
	$fileNameList = scandir($targetFolder);
	
	foreach($fileNameList as $filename){
	
		if(strpos($filename, "node") !== false){
			array_push($tmpArr['node'], $filename);
		} else if(strpos($filename, "edge") !== false) {
			array_push($tmpArr['edge'], $filename);
		} else if(strpos($filename, "demand") !== false) {
			array_push($tmpArr['demand'], $filename);
		}
	}
	
	return $tmpArr;
}
?>