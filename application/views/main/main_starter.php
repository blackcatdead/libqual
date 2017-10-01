<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LibQual Research</title>
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

    <link rel="stylesheet" href="<?php echo base_url().'assets/admin/'; ?>plugins/daterangepicker/daterangepicker-bs3.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition register-page"s>
    <div class="register-box">
      <div class="register-logo">
        <a href="<?php echo base_url(); ?>"><b>Data Responden</b></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Isilah data diri anda</p>
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
        <form action="<?php echo site_url().'verifylogin/starting'; ?>" method="post">
          <div class="form-group">
            <input type="text" name="nama" class="form-control" placeholder="*Nama" required autocomplete="off">
            <!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
          </div>
          <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="*Email" required autocomplete="off">
            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
          </div>
          <div class="form-group">
            <input type="text" name="no_anggota" class="form-control" placeholder="Nomor Anggota" autocomplete="off">
            <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
          </div>
          <div class="form-group">
            <select class="form-control" name="tingkat_pendidikan" id="edit_pendidikan" value="" required autocomplete="off">
                <option value="">- *Tingkat Pendidikan - </option>
                 <option value="1">SD/Sederajat</option>
                <option value="2">SMP/Sederajat</option>  
                <option value="3">SMA/Sederajat</option> 
                <option value="4">S1</option>
                <option value="5">S2</option> 
                <option value="6">S3</option>
                <option value="7">lain-lain</option>
            </select>
          </div>
          <div class="form-group has-feedback">
            <select class="form-control" name="jenis_kelamin" id="edit_jenis_kelamin" value="" required autocomplete="off">
                <option value="">- *Jenis Kelamin - </option>
                <option value="1">Laki - laki</option>
                <option value="2">Perempuan</option>   
            </select>
            <!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
          </div>
          
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" id="registernow" class="btn btn-primary btn-block btn-flat">Mulai Isi Kuesioner</button>
            </div><!-- /.col -->
          </div>
        </form>

        
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().'assets/admin/'; ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/iCheck/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url().'assets/admin/'; ?>plugins/daterangepicker/daterangepicker.js"></script>

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

    <script>
      $(function () {
        $('#edit_tanggal_lahir').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        });

        $('#edit_tanggal_lahir').val('');
      });

      
    </script>

    <script>
      $(document).ready(function() {

        $('#cekdulu').change(function() {
            alert("asdasdasf");
           
        });
     });

    </script>
  </body>
</html>
