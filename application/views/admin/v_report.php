<!-- <pre>
	<?php print_r($countpergroup) ?>
</pre> -->

<section class="content-header">
	<h1>
    	Report
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
				  <h3 class="box-title">Unduh Report</h3>
				</div><!-- /.box-header -->
				
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<a class="btn btn-flat btn-success margin" href="<?php echo site_url('admin/dl/excel') ?>"><i class="fa fa-file-excel-o"></i><span> Download as Excel</span></a>
							<!-- <a class="btn btn-flat btn-danger margin" href="<?php echo site_url('admin/dl/pdf') ?>"><i class="fa fa-file-pdf-o"></i><span> Download as PDF</span></a> -->
						</div>
					</div>
				</div><!-- /.box-body -->
				
			</div><!-- /.box -->
        </div>
	</div>

	
</section><!-- /.content -->
