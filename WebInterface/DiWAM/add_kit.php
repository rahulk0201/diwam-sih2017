<?php include 'header.tpl'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kits
        <small>Add Kit</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="box">
        <div class="box-body">
          <form class="form-horizontal" name="add_source" action="core/add_kit.php" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Source Name</strong></label>

                <div class="col-sm-6">
                  <select id="source_list" class="form-control select2" style="width: 100%;" onchange="load_data(this.value)" name="source">
                  </select>
                </div>
                <div class="col-sm-4">
                  <button type="button" class="btn bg-olive btn-flat" onclick='window.open("add_source.php")'>Water source not found?</button>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Kit ID</strong></label>

                <div class="col-sm-10">
                  <input type="text"  id="kit_id_display" name="kit_id" class="form-control" id="inputEmail3" placeholder="Kit ID - auto generated" disabled="true"></input>
                </div>
              </div>
              <div class="form-group" hidden="true">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Kit ID</strong></label>

                <div class="col-sm-10">
                  <input type="text"  id="kit_id" name="kit_id" class="form-control" id="inputEmail3" placeholder="Kit ID - auto generated"></input>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>State</strong></label>

                <div class="col-sm-10">
                  <input type="text"  id="state" name="state" class="form-control" id="inputEmail3" placeholder="State - auto generated"></input>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>PH threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="pht_min" class="form-control" id="inputEmail3" placeholder="PH min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>PH threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="pht_max" class="form-control" id="inputEmail3" placeholder="PH max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>EC threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="ect_min" class="form-control" id="inputEmail3" placeholder="EC min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>EC threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="ect_max" class="form-control" id="inputEmail3" placeholder="EC max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>TDS threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="tdst_min" class="form-control" id="inputEmail3" placeholder="TDS min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>TDS threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="tdst_max" class="form-control" id="inputEmail3" placeholder="TDS max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>ORP threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="orpt_min" class="form-control" id="inputEmail3" placeholder="ORP min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>ORP threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="orpt_max" class="form-control" id="inputEmail3" placeholder="ORP max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Turbidity threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="turbt_min" class="form-control" id="inputEmail3" placeholder="Turbidity min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Turbidity threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="turbt_max" class="form-control" id="inputEmail3" placeholder="Turbidity max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Temperature threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="tempt_min" class="form-control" id="inputEmail3" placeholder="Temperature min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Temperature threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="tempt_max" class="form-control" id="inputEmail3" placeholder="Temperature max">
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="button" class="btn btn-default" onclick='window.open("kits.php")'>View all kits</button>
              <button type="submit" class="btn bg-olive pull-right">Add kit</button>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
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
<script>

  var data;

  $(document).ready(function(){

    var xmlhttp = new XMLHttpRequest();
    var url = "core/source_list.php";

    xmlhttp.open("GET", url);
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
    xmlhttp.setRequestHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
    xmlhttp.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
    xmlhttp.setRequestHeader("Access-Control-Request-Headers", "X-Requested-With, accept, content-type");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          data = JSON.parse(xmlhttp.responseText);
          var text = "<option>Select</option>";
          for(var i=0;i<data.length;i++) {
            var obj = data[i];
            text += "<option>"+ obj.source +"</option>";
          }

          document.getElementById("source_list").innerHTML = text;
        }
    };

    xmlhttp.send();
  });

  function load_data(source) {

    var state, id;
    for(var i=0;i<data.length;i++) {
      var obj = data[i];
      if(obj.source.localeCompare(source) == 0) {
        state = obj.state;
        id = obj.kit_id;
      }
    }
    document.getElementById("kit_id_display").value = id;
    document.getElementById("kit_id").value = id;
    document.getElementById("state").value = state;
  }
</script>
<!-- page script -->
<script>
</script>
<?php include 'footer.tpl'; ?>
</body>
</html>