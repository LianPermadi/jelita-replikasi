<style>
	tbody{
		font-size:13px
	}
	
	.btn{
		font-size:10px!important;
		padding-bottom:10px;
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
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div><!--/.row-->
	
	<?php if($ada==1){ ?>
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
							<label class="col-md-3 text">Nomor Pengajuaan</label>
							<label class="col-md-9" class="text2">: <?php echo $permohonan->no_permohonan; ?></label>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 text">Perizinan yang Dipilih</label>
							<label class="col-md-9" class="text2">: <?php echo $nama; ?></label>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 text">Tanggal Pengajuan</label>
							<label class="col-md-9" class="text2">: <?php echo date("d m Y",strtotime($permohonan->tglmsk)) ?></label>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 text">Status</label>
							<label class="col-md-9" class="text2">: <?php echo $status; ?></label>
						</div>
					</form>
					
				</div>	
			</div>
		
			<?php if($track!=0){ ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Tracking Permohonan Anda</div>
						<div class="col-md-2">
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<table data-toggle="table"  data-search="true" data-pagination="true" data-sort-name="tanggal" data-sort-order="desc">
						<thead>
						<tr>
							<th data-field="name"  data-sortable="true" >Keterangan</th>
							<th data-field="tanggal"  data-sortable="true" >Tanggal</th>
							<th data-field="waktu"  data-sortable="true" >Waktu</th>
						</tr>
						</thead>
						<tbody>
						
							<?php foreach($track as $trac){ ?>
							
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
			<?php } ?>
		</div><!-- /.col-->
	</div><!-- /.row -->
	<?php } ?>
	
	<?php if($ada==0){ ?>
	
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