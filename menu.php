<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="topolopy.php">NEO</a>
	<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
		  <li class="nav-item">
            <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				File
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="uploadView.php">Import</a>
				<a class="dropdown-item" href="selectView.php">Calculate Rawdata</a>
			  </div>
			</div>
          </li>
		  <li class="nav-item">
		    <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				RawData
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="rawDataNode.php">Node</a>
				<a class="dropdown-item" href="rawDataEdge.php">Edge</a>
				<a class="dropdown-item" href="rawDataDemand.php">Demand</a>
			  </div>
			</div>
		  <li class="nav-item">
		    <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Topology
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="topolopy.php?mode=pop">Topology(POP)</a>
				<a class="dropdown-item" href="topolopy.php?mode=router">Topology(Router)</a>
			  </div>
			</div>
		  <li class="nav-item">
            <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				SPF
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="showSPF.php">SPF</a>
				<a class="dropdown-item" href="showDemand.php">Demand</a>
				<a class="dropdown-item" href="showCircuitUtilization.php">Circuit utilization</a>
			  </div>
			</div>
          </li>
		  <li class="nav-item">
            <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Analysis
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="showSingleNodeFail.php">Single node fail </a>
				<a class="dropdown-item" href="showSingleCircuitFail.php">Single circuit fail </a>
			  </div>
			</div>
          </li>
		  <li class="nav-item">
            <div class="dropdown">
			  <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Settings
			  </a>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="getNewData.php">Get online data</a>
			  </div>
			</div>
          </li>
        </ul>
      </div>
</nav>