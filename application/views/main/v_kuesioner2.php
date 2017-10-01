<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      KUESIONER 
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
          <h3 class="box-title">Kuesioner Ekspektasi</h3>
        </div><!-- /.box-header -->
    	<form method="post" action="<?php echo site_url() ?>main/submitkuesioner/2">
        <div class="box-body">

        <p>Jawablah pertanyaan berikut sesuai dengan kondisi dan pendapat Anda yang sebenarnya dengan memilih salah satu dari lima alternatif jawaban yang tersedia: </p>
			<table class="table table-bordered">
	            <tbody>
	            <tr>
	              <th rowspan="1"><center>No</th>
	              <th rowspan="1"><center>Pernyataan</th>
	              <!-- <th colspan="5" class="success"><center>Persepsi</th> -->
	              <th colspan="1" class="danger" style="width: 100px"><center>Kepentingan</th>
	              
	            </tr>

	            <?php $temp_id=0; ?>
	            <?php foreach ($q as $key => $value): ?>
	           	<?php if ($temp_id!==$value['id_criteria']): ?>
	           		<tr>
	           		
           			<td colspan="3">
           				<strong><?php echo $value['criteria'] ?></strong>
           			</td>
	           		</tr>
	           		<?php $temp_id=$value['id_criteria'] ?>
	           	<?php endif ?>
	            <tr>
	              <td><?php echo $key+1 ?></td>
	              <td><?php echo $value['subcriteria'] ?></td>
<!-- 
			      <td class="danger"> 
					<center><input class="radio" type="radio" id='regular2' name="kepentingan[<?php echo $key ?>]" value="1" required></center>
			      </td>
	               <td class="danger"> 
					<center><input class="radio" type="radio" id='regular2' name="kepentingan[<?php echo $key ?>]" value="2"></center>
			      </td>
			       <td class="danger"> 
					<center><input class="radio" type="radio" id='regular2' name="kepentingan[<?php echo $key ?>]" value="3"></center>
			      </td>
			       <td class="danger"> 
					<center><input class="radio" type="radio" id='regular2' name="kepentingan[<?php echo $key ?>]" value="4"></center>
			      </td>
			       <td class="danger"> 
					<center><input class="radio" type="radio" id='regular2' name="kepentingan[<?php echo $key ?>]" value="5"></center>
			      </td> -->
			      <td>
			      	<input class ="ex11" name="kepentingan[<?php echo $key ?>]" type="text" required data-slider-value="1"/>
			      </td>
	            </tr>
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