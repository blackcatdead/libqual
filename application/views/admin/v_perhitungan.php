<section class="content-header">
	<h1>
    	Perhitungan
    	<small></small>
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


	<div class="row">
		<div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                	<h3 class="box-title">Perhitungan</h3>
                	<div class="box-tools pull-right">
	                    <ul class="pagination pagination-sm inline">
	                    	<!-- <li class="active"><a href="#g2" data-toggle="tab">Hasil Libqual</a></li> -->
	                    	
	                    	<li class="active"><a href="#g3" data-toggle="tab">Perhitungan LibQual Diskretisasi</a></li>
	                     	<li class=""><a href="#g1" data-toggle="tab">Perhitungan Persepsi Berbobot</a></li>
	                     	<li class=""><a href="#g4" data-toggle="tab">Perhitungan Ekspektasi Berbobot</a></li>
	                     	<li class=""><a href="#g0" data-toggle="tab">Analisis Kuadran IPA</a></li>
		                </ul>
	                </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<div class="tab-content">
                	
	                	<div class="tab-pane active" id="g3">
	                		<?php $this->load->view('admin/v_perhitungan_tab4'); ?>
	                	</div>
	                	<div class="tab-pane " id="g0">
	                		<?php $this->load->view('admin/v_perhitungan_tab1'); ?>
	                	</div>
	                	<div class="tab-pane" id="g1">
	                		<?php $this->load->view('admin/v_perhitungan_tab2'); ?>
	                	</div>
	                	<div class="tab-pane" id="g4">
	                		<?php $this->load->view('admin/v_perhitungan_tab5'); ?>
	                	</div>
					</div>	
                </div>
                
		    </div><!-- /.box -->
		</div>	
</section><!-- /.content -->
