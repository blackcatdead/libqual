<!-- <pre>
	<?php print_r($subcriteria2) ?>
</pre> -->
<div class="row">
	<div class="col-sm-12">
		<h4 class="page-header">Hasil IPA</h4>
		<table class="table table-bordered">
			<tr>
				<th>Pernyataan</th>
				<th>Persepsi Berbobot</th>
				<th>Ekspektasi Berbobot</th>
				<!-- <th>Masing-masing Item (Tki)</th> -->
			</tr>
			<?php foreach ($view['hasil']['ipa']['tingkatkesesuaian'] as $kc => $cri): ?>
				<?php foreach ($cri as $ksc => $sc): ?>
					<tr>
						<td><?php echo $ksc ?></td>
						<td><?php echo $sc[1] ?></td>
						<td><?php echo $sc[2] ?></td>
						<!-- <td><?php echo $sc['kesesuaian'] ?></td> -->
					</tr>
				<?php endforeach ?>
			<?php endforeach ?>
			<tr class="warn">
				<td>Total</td>
				<td><?php echo $view['hasil']['ipa']['tingkatkesesuaian_total'][1] ?></td>
				<td><?php echo $view['hasil']['ipa']['tingkatkesesuaian_total'][1] ?></td>
				<!-- <td><?php echo round($view['hasil']['ipa']['tingkatkesesuaian_total']['kesesuaian'],2).'%' ?></td> -->
			</tr>
			
		</table>
		<table class="table">
			<!-- <tr>
				<td><strong>Tingkat Kesesuaian Total</strong></td>
				<td><?php echo round($view['hasil']['ipa']['tingkatkesesuaian_total']['kesesuaian'],2).'%' ?></td>
			</tr> -->
			<tr>
				<td><strong>Sumbu x</strong></td>
				<td>Total persepsi berbobot dibagi banyaknya item pernyataan</td>
			<tr>
			<tr>
				<td></td>
				<td><?php echo round($view['hasil']['ipa']['sumbu']['x'],2) ?></td>
			</tr>
			
				<td><strong>Sumbu y</strong></td>
				<td>Rata-rata importance dibagi banyaknya item pertanyaan</td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo round($view['hasil']['ipa']['sumbu']['y'],2) ?></td>
			</tr>
		</table>
		<table class="table table-bordered">
			<tr>
				<th>Pernyataan</th>
				<th>Performance/Persepsi (Sumbu x)</th>
				<th>Importance/Ekspektasi (Sumbu y)</th>
				<th>Kuadran</th>
			</tr>
			<?php foreach ($view['hasil']['ipa']['kuadran'] as $kc => $cri): ?>
				<?php foreach ($cri as $ksc => $sc): ?>
					<tr>
						<td><?php echo $ksc ?></td>
						<td><?php echo $sc[1] ?></td>
						<td><?php echo $sc[2] ?></td>
						<td><?php echo 'Kuadran '.$sc['posisi'] ?></td>
					</tr>
				<?php endforeach ?>
			<?php endforeach ?>
			
		</table>
	</div>
</div>
<div id="container" style="height:750px;width:750px;"></div>