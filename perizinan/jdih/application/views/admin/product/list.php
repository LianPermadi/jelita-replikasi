<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">

	<?php $this->load->view("admin/_partials/navbar.php") ?>
	<div id="wrapper">

		<?php $this->load->view("admin/_partials/sidebar.php") ?>

		<div id="content-wrapper">

			<div class="container-fluid">


				<!--DataTables //	  -->
				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('products/add') ?>"><i class="fas fa-plus"></i> Tambah Data</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>			
									<th>Action</th>		
										<th>Nama</th>
										<th>NIP</th>
										<th>Bulan</th>
										<th>THP</th>
										<th>Tunjangan Pasangan</th>
										<th>Tunjangan Anak</th>
										<th>Tunjangan Umum</th>
										<th>Tunjangan Struktural</th>
										<th>Tunjangan Beras</th>
										<th>Tunjangan PPh 21</th>
										<th>Pembulatan</th>
										<th>Gaji Bruto</th>
										<th>Rapel Gaji</th>
										<th>Keterangan Rapel</th>
										<th>Potongan Beras</th>
										<th>Potongan I.W.P 8%</th>
										<th>Potongan ASKES 2%</th>
										<th>Potongan PPh</th>
										<th>S. Rumah</th>
										<th>Hutang</th>
										<th>T.Rumah</th>
										<th>Lain-lain</th>
										<th>Potongan Bank (Gaji)</th>

<th>Iuran Koperasi PEMDA</th>
										<th>Cicilan Koperasi PEMDA (Gaji)</th>
										<th>Jumlah Potongan Bank & Koperasi</th>

<th>Gaji Yang diterima</th>
										<th>TTP Maksimal</th>
										<th>Rapel TOL</th>
										<th>Prosentase TTP</th>
										<th>TTP Bruto</th>
										<th>Pajak TPP (progresif)</th>
										<th>TPP Netto</th>
										<th>Zakat TTP (2,5 %)</th>
										<th>Cicilan Koperasi Praja </th>
										<th>Simpanan Koperasi Praja </th>
										<th>Cicilan Koperasi PEMDA (TTP) </th>
										<th>Potongan Bank  (TTP) </th>
										<th>Potongan Lain-Lain</th>
										<th>Jumlah Potongan TTP</th>
										<th>TPP yang Diterima</th>
										<th>Jumlah Konpen</th>
																			


									</tr>
								</thead>
								<tbody>
									<?php foreach ($products as $product): ?>
									<tr>
										<td width="250">
											<a href="<?php echo site_url('products/edit/'.$product->id) ?>"
											 class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
											<a onclick="deleteConfirm('<?php echo site_url('products/delete/'.$product->id) ?>')"
											 href="#!" class="btn btn-small text-danger"><i class="fas fa-trash"></i> Hapus</a>
											 <a onclick="duplicatConfirm('<?php echo site_url('products/duplikat/'.$product->id) ?>')"
											 href="#!" class="btn btn-small text-success"><i class="fas fa-copy"></i> Duplikat</a>
										</td>										
										
										<td>
											<?php echo $product->n_pegawai ?>
										</td>
										<td>
											<?php echo $product->id_pegawai ?>
										</td>										
										<td>
											<?php echo $product->bulan ?>
										</td>		
										<td>
											<?php echo  "Rp" . number_format($product->thp,0,',','.'); ?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_pasangan,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_anak,0,',','.'); ?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_umum,0,',','.'); ?>
										</td>
									
										<td>
											<?php echo  "Rp" . number_format($product->t_struktural,0,',','.'); ?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_beras,0,',','.'); ?>
										</td>
										
										<td>
											<?php echo  "Rp" . number_format($product->t_khususpph21,0,',','.'); ?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_pembulatan,0,',','.'); ?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->t_jumlah,0,',','.');?>
										</td>
										
										<td>
											<?php echo  "Rp" . number_format($product->rapel_gaji,0,',','.');?>
										</td>
										<td>
											<?php echo  $product->ket_rapel_gaji?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_beras,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_iuranwajib,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_askes,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_pph,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->a_p_srumah,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->a_p_hutang,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_cicilanrumah,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->a_2_lainnya,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_cicilanbank,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_iurankoperasipemda,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->p_cicilankoperasipemda,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->jumlahpotongan,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->gajiterima,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->bp_ttpbruto,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->rapel_tol,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->bp_prosentasettp,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->bp_ttpnett,0,',','.');?>
										</td>
										<td>
											<?php echo  "Rp" . number_format($product->bp_pajakttp,0,',','.');?>
										</td>
									
										<td>
											<?php echo  "Rp" . number_format($product->t_jumlahttp,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_zakatttp,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_koperasipraja,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_simpanankopraja,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_koperasipemda,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_bankttp,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_lainnya,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->bp_jumlahpotonganttp,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->t_tpp,0,',','.');?>
										</td>
											<td>
											<?php echo  "Rp" . number_format($product->jlh_kompen,0,',','.');?>
										</td>

									
									</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<?php $this->load->view("admin/_partials/footer.php") ?>

		</div>
		<!-- /.content-wrapper -->

	</div>
	<!-- /#wrapper -->


	<?php $this->load->view("admin/_partials/scrolltop.php") ?>
	<?php $this->load->view("admin/_partials/modal.php") ?>

	<?php $this->load->view("admin/_partials/js.php") ?>

	<script>
	function deleteConfirm(url){
		$('#btn-delete').attr('href', url);
		$('#deleteModal').modal();
	}
	function duplicatConfirm(url){
		$('#btn-copy').attr('href', url);
		$('#duplicatModal').modal();
	}
	</script>
</body>

</html>
