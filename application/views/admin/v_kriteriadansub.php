<!-- <?php 
echo '<pre>';
print_r($criteriansub) ;
echo '<pre>';
?> -->

<!-- <pre>
	<?php print_r($countpergroup) ?>
</pre> -->

<section class="content-header">
	<h1>
    	Kriteria dan Sub Kriteria
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
                  <h3 class="box-title">Kriteria dan Sub Kriteria (<?php echo count($criteriansub) ?>/22)</h3>
                  <div class="box-tools pull-right ">
		            <a data-toggle="modal" onclick="clickTambah();" data-target="#tambahEditModal"><button class="btn btn-box-tool ">Add Sub Criteria</button></a>
		          </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="tab-content">
                  <!-- Morris chart - Sales -->
	                  	<table id="dtble" class="table table-bordered table-hover">
		                    <thead>
		                      <tr>
		                        <th style="width: 50px;">#</th>
		                        <th>Sub Criteria</th>
		                        <th>Pertanyaan</th>
		                        <th></th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	<?php
		                    		$num=1;
		                    		$temp_id_criteria=0;
		                    	?>
		                    	<?php foreach ($criteriansub as $key => $value): ?>
		                    		<?php if ($temp_id_criteria != $value['id_criteria']): ?>
		                    		<tr>
				                        <td colspan="4"><strong><?php echo $value['criteria'] ?></strong></td>
				                 	</tr>
				                 	<?php $temp_id_criteria = $value['id_criteria']; ?>
		                    		<?php endif ?>

		                    		<tr>
				                        <td><?php echo $num++ ?></td>
				                        <td><?php echo $value['subcriteria'] ?></td>
				                        <td><?php echo $value['pertanyaan'] ?></td>	
				                       	<td>
				                       		<a  data-toggle="modal" onclick="clickEdit(
				                       			'<?php echo $value['id_subcriteria'];?>',
												'<?php echo $value['id_criteria'];?>',
												'<?php echo $value['subcriteria'];?>',
												'<?php echo $value['pertanyaan'];?>'
				                       		);" data-target="#tambahEditModal">
				                       			<button class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
				                       		</a>
		                       				<a data-toggle="modal" onclick="clickHapus('<?php echo $value['id_subcriteria'];?>', '<?php echo $value['subcriteria'];?>', '<?php echo $value['criteria'];?>')"  data-target="#hapusModal"><button class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></button></a>
				                       	</td>
				                 	</tr>
		                    	<?php endforeach ?>
		                    </tbody>
		                    
		                </table>

                  
                	</div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div>

	</div>

	
</section><!-- /.content -->

<!-- Hapus Modal -->
<div class="modal modal-danger fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Remove User</h4>
			</div>
			<form  class="form-horizontal" id="formhapus" action="" method="POST" enctype="multipart/form-data">
			<div id="body_hapus" class="modal-body">
				Body goes here...
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-outline pull-left" type="button">Close</button>
				<button class="btn btn-outline" type="submit" type="button">Remove</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Hapus modal -->

<!-- Modal -->
<div class="modal modal-info fade" id="tambahEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
     	<form id="formtambahedit" class="form-horizontal" action="" method="POST">
	     	<div class="modal-content">
	     		<div class="modal-header">
	     			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	     			<h4 id="judul" class="modal-title">Add User</h4>
	     		</div>
	     		<div class="modal-body">
	     			<fieldset>
					  	<div class="form-group">
							<label for="edit_role" class="col-sm-2 control-label">Criteria</label>
							<div class="col-sm-8">
					    		<select class="form-control" name="id_criteria_fk" id="edit_id_criteria_fk" >
					    			<option value="" disabled>- Criteria - </option>
					    			<?php foreach ($criteria as $key => $value): ?>
					    				<option value="<?php echo $value['id_criteria'] ?>"><?php echo $value['criteria'] ?></option>
					    			<?php endforeach ?>
						  		</select>
					    	</div>
						</div>
						<div class="form-group">
					    	<label for="subcriteria" class="col-sm-2 control-label">Sub Criteria</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_subcriteria" name="subcriteria" placeholder="subcriteria" value="" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="edit_pertanyaan" class="col-sm-2 control-label">Pertanyaan</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_pertanyaan" name="pertanyaan" placeholder="pertanyaan" value="" required>
					    	</div>
					  	</div>
					</fieldset>
				</div>
					
	     		<div class="modal-footer">
	     			<button data-dismiss="modal" class="btn btn-outline pull-left" type="button">Close</button>
	     			<button  class="btn btn-outline"  type="submit">Save</button>
	     		</div>
	     	</div>
	     </form>
     </div> 
</div>
<!-- modal -->

<script type="text/javascript">
	function clickHapus(id_subcriteria,subcriteria, criteria) {
    	var formhapus=document.getElementById('formhapus');
    	formhapus.action="<?php echo site_url();?>"+"admin/hapussubcriteria/"+id_subcriteria;
        document.getElementById("body_hapus").innerHTML = "Remove Sub Criteria <b>"+subcriteria+"</b> pada Criteria  <b>"+criteria+"</b>?";
    }

    function clickTambah()
	{
		document.getElementById('judul').innerHTML="Add Sub Criteria";

		var modal=document.getElementById('tambahEditModal');
		var edit_id_criteria_fk = document.getElementById('edit_id_criteria_fk');
		var edit_subcriteria = document.getElementById('edit_subcriteria');
		var edit_pertanyaan = document.getElementById('edit_pertanyaan');
		var formtambahedit = document.getElementById('formtambahedit');

      	
        modal.className="modal modal-info fade";
		edit_id_criteria_fk.value = "";
		edit_subcriteria.value = "";
		edit_pertanyaan.value = "";
        formtambahedit.action="<?php echo site_url();?>"+"admin/tambahsubcriteria";
	}

	function clickEdit(id_subcriteria, id_criteria, subcriteria , pertanyaan)
	{
		document.getElementById('judul').innerHTML="Edit Sub Criteria";

		var modal=document.getElementById('tambahEditModal');

		var edit_id_criteria_fk = document.getElementById('edit_id_criteria_fk');
		var edit_subcriteria = document.getElementById('edit_subcriteria');
		var edit_pertanyaan = document.getElementById('edit_pertanyaan');

		var formtambahedit = document.getElementById('formtambahedit');
        
        modal.className="modal modal-warning fade";       
		edit_id_criteria_fk.value = id_criteria;
		edit_subcriteria.value = subcriteria;
		edit_pertanyaan.value = pertanyaan;
        formtambahedit.action="<?php echo site_url();?>"+"admin/ubahsubcriteria/"+id_subcriteria;
	}

	
</script>