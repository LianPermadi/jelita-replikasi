<?php	$base_url=base_url().'assets/userassets/'; ?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Permohonan</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
					<!--h1 class="page-header"></h1-->
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Petunjuk Penggunaan</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						Jika sudah melengkapi dokumen legalitas, silakan mulai mengajukan permohonan perizinan.<br>
					<ol type='1'>
					<li>Klik tombol <button class="btn btn-primary">Permohonan Baru</button> kemudian pilih perizinan yang akan anda ajukan, klik <button class="btn btn-primary">Lanjutkan</button></li>
					<li>Isi data teknis permohonan, klik <button class="btn btn-primary">Lanjutkan</button></li>
					<li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file .pdf</li>
					<li>Mohon periksa kembali kelengkapan yang telah anda isikan (Dibuat Bold/Underline).</li>
					<li>klik <button class="btn btn-primary">Lanjutkan</button> apabila sudah yakin silahkan pilih <button class="btn btn-primary">YA</button>.</li>
					<li>Permohonan sudah diterima oleh BPMPT apabila nomor pendaftaran sudah diberikan oleh BPMPT yang dapat dilihat di status proses</li> 
					<li>Jika Nomor Pendaftaran belum diberikan, maka akan ada perbaikan proses permohonan yang dikonfirmasi melalui sms dan fitur messenger pada aplikasi</li> 
					<li>Selamat, permohonan anda sudah berhasil diajukan.</li> 
					</ol>
						<br>
						<p align="center">Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih ya apabila ingin mengajukan permohonan lain, pilih tidak jika anda ingin menyelesaikan proses permohonan izin baru.</p>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">
							Data Permohonan Izin
						</div>
						<div class="col-md-3">
							<?php echo anchor('main/permohonan/step1', 'Permohonan Baru',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<?php 
						$success 	= $this->session->flashdata("success");
						if(!empty($success)){
					?>
					<div class="alert bg-success" role="alert" style="background:#7EB332;">
						<span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
					</div>
					<?php } ?>
					<?php 
						$error 	= $this->session->flashdata("error");
						if(!empty($error)){
					?>
					<div class="alert bg-danger" role="alert" style="">
						<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
					</div>
					<?php } ?>
					<table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						<thead>
						<tr>
							<th data-field="nomor"  data-sortable="true" >Nomor Pendaftaran</th>
							<th data-field="state"  data-sortable="true" >Jenis Perizinan</th>
							<th data-field="name" data-sortable="true">Tanggal Pengajuan</th>
							<th data-field="id"  data-sortable="true">Status</th>
							<th data-field="price" data-sortable="false"></th>
						</tr>
						</thead>
						<tbody>
							<?php foreach($permohonan as $data){ ?>
							<?php
								
								$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
								
								$sql 	= "select * from trperizinan where id='".$data->id_perizinan."'";
								$nama	= $otherdb->query($sql)->first_row();
								
							?>
							<tr>
								<td><?php echo $data->no_permohonan; ?></td>
								<td><?php echo $nama->n_perizinan; ?></td>
								<td><?php echo date("d m Y",strtotime($data->d_entry)); ?></td>
								<td><?php echo $data->status; ?></td>
								<td>
									<?php
										
										$text = "Detail";
										
										if($data->editable=="1" && $data->status!="Ditolak"){
											$text = "Ubah";
										}
										
									?>
									<?php echo anchor('main/permohonan/detail/'.$data->uuid, $text,array("style"=>"background:#1ebfae;color:white","class"=>"btn")) ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!--/.row-->	
	
	
</div><!--/.main-->