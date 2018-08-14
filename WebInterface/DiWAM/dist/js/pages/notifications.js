//display list of sources for today
var admin_id = '<?php echo $_SESSION["admin_id"]; ?>';
var url = "core/get_notif.php?admin_id="+admin_id;
var kit_readings;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//get data from url
$(document).ready(function(){

	get_data();
  	setInterval(get_data,10000);
});


//function to get data
function get_data() {
	console.log("aga");
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
	<table class="table table-hover table-striped">
      <thead>
      <th>
      	<td>Source</td>
      	<td>State</td>
      	<td>PH</td>
      	<td>EC</td>
      	<td>TDS</td>
      	<td>ORP</td>
      	<td>Turbidity</td>
      	<td>Temperature</td>
      	<td>Status</td>
      </thead>
`;
	for(var i = 0; i < kit_readings.length; i++) {
		var obj = kit_readings[i];
		rows += `<tr>
			<td>`+ obj.source +`</td>
			<td>`+ obj.state +`</td>`;

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

		rows += `<td><span class="label label-danger">Unsafe</span></td>`;	

		rows += "</tr>";
	}
	rows += "</table>";
	document.getElementById("notif_list").innerHTML = rows;
}