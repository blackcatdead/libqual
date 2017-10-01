<?php 
  $slider[0] = 'Kuesioner';
  $slider[1] = 'Kuesioner Ekspektasi';
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LibQual | <?php echo $page ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>dist/css/skins/_all-skins.min.css">

    <?php if (in_array($page, $slider)): ?>
      <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>plugins/slider/css/bootstrap-slider.min.css">
    <?php endif ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand"><b>LIBQUAL</b></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
             <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="<?php echo ($page=="Petunjuk") ? 'active' : '' ;?>"><a href="<?php echo site_url() ?>main/petunjuk">Petunjuk <span class="sr-only">(current)</span></a></li>
                <li class="<?php echo ($page=="Kuesioner") ? 'active' : '' ;?>"><a href="<?php echo site_url() ?>main/kuesioner">Kuesioner<span class="sr-only">(current)</span></a></li>
              </ul>
              
            </div><!-- /.navbar-collapse -->

            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">
                          		
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?php echo base_url().'assets/admin/'; ?>dist/img/icon-user-default.png" class="user-image" alt="User Image">
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php echo $this->ses_nama ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="<?php echo base_url().'assets/admin/'; ?>dist/img/icon-user-default.png" class="img-circle" alt="User Image">
                        <p>
                          <?php echo $this->ses_nama ?>
                          <small><?php echo $this->ses_email ?></small>
                        </p>
                      </li>
                       <li class="user-footer">
                          <a href="" data-toggle="modal" class="btn btn-default btn-flat" data-target="#logoutsModal" >Sign Out</a>

                      </li>
	                  
                      <!-- Menu Footer-->
                      
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">

        <?php 
      		if ($page=='Petunjuk') {
       			$this->load->view('main/v_petunjuk');
      		}else if ($page=='Kuesioner') {
       			$this->load->view('main/v_kuesioner');
      		}else if ($page=='Kuesioner Ekspektasi') {
            $this->load->view('main/v_kuesioner2');
          }else if ($page=='Selesai') {
            $this->load->view('main/v_selesai');
          }



          else
        	{

        	}

        	
      	 ?>
      </div><!-- /.content-wrapper -->

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url().'assets/admin/'; ?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url().'assets/admin/'; ?>dist/js/demo.js"></script>

    <?php if (in_array($page, $slider)): ?>
       <script src="<?php echo base_url().'assets/admin/'; ?>plugins/slider/bootstrap-slider.min.js"></script>
    <?php endif ?>      


    <script type="text/javascript">
      <?php if (in_array($page, $slider)): ?>
        // With JQuery
        $(".ex11").slider({step: 0.5, min: 0.5, max: 9});

        $(".ex11").on("slide", function(slideEvt) {
          // $("#ex6SliderVal").text(slideEvt.value);
          //alert(slideEvt.value);
        });

        <?php foreach ($q as $key => $value): ?>
          $("#persepsi<?php echo $key ?>").on("slide", function(slideEvt) {
            // $("#ex6SliderVal").text(slideEvt.value);
            if (slideEvt.value >0.5) 
            {
               $("#p<?php echo $key ?>").text(slideEvt.value);
            }else
            {
              $("#p<?php echo $key ?>").text('0');
            }
           
            //alert(slideEvt.value);
          });

          $("#kepentingan<?php echo $key ?>").on("slide", function(slideEvt) {
            // $("#ex6SliderVal").text(slideEvt.value);
            if (slideEvt.value >0.5) 
            {
               $("#k<?php echo $key ?>").text(slideEvt.value);
            }else
            {
              $("#k<?php echo $key ?>").text('0');
            }

           
            //alert(slideEvt.value);
          });
        <?php endforeach ?>
        // Without JQuery
        // var slider = new Slider("#ex11", {
        //   step: 0.5,
        //   min: 1,
        //   max: 9
        // });        
      <?php endif ?>      
    </script>
  </body>

   <!-- Logout Modal -->
    <div class="modal modal-danger fade" id="logoutsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Log Out</h4>
          </div>
          <form  class="form-horizontal" id="formhapuspeserta" action="<?php echo site_url().'main/logoutdanhapus'; ?>" method="POST" enctype="multipart/form-data">
          <div id="body_hapus" class="modal-body">
            Are you sure you want to logout?
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-outline pull-left" type="button">Tidak</button>
            <button class="btn btn-outline" type="submit" type="button">Ya</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Logout modal -->
</html>


