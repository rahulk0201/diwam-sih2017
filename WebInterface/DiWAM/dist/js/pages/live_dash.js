//params
var url = "";
var kit_readings;
var state_dict;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//Map params
var mymap;
var blueIcon = L.icon({
    iconUrl: 'plugins/leaflet/images/blue_marker.png',
    shadowUrl: 'plugins/leaflet/images/marker-shadow.png',

    iconSize:     [25, 37], // size of the icon
    shadowSize:   [33, 43], // size of the shadow
    iconAnchor:   [15, 37], // point of the icon which will correspond to marker's location
    shadowAnchor: [12, 43],  // the same for the shadow
    popupAnchor:  [-1, -30] // point from which the popup should open relative to the iconAnchor
});
var redIcon = L.icon({
    iconUrl: 'plugins/leaflet/images/red_marker.png',
    shadowUrl: 'plugins/leaflet/images/marker-shadow.png',

    iconSize:     [25, 37], // size of the icon
    shadowSize:   [33, 43], // size of the shadow
    iconAnchor:   [15, 37], // point of the icon which will correspond to marker's location
    shadowAnchor: [12, 43],  // the same for the shadow
    popupAnchor:  [-1, -30] // point from which the popup should open relative to the iconAnchor
});

//constants
var count = "COUNT";
var state_summary = "STATE_SUMMARY";
var unsafe_sources = "UNSAFE_SOURCES";
var all = "ALL";

//flags
var data_loaded = false;

$(document).ready(function(){

	init_data();
	get_data();
	setInterval(get_data,10000);
  //set date
  n =  new Date();
	y = n.getFullYear();
	m = n.getMonth() + 1;
	d = n.getDate();
	document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
});

//this function gets the all the data from the today table
function get_data() {
	
	get_summary(all, function(data) {
		kit_readings = data;

		var dict = {};
	  var states = [];
	  var safe = [];
	  var unsafe = [];

	  for(var i = 0; i < data.length; i++) {
			var obj = data[i];
			dict[obj.state] = {"Safe":0, "Unsafe":0, "sources":[]};
	  }

	  for(var i = 0; i < data.length; i++) {
			var obj = data[i];
			if(obj.status == "Safe" && dict[obj.state]["sources"].indexOf(obj.source) == -1) {
				dict[obj.state]["Safe"]++;
				dict[obj.state]["sources"].push(obj.source);
			}
			else {
				if(dict[obj.state]["sources"].indexOf(obj.source) == -1) {
					dict[obj.state]["Unsafe"]++;
					dict[obj.state]["sources"].push(obj.source);
				}
			}
	  }
	 
	  for(var key in dict) {
	  	states.push(key);
	  	safe.push(dict[key]["Safe"]);
	  	unsafe.push(dict[key]["Unsafe"]);
	  }

	  state_dict = dict;

	  //add data to state list filter of pie chart
	  var text_pie = "<option>select</option>";
	  var text_table = "<option>select</option>";

	  for(var i=0;i<states.length;i++) {
			text_pie += "<option>"+ states[i] +"</option>";
			text_table += "<option>"+ states[i] +"</option>"
		}
	  
	  document.getElementById("state_options").innerHTML = text_pie;

		//display state, source, status in live readings
		document.getElementById("state_options_live").innerHTML = text_table;

		text_table = "<option>select</option>";
		for(var i=0;i<data.length;i++) {
			
			text_table += "<option>"+ data[i]["source"] +"</option>";
		}
		document.getElementById("source_options_live").innerHTML = text_table;

	  //enable filters
	  document.getElementById("state_options").disabled = false;
	  document.getElementById("state_options_live").disabled = false;
	  document.getElementById("source_options_live").disabled = false;
	  document.getElementById("status_options_live").disabled = false;
	  //update charts at intervals
	  render_state_chart(states, safe, unsafe);

	  render_map(data);
	});
}

//init summarized data
function init_data() {

	//initialize maps
  mymap = L.map('mapid').setView([20.5937, 78.9629], 5);

	get_summary(count, function(data) {
		update_info_boxes(data[0]["total"], data[0]["safe"], data[0]["unsafe"], data[0]["kits"]);
	});

	get_summary(state_summary, function(data) {
		var states = [];
	  var safe = [];
	  var unsafe = [];

	  for(var i = 0; i < data.length; i++) {
			var obj = data[i];
			states.push(obj.state);
			safe.push(obj.safe_sources);
			unsafe.push(obj.unsafe_sources);
	  }
	  render_state_chart(states, safe, unsafe);
	});

	get_summary(unsafe_sources, function(data) {

		var states = [];
		for(var i=0;i<data.length;i++) {
			var obj = data[i];
			if(states.indexOf(obj.state) == -1)
				states.push(obj.state);
		}
		//display live readings for all source_options_live
		rows = `
			<table class="table table-bordered"">
	    <tr>
	      <th>KIT ID</th>
	      <th>Source</th>
	      <th>State</th>
	      <th>Time</th>
	      <th>PH</th>
	      <th>EC</th>
	      <th>TDS</th>
	      <th>ORP</th>
	      <th>Turbidity</th>
	      <th>Temperature</th>
	      <th>Status</th>
	    </tr>
		`;
		for(var i = 0; i < data.length; i++) {
			var obj = data[i];
			
			rows += `<tr>
				<td>`+ obj.kit_id +`</td>
				<td>`+ obj.source +`</td>
				<td>`+ obj.state +`</td>
				<td>`+ obj.timestamp +`</td>`;

			if(obj.ph_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ph +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ph +`</td>`;
			if(obj.ec_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ec +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ec +`</td>`;
			if(obj.tds_anomaly == 1)
				rows += `<td style="color:red">`+ obj.tds +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.tds +`</td>`;
			if(obj.orp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.orp +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.orp +`</td>`;
			if(obj.turb_anomaly == 1)
				rows += `<td style="color:red">`+ obj.turbidity +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.turbidity +`</td>`;
			if(obj.temp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.temperature +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.temperature +`</td>`;

			rows += `<td><span class="label label-danger">` +obj.status+ `</span></td>`;	

			rows += "</tr>";
		}
		rows += "</table>";
		document.getElementById("live_readings").innerHTML = rows;
	});
}


//get summary
function get_summary(s, callback) {

	if(s.localeCompare(count) === 0) {
		url = "core/count_summary.php";
	}
	else if(s.localeCompare(state_summary) == 0) {
		url = "core/state_summary.php";
	}
	else if(s.localeCompare(unsafe_sources) == 0) {
		url = "core/unsafe_sources.php";
	}
	else if(s.localeCompare(all) == 0) {
		url = "core/all_data.php";
	}

	var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", url);
  xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
  xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
  xmlhttp.setRequestHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
  xmlhttp.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
  xmlhttp.setRequestHeader("Access-Control-Request-Headers", "X-Requested-With, accept, content-type");

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    	var data = JSON.parse(xmlhttp.responseText);
    	callback(data);
    }	
  };

  xmlhttp.send();
}


//update info boxes
function update_info_boxes(total, safe, unsafe, kits) {

	//update DOM
	var x = document.getElementsByClassName("info-box-number");
	x[0].innerHTML = total;
	x[1].innerHTML = safe;
	x[2].innerHTML = unsafe;
	x[3].innerHTML = kits;
}


//update bar chart
function render_state_chart(states, safe, unsafe) {

  var stateChartData = {
    labels  : states,
    datasets: [
      {
        label               : 'Safe sources',
        backgroundColor 		: color_green,
        pointBackgroundColor: 'pink',
        pointHoverBackgroundColor: 'rgba(green, 1)',
        borderColor 				: 'rgba(black, 1)',
        pointBorderColor 		: '#fff',
        pointHoverBorderColor: 'rgba(black, 1)',
        data                : safe
      },
      {
        label               : 'Unsafe sources',
        backgroundColor 		: color_red,
        pointBackgroundColor: 'pink',
        pointHoverBackgroundColor: 'rgba(red, 1)',
        borderColor 				: 'rgba(black, 1)',
        pointBorderColor 		: '#fff',
        pointHoverBorderColor: 'rgba(black, 1)',
        data                : unsafe
      }
    ]
  };

  var ctx = document.getElementById('stateChart').getContext('2d');
	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: stateChartData,
		options: {
			responsive: true,
			legend: {
				position: 'top',
			}
		}
	});
}


//update pie chart
function update_pie_chart() {
	var state = document.getElementById("state_options").value;
	var safe = state_dict[state]["Safe"];
	var unsafe = state_dict[state]["Unsafe"];

	render_pie_chart(state, safe, unsafe);
}

//render pie
function render_pie_chart(state, safe, unsafe) {

  var config = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
					safe, unsafe
				],
				backgroundColor: [
					color_green, color_red
				],
				label: state
			}],
			labels: [
				'Safe sources',
				'Unsafe sources'
			]
		},
		options: {
			responsive: true,
			legend: {
				position: 'bottom',
			}
		}
	};

	var ctx = document.getElementById('pieChart').getContext('2d');
	window.myPie = new Chart(ctx, config);
  // -----------------
  // - END PIE CHART -
  // -----------------
}


//create pie, bar, map
function render_map(data) {

  // --------
  // - MAPS -
  // --------

  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets'
  }).addTo(mymap);

  for(var i=0;i<data.length;i++) {

  	var obj = data[i];
  	var str = "Source: "+ obj.source +"  Anomaly:";

  	if(obj.ph_anomaly == 1)
			str += " PH,";
		if(obj.ec_anomaly == 1)
			str += " EC,";
		if(obj.tds_anomaly == 1)
			str += " TDS,";
		if(obj.orp_anomaly == 1)
			str += " ORP,";
		if(obj.turb_anomaly == 1)
			str += " Turbidity,";
		if(obj.temp_anomaly == 1)
			str += " Temperature";

  	if(obj.status.localeCompare("Safe") == 0)
  		L.marker([obj.latitude, obj.longitude], {icon: blueIcon}).addTo(mymap).bindPopup(str);
  	else
  		L.marker([obj.latitude, obj.longitude], {icon: redIcon}).addTo(mymap).bindPopup(str);
  }


  var popup = L.popup();

  function onMapClick(e) {
    popup
      .setLatLng(e.latlng)
      .setContent("You clicked the map at " + e.latlng.toString())
      .openOn(mymap);
  }

  mymap.on('click', onMapClick);

  // -----------
  // - END MAP -
  // -----------
}



////////////
///EVENTS///
////////////
function update_live_readings(id) {

	var dict = kit_readings;
	var states = [];

	for(var key in dict) {
		states.push(key);
	}

	//state selected
	if(id.localeCompare("state_options_live") == 0) {

		var state = document.getElementById("state_options_live").value;
		var status = document.getElementById("status_options_live").value;

		if(state.localeCompare("select") == 0) {
			return;
		}

		//update table
		//display live readings for all sources
		rows = `
			<table class="table table-bordered"">
	    <tr>
	      <th>KIT ID</th>
	      <th>Source</th>
	      <th>State</th>
	      <th>Time</th>
	      <th>PH</th>
	      <th>EC</th>
	      <th>TDS</th>
	      <th>ORP</th>
	      <th>Turbidity</th>
	      <th>Temperature</th>
	      <th>Status</th>
	    </tr>
		`;
		for(var i = 0; i < kit_readings.length; i++) {
			var obj = kit_readings[i];

			if(state.localeCompare(obj.state) != 0 || status.localeCompare(obj.status) != 0)
				continue;

			rows += `<tr>
				<td>`+ obj.kit_id +`</td>
				<td>`+ obj.source +`</td>
				<td>`+ obj.state +`</td>
				<td>`+ obj.timestamp +`</td>`;
			
			if(obj.ph_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ph +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ph +`</td>`;
			if(obj.ec_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ec +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ec +`</td>`;
			if(obj.tds_anomaly == 1)
				rows += `<td style="color:red">`+ obj.tds +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.tds +`</td>`;
			if(obj.orp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.orp +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.orp +`</td>`;
			if(obj.turb_anomaly == 1)
				rows += `<td style="color:red">`+ obj.turbidity +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.turbidity +`</td>`;
			if(obj.temp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.temperature +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.temperature +`</td>`;

			if(obj.status.localeCompare("Safe") == 0) 
				rows += `<td><span class="label label-success">Safe</span></td>`;
			else 
				rows += `<td><span class="label label-danger">Unsafe</span></td>`;

			rows += "</tr>";
		}
		rows += "</table>";
		document.getElementById("live_readings").innerHTML = rows;

		//set sources filter
		var sources = state_dict[state]["sources"];
		var src_text = "<option>select</option>";
		for(var i=0;i<sources.length;i++) {
			src_text += "<option>"+ sources[i] +"</option>";
		}
		document.getElementById("source_options_live").innerHTML = src_text;
	}

	else if(id.localeCompare("source_options_live") == 0) {

		//get source
		var source = document.getElementById("source_options_live").value;

		//display live readings for selected source
		rows = `
			<table class="table table-bordered"">
	    <tr>
	      <th>KIT ID</th>
	      <th>Source</th>
	      <th>State</th>
	      <th>Time</th>
	      <th>PH</th>
	      <th>EC</th>
	      <th>TDS</th>
	      <th>ORP</th>
	      <th>Turbidity</th>
	      <th>Temperature</th>
	      <th>Status</th>
	    </tr>
		`;
		for(var i = 0; i < kit_readings.length; i++) {
			var obj = kit_readings[i];

			if(source.localeCompare(obj.source) != 0)
				continue;

			rows += `<tr>
				<td>`+ obj.kit_id +`</td>
				<td>`+ obj.source +`</td>
				<td>`+ obj.state +`</td>
				<td>`+ obj.timestamp +`</td>`;

			if(obj.ph_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ph +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ph +`</td>`;
			if(obj.ec_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ec +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ec +`</td>`;
			if(obj.tds_anomaly == 1)
				rows += `<td style="color:red">`+ obj.tds +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.tds +`</td>`;
			if(obj.orp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.orp +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.orp +`</td>`;
			if(obj.turb_anomaly == 1)
				rows += `<td style="color:red">`+ obj.turbidity +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.turbidity +`</td>`;
			if(obj.temp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.temperature +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.temperature +`</td>`;

			if(obj.status.localeCompare("Safe") == 0) 
				rows += `<td><span class="label label-success">Safe</span></td>`;
			else 
				rows += `<td><span class="label label-danger">Unsafe</span></td>`;

			rows += "</tr>";
		}
		rows += "</table>";
		document.getElementById("live_readings").innerHTML = rows;
	}

	else if(id.localeCompare("status_options_live") == 0) {

		//get status
		var status = document.getElementById("status_options_live").value;
		var state = document.getElementById("state_options_live").value;

		var state_flag = state.localeCompare("select");

		//display live readings for selected source
		rows = `
			<table class="table table-bordered"">
	    <tr>
	      <th>KIT ID</th>
	      <th>Source</th>
	      <th>State</th>
	      <th>Time</th>
	      <th>PH</th>
	      <th>EC</th>
	      <th>TDS</th>
	      <th>ORP</th>
	      <th>Turbidity</th>
	      <th>Temperature</th>
	      <th>Status</th>
	    </tr>
		`;
		for(var i = 0; i < kit_readings.length; i++) {
			var obj = kit_readings[i];

			if(status.localeCompare(obj.status) != 0 || (state.localeCompare(obj.state) != 0) && state.localeCompare("select") != 0)
				continue;

			rows += `<tr>
				<td>`+ obj.kit_id +`</td>
				<td>`+ obj.source +`</td>
				<td>`+ obj.state +`</td>
				<td>`+ obj.timestamp +`</td>`;

			if(obj.ph_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ph +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ph +`</td>`;
			if(obj.ec_anomaly == 1)
				rows += `<td style="color:red">`+ obj.ec +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.ec +`</td>`;
			if(obj.tds_anomaly == 1)
				rows += `<td style="color:red">`+ obj.tds +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.tds +`</td>`;
			if(obj.orp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.orp +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.orp +`</td>`;
			if(obj.turb_anomaly == 1)
				rows += `<td style="color:red">`+ obj.turbidity +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.turbidity +`</td>`;
			if(obj.temp_anomaly == 1)
				rows += `<td style="color:red">`+ obj.temperature +`</td>`;
			else
				rows += `<td style="color:green">`+ obj.temperature +`</td>`;

			if(obj.status.localeCompare("Safe") == 0) 
				rows += `<td><span class="label label-success">Safe</span></td>`;
			else 
				rows += `<td><span class="label label-danger">Unsafe</span></td>`;

			rows += "</tr>";
		}
		rows += "</table>";
		document.getElementById("live_readings").innerHTML = rows;
	}
}