<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LibQual | Log in</title>
    <link rel="icon" 
      type="image/png" 
      href="<?php echo base_url().'assets/admin/'; ?>dist/img/fav.png">
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
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" style="background:#222d32">
    <div class="login-box">
      <div class="login-logo">
        <a  style="color:#e5e5e5" href="<?php echo base_url(); ?>"><b>LibQual</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      	<p class="login-box-msg">Login admin</p>
        <!-- <p class="login-box-msg"><img src="<?php echo base_url().'assets/admin/'; ?>dist/img/pertamina_aviation.jpg"></p> -->

        <?php if (!($this->session->flashdata('msg')==null)): ?>
          <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $this->session->flashdata('msg'); ?>
          </div>
          
          <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif ?>
        <form action="<?php echo site_url(); ?>verifyloginadmin/logingin" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-danger btn-block btn-flat">Log in</button>
            </div><!-- /.col -->
          </div>
        </form>
        
      </div><!-- /.login-box-body -->
      <br>
      <div style="color:#e5e5e5">
        
      <!-- <center><b>Penelitian ini dilakukan oleh:</b><br> Mahmudi</center> 
      <center><b>Dengan Supervisor:</b><br> Supriyadi, M.Sc., Ph.D., CMA,</center> 
      <center>Ertambang Nahartyo, M.Sc., Ph.D.,</center>
      <center>Prof. Mahfud Sholihin, M. Acc., Ph.D. </center> -->
      </div>
      
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });

    
    </script>
  </body>
</html>
