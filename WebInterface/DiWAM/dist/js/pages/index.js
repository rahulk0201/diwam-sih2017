//config variables
//url to get real time data i.e for current date
//TODO: Pass today as a parameter to the url to get only todays data
var url = "http://localhost/DIWAM/core/all_data.php";
var kit_readings;
var first = true;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//global chart variables
var stateChart;
var pieChart;
var map;

//get data from url
$(document).ready(function(){

	get_json_data();
  setInterval(get_json_data,10000);

  //set date
  n =  new Date();
	y = n.getFullYear();
	m = n.getMonth() + 1;
	d = n.getDate();
	document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
});


//function to get data
function get_json_data() {

	//make your ajax call here
    //var url = "core.php";
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", url);
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
    xmlhttp.setRequestHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
    xmlhttp.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
    xmlhttp.setRequestHeader("Access-Control-Request-Headers", "X-Requested-With, accept, content-type");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	kit_readings = JSON.parse(xmlhttp.responseText);

        	if(first) {

        		//create dom elements
        		create_DOM_elements();

        		//update info boxes
          		update_info_boxes();

        		//create charts
        		create_map();
	          update_state_chart();
	          update_pie_chart();

        		first = false;
        		return;
        	}

          //update info boxes
          update_info_boxes();

          //update state vs sources chart
          update_state_chart();
          update_pie_chart();
          update_map();
        }
    };

    xmlhttp.send();
} 


function update_state_chart() {

	//init dict
  var dict = {};
  var states = [];
  var safe = [];
  var unsafe = [];

  for(var i = 0; i < kit_readings.length; i++) {
	var obj = kit_readings[i];
	dict[obj.state] = {"Safe":0, "Unsafe":0};
  }

  for(var i = 0; i < kit_readings.length; i++) {
	var obj = kit_readings[i];
	if(obj.status == "Safe")
		dict[obj.state]["Safe"]++;
	else 
		dict[obj.state]["Unsafe"]++;
  }
 
  for(var key in dict) {
  	states.push(key);
  	safe.push(dict[key]["Safe"]);
  	unsafe.push(dict[key]["Unsafe"]);
  }


  //bar chart
  // Get context with jQuery - using jQuery's .get() method.
  /*var stateChartCanvas = $('#stateChart').get(0).getContext('2d');*/
  // This will get the first returned node in the jQuery collection.
  /*stateChart       = new Chart(stateChartCanvas);*/

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

 /* // Create the bar chart
  stateChart.Bar(stateChartData, stateChartOptions);*/
}


function update_pie_chart() {

	//init dict
  var dict = {};
  var states = [];
  var safe = [];
  var unsafe = [];

  for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		dict[obj.state] = {"Safe":0, "Unsafe":0};
  }

  for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		if(obj.status == "Safe")
			dict[obj.state]["Safe"]++;
		else 
			dict[obj.state]["Unsafe"]++;
  }
 
  for(var key in dict) {
  	states.push(key);
  	safe.push(dict[key]["Safe"]);
  	unsafe.push(dict[key]["Unsafe"]);
  }

	// -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.

  //get state selected
  var state = document.getElementById("state_options").value;
  if(state.localeCompare("select") == 0)
  	return;

  safe = dict[state]["Safe"];
  unsafe = dict[state]["Unsafe"];

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


function update_map() {

}


//create pie, bar, map
function create_map() {

  // --------
  // - MAPS -
  // --------

  var markers = [];

  for(var i=0;i<kit_readings.length;i++) {
  	
  	if(kit_readings[i]["status"] == "Safe") {
  		markers.push({latLng: [kit_readings[i]["latitude"], kit_readings[i]["longitude"]], source: kit_readings[i]["source"], state: kit_readings[i]["state"], status: kit_readings[i]["status"], style: {fill: 'green', r:5}});
  	}
  	else {
  		markers.push({latLng: [kit_readings[i]["latitude"], kit_readings[i]["longitude"]], source: kit_readings[i]["source"], state: kit_readings[i]["state"], status: kit_readings[i]["status"], style: {fill: 'red', r:5}});
  	}
  }

	/* jVector Maps
   * ------------
   * Create a world map with markers
   */
  $('#world-map-markers').vectorMap({
    map              : 'in_mill',
    normalizeFunction: 'polynomial',
    hoverOpacity     : 0.7,
    hoverColor       : false,
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial      : {
        fill            : 'rgba(210, 214, 222, 1)',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 0,
        'stroke-opacity': 1
      },
      hover        : {
        'fill-opacity': 0.7,
        cursor        : 'pointer'
      },
      selected     : {
        fill: 'yellow'
      },
      selectedHover: {}
    },
    markerStyle      : {
      initial: {
        fill  : '#00a65a',
        stroke: '#111'
      },
      hover        : {
        'fill-opacity': 0.7,
        cursor        : 'pointer'
      }
    },
    markers          : markers,
    onMarkerClick: function(event, index) {
      //update marker details
      var x = document.getElementsByClassName("marker-detail");
      console.log("sdfghj");
      x[0].innerHTML = markers[index].state;
      x[1].innerHTML = markers[index].source;
      x[2].innerHTML = markers[index].status;
    }
  });

  // -----------
  // - END MAP -
  // -----------
}


function update_info_boxes() {

	var dict = {};
	var no_of_sources = 0;
	var safe_sources = 0;

	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		dict[obj.source] = obj.status;
	}

	for(var key in dict) {
		no_of_sources++;
		if(dict[key] == "Safe")
			safe_sources++;
	}

	var unsafe_sources = no_of_sources - safe_sources;

	//update DOM
	var x = document.getElementsByClassName("info-box-number");
	x[0].innerHTML = no_of_sources;
	x[1].innerHTML = safe_sources;
	x[2].innerHTML = unsafe_sources;
	x[3].innerHTML = no_of_sources;
}


//non update funtions
function create_DOM_elements() {

	//init dict
	var dict = {};
	var states = [];

	for(var i = 0; i < kit_readings.length; i++) {
	var obj = kit_readings[i];
	dict[obj.state] = {"Safe":0, "Unsafe":0, "sources":[]};
	}

	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		dict[obj.state]["sources"].push(obj.source);
		if(obj.status == "Safe")
			dict[obj.state]["Safe"]++;
		else 
			dict[obj.state]["Unsafe"]++;
	}

	for(var key in dict) {
		states.push(key);
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
      <th>DO</th>
      <th>BOD</th>
      <th>Status</th>
    </tr>
	`;
	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		if(obj.status.localeCompare("Safe") == 0)
			continue; 
		rows += `<tr>
			<td>`+ obj.kit_id +`</td>
			<td>`+ obj.source +`</td>
			<td>`+ obj.state +`</td>
			<td>12:00</td>
			<td>`+ obj.ph +`</td>
			<td>`+ obj.ec +`</td>
			<td>`+ obj.do +`</td>
			<td>`+ obj.bod +`</td>
		`;

		if(obj.status.localeCompare("Safe") == 0) 
			rows += `<td><span class="label label-success">Safe</span></td>`;
		else 
			rows += `<td><span class="label label-danger">Unsafe</span></td>`;

		rows += "</tr>";
	}
	rows += "</table>";
	document.getElementById("live_readings").innerHTML = rows;

	//display states option in the list
	var text_pie = "";
	var text_table = "<option>select</option>";
	for(var i=0;i<states.length;i++) {
		
		text_pie += "<option>"+ states[i] +"</option>";
		text_table += "<option>"+ states[i] +"</option>"
	}
	document.getElementById("state_options").innerHTML = text_pie;

	//display state, source, status in live readings
	document.getElementById("state_options_live").innerHTML = text_table;

	text_table = "<option>select</option>";
	for(var i=0;i<kit_readings.length;i++) {
		
		text_table += "<option>"+ kit_readings[i]["source"] +"</option>";
	}
	document.getElementById("source_options_live").innerHTML = text_table;
}

////////////
///EVENTS///
////////////
function update_live_readings(id) {


	var dict = {};
	var states = [];

	for(var i = 0; i < kit_readings.length; i++) {
	var obj = kit_readings[i];
	dict[obj.state] = {"Safe":0, "Unsafe":0, "sources":[]};
	}

	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		dict[obj.state]["sources"].push(obj.source);
		if(obj.status == "Safe")
			dict[obj.state]["Safe"]++;
		else 
			dict[obj.state]["Unsafe"]++;
	}

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
	      <th>DO</th>
	      <th>BOD</th>
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
				<td>12:00</td>
				<td>`+ obj.ph +`</td>
				<td>`+ obj.ec +`</td>
				<td>`+ obj.do +`</td>
				<td>`+ obj.bod +`</td>
			`;

			if(obj.status.localeCompare("Safe") == 0) 
				rows += `<td><span class="label label-success">Safe</span></td>`;
			else 
				rows += `<td><span class="label label-danger">Unsafe</span></td>`;

			rows += "</tr>";
		}
		rows += "</table>";
		document.getElementById("live_readings").innerHTML = rows;

		//set sources filter
		var sources = dict[state]["sources"];
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
	      <th>DO</th>
	      <th>BOD</th>
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
				<td>12:00</td>
				<td>`+ obj.ph +`</td>
				<td>`+ obj.ec +`</td>
				<td>`+ obj.do +`</td>
				<td>`+ obj.bod +`</td>
			`;

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
	      <th>DO</th>
	      <th>BOD</th>
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
				<td>12:00</td>
				<td>`+ obj.ph +`</td>
				<td>`+ obj.ec +`</td>
				<td>`+ obj.do +`</td>
				<td>`+ obj.bod +`</td>
			`;

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