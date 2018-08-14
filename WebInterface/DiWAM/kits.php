<?php include 'header.tpl'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kits
        <small>List of deployed kits and their status</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div id="kit_table" class="box">
        <div class="box-body">
          <div id="kit_list"></div>
        </div>
      </div>
      <div id="kit_edit" class="box" style="display: none">
        <div class="box-body">
          <form class="form-horizontal" name="add_source" action="core/edit_kit.php" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Source Name</strong></label>

                <div class="col-sm-10">
                  <input type="text"  id="source" name="source" class="form-control" id="inputEmail3" placeholder="Water Source"></input>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Kit ID</strong></label>

                <div class="col-sm-10">
                  <input type="text"  id="kit_id" name="kit_id" class="form-control" id="inputEmail3" placeholder="Kit ID - auto generated"></input>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>PH threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="pht_min" name="pht_min" class="form-control" id="inputEmail3" placeholder="PH min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>PH threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="pht_max" name="pht_max" class="form-control" id="inputEmail3" placeholder="PH max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>EC threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="ect_min" name="ect_min" class="form-control" id="inputEmail3" placeholder="EC min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>EC threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="ect_max" name="ect_max" class="form-control" id="inputEmail3" placeholder="EC max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>TDS threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="tdst_min" name="tdst_min" class="form-control" id="inputEmail3" placeholder="TDS min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>TDS threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="tdst_max" name="tdst_max" class="form-control" id="inputEmail3" placeholder="TDS max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>ORP threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="orpt_min" name="orpt_min" class="form-control" id="inputEmail3" placeholder="ORP min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>ORP threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="orpt_max" name="orpt_max" class="form-control" id="inputEmail3" placeholder="ORP max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Turbidity threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="turbt_min" name="turbt_min" class="form-control" id="inputEmail3" placeholder="Turbidity min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Turbidity threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="turbt_max" name="turbt_max" class="form-control" id="inputEmail3" placeholder="Turbidity max">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Temperature threshold Minimum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="tempt_min" name="tempt_min" class="form-control" id="inputEmail3" placeholder="Temperature min">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Temperature threshold Maximum</strong></label>

                <div class="col-sm-10">
                  <input type="text" id="tempt_max" name="tempt_max" class="form-control" id="inputEmail3" placeholder="Temperature max">
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="button" class="btn btn-default" onclick='showKits()'>Back</button>
              <button type="submit" class="btn bg-olive pull-right">Edit kit</button>
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
<script src="dist/js/pages/kits.js"></script>
<!-- page script -->
<script>
  function openForm(id) {
    var xmlhttp = new XMLHttpRequest();
    var url = "core/all_kits.php?kit_id="+id;
    console.log(id);

    xmlhttp.open("GET", url);
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
    xmlhttp.setRequestHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
    xmlhttp.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
    xmlhttp.setRequestHeader("Access-Control-Request-Headers", "X-Requested-With, accept, content-type");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          data = JSON.parse(xmlhttp.responseText);
          var obj = data[0];

          document.getElementById("source").value = obj.source;
          document.getElementById("kit_id").value = obj.kit_id;
          document.getElementById("pht_min").value = obj.ph_thres_min;
          document.getElementById("ect_min").value = obj.ec_thres_min;
          document.getElementById("tdst_min").value = obj.tds_thres_min;
          document.getElementById("orpt_min").value = obj.orp_thres_min;
          document.getElementById("turbt_min").value = obj.turb_thres_min;
          document.getElementById("tempt_min").value = obj.temp_thres_min;
          document.getElementById("pht_max").value = obj.ph_thres_max;
          document.getElementById("ect_max").value = obj.ec_thres_max;
          document.getElementById("tdst_max").value = obj.tds_thres_max;
          document.getElementById("orpt_max").value = obj.orp_thres_max;
          document.getElementById("turbt_max").value = obj.turb_thres_max;
          document.getElementById("tempt_max").value = obj.temp_thres_max;

          document.getElementById("kit_list").style.display = "none";
          document.getElementById("kit_edit").style.display = "block";
        }
    };

    xmlhttp.send();
  }

  function showKits() {
    document.getElementById("kit_edit").style.display = "none";
    document.getElementById("kit_list").style.display = "block";
  }
</script>
<?php include 'footer.tpl'; ?>
</body>
</html>