
<div class="row">
	<div class="col-sm-12">
		<h4 class="page-header">Bobot AHP</h4>
	     <table class="table table-bordered">

			<tr>
				<th>DM</th>
				<?php foreach ($criteria as $k => $v): ?>
					<th><?php echo $v['criteria'] ?></th>
				<?php endforeach ?>
				<!-- <th>Porsi</th> -->
			</tr>
			
			<?php foreach ($view['perhitungan']['libq']['bobot_criteria'] as $kuser => $cri): ?>
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
				<?php foreach ($view['perhitungan']['libq']['bobot_criteria_dm'] as $key => $value): ?>
			
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
				<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria_dm'] as $key => $value): ?>
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
			
			<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria'] as $kuser => $cri): ?>
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
				<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria_dm'] as $key => $value): ?>
					
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
		<h4 class="page-header">Inputan Responden</h4>
		<table class="table table-bordered">
			<tr>
				<th></th>
				<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria_dm'] as $key => $value): ?>
					<th colspan="<?php echo sizeof($value) ?>"><?php echo $criteria[$key]['criteria'] ?></th>
				<?php endforeach ?>
			</tr>
			<tr>
				<th>No</th>
				<?php foreach ($subcriteria as $ksubc => $subc): ?>
					<th><?php echo 'sc'.$subc['id_subcriteria'] ?></th>
				<?php endforeach ?>
				<?php foreach ($view['perhitungan']['libq']['responden'] as $kresp => $resp): ?>
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
		</table>
		<h4 class="page-header">Diskretisasi</h4>
		<table class="table">
			<tr>
				<th>Diskretisasi</th>
				<th>Min</th>
				<th>Max</th>
			</tr>
				<?php $batas_awal=1; ?>
				<?php foreach ($diskretisasi as $key => $value): ?>
					<tr>
						<td><?php echo $value['diskretisasi'] ?></td>
						<td><?php echo $batas_awal ?></td>
						
						<td><?php echo $value['batas_akhir'] ?></td>
					</tr>
					<?php $batas_awal= $value['batas_akhir']+0.5?>
				<?php endforeach ?>
		</table>

		<h4 class="page-header">Diskretisasi Responden</h4>
		<table class="table table-bordered">
			<tr>
				<th></th>
				<?php foreach ($view['perhitungan']['libq']['bobot_subcriteria_dm'] as $key => $value): ?>
					<th colspan="<?php echo sizeof($value) ?>"><?php echo $criteria[$key]['criteria'] ?></th>
				<?php endforeach ?>
			</tr>
			<tr>
				<th>No</th>
				<?php foreach ($subcriteria as $ksubc => $subc): ?>
					<th><?php echo 'sc'.$subc['id_subcriteria'] ?></th>
				<?php endforeach ?>
				<?php foreach ($view['perhitungan']['libq']['responden_diskretisasi'] as $kresp => $resp): ?>
					<tr>
						<td><?php echo 'r'.$kresp ?></td>
						<?php foreach ($resp as $kc => $cri): ?>
							<?php foreach ($cri as $ksc => $sc): ?>
								<td><?php echo $diskretisasi3[$sc]['diskretisasi'] ?></td>
							<?php endforeach ?>
							
						<?php endforeach ?>	
					</tr>
				<?php endforeach ?>
			</tr>
		</table>
		<h4 class="page-header">Olah Diskretisasi</h4>
		<table class="table table-bordered">
			<tr>
				<th rowspan="2">Pernyataan</th>
				<th colspan="<?php echo sizeof($diskretisasi) ?>">Nilai</th>
				<th colspan="<?php echo sizeof($diskretisasi) ?>">Rerata</th>
			</tr>
			<tr>
				<?php foreach ($diskretisasi as $key => $value): ?>
					<th><?php echo $value['diskretisasi'] ?></th>
				<?php endforeach ?>
				<?php foreach ($diskretisasi as $key => $value): ?>
					<th><?php echo $value['diskretisasi'] ?></th>
				<?php endforeach ?>
			</tr>
			<?php foreach ($view['perhitungan']['libq']['olahdiskretisasi'] as $kcri => $cri): ?>
				<?php foreach ($cri as $ksc => $sc): ?>
					<tr>
						<td><?php echo 'sc'.$ksc ?></td>
						<?php foreach ($sc as $kdiskrit => $diskrit): ?>
							<td><?php echo $diskrit['count'] ?></td>
						<?php endforeach ?>
						<?php foreach ($sc as $kdiskrit => $diskrit): ?>
							<td><?php echo round($diskrit['avg'],2) ?></td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			<?php endforeach ?>
		</table>
		
		<h4 class="page-header">Step 1</h4>
		<?php foreach ($view['perhitungan']['libq']['hitung1'] as $kc => $cri): ?>
			<table class="table table-bordered">
				<tr>
					<th></th>
					<?php foreach ($diskretisasi as $key => $value): ?>
						<th><?php echo $value['diskretisasi'] ?></th>
					<?php endforeach ?>
				</tr>
				<?php foreach ($cri as $ksc => $sc): ?>
					<tr>
						<td><?php echo 'sc'.$ksc ?></td>
						<?php foreach ($sc as $kd => $dis): ?>
							<td><?php echo round($dis,5) ?></td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
				<tr class="warning">
					<td>SUM</td>
					<?php foreach ($view['perhitungan']['libq']['hitung1_sum'][$kc] as $key => $value): ?>
						<td><?php echo round($value,5) ?></td>
					<?php endforeach ?>
				</tr>
			</table>
		<?php endforeach ?>

		<h4 class="page-header">Step 2</h4>
		<table class="table table-bordered">
			<tr>
				<th></th>
				<?php foreach ($diskretisasi as $key => $value): ?>
					<th><?php echo $value['diskretisasi'] ?></th>
				<?php endforeach ?>
			</tr>
			<?php foreach ($view['perhitungan']['libq']['hitung2'] as $kc => $c): ?>
				<tr>
					<td><?php echo $criteria[$kc]['criteria'] ?></td>
					<?php foreach ($c as $kd => $d): ?>
						<td><?php echo round($d,5) ?></td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
			<tr class="warning">
				<td>SUM</td>
				<?php foreach ($view['perhitungan']['libq']['hitung2_sum'] as $key => $value): ?>
					<td><?php echo round($value,5) ?></td>
				<?php endforeach ?>
			</tr>
		</table>

		<h4 class="page-header">Kesimpulan Tingkat Kualitas Layanan (Persentase)</h4>
		
		<table class="table table-bordered">
			<tr>
				<?php foreach ($diskretisasi as $key => $value): ?>
					<th><?php echo $value['diskretisasi_panjang'].' ('.$value['diskretisasi'].')' ?></th>
				<?php endforeach ?>
			</tr>
			<tr>
			<?php $id_diskretisasi_max=0 ?>
				<?php foreach ($view['hasil']['libq']['prosentase'] as $key => $value): ?>
					<td class="<?php echo ($value == max($view['hasil']['libq']['prosentase'])) ? 'warning' : '' ; ?>"><?php echo round($value,5).'%' ?></td>
					<?php 
						if ($value == max($view['hasil']['libq']['prosentase'])) {
							$id_diskretisasi_max=$key;
						}
					 ?>
				<?php endforeach ?>	
			</tr>
			
		</table>
		<p>
		<?php if (isset($diskretisasi3[$id_diskretisasi_max]['diskretisasi_panjang'])): ?>
			Kesimpulan berdasarkan Evaluasi dinyatakan bahwa tingkat kepuasan Pemustaka/Responden adalah pada tingkat <strong><?php echo $diskretisasi3[$id_diskretisasi_max]['diskretisasi_panjang'].' ('.$diskretisasi3[$id_diskretisasi_max]['diskretisasi'].')' ?></strong> yaitu (<?php echo round(max($view['hasil']['libq']['prosentase']),5).'%' ?>)
		<?php endif ?>
			
		</p>
	</div>
</div>