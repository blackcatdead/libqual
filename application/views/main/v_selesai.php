<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      
    </h1>
   
  </section>

  <!-- Main content -->
  <section class="content">
      <?php if ($this->session->flashdata('msg')): ?>
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
    <?php endif; ?>
   
    <div class="box box-default">
           <div class="box-body">
      <center><strong>Selesai</strong></center>
      <center><p>Terima kasih atas partisipasi anda mengisi kuesioner ini!</p></center>
      
      </div><!-- /.box-body -->
      <div class="box-footer">
          <a class="btn btn-danger pull-right btn-lg" href="<?php echo site_url() ?>main/logout">Keluar</a>
      </div>
    </div><!-- /.box -->
  </section><!-- /.content -->
</div><!-- /.container -->