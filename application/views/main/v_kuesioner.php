<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      KUESIONER <?php echo $this->ses_status ?>
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
    	<div class="box-header with-border">
          <h3 class="box-title"><?php echo $criteria[0]['criteria'] ?></h3>
        </div><!-- /.box-header -->
    	<form method="post" action="<?php echo site_url() ?>main/submitkuesioner/<?php echo $this->ses_status ?>">
        <div class="box-body">

        <p>Berikan penilaian Anda tentang kualitas layanan Perpustakaan Kementerian Perdagangan, baik menurut Persepsi (layanan yang Anda rasakan saat ini) maupun menurut Ekspektasi (harapan yang Anda inginkan terhadap layanan). Anda diminta mengisikan jawaban Anda atas pernyataan-pernyataan kuesioner yang diberikan dengan cara menggeser/menarik slider jawaban dengan menggunakan skala jawaban 1-9. </p>
			<table class="table table-bordered">
	            <tbody>
	            <tr>
	              <th rowspan="1"><center>No</th>
	              <th rowspan="1"><center>Pernyataan</th>
	              <th class="success" style="width: 100px"><center>Persepsi</th>
	              <th class="danger" style="width: 100px"><center>Ekspektasi</th>
	              
	            </tr>

	            <?php $temp_id=0; ?>
	            <?php foreach ($q as $key => $value): ?>
<!-- 	           	<?php if ($temp_id!==$value['id_criteria']): ?>
	           		<tr>
	           		
           			<td colspan="3">
           				<strong><?php echo $value['criteria'] ?></strong>
           			</td>
	           		</tr>
	           		<?php $temp_id=$value['id_criteria'] ?>
	           	<?php endif ?> -->
	           	<?php if ($value['id_criteria'] == $this->ses_status): ?>
	           		<tr>
		              <td><?php echo $key+1 ?></td>
		              <td><?php echo $value['pertanyaan'] ?></td>
		             
				      <td>
               <center><div id="p<?php echo $value['id_subcriteria'] ?>">0</div></center>
				      	<input class ="ex11" name="persepsi[<?php echo $value['id_subcriteria'] ?>]" id="persepsi<?php echo $value['id_subcriteria'] ?>" type="text" data-slider-value="" value="" data-slider-tooltip="hide"/>
               
				      </td>
				      <td>
              <center><div id="k<?php echo $value['id_subcriteria'] ?>">0</div></center>
				      	<input class ="ex11" name="kepentingan[<?php echo $value['id_subcriteria'] ?>]" id="kepentingan<?php echo $value['id_subcriteria'] ?>" type="text" data-slider-value="" value="" data-slider-tooltip="hide"/>
                
				      </td>
		            </tr>
	           	<?php endif ?>
	            
	            <?php endforeach ?>
	           
	          </tbody>
          </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
          <!-- <a class="btn btn-info pull-right btn-lg" href="">Submit</a> -->
      	<button type="submit" class="btn btn-info pull-right btn-lg">Submit</button>
      </div>
      </form>
    </div><!-- /.box -->
    
  </section><!-- /.content -->
</div><!-- /.container -->