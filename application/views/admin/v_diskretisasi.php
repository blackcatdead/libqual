<!-- <pre>
	<?php print_r($countpergroup) ?>
</pre> -->

<section class="content-header">
	<h1>
    	Diskretisasi
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
				  <h3 class="box-title">Diskretisasi</h3>
				</div><!-- /.box-header -->
				
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<table class="table">
								<tr>
									<th>#</th>
									<th>Label Diskretisasi</th>
									<th>Singkat</th>
									<th>Min</th>
									<th>Max</th>
									<th></th>
								</tr>
								<?php $value['batas_akhir']=1; ?>
								<?php foreach ($diskretisasi as $key => $value): ?>
									
									<tr>
										<td><?php echo $key+1 ?></td>
										<td><?php echo $value['diskretisasi_panjang'] ?></td>
										<td><?php echo $value['diskretisasi'] ?></td>
										<?php if ($key==0): ?>
											<td>1</td>
										<?php else: ?>
											<td><?php echo $diskretisasi[$key-1]['batas_akhir']+0.5 ?></td>
										<?php endif ?>
										<td><?php echo $value['batas_akhir'] ?></td>
										<td>
										<?php if (sizeof($diskretisasi)==$key+1): ?>
											<a href="<?php echo site_url().'admin/hapusdiskretisasi/'.$value['id_diskretisasi'] ?>"><button class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></button></a>
										<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
								<?php if ($value['batas_akhir']<9): ?>
									<form method="POST" action="<?php echo site_url() ?>admin/tambahdiskretisasi">
									<tr class="warning">
										<td></td>
										<td><input type="text" required class="" name="diskretisasi_panjang" placeholder="Nama Diskretisasi"></td>
										<td><input type="text" required class="" name="diskretisasi" placeholder="Nama Diskretisasi Singkat"></td>
										<td><?php echo $value['batas_akhir']+((sizeof($diskretisasi)>0) ? 0.5 : 0 );?></td>
										<td><input type="number" min="<?php echo $value['batas_akhir']+0.5?>" max="9" step="0.5"  value="<?php echo $value['batas_akhir']+((sizeof($diskretisasi)>0) ? 1 : 0.5 ) ?>" class="" name="batas_akhir" required></td>
										<td>
											<button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus"></i>Tambah</button>
										</td>
									</tr>
									</form>
								<?php endif ?>
								
							</table>
						</div>
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
					    	<label for="username" class="col-sm-2 control-label">Username</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_username" name="username" placeholder="username" value="" required>
					    	</div>
					  	</div>
	     				<div class="form-group">
					    	<label for="password" class="col-sm-2 control-label">Password</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_password" name="password" placeholder="password" value="" required>
					    	</div>
					  	</div>
	     				<div class="form-group">
					    	<label for="username" class="col-sm-2 control-label">Nama</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Nama" value="" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
							<label for="edit_role" class="col-sm-2 control-label">Role</label>
							<div class="col-sm-8">
					    		<select class="form-control" name="role" id="edit_role" >
					    			<option value="" disabled>- Role - </option>
					      			<option value="1">Admin</option>
					      			<option value="2">Petugas Perpustakaan</option>
					      			<option value="3">Pakar</option>
						  		</select>
					    	</div>
						</div>
					  	<div class="form-group">
					    	<label for="username" class="col-sm-2 control-label">Email</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_email" name="email" placeholder="Email" value="" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="alamat" class="col-sm-2 control-label">Alamat</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_alamat" name="alamat" placeholder="alamat" value="" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="jabatan" class="col-sm-2 control-label">Jabatan</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control" id="edit_jabatan" name="jabatan" placeholder="jabatan" value="" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="porsi_bobot" class="col-sm-2 control-label">Porsi Bobot</label>
					    	<div class="col-sm-8">
					      		<input type="number" class="form-control" id="edit_porsi_bobot" name="porsi_bobot" placeholder="porsi bpobot" value="" required>
					    	</div>
					  	</div>

					  	<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-8">
					    		<select class="form-control" name="user_status" id="edit_user_status" value="1">
					      			<option value="1">Active</option>
					      			<option value="2">Deactive</option>
						  		</select>
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
