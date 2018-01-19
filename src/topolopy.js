$(document).ready(function() {
	
	d3.json("rawdata/netjson.json", function(json) {
		
		var data = json;
		var svg = d3.select("svg");
		
		var neo = new NEO(svg, data.pops, data.nodes, data.links, data.spf, true);
		
		//click zone	
		d3.selectAll("input[name='mode']").on("change", function (){ 
			
			if(this.value == "nomo"){
				neo.setMode("nomo");
			} else if(this.value == "change"){
				neo.setMode("change");
			} else if(this.value == "node"){
				neo.setMode("node");
			} else if(this.value == "line"){
				neo.setMode("line");
			} else if(this.value == "spf"){
				neo.setMode("spf");
			}
			neo.reset();
		});
		/*
		$("#log").on("click", function() {
			
			var rs = neo.getNodeData();

			d3.request('updateAddr.php')
				//.header("Content-Type","application/json")
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Content-Type", "application/x-www-form-urlencoded")
				.post('nodes='+JSON.stringify(rs) , function(err, rawData){

						console.log(rawData.response);
				});

		});
		*/
		
	});
});