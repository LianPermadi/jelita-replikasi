<?php 

	$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

?>
<style>
	tbody{
		font-size:13px
	}
	
	.btn{
		font-size:10px!important;
		padding-bottom:10px;
	}

	.text{
		*padding-top:7px!important;
		text-align:right;
	}
	
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Status Proses</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Status Proses</h1>
		</div>
	</div><!--/.row-->
	
	<?php 
	
		if($ada==1){ 
		foreach($permohonan_sementara as $permohonan){
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							
							<?php
								
								if($permohonan->editable=="1"){
									echo "Permohonan ini memiliki persyaratan yang harus diubah, klik tombok ubah !";
								}else{
									echo "Permohonan Terakhir Anda";
								}
								
							?>
							
						</div>
						<div class="col-md-2">
							
							
							<?php
								if($permohonan->editable=="1"){
									 echo anchor('main/permohonan/detail/'.$permohonan->uuid, "Ubah",array("style"=>"background:#1ebfae;color:white;font-size:16px!important","class"=>"btn btn-block"));
								}
								
							?>
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<form role="form">
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Nomor Pendaftaran</label>
								<label class="col-md-9" class="text2">: <?php echo $permohonan->no_permohonan; ?></label>
							</div>
						</div>
						
						<?php
							
							$nama = $otherdb->get_where("trperizinan",array("id"=>$permohonan->id_perizinan))->first_row();

						?>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Perizinan yang Dipilih</label>
								<label class="col-md-9" class="text2">: <?php echo $nama->n_perizinan; ?></label>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Tanggal Pengajuan</label>
								<label class="col-md-9" class="text2">: <?php echo date("d m Y",strtotime($permohonan->d_entry)) ?></label>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Status</label>
								<label class="col-md-9" class="text2">: Online</label>
							</div>
						</div>
					</form>
					
				</div>	
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	<?php }} ?>
	
	
	<?php 
		if($ada2==1){ 
		foreach($permohonan_track as $permohonan){
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Terakhir Anda</div>
						<div class="col-md-2">
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<form role="form">
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Nomor Pendaftaran</label>
								<label class="col-md-9" class="text2">: <?php echo $permohonan->no_permohonan; ?></label>
							</div>
						</div>
						
						<?php
							
							$nama = $otherdb->get_where("trperizinan",array("id"=>$permohonan->id_perizinan))->first_row();

						?>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Perizinan yang Dipilih</label>
								<label class="col-md-9" class="text2">: <?php echo $nama->n_perizinan; ?></label>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Tanggal Pengajuan</label>
								<label class="col-md-9" class="text2">: <?php echo date("d m Y",strtotime($permohonan->d_entry)) ?></label>
							</div>
						</div>
						
						<?php
							
							$key = array_search($permohonan->no_permohonan, $status);
							
						?>
						
						<div class="form-group">
							<div class="col-md-12">
								<label class="col-md-3 text">Status</label>
								<label class="col-md-9" class="text2">: <?php echo $status[$key+1]; ?></label>
							</div>
						</div>
					</form>
					
					
					<table data-toggle="table"  data-search="true" data-pagination="true" data-sort-name="tanggal" data-sort-order="desc">
						<thead>
						<tr>
							<th data-field="name"  data-sortable="true" >Keterangan</th>
							<th data-field="tanggal"  data-sortable="true" >Tanggal</th>
							<th data-field="waktu"  data-sortable="true" >Waktu</th>
						</tr>
						</thead>
						<tbody>
						
							<?php 
							
							$track	=	$otherdb->order_by("id","desc");
							$track	=	$otherdb->get_where("tmtrackingperizinan", array("pendaftaran_id"=>$permohonan->no_permohonan))->result();
							
							foreach($track as $trac){ 
							
							?>
							
								<tr>
									<td>
										<?php echo $trac->tr_activiti; ?>
									</td>
									<td>
										<?php echo date("d m Y",strtotime($trac->d_entry)); ?>
									</td>
									<td>
										<?php echo date("H:i:s",strtotime($trac->d_entry)); ?>
									</td>
								</tr>
							
							<?php } ?>
							
						</tbody>
					</table>
					
				</div>	
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	<?php }} ?>
	
	
	<?php if($ada==0 && $ada2==0){ ?>
	
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						
						<form role="form">
							<h2>
								<center>Tidak Ada Permohonan Untuk Ditracking,<?php echo anchor('main/permohonan/step1', '<h2>Ajukan Permohonan Sekarang !</h2>') ?></center>
							</h2>
						</form>
						
					</div>	
				</div>
			</div>
		</div>
	
	<?php } ?>
	
</div>