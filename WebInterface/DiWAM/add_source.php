<?php include 'header.tpl'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sources
        <small>Add Source</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="box">
        <div class="box-body">
          <form class="form-horizontal" name="add_source" action="core/add_source.php" method="post">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Source Name</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="source" class="form-control" id="inputEmail3" placeholder="Source Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Pincode</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="pincode" class="form-control" id="inputEmail3" placeholder="Pincode">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>State</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="state" class="form-control" id="inputEmail3" placeholder="State">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Latitude</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="latitude" class="form-control" id="inputEmail3" placeholder="Latitude">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" style="font-size: 1em; color: #8A8A8A;"><strong>Longitude</strong></label>

                <div class="col-sm-10">
                  <input type="text" name="longitude" class="form-control" id="inputEmail3" placeholder="Longitude">
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="button" class="btn btn-default" onclick='window.open("sources.php")'>View all sources</button>
              <button type="submit" class="btn bg-olive pull-right">Add source</button>
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
<script src="dist/js/pages/sources.js"></script>
<!-- page script -->
<script>
  $(function () {
    
  })
</script>
<?php include 'footer.tpl'; ?>
</body>
</html>