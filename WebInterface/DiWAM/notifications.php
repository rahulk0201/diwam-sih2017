<?php include 'header.tpl' ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notifications
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
          <!-- /.col -->
	        <div class="col-md-12">
	          <div class="box box-primary">
	            
	            <!-- /.box-header -->
	            <div class="box-body no-padding">
	            	<form class="form-horizontal" id="notif_list" name="add_source" action="core/update_notif.php" method="post">
	              </form>
	              <!-- /.mail-box-messages -->
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer no-padding">
	            </div>
	          </div>
	          <!-- /. box -->
	        </div>
	        <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">DIWAM</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Material Design -->
<script src="dist/js/material.min.js"></script>
<script src="dist/js/ripples.min.js"></script>
<script>
    $.material.init();
</script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/global.js"></script>
<!-- <script src="dist/js/pages/notifications.js"></script> -->
<!-- page script -->
<script type="text/javascript">
	//display list of sources for today
var admin_id = '<?php echo $_SESSION["admin_id"]; ?>';
var url = "core/get_notif.php?admin_id="+admin_id;
var kit_readings;
var color_red = '#DD4B39';
var color_green = '#00A65A';

//get data from url
$(document).ready(function(){

	get_data();
  setInterval(get_data,1800000);
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
		<div class="box-header with-border">
      <h3 class="box-title">Inbox</h3>

      <div class="box-tools pull-right">
        <button type="submit" class="btn bg-olive">Mark as read</button>
      </div>
      <!-- /.box-tools -->
    </div>
		<table class="table table-hover table-striped">
	      <tr>
	      	<td><input type="checkbox" onclick="select_all()"></input></td>
	      	<td>Source</td>
	      	<td>State</td>
	      	<td>PH</td>
	      	<td>EC</td>
	      	<td>TDS</td>
	      	<td>ORP</td>
	      	<td>Turbidity</td>
	      	<td>Temperature</td>
	      	<td>Status</td>
	      </tr>
	`;
		for(var i = 0; i < kit_readings.length; i++) {
			var obj = kit_readings[i];
			rows += `<tr>
				<td><input type="checkbox" name="check_list[]" value="`+ obj.notif_id +`"></input></td>
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

			rows += '</tr>';
		}
		rows += "</table>";
		document.getElementById("notif_list").innerHTML = rows;
	}

	function select_all() {
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++) {
			if(inputs[i].checked == false) {
	        inputs[i].checked = true; 
	    }
	    else {
	        if(inputs[i].checked == true) {
	            inputs[i].checked = false; 
	         }   
	    }
	  }
	}
</script>
<?php include 'footer.tpl'; ?>
</body>
</html>