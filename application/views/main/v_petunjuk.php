<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PETUNJUK
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
      <strong>Petunjuk Pengisian</strong>
       <p>
          Berikan penilaian Anda tentang kualitas layanan Perpustakaan Kementerian Perdagangan, baik menurut Persepsi (layanan yang Anda rasakan saat ini) maupun menurut Ekspektasi (harapan yang Anda inginkan terhadap layanan).

          Anda diminta mengisikan jawaban Anda atas pernyataan-pernyataan kuesioner yang diberikan dengan cara menggeser/menarik slider jawaban dengan menggunakan skala jawaban 1-9.
        </p>
        
        <br>
        <strong>Contoh Pengisian:</strong>
          <br>
        <img src="<?php echo base_url() ?>assets/main/img/contoh_kuesioner.png">
        <br>
        <p><strong>Berarti Anda memberikan penilaian sebagai berikut:</strong>
          <br>
          <ol type="1">
          <li> Penampilan dan kerapian pustakawan menurut persepsi Anda <strong>bernilai 8</strong>, sebenarnya ekspektasi yang anda harapkan cukup <strong>bernilai 7.</strong></li>
          <li> Sikap dan perilaku pustakawan dalam memberikan pelayanan menurut persepsi Anda <strong>bernilai 7.5</strong>, sebenarnya ekspektasi yang Anda harapkan <strong>bernilai 9.</strong></li>
          <li> Daya tanggap pustakawan dalam pelayanan menurut persepsi Anda <strong>bernilai 7</strong>, sementara ekspekstasi yang Anda harapkan telah memenuhi/bernilai sama dengan persepsi yaitu <strong>bernilai 7</strong>.</li>
          

        </p>
      </div><!-- /.box-body -->
      <div class="box-footer">
          <a class="btn btn-info pull-right btn-lg" href="<?php echo site_url() ?>main/kuesioner">Next</a>
      </div>
    </div><!-- /.box -->
  </section><!-- /.content -->
</div><!-- /.container -->