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
	<link href="css/datatables.css" rel="stylesheet" type="text/css" />

  </head>

  <body>
    <?php include('menu.php') ?>

    <div class="container-fluid">
      <div class="row">
        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
		
		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item">
			<a class="nav-link active" id="TypeA-tab" data-toggle="tab" href="#TypeA" role="tab" aria-controls="home" aria-expanded="true">Type A</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="TypeB-tab" data-toggle="tab" href="#TypeB" role="tab" aria-controls="profile">Type B</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="TypeC-tab" data-toggle="tab" href="#TypeC" role="tab" aria-controls="profile">Type C</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="TypeA" role="tabpanel" aria-labelledby="TypeA-tab">
				<table id="tabTypeA" class="display" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Router</th>
							<th>Impact traffic (MB)</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Router</th>
							<th>Impact traffic (MB)</th>
						</tr>
					</tfoot>
				</table>
			</div>
		  <div class="tab-pane fade" id="TypeB" role="tabpanel" aria-labelledby="TypeB-tab">
		  		<table id="tabTypeB" class="display" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Router</th>
							<th>Impact Circuits</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Router</th>
							<th>Impact Circuits</th>
						</tr>
					</tfoot>
				</table>
		  </div>
		  <div class="tab-pane fade" id="TypeC" role="tabpanel" aria-labelledby="TypeC-tab">
		  		<table id="tabTypeC" class="display" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Circuit</th>
							<th>Impacted Count</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Circuit</th>
							<th>Impacted Count</th>
						</tr>
					</tfoot>
				</table>
		  </div>
		</div>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/datatables.js"></script>
	<script>
		$(document).ready(function() {
			$('#tabTypeA').DataTable( {
				"ajax": 'getCalcFailNode.php?type=TypeA',
				"order": [[ 1, "desc" ]]
			} );
			$('#tabTypeB').DataTable( {
				"ajax": 'getCalcFailNode.php?type=TypeB',
				"order": [[ 1, "desc" ]]
			} );
			$('#tabTypeC').DataTable( {
				"ajax": 'getCalcFailNode.php?type=TypeC',
				"order": [[ 1, "desc" ]]
			} );
					
		} );
	</script>
  </body>
</html>
