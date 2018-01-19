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
	<link href="css/datatables.min.css" rel="stylesheet" type="text/css" />

  </head>

  <body>
    <?php include('menu.php') ?>

    <div class="container-fluid">
      <div class="row">
        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
		<table id="example" class="display" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>File</th>
					<th>Status</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>File</th>
					<th>Status</th>
				</tr>
			</tfoot>
			<tbody>
            <tr>
                <td>Get Node info</td>
                <td> <img src="images/loading.gif" alt="loading" height="60" width="60"> </td>
            </tr>
			<tr>
                <td>Get Edge info</td>
                <td> <img src="images/loading.gif" alt="loading" height="60" width="60"> </td>
            </tr>
			<tr>
                <td>Get Demand info</td>
                <td> <img src="images/loading.gif" alt="loading" height="60" width="60"> </td>
            </tr>
			<tr>
                <td>Get SPF info</td>
                <td> <img src="images/loading.gif" alt="loading" height="60" width="60"> </td>
            </tr>
			<tr>
                <td>Get Analysis info</td>
                <td> <img src="images/loading.gif" alt="loading" height="60" width="60"> </td>
            </tr>
			</tbody>
		</table>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="lib/jquery-3.2.1.slim.min.js"></script>
	<script src="lib/jquery-1.12.4.js"></script>
    <script src="lib/popper.min.js"></script>
    <script src="lib/bootstrap.min.js"></script>
	<script src="lib/datatables.js"></script>
	<script>
	$(document).ready(function() {
		$('#example').DataTable( {
		} );
	} );
	</script>
  </body>
</html>
