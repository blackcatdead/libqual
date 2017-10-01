<!-- <pre>
	<?php print_r($view['perhitungan']['ipa']['bobot_criteria_dm']) ?>
</pre> -->
<div class="row">
	<div class="col-sm-12">

		<h4 class="page-header">Ekspektasi LibQual Berbobot</h4>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th></th>
					<?php foreach ($view['perhitungan']['ipa']['bobot_subcriteria_dm'] as $key => $value): ?>
						<th colspan="<?php echo sizeof($value) ?>"><?php echo $criteria[$key]['criteria'] ?></th>
					<?php endforeach ?>
				</tr>
				<tr>
					<th>No</th>
					<?php foreach ($subcriteria as $ksubc => $subc): ?>
						<th><?php echo 'sc'.$subc['id_subcriteria'] ?></th>
					<?php endforeach ?>
					<?php foreach ($view['perhitungan']['ipa']['responden'][2] as $kresp => $resp): ?>
						<tr>
							<td><?php echo 'r'.$kresp ?></td>
							<?php foreach ($resp as $kc => $cri): ?>
								<?php foreach ($cri as $ksc => $sc): ?>
									<td><?php echo $sc ?></td>
								<?php endforeach ?>
								
							<?php endforeach ?>	
						</tr>
					<?php endforeach ?>
				</tr>
				<tr class="warning">
					<td>Jumlah</td>
					<?php foreach ($view['perhitungan']['ipa']['responden']['sum_jum_2'] as $kc => $cri): ?>
						<?php foreach ($cri as $ksc => $sc): ?>
							<?php 
								if (!isset($sc['sum'])) {
									$sc['sum']=0;
								}
							 ?>
							<td><?php echo $sc['sum'] ?></td>
						<?php endforeach ?>
						
					<?php endforeach ?>
				</tr>
				<tr class="warning">
					<td>Rerata</td>
					<?php foreach ($view['perhitungan']['ipa']['responden']['sum_jum_2'] as $kc => $cri): ?>
						<?php foreach ($cri as $ksc => $sc): ?>
							<?php 
								if (!isset($sc['avg'])) {
									$sc['avg']=0;
								}
							 ?>
							<td><?php echo round($sc['avg'],2) ?></td>
						<?php endforeach ?>
						
					<?php endforeach ?>
				</tr>
				<tr class="warning">
					<td>Bobot GDSS-AHP</td>
					<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria_dm'] as $key => $value): ?>
						
						<?php foreach ($value as $key1 => $value1): ?>
							<td><?php echo round($value1,2) ?></td>
						<?php endforeach ?>
					<?php endforeach ?>
				</tr>
				<tr class="warning">
					<td><strong>Ekspektasi Berbobot</strong></td>
					<?php foreach ($view['perhitungan']['ipa']['responden']['sum_jum_2'] as $kc => $cri): ?>
						<?php foreach ($cri as $ksc => $sc): ?>
							<td><?php echo round($sc['berbobot'],2) ?></td>
						<?php endforeach ?>
						
					<?php endforeach ?>
				</tr>
				<!-- <tr class="warning">
					<td>Rerata Ekspektasi Berbobot</td>
					<?php foreach ($view['perhitungan']['ipa']['responden']['rata_subcri_berbobot_2'] as $key => $value): ?>
						<td colspan="<?php echo sizeof($view['perhitungan']['ipa']['bobot_subcriteria_dm'][$key]) ?>" =""><?php echo round($value,2) ?></td>
					<?php endforeach ?>
				</tr> -->
			</table>	
		</div>
		
	</div>
</div>