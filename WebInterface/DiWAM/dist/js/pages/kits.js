//display list of sources for today
var url = "core/all_kits.php";
var kit_readings;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//get data from url
$(document).ready(function(){

	get_data();
  	setInterval(get_data,100000);
});


//function to get data
function get_data() {

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
          //update info boxes
          update_table();
          $('#example1').DataTable()
        }
    };

    xmlhttp.send();
} 


function update_table() {
	rows = `
	<table id="example1" class="table table-bordered table-striped">
	<thead>
	  <tr>
	    <th>Kit ID</th>
	    <th>Source Name</th>
	    <th>Min ph</th>
	    <th>Max ph</th>
	    <th>Min EC</th>
	    <th>Max EC</th>
	    <th>Min TDS</th>
	    <th>Max TDS</th>
	    <th>Min ORP</th>
	    <th>Max ORP</th>
	    <th>Min Turbidity</th>
	    <th>Max Turbidity</th>
	    <th>Min Temperature</th>
	    <th>Max Temperature</th>
	    <th>Date of Deployment</th>
	    <th>Kit Status</th>
	    <th>Edit threshold</th>
	  </tr>
	</thead>
	`;
	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		rows += `<tr>
			<td>`+ obj.kit_id +`</td>
			<td>`+ obj.source +`</td>
			<td>`+ obj.ph_thres_min +`</td>
			<td>`+ obj.ph_thres_max +`</td>
			<td>`+ obj.ec_thres_min +`</td>
			<td>`+ obj.ec_thres_max +`</td>
			<td>`+ obj.tds_thres_min +`</td>
			<td>`+ obj.tds_thres_max +`</td>
			<td>`+ obj.orp_thres_min +`</td>
			<td>`+ obj.orp_thres_max +`</td>
			<td>`+ obj.turb_thres_min +`</td>
			<td>`+ obj.turb_thres_max +`</td>
			<td>`+ obj.temp_thres_min +`</td>
			<td>`+ obj.temp_thres_max +`</td>
			<td>`+ obj.date_of_deployment +`</td>
			<td>`+ obj.kit_status +`</td>
			<td> <button id="`+ obj.kit_id +`" class="btn bg-olive pull-right" type="button" onclick="openForm(this.id)">Edit</button> </td>`;

		rows += "</tr>";
	}
	rows += "</table>";
	document.getElementById("kit_list").innerHTML = rows;
}