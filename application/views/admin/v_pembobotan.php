<!-- <?php 
echo '<pre>';
print_r($view_criteria) ;
echo '</pre>';
?>

<?php 
echo '<pre>';
print_r($view_subcriteria) ;
echo '</pre>';
?>
 -->
<!-- <pre>
	<?php print_r($countpergroup) ?>
</pre> -->

<section class="content-header">
	<h1>
    	Pembobotan
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
                  <h3 class="box-title">Kriteria & Sub Kriteria</h3>
                   <div class="box-tools pull-right">
                    <ul class="pagination pagination-sm inline">
                      <li class="<?php echo ($this->session->flashdata('tab')==0) ? "active" : "" ; ?>"><a href="#g0" data-toggle="tab">Kriteria</a></li>
                      <?php for ($i=0; $i < count($criteria); $i++): ?>
                      	<li class="<?php echo ($this->session->flashdata('tab')==$criteria[$i]['id_criteria']) ? "active" : "" ; ?>"><a href="#g<?php echo $criteria[$i]['id_criteria'] ?>" data-toggle="tab"><?php echo "Sub Kriteria ".$criteria[$i]['criteria'] ?></a></li>
                      <?php endfor ?>
                      <li class=""><a href="#g10" data-toggle="tab">Hasil Pembobotan</a></li>
	                </ul>
                  </div>
                </div><!-- /.box-header -->

                <div class="tab-content">
	                <div class="tab-pane <?php echo ($this->session->flashdata('tab')==0) ? "active" : "" ; ?>" id="g0">
		                <form class="form-horizontal" method="POST" action="<?php echo site_url() ?>admin/submitbobot/1/0">
		                <div class="box-body">
		                   
		                   		
		                   			<div class="row">
			                  			<div class="col-sm-6">
				                  			<table class="table table-bordered table-hover">
			                  					<tr class="success">
			                  						<td></td>
			                  						<?php foreach ($view_criteria['list'] as $key => $value): ?>
			                  							<td><?php echo $value['criteria'] ?></td>
													<?php endforeach ?>
			                  					</tr>
					                  			<?php foreach ($view_criteria['table'] as $key => $value): ?>
					                  				<tr>
					                  					<td class="success"><?php echo $view_criteria['list'][$key]['criteria'] ?></td>
					                  					<?php foreach ($value as $key2 => $value2): ?>
						                  					<td class="<?php echo ($key == $key2) ? 'warning' : '' ; ?>"><?php echo (($value2[1]!=0) && ($value2[2]!=0)) ? round($value2[1]/$value2[2],2) : 0 ;?></td>
						                  				<?php endforeach ?>	
					                  				</tr>
					                  				
					                  			<?php endforeach ?>
					                  		</table>

				                  		</div>	
				                  		<div class="col-sm-6">
				                  			<!-- <ul>
						                  		<?php foreach ($view_criteria['list'] as $key => $value): ?>
						                  			<li>c<?php echo $value['id_criteria'] ?>: <?php echo $value['criteria'] ?></li>
						                  		<?php endforeach ?>
					                  		</ul> -->
				                  		</div>
			                  		</div>
			                  		

			                  		<?php foreach ($view_criteria['form'] as $key1 => $value1): ?>

			                  			<?php foreach ($value1 as $key2 => $value2): ?>
			                  				<div class="form-group">
							                  <div class="col-sm-4">
							                    <input type="text" class="form-control" placeholder="criteria 1" readonly value="c<?php echo $key1.'. '.$view_criteria['list'][$key1]['criteria'] ?>" tabindex="-1" >
							                  </div>
							                  <div class="col-sm-2">
							                  	<!-- <?php print_r($value2)?> -->
							                    <select id="<?php echo 'ac'.$key1.'ac'.$key2 ?>" onchange="onselectchange('<?php echo $key1 ?>','<?php echo $key2 ?>')" class="form-control" name="bobot[<?php echo $key1 ?>][<?php echo $key2 ?>][lebihpenting]">
							                    	<option value="1" <?php echo ($value2['lebihpenting'] == 1) ? 'selected' : '' ; ?>>Lebih Penting</option>
							                    	<option value="2" <?php echo ($value2['lebihpenting'] == 2) ? 'selected' : '' ; ?>>Kurang Penting</option>
							                    	<option value="3" <?php echo ($value2['nilai'] == 1) ? 'selected' : '' ; ?>>Sama Penting</option>
							                    </select>
							                  </div>
							                  <div class="col-sm-4">
							                    <input type="text" class="form-control" placeholder="criteria 2" readonly value="c<?php echo $key2.'. '.$view_criteria['list'][$key2]['criteria'] ?>" tabindex="-1" >
							                  </div>
							                  <div class="col-sm-2">
							                    <input type="number" id="<?php echo 'c'.$key1.'c'.$key2 ?>" min="1" max="9" class="form-control" name="bobot[<?php echo $key1 ?>][<?php echo $key2 ?>][nilai]" placeholder="bobot" value="<?php echo $value2['nilai'] ?>" <?php echo ($value2['nilai'] == 1) ? 'readonly' : '' ; ?> required>
							                  </div>
							                </div>
			                  			<?php endforeach ?>
			                  		<?php endforeach ?>

			                  		<script type="text/javascript">
				                    	function onselectchange(key1, key2) {
				                    		var select = document.getElementById("ac"+key1+"ac"+key2);
				                    		var bobot = document.getElementById("c"+key1+"c"+key2);
										    if(select.value == 3)
										    {
										    	bobot.value=1;
										    	bobot.readOnly = true;
										    	//alert(key1+" - "+key2+" - "+bobot.value);
										    }else
										    {
										    	bobot.readOnly = false;
										    }
										}
				                    </script>
			           				
			                  		<div class="row">
			                  			<div class="col-sm-6">
			                  				<table class="table col-sm-1">
					           					<tr>
					           						<td>Nilai Lambda</td>
					           						<td><?php echo round($view_criteria['konsistensi']['lambda'],5) ?></td>
					           					</tr>
					           					<tr>
					           						<td>Nilai Consistency Index</td>
					           						<td><?php echo round($view_criteria['konsistensi']['ci'],5) ?></td>
					           					</tr>
					           					<tr>
					           						<td>Nilai Consistency Ratio</td>
					           						<td><?php echo round($view_criteria['konsistensi']['cr'],5) ?></td>
					           					</tr>
					           					<tr>
					           						<td>Consistency</td>
					           						<td><h4><span class="label label-<?php echo ($view_criteria['konsistensi']['konsisten']=="Telah Konsisten") ? "success" : "danger" ;?>"><?php echo $view_criteria['konsistensi']['konsisten'] ?></span></h4>
					           							<?php echo ($view_criteria['konsistensi']['konsisten']=="Telah Konsisten") ? "" : "<strong>(Periksa kembali nilai perbandingan antar kriteria)</strong>" ;?> </td>
					           					</tr>
					           				</table>
			                  			</div>
			                  		</div>
		                   		
			                
			            </div><!-- /.box-body -->
			            <div class="box-footer">
			            	<button type="submit" class="btn btn-info pull-right btn-md">Save</button>
			            </div>
			            </form>
			       	</div><!--/end tab pane -->

			       	<?php $index=1; ?>
               		<?php foreach ($view_subcriteria as $key => $persub): ?>

               		<div class="tab-pane  <?php echo ($this->session->flashdata('tab')==$key) ? "active" : "" ; ?>" id="g<?php echo $key ?>">
               			<form class="form-horizontal" method="POST" action="<?php echo site_url() ?>admin/submitbobot/2/<?php echo $key ?>">
		                <div class="box-body">
		                	<div class="page-header">
						        Sub Kriteria: <strong><?php echo $view_criteria['list'][$key]['criteria'] ?></strong>
						    </div>
		                    <div class="row">
	                  			<div class="col-sm-6">
		                  			<table class="table table-bordered table-hover">
	                  					<tr class="success">
	                  						<td></td>
	                  						<?php 
	                  							if (!isset($persub['list'])) {
	                  								$persub['list']=[];
	                  							}
	                  						 ?>
	                  						<?php foreach ($persub['list'] as $key => $value): ?>
	                  							<td>sc<?php echo $value['id_subcriteria'] ?></td>
											<?php endforeach ?>
	                  					</tr>

	                  					<?php 
                  							if (!isset($persub['table'])) {
                  								$persub['table']=[];
                  							}
                  						 ?>
			                  			<?php foreach ($persub['table'] as $key2 => $value): ?>
			                  				<tr>
			                  					<td class="success">sc<?php echo $key2 ?></td>
			                  					<?php foreach ($value as $key => $value2): ?>
				                  					<td class="<?php echo ($key == $key2) ? 'warning' : '' ; ?>"><?php echo (($value2[1]!=0) && ($value2[2]!=0)) ? round($value2[1]/$value2[2],2) : 0 ;?></td>
				                  				<?php endforeach ?>	
			                  				</tr>
			                  				
			                  			<?php endforeach ?>
			                  		</table>

		                  		</div>
		                  		<div class="col-sm-6">
		                  			<ul>

				                  		<?php foreach ($persub['list'] as $key => $value): ?>
				                  			<li>sc<?php echo $value['id_subcriteria'] ?>: <?php echo $value['subcriteria'] ?></li>
				                  		<?php endforeach ?>
			                  		</ul>
		                  		</div>	
	                  		</div>
	                  		<?php 
      							if (!isset($persub['form'])) {
      								$persub['form']=[];
      							}
      						 ?>
	                  		<?php foreach ($persub['form'] as $key1 => $value1): ?>
	                  			<?php foreach ($value1 as $key2 => $value2): ?>
	                  				<div class="form-group">
					                  <div class="col-sm-4">
					                    <input type="text" class="form-control" placeholder="criteria 1" readonly value="sc<?php echo $key1.'. '.$persub['list'][$key1]['subcriteria'] ?>" tabindex="-1" >
					                  </div>
					                  <div class="col-sm-2">
					                  	<!-- <?php print_r($value2)?> -->
					                    <select id="<?php echo 'asc'.$key1.'asc'.$key2 ?>" onchange="onselectchange2('<?php echo $key1 ?>','<?php echo $key2 ?>')" class="form-control" name="bobot[<?php echo $key1 ?>][<?php echo $key2 ?>][lebihpenting]">
					                    	<option value="1" <?php echo ($value2['lebihpenting'] == 1) ? 'selected' : '' ; ?>>Lebih Penting</option>
					                    	<option value="2" <?php echo ($value2['lebihpenting'] == 2) ? 'selected' : '' ; ?>>Kurang Penting</option>
					                    	<option value="3" <?php echo ($value2['nilai'] == 1) ? 'selected' : '' ; ?>>Sama Penting</option>
					                    </select>
					                  </div>
					                  <div class="col-sm-4">
					                    <input type="text" class="form-control" placeholder="criteria 2" readonly value="sc<?php echo $key2.'. '.$persub['list'][$key2]['subcriteria'] ?>" tabindex="-1" >
					                  </div>
					                  <div class="col-sm-2">
					                    <input type="number" id="<?php echo 'sc'.$key1.'sc'.$key2 ?>" min="1" max="9" class="form-control" name=bobot[<?php echo $key1 ?>][<?php echo $key2 ?>][nilai] placeholder="bobot" value="<?php echo $value2['nilai'] ?>" <?php echo ($value2['nilai'] == 1) ? 'readonly' : '' ; ?> required>
					                  </div>
					                </div>
	                  			<?php endforeach ?>
	                  		<?php endforeach ?>
	                  		<div class="row">
	                  			<div class="col-sm-6">
	                  			<!-- <?php print_r($persub) ?> -->
	                  				<table class="table col-sm-1">
			           					<tr>
			           						<td>Nilai Lambda</td>
			           						<td><?php echo round($persub['konsistensi']['lambda'],5) ?></td>
			           					</tr>
			           					<tr>
			           						<td>Nilai Consistency Index</td>
			           						<td><?php echo round($persub['konsistensi']['ci'],5) ?></td>
			           					</tr>
			           					<tr>
			           						<td>Nilai Consistency Ratio</td>
			           						<td><?php echo round($persub['konsistensi']['cr'],5) ?></td>
			           					</tr>
			           					<tr>
			           						<td>Consistency</td>
			           						<td><h4><span class="label label-<?php echo ($persub['konsistensi']['konsisten']=="Telah Konsisten") ? "success" : "danger" ;?>"><?php echo $persub['konsistensi']['konsisten'] ?></span></h4>
			           							<?php echo ($persub['konsistensi']['konsisten']=="Telah Konsisten") ? "" : "<strong>(Periksa kembali nilai perbandingan antar kriteria)</strong>" ;?> </td>
			           					</tr>
			           				</table>
	                  			</div>
	                  		</div>
                  		</div><!-- /.box-body -->
			            <div class="box-footer">
			            	<button type="submit" class="btn btn-info pull-right btn-md">Save</button>
			            </div>
			            </form>
			        </div>
                	<?php endforeach ?>
                	<script type="text/javascript">
                    	function onselectchange2(key1, key2) {
                    		var select = document.getElementById("asc"+key1+"asc"+key2);
                    		var bobot = document.getElementById("sc"+key1+"sc"+key2);
						    if(select.value == 3)
						    {
						    	bobot.value=1;
						    	bobot.readOnly = true;
						    	//alert(key1+" - "+key2+" - "+bobot.value);
						    }else
						    {
						    	bobot.readOnly = false;
						    }
						}
                    </script>
                	<div class="tab-pane " id="g10">
                		<div class="box-body">
                		 	<table class="table table-bordered col-sm-1">
                		 		<?php $sum=0; ?>
	           					<tr class="success">
	           						<th>Kriteria</th>
	           						<th>Bobot Kriteria</th>
	           						<th>Sub Kriteria</th>
	           						<th>Bobot Prioritas Sub-Kriteria</th>
	           						<th>Bobot Global Sub-Kriteria</th>
	           					</tr>
	           					<?php foreach ($view_pembobotan[2] as $key1 => $value1): ?>
	           						<?php $row=1; ?>
	           						<?php foreach ($value1 as $key2 => $value2): ?>
	           							<tr>
	           								<?php if ($row==1): ?>
	           									<td rowspan="<?php echo sizeof($value1) ?>"><?php echo $view_criteria['list'][$key1]['criteria'] ?></td>
	           								<?php endif ?>
	           								<?php if ($row==1): ?>
	           									<td rowspan="<?php echo sizeof($value1) ?>"><?php echo round($view_pembobotan[1][$key1],2) ?></td>
	           								<?php endif ?>
	           							<!-- <?php echo '<pre>'; print_r($view_subcriteria[$key1]['list'][$key2]); ?> -->
	           								<td><?php echo $view_subcriteria[$key1]['list'][$key2]['subcriteria'] ?></td>
	           								<td><?php echo round($value2,2) ?></td>
	           								<td><?php echo round($value2*$view_pembobotan[1][$key1],2) ?></td>
	           								<?php $sum=$sum+($value2*$view_pembobotan[1][$key1]) ?>
	           							</tr>
	           							<?php $row++ ?>
	           						<?php endforeach ?>
	           					<?php endforeach ?>
	           					<tr class="warning">
	   								<th colspan="4">Bobot Prioritas</th>
	   								<th><?php echo $sum ?></th>
	   							</tr>
	           				</table>
                		</div>
                	
                	</div>
				</div>
		    </div><!-- /.box -->
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
		var formtambahedit = document.getElementById('formtambahedit');

      	
        modal.className="modal modal-info fade";
		edit_id_criteria_fk.value = "";
		edit_subcriteria.value = "";
        formtambahedit.action="<?php echo site_url();?>"+"admin/tambahsubcriteria";
	}

	function clickEdit(id_subcriteria, id_criteria, subcriteria )
	{
		document.getElementById('judul').innerHTML="Edit Sub Criteria";

		var modal=document.getElementById('tambahEditModal');

		var edit_id_criteria_fk = document.getElementById('edit_id_criteria_fk');
		var edit_subcriteria = document.getElementById('edit_subcriteria');

		var formtambahedit = document.getElementById('formtambahedit');
        
        modal.className="modal modal-warning fade";       
		edit_id_criteria_fk.value = id_criteria;
		edit_subcriteria.value = subcriteria;
        formtambahedit.action="<?php echo site_url();?>"+"admin/ubahsubcriteria/"+id_subcriteria;
	}

	
</script>