<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Network Enhance Optimizer</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dashboard.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
	<link href="css/netjsongraph.css" rel="stylesheet">
    <link href="css/netjsongraph-theme.css" rel="stylesheet">
	<link href="css/topolopy.css" rel="stylesheet">
	
	<script src="js/d3.v4.min.js"></script>
	
  </head>

  <body>
	<?php include('menu.php') ?>
	
	<div class="njg-menu">
		<div class="radio"><label><input type="radio" value="nomo" name="mode">Nomo</label></div>
		<div class="radio"><label><input type="radio" value="node" name="mode">Node</label></div>
		<div class="radio"><label><input type="radio" value="line" name="mode">Line</label></div>
		<div class="radio"><label><input type="radio" value="spf" name="mode">SPF</label></div>
		<div class="radio"><label><input type="radio" value="change" name="mode">expan</label></div>
	</div>
	<svg></svg>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="src/neo.js"></script> 
	<script src="src/topolopy.js"></script> 
  </body>
  
</html>
