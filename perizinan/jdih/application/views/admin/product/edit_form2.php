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

				<?php $this->load->view("admin/_partials/breadcrumb.php") ?>

				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>

				<!-- Card  -->
				<div class="card mb-3">
					<div class="card-header">

						<a href="<?php echo site_url('admin/products/') ?>"><i class="fas fa-arrow-left"></i>
							Back</a>
					</div>
					<div class="card-body">

						<form action="<?php base_url(" admin/product/edit") ?>" method="post"
							enctype="multipart/form-data" >

							<input type="hidden" name="id" value="<?php echo $product->id?>" />

							<div class="form-group">
								<label for="price">NIP</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="id_pegawai" min="0" placeholder="Product price" value="<?php echo $product->id_pegawai ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							
							<div class="form-group">
								<label for="name">Bulan*</label>
								<input class="form-control <?php echo form_error('name') ? 'is-invalid':'' ?>"
								 type="text" name="bulan" placeholder="Bulan Tahun" value="<?php echo $product->bulan ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('name') ?>
								</div>
							</div>
						
							<div class="form-group">
								<label for="price">THP</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="thp" min="0" placeholder="Product price" value="<?php echo $product->thp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
						<div class="form-group">
								<label for="price">Gaji Pokok</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_gaji_pokok" min="0" placeholder="Product price" value="<?php echo $product->t_gaji_pokok ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>

						<div class="form-group">
								<label for="price">Tunjangan Pasangan (Suami/Istri)</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_pasangan" min="0" placeholder="Product price" value="<?php echo $product->t_pasangan ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
					
					<div class="form-group">
								<label for="price"> Tunjangan Anak</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_anak" min="0" placeholder="Product price" value="<?php echo $product->t_anak ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>

							<div class="form-group">
								<label for="price">Tunjangan Umum </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_umum" min="0" placeholder="Product price" value="<?php echo $product->t_umum ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
						
							<div class="form-group">
								<label for="price">Tunjangan Struktural </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_struktural" min="0" placeholder="Product price" value="<?php echo $product->t_struktural ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Tunjangan Beras </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_beras" min="0" placeholder="Product price" value="<?php echo $product->t_beras ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Tunjangan PPh 21</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_khususpph21" min="0" placeholder="Product price" value="<?php echo $product->t_khususpph21 ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Pembulatan</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_pembulatan" min="0" placeholder="Product price" value="<?php echo $product->t_pembulatan ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Gaji Bruto </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_jumlah" min="0" placeholder="Product price" value="<?php echo $product->t_jumlah ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Rapel Gaji</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="rapel_gaji" min="0" placeholder="Product price" value="<?php echo $product->rapel_gaji ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Keterangan Rapel </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="ket_rapel_gaji" min="0" placeholder="Product price" value="<?php echo $product->ket_rapel_gaji ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Potongan Beras</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_beras" min="0" placeholder="Product price" value="<?php echo $product->p_beras ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Potongan I.W.P 8% </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_iuranwajib" min="0" placeholder="Product price" value="<?php echo $product->p_iuranwajib ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Potongan ASKES 2% </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_askes" min="0" placeholder="Product price" value="<?php echo $product->p_askes ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Potongan PPh </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_pph" min="0" placeholder="Product price" value="<?php echo $product->p_pph ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> S. Rumah</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="a_p_srumah" min="0" placeholder="Product price" value="<?php echo $product->a_p_srumah ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Hutang </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="a_p_hutang" min="0" placeholder="Product price" value="<?php echo $product->a_p_hutang ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">T.Rumah </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_cicilanrumah" min="0" placeholder="Product price" value="<?php echo $product->p_cicilanrumah ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Lain-lain</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="a_2_lainnya" min="0" placeholder="Product price" value="<?php echo $product->a_2_lainnya ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Potongan Bank (Gaji)</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_cicilanbank" min="0" placeholder="Product price" value="<?php echo $product->p_cicilanbank ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Iuran Koperasi PEMDA</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_iurankoperasipemda" min="0" placeholder="Product price" value="<?php echo $product->p_iurankoperasipemda ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Cicilan Koperasi PEMDA (Gaji) </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="p_cicilankoperasipemda" min="0" placeholder="Product price" value="<?php echo $product->p_cicilankoperasipemda ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Jumlah Potongan Bank & Koperasi </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="jumlahpotongan" min="0" placeholder="Product price" value="<?php echo $product->jumlahpotongan ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Gaji Yang diterima </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="gajiterima" min="0" placeholder="Product price" value="<?php echo $product->gajiterima ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">TTP Maksimal </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_ttpbruto" min="0" placeholder="Product price" value="<?php echo $product->bp_ttpbruto ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Rapel TOL</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="rapel_tol" min="0" placeholder="Product price" value="<?php echo $product->rapel_tol ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Prosentase TTP </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_prosentasettp" min="0" placeholder="Product price" value="<?php echo $product->bp_prosentasettp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> TTP Bruto</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_ttpnett" min="0" placeholder="Product price" value="<?php echo $product->bp_ttpnett ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Pajak TPP (progresif) </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_pajakttp" min="0" placeholder="Product price" value="<?php echo $product->bp_pajakttp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">TPP Netto </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_jumlahttp" min="0" placeholder="Product price" value="<?php echo $product->t_jumlahttp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Zakat TTP (2,5 %)</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_zakatttp" min="0" placeholder="Product price" value="<?php echo $product->bp_zakatttp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>

<div class="form-group">
								<label for="price">Cicilan Koperasi Praja  </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_koperasipraja" min="0" placeholder="Product price" value="<?php echo $product->bp_koperasipraja ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Simpanan Koperasi Praja</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_simpanankopraja" min="0" placeholder="Product price" value="<?php echo $product->bp_simpanankopraja ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Cicilan Koperasi PEMDA (TTP) </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_koperasipemda" min="0" placeholder="Product price" value="<?php echo $product->bp_koperasipemda ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Potongan Bank  (TTP)</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_bankttp" min="0" placeholder="Product price" value="<?php echo $product->bp_bankttp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Potongan Lain-Lain</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_lainnya" min="0" placeholder="Product price" value="<?php echo $product->bp_lainnya ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price">Jumlah Potongan TTP </label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="bp_jumlahpotonganttp" min="0" placeholder="Product price" value="<?php echo $product->bp_jumlahpotonganttp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> TPP yang Diterima</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="t_tpp" min="0" placeholder="Product price" value="<?php echo $product->t_tpp ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="price"> Jumlah Konpen</label>
								<input class="form-control <?php echo form_error('price') ? 'is-invalid':'' ?>"
								 type="number" name="jlh_kompen" min="0" placeholder="Product price" value="<?php echo $product->jlh_kompen ?>" />
								<div class="invalid-feedback">
									<?php echo form_error('price') ?>
								</div>
							</div>
						

							<input class="btn btn-success" type="submit" name="btn" value="Save" />
						</form>

					</div>

					<div class="card-footer small text-muted">
						* required fields
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

		<?php $this->load->view("admin/_partials/js.php") ?>

</body>

</html>
