<?php include 'header.tpl'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Todays data of all water sources in India</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-tint"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sources Monitored</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Safe Sources</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Unsafe Sources</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cogs"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kits Deployed</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row info boxes complete-->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Today's Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>State wise status for <span id="date"></span></strong>
                  </p>

                  <div class="chart" style="height: 58vh; border: 2px solid #F4F4F4; padding: 10px;">
                    <!-- Sales Chart Canvas -->
                    <canvas id="stateChart"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Quick overview</strong>
                  </p>
                  <!-- Pie chart -->
                  <div id="pie_chart_state" class="chart" style="height: 44.5vh; border: 2px solid #F4F4F4;">
                    <canvas id="pieChart" style="padding: 10px;  margin-top: 8vh"></canvas>
                  </div>
                  <!-- /.pie chart-->
                  <!--state select options-->
                  <form role="form">
                    <!-- select -->
                    <div class="form-group" style="border: 2px solid #F4F4F4; padding: 10px;">
                      <label>Select State</label>
                      <select id="state_options" onchange="update_pie_chart()" class="form-control" disabled="true">
                      </select>
                    </div>
                  </form>
                  <!--/.state select options -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="box box-success">
              <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Live Readings</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="row">
                <div class="col-md-10">
                  <div id="live_readings" class="box-body table-responsive" style="height:39vh;">
                  </div>
                </div>
                <div class="col-md-2">
                  <!-- /.box-body -->
                  <div class="filters" style="padding: 10px;">
                    <div class="box-body" style="border: 2px solid #F4F4F4;">
                    <h4><strong>Filters</strong></h4>
                      <div class="row">
                        <div class="col-xs-12">
                          <label>Select State</label>
                          <select id="state_options_live" onchange="update_live_readings(this.id)" class="filter form-control" disabled="true">
                          </select>
                        </div>
                        <div class="col-xs-12">
                          <label>Select Source</label>
                          <select id="source_options_live" onchange="update_live_readings(this.id)" class="filter form-control" disabled="true">
                          </select>
                        </div>
                        <div class="col-xs-12">
                          <label>Select status</label>
                          <select id="status_options_live" onchange="update_live_readings(this.id)" class="filter form-control" disabled="true">
                            <option>Unsafe</option>
                            <option>Safe</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Summary Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-9 col-sm-8">
                  <div class="pad">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 50vh;"></div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-4">
                  <div class="pad box-pane-right bg-green" style="height: 50vh;">
                  <h3 style="text-align: center;"><strong>Marker Details</strong></h3>
                    <div class="description-block margin-bottom">
                      <span class="description-text">Select a marker to view details</span>
                    </div>
                    <div class="description-block margin-bottom">
                      <h5 class="description-header">State</h5>
                      <span class="description-text marker-detail"></span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block margin-bottom">
                      <h5 class="description-header">Source</h5>
                      <span class="description-text marker-detail"></span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block">
                      <h5 class="description-header">Status</h5>
                      <span class="description-text marker-detail"></span>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/live_dash.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-in-mill.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<?php include 'footer.tpl'; ?>
</body>
</html>