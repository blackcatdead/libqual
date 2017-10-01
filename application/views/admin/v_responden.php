<!-- <pre>
	<?php print_r($countpergroup) ?>
</pre> -->

<section class="content-header">
	<h1>
    	Responden
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
                  <h3 class="box-title">Respondens</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="tab-content">
                  <!-- Morris chart - Sales -->
                  	<div class="table-responsive">
              			<table id="dtble" class="table table-bordered table-hover">
		                    <thead>
		                      <tr>
		                        <th style="width: 50px;">#</th>
		                        <th>Timestamp</th>
		                        <th>Nama</th>
		                        <th>Email</th>
		                        <th>Persepsi</th>
		                        <th>Ekspektasi</th>
		                        <th></th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    <?php $num=1 ?>
		                    	<?php foreach ($responden as $key => $value): ?>
		                    		<tr>
				                        <td><?php echo $num++ ?></td>
				                        <td><?php echo $value['timestamp'] ?></td>	
				                        <td><?php echo $value['nama'] ?></td>	
				                        <td><?php echo $value['email'] ?></td>
				                        <?php 
				                        	$exp_1=explode(',', $value['answers_1']);
				                        	$exp_2=explode(',', $value['answers_2']);

				                        	foreach ($exp_1 as $key => $va1) {
				                        		if ($va1=='') {
				                        			unset($exp_1[$key]);
				                        		}
				                        	}

				                        	foreach ($exp_2 as $key => $va2) {
				                        		if ($va2=='') {
				                        			unset($exp_2[$key]);
				                        		}
				                        	}
				                        ?>

				                       
				                       

				                        <td>
				                        <?php foreach ($exp_1 as $ke => $valu): ?>
				                        	<span class="label label-<?php echo (sizeof($exp_1)==sizeof($subcriteria)) ? 'success' : 'danger' ;?>"><?php echo $valu ?></span>
				                        <?php endforeach ?>
				                        (<?php echo sizeof($exp_1) ?>)
				                        </td>
				                        <td>
				                        <?php foreach ($exp_2 as $ke => $valu): ?>
				                        	<span class="label label-<?php echo (sizeof($exp_2)==sizeof($subcriteria)) ? 'success' : 'danger' ;?>"><?php echo $valu ?></span>
				                        <?php endforeach ?>
				                        (<?php echo sizeof($exp_2); ?>)
				                        </td>	
				                        <td>
		                       				<a data-toggle="modal" onclick="clickHapus('<?php echo $value['id_responden'];?>', '<?php echo $value['email'];?>')"  data-target="#hapusModal"><button class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></button></a>
				                       	</td>
				                 	</tr>
		                    	<?php endforeach ?>
		                    </tbody>
		                    
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
<!-- modal -->

<script type="text/javascript">
	function clickHapus(id,email) {
    	var formhapus=document.getElementById('formhapus');
    	formhapus.action="<?php echo site_url();?>"+"admin/hapusresponden/"+id;
        document.getElementById("body_hapus").innerHTML = "Remove responden dengan email <b>"+email+"</b>?";
    }

    function clickTambah()
	{
		document.getElementById('judul').innerHTML="Add User";

		var modal=document.getElementById('tambahEditModal');
		var edit_username = document.getElementById('edit_username');
		var edit_password = document.getElementById('edit_password');
		var edit_nama = document.getElementById('edit_nama');
		var edit_role = document.getElementById('edit_role');
		var edit_email = document.getElementById('edit_email');
		var edit_alamat = document.getElementById('edit_alamat');
		var edit_jabatan = document.getElementById('edit_jabatan');
		var edit_porsi_bobot = document.getElementById('edit_porsi_bobot');
		var edit_user_status = document.getElementById('edit_user_status');
		var formtambahedit = document.getElementById('formtambahedit');

      	
        modal.className="modal modal-info fade";
		edit_nama.value = "";
		edit_username.value = "";
		edit_password.value = "";
		edit_nama.value = "";
		edit_role.value = "";
		edit_email.value = "";
		edit_alamat.value = "";
		edit_jabatan.value = "";
		edit_porsi_bobot.value = "";
		edit_user_status.value = 1;
        formtambahedit.action="<?php echo site_url();?>"+"admin/tambahuser";
	}

	function clickEdit(id_user, username, password, role, user_status, porsi_bobot, nama, alamat, jabatan, email)
	{
		document.getElementById('judul').innerHTML="Edit User";

		var modal=document.getElementById('tambahEditModal');

		var edit_username = document.getElementById('edit_username');
		var edit_password = document.getElementById('edit_password');
		var edit_nama = document.getElementById('edit_nama');
		var edit_role = document.getElementById('edit_role');
		var edit_email = document.getElementById('edit_email');
		var edit_alamat = document.getElementById('edit_alamat');
		var edit_jabatan = document.getElementById('edit_jabatan');
		var edit_porsi_bobot = document.getElementById('edit_porsi_bobot');
		var edit_user_status = document.getElementById('edit_user_status');

		var formtambahedit = document.getElementById('formtambahedit');
        
        modal.className="modal modal-warning fade";       
		edit_nama.value=nama;
		edit_username.value = username;
		edit_password.value = password;
		edit_nama.value = nama;
		edit_role.value = role;
		edit_email.value = email;
		edit_alamat.value = alamat;
		edit_jabatan.value = jabatan;
		edit_porsi_bobot.value = porsi_bobot;
		edit_user_status.value = user_status;
        formtambahedit.action="<?php echo site_url();?>"+"admin/ubahuser/"+id_user;
	}

	
</script>