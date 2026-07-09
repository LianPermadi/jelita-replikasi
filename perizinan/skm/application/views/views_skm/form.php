<div class="col-lg-6 content-right" id="start">
	<div id="wizard_container">
		<form id="wrapped" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="resi" value="<?= $responden['resi'] ?>">
			<input type="hidden" name="sumber" value="<?= $sumber ?>">
			
			<div class="step">
				<h3 class="main_question"><strong>1/<?= count($pertanyaan) + 2 ?></strong>Data Masyarakat</h3>
				
				<input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $responden['nama_responden'] ?>">

				<input type="text" name="hp" class="form-control" placeholder="No HP" value="<?= $responden['mobile'] ?>">

				<!-- dst... Tambahkan sesuai struktur lama -->
			</div>

			<?php $i = 2; foreach ($pertanyaan as $p): ?>
				<div class="step">
					<h3 class="main_question"><strong><?= $i ?>/<?= count($pertanyaan) + 2 ?></strong><?= $p['judul'] ?></h3>
					<?php foreach ($p['opsi'] as $index => $opsi): ?>
						<div class="form-group">
							<label class="container_radio version_2">
								<?= chr(65 + $index) ?>. <?= $opsi['pertanyaan'] ?>
								<input type="radio" name="question_<?= $p['kode'] ?>" value="<?= $index + 1 ?>">
								<span class="checkmark"></span>
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			<?php $i++; endforeach; ?>

			<div class="submit step">
				<h3 class="main_question">Saran</h3>
				<textarea name="saran"></textarea>

				<h3 class="main_question">Komentar Positif</h3>
				<textarea name="komentar"></textarea>

				<h3 class="main_question">Kendala</h3>
				<textarea name="kendala"></textarea>

				<div class="g-recaptcha" data-sitekey="KUNCI-GOOGLE-CAPTCHA"></div>
			</div>

			<div id="bottom-wizard">
				<button type="button" class="backward">Prev</button>
				<button type="button" class="forward">Next</button>
				<button type="submit" class="submit">Submit</button>
			</div>
		</form>
	</div>
</div>
