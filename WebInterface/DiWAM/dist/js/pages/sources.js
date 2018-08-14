//display list of sources for today
var url = "core/all_data.php";
var data;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//get data from url
$(document).ready(function(){

	get_data();
  setInterval(get_data,10000);
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
        	data = JSON.parse(xmlhttp.responseText);
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


		if(obj.status != null && obj.status.localeCompare("Safe") == 0) 
			rows += `<td><span class="label label-success">` +obj.status+ `</span></td>`;
		else 
			rows += `<td><span class="label label-danger">` +obj.status+ `</span></td>`;

		rows += "</tr>";
	}
	rows += "</table>";
	document.getElementById("source_list").innerHTML = rows;
}