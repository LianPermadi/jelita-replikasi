<style>
	.text{
		padding-top:7px!important;
		text-align:right;
	}
	
	.buton{
		font-weight:bold;
	}
	.buton:hover{
		text-decoration:none
	}
	tr.usr{
		color: rgba(254,174,45,1);
	}
	tr.adm{
		color : rgba(18,189,185,1)
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li ><?php echo $title;?></li>
			
		</ol>
	</div><!--/.row-->
	

	<div class="row">
		<div class="col-lg-12">
			<!--h1 class="page-header"></h1-->
		</div>
	</div>
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Pesan Komunikasi Pelaporan API</div>
					</div>
				</div>
			
			</div>
			
			<div class="panel panel-default">
			
				<div class="panel-body">
					<div class="col-md-12">
						<?php
						foreach ($data_noapi as $key => $value) {
						 	$id_tmpemohon = $value->id_tmpemohon;
						 } 

						?>
						<form  action="<?php echo base_url();?>main/laporanapiuser/save_pesan" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id_tmpemohon" value="<?php echo $id_tmpemohon;?>">
							<input type="hidden" name="username" value="<?php echo $username;?>">
							Pesan : <br>
							<textarea name="pesan" autofocus cols="80" rows="3"></textarea>
							<br>
							<input type="submit" name="" value="KIRIM" class="btn btn-primary">
						</form>

<table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
<thead>
						<tr>
						<th data-field="Waktu"  data-sortable="false">Waktu</th>
						<th data-field="Pengirim"  data-sortable="false">Pengirim</th>
						<th data-field="Isi Pesan"  data-sortable="false">Isi Pesan</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($data_pesan as $key => $value) {
							
							
							if($value->oleh == $username){$cls='user';}else{$cls='adm';}
							?>
									<tr class="<?php echo $cls;?>">
									<td ><?php echo $value->tgl_pesan;?></td>
									<td><?php echo $value->oleh;?></td>
									<td><?php echo $value->pesan;?></td>
									</tr>
								
								
							
							<?php
						}

						?>
						</tbody>
</table>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
