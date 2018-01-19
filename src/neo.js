function NEO(svg, pops, nodes, links, spfs, mode) { 

	var oNEO = this;
	
	var width = 7000;
	var height = 7000;
	var grid = 50;
	
	//
	oNEO.modeFlag = "nomo";
	oNEO.gFlag = mode;
	oNEO.sNode = null;
	oNEO.tNode = null;
	
	//showbox
	oNEO.overlay = d3.select("body").append("div").attr("class", "njg-overlay");
	oNEO.closeOverlay = oNEO.overlay.append("a").attr("class", "njg-close");
	oNEO.overlayInner = oNEO.overlay.append("div").attr("class", "njg-inner");
	
	//for D3
	oNEO.SVG = svg;
	oNEO.Zoom = null;
	oNEO.G = oNEO.SVG.append("g");	
	oNEO.color = d3.scaleOrdinal(d3.schemeCategory20);
	oNEO.simulation = null;
	oNEO.linkg = null;
	oNEO.link = null;
	oNEO.nodeg = null;
	oNEO.node = null;
	oNEO.textg = null;
	oNEO.text = null;
		
	//for data info
	oNEO.popArr = [];
	oNEO.nodeArr = [];
	oNEO.linkArr = [];
	oNEO.popLinkArr = [];
	oNEO.spfArr = [];
	oNEO.popSPFArr = [];
	
	//for rendering	
	oNEO.rNodes = [];
	oNEO.rLinks = [];
	
	//constructor
	var init = function() {
	
		//spf
		for(var i in spfs){
			
			if(!oNEO.spfArr.hasOwnProperty(spfs[i].source)) oNEO.spfArr[spfs[i].source] = [];
			oNEO.spfArr[spfs[i].source][spfs[i].target] = [];
			
			for(var j in spfs[i].through){
				
				if(spfs[i].through[j] == null) spfs[i].through[j]=[];

				spfs[i].through[j].unshift(spfs[i].source);
				spfs[i].through[j].push(spfs[i].target);
			}
			
			oNEO.spfArr[spfs[i].source][spfs[i].target] = spfs[i].through;
		}
		
		for(var i in oNEO.spfArr){
			
			var src = i.substring(0, 4);
			if(!oNEO.popSPFArr.hasOwnProperty(src)) oNEO.popSPFArr[src] = [];
			
			for(var j in oNEO.spfArr[i]){
			
				var dst = j.substring(0, 4); 
				if(src == dst) continue;
				
				if(!oNEO.popSPFArr[src].hasOwnProperty(dst)) oNEO.popSPFArr[src][dst] = [];
				
				for(var k in oNEO.spfArr[i][j]){

					var tmp = [];
					tmp.push(oNEO.spfArr[i][j][k][0].substring(0, 4));
										
					for(var l=1; l < oNEO.spfArr[i][j][k].length; l++){
						if(oNEO.spfArr[i][j][k][l-1].substring(0, 4) == oNEO.spfArr[i][j][k][l].substring(0, 4)){
							continue;
						} else {
							tmp.push(oNEO.spfArr[i][j][k][l].substring(0, 4));
						}
					}
					
					var flag = true;
					for(var m in oNEO.popSPFArr[src][dst]){
						if(oNEO.popSPFArr[src][dst][m].toString() == tmp.toString()){
							flag = false;
							break;
						}
					}
					if(flag){
						oNEO.popSPFArr[src][dst].push(tmp);
					}
					
				}
			}
		
		}

		//pops
		for (var i in pops) {
			
			o = pops[i];
			o.location = o.name;
			o.cNodes = [];
			o.iLinks = [];
			o.count = 0;
			
			oNEO.popArr[o.name] = o;
		}
		
		//nodes
		for (var i in nodes) {
		
			o = nodes[i];
			o.name = o.hostname;
			o.count = 0;

			oNEO.nodeArr[o.name] = o;
			oNEO.popArr[o.location].cNodes.push(o);
		}
		
		
		//link
		for (var i in links) {
		
			o = links[i];
			oNEO.nodeArr[o.source].count++;
			o.id = o.source + "_" + o.target;
			o.source = oNEO.nodeArr[o.source];
			o.target = oNEO.nodeArr[o.target];
			
			oNEO.linkArr.push(o);
			
			//for group
			if(o.source.location == o.target.location){
				
				oNEO.popArr[o.source.location].iLinks.push(o);
				continue;
			}
				
			var hit = false;
			for(var j in oNEO.popLinkArr){
				
				var glink = oNEO.popLinkArr[j];
				
				if(o.source.location == glink.source.location && o.target.location == glink.target.location){
					
					if(o.utilization > glink.utilization){
						oNEO.popLinkArr[j].utilization = o.utilization;
					}
					oNEO.popLinkArr[j].traffic += o.traffic;
					oNEO.popLinkArr[j].bw += o.bw;
					oNEO.popArr[o.source.location].count++;
					oNEO.popLinkArr[j].cLinks.push(o);
					hit = true;
					break;
				}
				//glinkArr		
			}
			
			if(!hit){
				
				oNEO.popArr[o.source.location].count = 1;
				
				var arr = [o];
				oNEO.popLinkArr.push({ 
					"source": oNEO.popArr[o.source.location], 
					"target": oNEO.popArr[o.target.location],
					"id": o.source.location + "_" + o.target.location,
					"traffic": o.traffic, 
					"bw": o.bw,
					"utilization": o.utilization, 
					"cLinks": arr }); 
			}
		}
		
		//set start with pop
		if(oNEO.gFlag){
			
			for(var i in oNEO.popArr){
				oNEO.rNodes.push(oNEO.popArr[i]); 
			}
			for(var i in oNEO.popLinkArr){
				oNEO.rLinks.push(oNEO.popLinkArr[i]);
			}
			
		} else {
			
			for(var i in oNEO.nodeArr){
				oNEO.rNodes.push(oNEO.nodeArr[i]); 
			}
			for(var i in oNEO.linkArr){
				oNEO.rLinks.push(oNEO.linkArr[i]);
			}
		}
			
		//Rendering
		oNEO.closeOverlay.on("click", function() {
			d3.selectAll("svg .njg-open").classed("njg-open", false);
			oNEO.overlay.classed("njg-hidden", true);
		});

		oNEO.Zoom = d3.zoom().on("zoom", zoomed);//.scaleExtent([1 / 8, 4])
		oNEO.SVG.call(oNEO.Zoom).on("dblclick.zoom", null);
		oNEO.simulation = d3.forceSimulation()
			.force("link", d3.forceLink().id(function(d) { return d.id; }).distance(10).strength(1))
			.force("charge", d3.forceManyBody().strength(-10).distanceMax(100));
			//.force("center", d3.forceCenter(1000, 1000));
			//.force("y", d3.forceY(500))
			//.force("x", d3.forceX(500));
			//.force("collide",d3.forceCollide(.5));
			//.force("collide",d3.forceCollide( function(d){return d.r + 8 }).iterations(4) );
			
		drawGrid(width, height, grid);
		drawNetwork(oNEO.rNodes, oNEO.rLinks);
	}
	
	//ZOOM
	var zoomed = function () {
		oNEO.G.attr("transform", d3.event.transform);
	}
	
	//rendering network
	var drawNetwork = function (nodes, links) {
		
		//if (oNEO.simulation) oNEO.simulation.stop();
		
		oNEO.linkg = oNEO.G.append("g");
		oNEO.link = oNEO.linkg.selectAll("path")
			.data(links)
			.enter().append("path")
				.attr("class", function(d) { return (d.utilization > 10)?"link_alert":"link_nomo"; })
				.attr("id", function (d){return d.id;})
			.on("click", onClickLink)
			.on("mouseout", function(d) {
				d3.select(this).classed("link_over", false);
			})                  
			.on("mouseover", function(d) { 
				d3.select(this).classed("link_over", true);
			});

		oNEO.nodeg = oNEO.G.append("g");
		oNEO.node = oNEO.nodeg.selectAll("circle").data(nodes)
			.enter().append("circle")
				.attr("class", "node")
				.attr("id", function (d){return d.name;})
				.attr("r", function (d){ 
					var r = (d.count < 3)?3:d.count/2;
					return 7+r;
				})
				.on("dblclick", onDbClickNode)
				.on("click", onClickNode)
				.call(d3.drag()
					.on("start", dragstarted)
					.on("drag", dragged)
					.on("end", dragended));
					
		oNEO.textg = oNEO.G.append("g");
		oNEO.text = oNEO.textg.selectAll("text")
			.data(nodes)
			.enter().append("text")
				.attr("x", -20)
				.attr("y", ".31em")
				.text(function(d) { return d.name;});

		oNEO.simulation
			.nodes(nodes)
			//  .alphaDecay(0.5)
			.velocityDecay(0.1)
			.on("tick", ticked);

		oNEO.simulation.force("link")
			.links(links);
			
		oNEO.simulation.alpha(1).restart();
	}
	
	//rendering Grid
	var drawGrid = function(width, height, grid) {

		var lineGraph = oNEO.G.append("g")
				.attr("width", width)
				.attr("height", height);

		// Using for loop to draw multiple horizontal lines
		for (var j=grid; j <= width-grid; j=j+grid) {
			lineGraph.append("svg:line")
				.attr("x1", 0)
				.attr("y1", j)
				.attr("x2", width)
				.attr("y2", j)
				.attr("class", "dasharray")
				.style("stroke", "rgb(119,119,119)")
				.style("stroke-width", 1);
		};

		// Using for loop to draw multiple vertical lines
		for (var j=grid; j <= height-grid; j=j+grid) {
			lineGraph.append("svg:line")
				.attr("x1", j)
				.attr("y1", 0)
				.attr("x2", j)
				.attr("y2", height)
				.attr("class", "dasharray")
				.style("stroke", "rgb(119,119,119)")
				.style("stroke-width", 1);
		};
	}
	
	
	//tick
	var ticked = function () {
		
		oNEO.link.attr("d", drawLinkArc);
		
		oNEO.node
		  .attr("cx", function(d) { return d.x; })
		  .attr("cy", function(d) { return d.y; });
		
		oNEO.text
		  .attr("x", function(d) { return d.x; })
		  .attr("y", function(d) { return d.y; });  
		
	}
	
	
	//draw link
	var drawLinkArc = function (d) {

		var dx = d.target.x - d.source.x,
			dy = d.target.y - d.source.y,
			dr = Math.sqrt(dx * dx + dy * dy)*6;
		
		var	dx = Number(d.source.x) + Number((d.target.x - d.source.x)/2);
			dy = Number(d.source.y) + Number((d.target.y - d.source.y)/2);
			
		//return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0 1 " + d.target.x + "," + d.target.y;
		return "M" + d.source.x + " " + d.source.y + "L" + dx + " " + dy;
	}
	
	//dragstarted
	var dragstarted = function (d) {
	
		  //if (!d3.event.active) simulation.alphaTarget(0.3).restart();
		  oNEO.simulation.restart();
		  // simulation.alpha -> redemarre la periode de simulation
		  oNEO.simulation.alpha(1.0);
		  d.fx = d.x;
		  d.fy = d.y;
	}
	
	//dragged
	var dragged = function (d,i) {
	
		//force.stop();
		//var grid = 50;

		var gx = Math.round(d3.event.x/grid)*grid;
		var gy = Math.round(d3.event.y/grid)*grid;

		d.fx = gx;
		d.fy = gy;
	}
	
	//dragended	
	var dragended = function(d) {
		
		if (!d3.event.active){ 
			oNEO.simulation.alphaTarget(0);
		}
		//    console.log(d);
		//  d.fx = null;
		//  d.fy = null;
		//  d.fixed = true;
	}
	
	//dbclick node	
	var onDbClickNode = function (n) {


	}	
	
	//click node	
	var onClickNode = function (n) {
		
		if(oNEO.modeFlag == "nomo"){
		
			showNodeInfo(n);
		
		} else if(oNEO.modeFlag == "node"){
		
			oNEO.SVG.selectAll("path").each(function(d, i) {
			
				if(d.source.name != n.name && d.target.name != n.name ){
					d3.select(this).attr("class", "unselected");
				} else if(d.utilization > 60){
					d3.select(this).attr("class", "selected_alert");
				} else {
					d3.select(this).attr("class", "selected");
				}
			});	
			
			showNodeInfo(n);
		
		} else if (oNEO.modeFlag == "spf"){
			
			if(oNEO.sNode == null){
				
				d3.select(this).attr("class", "node_select_src");
				oNEO.sNode = n;
				
			} else  {
			
				if(oNEO.tNode != null){
					d3.select("#"+oNEO.tNode.name).attr("class", "node");
				}
				
				d3.select(this).attr("class", "node_select_dst");
				
				oNEO.tNode = n;
				showNodeSPF(oNEO.sNode, oNEO.tNode);
			}
		}
		
	}
	
	//click Link
	var onClickLink = function (l) {
		
		if(oNEO.modeFlag == "line"){
			showLineSPF(l);
		} else {
			showLinkInfo(l);
		}
	}	
	
	//
	var setRendringData = function(){
		
	}
	
	//set show box message
	var setShowbox = function(html){
		
		oNEO.overlayInner.html(html);
		oNEO.overlay.classed("njg-hidden", false);
		oNEO.overlay.style("display", "block");

	}
	
	//show node info
	var showNodeInfo = function(n) {
		
		var	html = "<p><b>Name</b>: " + n.name + "</p>";
			html += "<p><b>Location</b>: " + n.location + "</p>";
		
		if(n.hasOwnProperty("loopback")) {
			html += "<p><b>loopback</b>: " + n.loopback + "</p>";
		} else {
			html += "<p><b>Router</b>: <ul>";
			for(var i in n.cNodes){
				
				html += "<li>" + n.cNodes[i].name + "</li>";
			}
			html += "</ul></p>";
		}
		
		setShowbox(html);
	}
	
	//show link info
	var showLinkInfo = function(l) {
		
		var	html = "<p><b>source</b>: " + (l.source.name) + "</p>";
			html += "<p><b>target</b>: " + (l.target.name) + "</p>";
			html += "<p><b>traffic</b>: " + l.traffic + "</p>";
			html += "<p><b>bandWidths</b>: " + l.bw + "</p>";
			html += "<p><b>utilization</b>: " + l.utilization + "% </p>";
		
		html += "<p><b>edges</b>: <ul>";
		
		if(l.hasOwnProperty("cLinks")) {
			
			for(var i in l.cLinks){
				for(var j in l.cLinks[i].CIDs){
					html += "<li>" + l.cLinks[i].CIDs[j].id + "</li>"; 
				}
			}

		} else {
		
			for(var j in l.CIDs[j]){
				html += "<li>" + l.CIDs[j].id + "</li>"; 
			}
		}
		
		html += "</ul>";
		
		setShowbox(html);
	}
	
	//show spf line
	var showLineSPF = function(l){
		
		var SPF = oNEO.popSPFArr;
		if(!l.hasOwnProperty("cLinks")) {
			SPF = oNEO.spfArr;
		}
		
		var tmp = inSPFArr(l, SPF);
		
		oNEO.SVG.selectAll("path").each(function(d, i) {
			
			d3.select(this).attr("class", "unselected");
			
		});
		
		for(var i in tmp){
			for(var j=0; j < tmp[i].length-1; j++){
				d3.select("#"+tmp[i][j]+"_"+tmp[i][j+1]).attr("class", "link_spf_select_bk");
				d3.select("#"+tmp[i][j+1]+"_"+tmp[i][j]).attr("class", "link_spf_select_bk");
			}
		}
		
		d3.select("#"+l.id).attr("class", "link_spf_select");
		
		
		var	html = "<p><b>source</b>: " + (l.source.name) + "</p>";
			html += "<p><b>target</b>: " + (l.target.name) + "</p>";
			html += "<p><b>Contain Paths</b>: <ul>";
		
		for(var i in tmp){
				
			var str = tmp[i].toString()
				.replace(l.source.name, "<b>"+l.source.name+"</b>")
				.replace(l.target.name, "<b>"+l.target.name+"</b>");
			
			html += "<li>" + str + "</li>"; 
				
		}
		html += "</ul>";
		
		setShowbox(html);
		
		$(".njg-overlay").on('click','li',function (){
		
			d3.selectAll(".link_spf_select_bk").classed("blink", false);
			
			var hops = $(this).text().split(",");
			
			for(var i=0; i < hops.length-1; i++){
				d3.select("#"+hops[i]+"_"+hops[i+1]).classed("blink", true);
				d3.select("#"+hops[i+1]+"_"+hops[i]).classed("blink", true);
			}
			
		});
	}
	
	//show spf node
	var showNodeSPF = function(src, dst){
		
		var SPF = oNEO.popSPFArr;
		if(!src.hasOwnProperty("cNodes")) {
			SPF = oNEO.spfArr;
		}
			
		oNEO.SVG.selectAll("path").each(function(d, i) {
		
			d3.select(this).attr("class", "unselected");
			
			if(	is_InSPF(d, SPF[oNEO.sNode.name][oNEO.tNode.name]) || 
				is_InSPF(d, SPF[oNEO.sNode.name][oNEO.tNode.name], true) ){
				
				d3.select(this).attr("class", "link_spf_select");
			}
			
		});

		var	html = "<p><b>source</b>: " + (src.name) + "</p>";
			html += "<p><b>target</b>: " + (dst.name) + "</p>";
			html += "<p><b>SPF</b>: <ul>";
			for(var i in SPF[src.name][dst.name]){
			
				var str = SPF[src.name][dst.name][i].toString();
				
				html += "<li>" + str + "</li>"; 
			}
			html += "</ul>";	

		setShowbox(html);	

		$(".njg-overlay").on('click','li',function (){
		
			d3.selectAll(".link_spf_select").classed("blink", false);
			
			var hops = $(this).text().split(",");
			
			for(var i=0; i < hops.length-1; i++){
				d3.select("#"+hops[i]+"_"+hops[i+1]).classed("blink", true);
				d3.select("#"+hops[i+1]+"_"+hops[i]).classed("blink", true);
			}
			
		});		
	}
	
	//link in SPF
	var is_InSPF = function (link, SPF, R=false){
		
		var src = link.source.name;
		var dst = link.target.name;
		
		if(R){
			dst = link.source.name;
			src = link.target.name;			
		}
		
		for(var k in SPF){
			
			for(var l=0; l<SPF[k].length-1; l++){
				
				if( src == SPF[k][l] && dst == SPF[k][l+1]){

					return true;
				}
			}
		}
		
		return false;
	}
	
	//link in SPF
	var inSPFArr = function (link, SPF){
		var tmp = [];
		
		for(var i in SPF){
			for(var j in SPF[i]){
				for(var k in SPF[i][j]){
					for(var l=0; l<SPF[i][j][k].length-1; l++){
						
						if(link.source.name == SPF[i][j][k][l] && link.target.name == SPF[i][j][k][l+1]){
								
							tmp.push(SPF[i][j][k]);
						}
					}
				}
			}
		}
		
		return tmp;
	}
	
	//set mode
	oNEO.setMode = function(mode){
		oNEO.modeFlag = mode;
	}
	
	//reset
	oNEO.reset = function(){
		
		oNEO.linkg.remove();
		oNEO.nodeg.remove();
		oNEO.textg.remove();
			
		oNEO.sNode = null;
		oNEO.tNode = null;
		
		if(oNEO.modeFlag == "change"){
			
			oNEO.rNodes = [];
			oNEO.rLinks = [];
		
			oNEO.gFlag = !oNEO.gFlag;
		
			if(oNEO.gFlag){
				
				for(var i in oNEO.popArr){
					oNEO.rNodes.push(oNEO.popArr[i]); 
				}
				for(var i in oNEO.popLinkArr){
					oNEO.rLinks.push(oNEO.popLinkArr[i]);
				}
				
			} else {
				
				for(var i in oNEO.nodeArr){
					oNEO.rNodes.push(oNEO.nodeArr[i]); 
				}
				for(var i in oNEO.linkArr){
					oNEO.rLinks.push(oNEO.linkArr[i]);
				}
			}
			
			oNEO.linkg.selectAll("*").remove();
			oNEO.nodeg.selectAll("*").remove();
			oNEO.textg.selectAll("*").remove();
		
		}
		
		drawNetwork(oNEO.rNodes, oNEO.rLinks);
	}
	
	//get node x,y
	oNEO.getNodeData = function(){
		return oNEO.rNodes.map(function(d) { return {"name":d.name, "x": d.x, "y":d.y}; });
	}
	
	//get node x,y
	oNEO.getData = function(){
		return oNEO.rNodes;
	}
	
	//init	
	init();
	
}