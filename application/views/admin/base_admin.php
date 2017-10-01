<?php  
  $dtSaja[0]="User Management"; //user management
  $dtSaja[1]="Reaction";
  $dtSaja[2]="Responden";

  
  $editor[0]="";

  $lstchckgroup[0]="";

  $datetimerangepick[0]="Responden";
  $datetimerangepick[1]="Report";

  $slider[0]="Diskretisasi";
  
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Libqual | <?php echo $page ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" 
      type="image/png" 
      href="<?php echo base_url().'assets/admin/'; ?>dist/img/fav.png">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>dist/css/skins/skin-blue.min.css">

    <?php if (in_array($page, $dtSaja)): ?>
       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css" />
    <?php endif ?>

    <?php if (in_array($page, $lstchckgroup)): ?>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/admin/'; ?>plugins/lstchckgroup/lstchckgroup.css" />
    <?php endif ?> 

    <?php if (in_array($page, $datetimerangepick)): ?>
       <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>plugins/daterangepicker/daterangepicker-bs3.css">
    <?php endif ?>

    <?php if (in_array($page, $slider)): ?>
      <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>plugins/slider/css/bootstrap-slider.min.css">
    <?php endif ?>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo site_url() ?>/admin" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>L</b>A</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Libqual</b>Admin</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo base_url().'assets/admin/'; ?>dist/img/icon-user-default.png" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $this->ses_name; ?><span class="" id="clock"></span></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header bg-grey">
                    <img src="<?php echo base_url().'assets/admin/'; ?>dist/img/icon-user-default.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $this->ses_name; ?>
                      <small><?php echo $this->ses_username ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    
                      <a href="" data-toggle="modal" class="btn btn-default btn-flat" data-target="#logoutsModal" >Sign Out</a>

                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url().'assets/admin/'; ?>dist/img/icon-user-default.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $this->ses_name; ?></p>
              <!-- Status -->
              <a href="#"><?php echo $this->ses_username ?></a>
            </div>
            
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <?php if ($this->ses_role!=3): ?>
                <li class="<?php echo ($page=="User Management") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/usermanagement' ?>"><i class="fa fa-users"></i> <span>User Management</span></a></li>
                <li class="<?php echo ($page=="Responden") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/responden' ?>"><i class="fa fa-file-o"></i> <span>Responden</span></a></li>
                <li class="<?php echo ($page=="Kriteria dan Sub Kriteria") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/kriteriadansub' ?>"><i class="fa fa-file-o"></i> <span>Kriteria dan Sub Kriteria</span></a></li>
                <li class="<?php echo ($page=="Diskretisasi") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/diskretisasi' ?>"><i class="fa fa-file-o"></i> <span>Diskretisasi</span></a></li>
            <?php endif ?>

            <?php if ($this->ses_role==1): ?>
                <li class="<?php echo ($page=="Bobot Total GDSS-AHP") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/pembobotangdss' ?>"><i class="fa fa-file-o"></i> <span>Bobot Total GDSS-AHP</span></a></li>
            <?php else: ?>
                <li class="<?php echo ($page=="Pembobotan") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/pembobotan' ?>"><i class="fa fa-file-o"></i> <span>Pembobotan</span></a></li>
            <?php endif ?>

            <li class="<?php echo ($page=="Perhitungan") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/perhitungan' ?>"><i class="fa fa-file-o"></i> <span>Perhitungan</span></a></li>
            <li class="<?php echo ($page=="Report") ? 'active' : '' ;?>"><a href="<?php echo site_url().'admin/report' ?>"><i class="fa fa-file-o"></i> <span>Report</span></a></li>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      	<?php 
      		if ($page=='User Management') {
       			$this->load->view('admin/v_usermanagement');
      		}else if($page=='Kriteria dan Sub Kriteria')
        	{
          		$this->load->view('admin/v_kriteriadansub');
        	}else if($page=='Pembobotan')
          {
            	$this->load->view('admin/v_pembobotan');
          }else if($page=='Perhitungan')
          {
            	$this->load->view('admin/v_perhitungan');
          }else if($page=='Responden')
          {
              $this->load->view('admin/v_responden');
          }else if($page=='Diskretisasi')
          {
              $this->load->view('admin/v_diskretisasi');
          }else if($page=='Report')
          {
              $this->load->view('admin/v_report');
          }else if($page=='Bobot Total GDSS-AHP')
          {
              $this->load->view('admin/v_pembobotangdss');
          }
      	 ?>
      </div><!-- /.content-wrapper -->


    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url().'assets/admin/'; ?>dist/js/app.min.js"></script>
 
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/chartjs/Chart.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url().'assets/admin/'; ?>plugins/jquery-countdownTimer/jquery.countdownTimer.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/admin/'; ?>plugins/jquery.countdown/jquery.countdown.min.js"></script>
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/highcharts/highcharts.js"></script>



    <?php if (in_array($page, $dtSaja)): ?>
      <script src=" https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
    <?php endif ?>

    <?php if (in_array($page, $lstchckgroup)): ?>
      <script src="<?php echo base_url().'assets/admin/'; ?>plugins/lstchckgroup/lstchckgroup.js"></script>
    <?php endif ?>  

    <?php if (in_array($page, $editor)): ?>
      <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <?php endif ?>

    <?php if (in_array($page, $datetimerangepick)): ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
      <script src="<?php echo base_url().'assets/admin/'; ?>plugins/daterangepicker/daterangepicker.js"></script>
    <?php endif ?> 

    <?php if (in_array($page, $slider)): ?>
       <script src="<?php echo base_url().'assets/admin/'; ?>plugins/slider/bootstrap-slider.min.js"></script>
    <?php endif ?>  

    <script type="text/javascript">
        <?php if (in_array($page, $dtSaja)): ?>
          $(document).ready(function() {
              $('#dtble').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "autoWidth": true,
                "responsive": true,
                "buttons": [
                    {
                        text: 'My button',
                        action: function ( e, dt, node, config ) {
                            alert( 'Button activated' );
                        }
                    }
                ]
              });

          } );
        <?php endif ?>


        <?php if ($page == "Responden"): ?>
          $(function () {
            $('#edit_tanggal_lahir').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
          });
        <?php endif ?>

         <?php if ($page == "Report"): ?>
          $(function () {
            $('#edit_start_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });

            $('#edit_end_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
          });
        <?php endif ?> 
       

        <?php if (in_array($page, $editor)): ?>
          CKEDITOR.replace('editor1');
        <?php endif ?>

        <?php if ($page == "Diskretisasi"): ?>
           
            $("#i2").change(function() {
              $('#i3').attr('min', $("#i2").val());
              $('#i1').attr('max', $("#i2").val());
            });
            $("#i3").change(function() {
              $('#i4').attr('min',  $("#i3").val());
              $('#i2').attr('max',  $("#i3").val());
            });
            $("#i4").change(function() {
              $('#i5').attr('min', $("#i4").val());
              $('#i3').attr('max', $("#i4").val());
            });
            $("#i5").change(function() {
              $('#i6').attr('min',  $("#i5").val());
              $('#i4').attr('max',  $("#i5").val());
            });
             $("#i6").change(function() {

            });

        <?php endif ?>

        <?php if ($page == "Perhitungan"): ?>

          <?php 
            $maxx=0;
            $maxy=0;
            $minx=0;
            $miny=0;

            foreach ($view['hasil']['ipa']['kuadran'] as $kc => $cri) {
              foreach ($cri as $ksc => $sc) {
                if($maxx<=$sc[1])
                {
                  $maxx=$sc[1];
                }else
                {
                  $minx=$sc[1];
                }

                if($maxy <= $sc[2])
                {
                  $maxy=$sc[2];
                }else
                {
                  $miny=$sc[2];
                }
              }
            }
           ?>
          var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                defaultSeriesType:'scatter',
                borderWidth:1,
                borderColor:'#ccc',
                marginLeft:90,
                marginRight:50,
                backgroundColor:'#eee',
                plotBackgroundColor:'#fff',
            },

            credits:{enabled:false},
            title:{
                text:'Kuadran Chart'
            },
            legend:{
                enabled:false                                
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.a+'. ' + this.point.p/*this.series.name*/ +'</b><br/>'+
                        this.x +': '+ this.y+"<b> (Kuadran "+this.point.k+")</b>";
                }
            },
            plotOptions: {
                series: {
                    shadow:false,
                }
            },
            xAxis:{
                title:{
                    text:'X Axis Title'
                },
                plotLines: [{
                    label:  "asdasd",
                    color: '#FF0000', // Red
                    width: 1,
                    value: <?php echo $view['hasil']['ipa']['sumbu']['x'] ?> // Position, you'll have to translate this to the values on your x axis
                }],
                min:<?php echo $minx-(($maxx-$minx)*5/100) ?>,
                max:<?php echo $maxx+(($maxx-$minx)*5/100) ?>,
                tickInterval:0.0001,
                minorTickInterval:10,
                tickLength:0,
                minorTickLength:0,
                gridLineWidth:1,
                showLastLabel:true,
                showFirstLabel:false,
                lineColor:'#000',
                lineWidth:1,
                
            },
            yAxis:{
                title:{
                    text:'Y Axis<br/>Title',
                    rotation:0,
                    margin:25,
                },
                plotLines: [{
                    label:'asdasdasd',
                    color: '#FF0000', // Red
                    width: 1,
                    value: <?php echo $view['hasil']['ipa']['sumbu']['y'] ?> // Position, you'll have to translate this to the values on your x axis
                }],
                min:<?php echo $miny-(($maxy-$miny)*5/100) ?>,
                max:<?php echo $maxy+(($maxy-$miny)*5/100) ?>,
                tickInterval:0.0001,
                minorTickInterval:10,
                tickLength:3,
                minorTickLength:0,
                lineColor:'#000',
                lineWidth:1,
                
            },
            series: [{
                color:'#185aa9',
                data: [
               <?php foreach ($view['hasil']['ipa']['kuadran'] as $kc => $cri): ?>
                  <?php foreach ($cri as $ksc => $sc): ?>
                    {x:  <?php echo round($sc[1],4) ?>,y:<?php echo round($sc[2],4) ?>, p:"<?php echo $subcriteria2[$ksc]['subcriteria'] ?>", k:"<?php echo $sc['posisi'] ?>", a:'<?php echo $ksc ?>'},
                  <?php endforeach ?>
                <?php endforeach ?>
                ],
            }]});
        <?php endif ?>
    </script>

     <!-- Logout Modal -->
    <div class="modal modal-danger fade" id="logoutsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Log Out</h4>
          </div>
          <form  class="form-horizontal" id="formhapuspeserta" action="<?php echo site_url().'admin/logout'; ?>" method="POST" enctype="multipart/form-data">
          <div id="body_hapus" class="modal-body">
            Are you sure you want to logout?
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-outline pull-left" type="button">No</button>
            <button class="btn btn-outline" type="submit" type="button">Yes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Logout modal -->
  </body>
</html>
