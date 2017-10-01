<section class="content-header">
	<h1>
    	Bobot Total GDSS-AHP
    	<small></small>
  	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Bobot Total GDSS-AHP</h3>
				</div><!-- /.box-header -->
				
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
						     <table class="table table-bordered">

								<tr>
									<th>DM</th>
									<?php foreach ($criteria as $k => $v): ?>
										<th><?php echo $v['criteria'] ?></th>
									<?php endforeach ?>
									<!-- <th>Porsi</th> -->
								</tr>
								
								<?php foreach ($bobot_criteria as $kuser => $cri): ?>
									<tr>
										<td><?php echo 'DM'.($kuser-1) ?></td>
										<?php foreach ($cri as $kcri => $val): ?>
											<td><?php echo $val ?></td>
										<?php endforeach ?>
										<!-- <td><?php echo $user[$kuser]['porsi_bobot'].'%' ?></td> -->
										
									</tr>
								<?php endforeach ?>
								<tr>
									<td></td>
									<?php 
					    			$sum_bobot=0;
					    		 ?>
									<?php foreach ($bobot_criteria_dm as $key => $value): ?>
								
									<td><?php echo $value ?></td>
									<?php 
										$sum_bobot=$sum_bobot+$value;
									 ?>
									<?php endforeach ?>
									<!-- <td><?php echo ($sum_bobot*100).'%' ?></td> -->
								</tr>
							</table>



							<table class="table table-bordered">
								<tr>
									<th></th>
									<?php foreach ($bobot_subcriteria_dm as $key => $value): ?>
										<th colspan="<?php echo sizeof($value) ?>"><?php echo $criteria[$key]['criteria'] ?></th>
									<?php endforeach ?>
								</tr>
								<tr>
									<th>DM</th>
									<?php foreach ($subcriteria as $ksubc => $subc): ?>
										<th><?php echo 'sc'.$subc['id_subcriteria'] ?></th>
									<?php endforeach ?>
									<!-- <th>Porsi</th> -->
								</tr>

								<?php foreach ($bobot_subcriteria as $kuser => $cri): ?>
									<tr>
										<td><?php echo 'DM'.($kuser-1) ?></td>
										<?php foreach ($cri as $kcri => $sc): ?>
											
											<?php foreach ($sc as $key => $va): ?>
											<td><?php echo round($va,2) ?></td>
											<?php endforeach ?>
										<?php endforeach ?>
										<!-- <td><?php echo $user[$kuser]['porsi_bobot'].'%' ?></td> -->
										
									</tr>
								<?php endforeach ?>
								<tr>
									<td></td>
									<?php 
					    			$sum_bobot=0;
					    		 ?>
									<?php foreach ($bobot_subcriteria_dm as $key => $value): ?>
										
										<?php foreach ($value as $key1 => $value1): ?>
											<td><?php echo round($value1,2) ?></td>
											<?php 
												$sum_bobot=$sum_bobot+$value1;
											 ?>
										<?php endforeach ?>
									<?php endforeach ?>
									<!-- <td><?php echo ($sum_bobot*100).'%' ?></td> -->
								</tr>
							</table>
							
						</div>
					</div>
				</div><!-- /.box-body -->
				
			</div><!-- /.box -->
        </div>
	</div>

	
</section><!-- /.content -->
