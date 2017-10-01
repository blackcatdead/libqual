<!--  <pre>
	<?php print_r($diskretisasi3) ?>
</pre>  -->
<div class="row">
	<div class="col-sm-12">
		<h4 class="page-header">Hasil Libqual (Persentase)</h4>
		
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
			Kesimpulannya berdasarkan Evaluasi dinyatakan bahwa tingkat kepuasan Pemustaka/Responden adalah pada tingkat <strong><?php echo $diskretisasi3[$id_diskretisasi_max]['diskretisasi_panjang'].' ('.$diskretisasi3[$id_diskretisasi_max]['diskretisasi'].')' ?></strong> yaitu (<?php echo round(max($view['hasil']['libq']['prosentase']),5).'%' ?>)
		</p>
	</div>
</div>


  