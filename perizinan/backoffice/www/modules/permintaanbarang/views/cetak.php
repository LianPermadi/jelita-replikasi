 <table>
	<tr>
		<th>No</th>
		<th>Status</th>
		<th>Nama Barang</th>
		<th>Merk</th>
		<th>Jumlah - Satuan</th>
		<th>Harga Satuan</th>
		<th>Harga Total</th>
		<th>Tanggal</th>
		<th>Penginput</th>
	</tr>
	<?php
		$i = 1;
		foreach ($log as $row) {
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->log; ?></td>
		<td><?php echo $row->nama_barang; ?></td>
		<td><?php echo $row->merk; ?></td>
		<td><?php echo $row->jumlah_barang.' - '.$row->satuan; ?></td>
		<td><?php echo $row->harga; ?></td>
		<td><?php 
		$hasil = $row->jumlah_barang * $row->harga;
		echo $hasil;
	?></td>
		<td><?php echo $row->date; ?></td>
		<td><?php echo $row->input; ?></td>
	</tr>
	<?php $i++} ?>
</table>
<script type="text/javascript">
	window.print();
</script>