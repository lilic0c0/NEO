<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Network Enhance Optimizer</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
	<link href="css/uploadstyle.css" rel="stylesheet" />
  </head>

  <body>
	<?php include('menu.php') ?>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
        </nav>

        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
			<h1>Upload file</h1>
			<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
				<div id="drop">
					Drop Here

					<a>Browse</a>
					<input type="file" name="upl" multiple />
				</div>

				<ul>
					<!-- The file uploads will be shown here -->
				</ul>

			</form>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.knob.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.iframe-transport.js"></script>
	<script src="js/jquery.fileupload.js"></script>
	<!-- Our main JS file -->
	<script src="js/file-upload.js"></script>
	
  </body>
</html>
