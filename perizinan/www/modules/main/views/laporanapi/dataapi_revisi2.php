<style type="text/css">
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
	table{
		font-size: 11px;
	}
	.th-inner{
font-size: 11px;
font-weight: bold;

	}



 
.strip1 {
    background:green;

}
 
.strip2 {
    background: red;
    
}


.dropdown {
    position: relative;
    display: inline-block;
    margin-left: 30px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
    text-indent: 10px;

}

.dropdown:hover .dropdown-content {
    display: block;
    width: 230px;

}
.strip2:hover {
    background-color: gray;
    width: 200px;
}
.strip1:hover {
    background-color: gray;
    width: 200px;
}
</style>
<?php
$no_api = "";

							foreach ($data_noapi as $key => $value) {
								//echo $value->no_api;
								$no_api = $value->no_api;
								$id_tmpemohon = $value->id_tmpemohon;
							}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<!--<ol class="breadcrumb">
			<!--<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<!--<li >Laporan API</li>
			<li >Data   </li>-->

		
		
  <!--</ol>-->
  <br>
  <div class="dropdown"><a href="<?php echo base_url() . 'main/laporanapiuser/pesan'; ?>"><span class="glyphicon glyphicon-home"></span></a>
  <a href="<?php echo base_url() . 'main/laporanapiuser/pesan'; ?>">Notifikasi Pesan</a><span class="badge badge-danger" id="load_row"><?php echo $jlhnotif;?></span>
  <div class="dropdown-content" role="menu" id="load_data">
  
                <?php 
                $no=0;
                if ($notifikasi != null) {
                foreach($notifikasi as $rnotif){ 
                	$no++;
                    if($no % 2==0){$cl='strip1';}else{$cl='strip2';}
                ?>
                <a href="pesan" style="text-decoration: none;">
                <div  class="<?php echo $cl;?>">
                <div  style="text-indent: 10px;color: red;"><?php echo $rnotif->oleh. ' : '.substr($rnotif->pesan,0,12).' ...';?></div>
                 <div style="text-indent: 10px; "><small><?php echo timeAgo($rnotif->tanggal);?></small></div>
                </div>
                </a>

              
                <?php }
                }?>
              
                
  </div>
</div>

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
						<div class="col-md-11"><a class="buton"><?php echo $data->namaPerusahaan;?><a class="buton"> <?php echo ' ( '.$no_api.' )';?></a>  </a></div>
		
					</div>

				</div>
				
			</div>
			
			<div class="panel panel-default">
			<!--	<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Data <?php echo ucfirst($data->jenis); ?></div>
						<div class="col-md-2">
							<?php echo anchor('main/user/datapemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>-->	
							<?php 
$jenis = $data->jenis;
//echo $jenis;
							if($jenis=="Pemohon"){ ?>
							<?php } ?>
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
							<?php if($jenis=="perusahaan" || $jenis=="Perusahaan"){ ?>
							<?php
							
							if($no_api == ""){
								
							redirect('main/laporanapiuser/inputnoapi', 'refresh');
							}else{
?>
<?php
							}

							} ?>
							
<div class="panel-body">

							<!--<form role="form" method="post" action="<?php 
							
echo base_url() . 'main/laporanapiuser/download_dataapirevisi'; 
							
							?>" target="_blank">
<div class="form-group">
<input type="hidden" class="tanggal"  placeholder="" name="tgl11" value="<?php echo $tgl1;?>" readonly="true" required>
								<input type="hidden" readonly name="tgl22" value="<?php echo $tgl2;?>" class="tanggal" />
						
								
									<input type="hidden" class="form-control" value="<?php echo $no_api;?>" name="no_api2" required>
<div class="col-md-10"></div>
								<div class="col-md-2">
								<button type="submit" class="btn btn-block btn-primary" >
										Download API
									</button>
									
								</div>
</div>
</form>-->
					<div class="col-md-12">
					
							
<!--	<div class="form-group">
<div class="col-md-3">
								<a href="<?php echo base_url() . 'main/laporanapiuser/tambah_api'; ?>"><button type="submit" class="btn btn-block btn-primary">
										Tambah Data Baru
									</button></a>
									</div>
									</div>-->

									<form role="form" method="post" action="<?php echo base_url() . 'main/laporanapiuser/update_multiple'; ?>">
								<div class="form-group">
								<center>Data Laporan API Yang Harus Direvisi</center>
								<div class="col-md-2">
								<button type="submit" class="btn btn-block btn-primary" >
										UPDATE
									</button>
									<br>
								</div>
								</div>
							<div class="col-md-12">	
						<table id="myTable" border="1">
						<thead>
						<tr >
						
							<th data-field="No"  data-sortable="true"  style="text-align: center;display: none;">
						<label style="font-size: 11px;" for="checkAll" ></label><input type="checkbox" id="checkAll" name="checkAll" checked="true"></th>
						<th>No</th>
							<!--<th>No Api</th>-->
							<th style="text-align: center;">Status</th>
							<th style="text-align: center;">Jenis Api</th>
							<th style="text-align: center;">Uraian Barang</th>
							<th style="text-align: center;">hs10digit</th>
							<th style="text-align: center;">Volume</th>
							<th style="text-align: center;">Satuan</th>
							<th style="text-align: center;">Harga Satuan</th>
							<th style="text-align: center;">Nilai CIF</th>
							<th style="text-align: center;">Nilai CNF</th>
							<th style="text-align: center;">Nilai FOB</th>
							<!--<th data-field="nilai_impor"  data-sortable="true" >Nilai Impor</th>-->
							<th style="text-align: center;">Mata Uang</th>
							<!--<th data-field="kurs"  data-sortable="true" >Kurs</th>-->
							<th style="text-align: center;">Negara Asal</th>
							<th style="text-align: center;">Pelabuhan Asal</th>
							<th style="text-align: center;">Pelabuhan Tujuan</th>
							<th style="text-align: center;">No LS</th>
							<th style="text-align: center;">Tgl LS</th>
							<th style="text-align: center;">No PIB</th>
							<th style="text-align: center;">Tgl PIB</th>
							
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						$x=0;
						foreach ($data_api as $key => $value) {
							echo '<tr>';
							
							?>
							<td style="display:none;">
							<input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $value->id; ?>" checked>
							</td>
							<?php
							echo '<td  style="text-align: center;">'. $i++ .'</td>';
							//echo '<td>'. $value->no_api .'</td>';
							?>
							<td> 
<select name="status[]">
					<option selected value="<?php echo $value->flag;?>"><?php echo $value->flag;?></option>
					<option value="not">Update</option>
					<option value="revisi">revisi</option>
					
					 
				</select>
							</td>
				<td> <select name="jenis_api[]">
					<option selected value="<?php echo $value->jenis_api;?>"><?php if ($value->jenis_api == 'API-P'){ echo 'PRODUSEN';}else if($value->jenis_api == 'API-U'){ echo 'UMUM';}?></option>
					<option value="API-P">PRODUSEN</option>
					<option value="API-U">UMUM</option>
				</select></td>
				<td>

				<input type="text" name="uraian_barang[]" value="<?php echo $value->uraian_barang; ?>" required>
				</td>
				<td><input type="text" style="width: 80px; text-align: center;"  name="hs10digit[]" value="<?php echo $value->hs10digit; ?>" required></td>
				<td><input type="number" style="width: 60px; text-align: center;" name="volume[]" value="<?php echo $value->volume; ?>" required></td>
				<td><select name="satuan[]" >
					<option selected value="<?php echo $value->satuan;?>"><?php echo$value->satuan;?></option>
					 <?php foreach($data_satuan as $row){ ?>
									  <option value="<?php echo $row->kode_satuan; ?>"><?php echo $row->kode_satuan . ' - ' .$row->uraian_satuan; ?>
									  </option>
									  <?php } ?>
				</select></td>
				<td><input type="number" style="width: 80px; text-align: center;" name="harga_satuan[]" value="<?php echo $value->harga_satuan; ?>" required></td>
				<td><input type="number" style="width: 60px; text-align: center;" name="nilai_cif[]" value="<?php echo $value->nilai_cif; ?>"></td>
				<td><input type="number" style="width: 60px; text-align: center;" name="nilai_cnf[]" value="<?php echo $value->nilai_cnf; ?>"></td>
				<td><input type="number" style="width: 60px; text-align: center;" name="nilai_fob[]" value="<?php echo $value->nilai_fob; ?>"></td>
				<td> <select name="currency[]">
					<option selected value="<?php echo $value->currency;?>"><?php echo $value->currency;?></option>
					<?php foreach($matauang as $row){ ?>
									  <option value="<?php echo $row->kode_currency; ?>"><?php echo $row->kode_currency . ' - ' .$row->uraian_currency; ?></option>
									  <?php } ?>
				</select></td>
				<td> <select name="negara_asal[]">
					<option selected value="<?php echo $value->negara_asal;?>"><?php echo $value->negara_asal;?></option>
					<?php foreach($data_negara as $row){ ?>
									  <option value="<?php echo $row->kode_negara; ?>"><?php echo $row->kode_negara.' - '.$row->nama_negara; ?></option>
									  <?php } ?>
				</select></td>
				<td> <select name="pelabuhan_asal[]">
					<option selected value="<?php echo $value->pelabuhan_asal;?>"><?php echo $value->pelabuhan_asal;?></option>
					<option value="-">-</option>
					 <?php foreach($data_pelabuhan_asal as $row){ ?>
									  <option value="<?php echo $row->kode_pelabuhan_asal; ?>"><?php echo $row->kode_pelabuhan_asal.' - '.$row->nama_pelabuhan_asal.' - '.$row->negara; ?></option>
									  <?php } ?>
				</select></td>
				<td> <select name="pelabuhan_tujuan[]">
					<option selected value="<?php echo $value->pelabuhan_tujuan;?>"><?php echo $value->pelabuhan_tujuan;?></option>
					<option value="-">-</option>
					 <?php foreach($data_pelabuhan_tujuan as $row){ ?>
									  <option value="<?php echo $row->kode_pelabuhan_tujuan; ?>"><?php echo $row->kode_pelabuhan_tujuan.' - '.$row->nama_pelabuhan_tujuan; ?></option>
									  <?php } ?>
				</select></td>
				<td><input type="number" style="width: 80px; text-align: center;" name="nomor_ls[]" value="<?php echo $value->nomor_ls; ?>"></td>

							<?php
							if($value->tgl_ls != '0000-00-00'){
?>
<td><input style="width: 60px; text-align: center;" type="text" name="tgl_ls[]" value="<?php echo $value->tgl_ls; ?>"></td>
<?php
							}else{
?>
<td><input style="width: 60px; text-align: center;" type="text" name="tgl_ls[]" ></td>
<?php
							}
							
							?>
<td><input type="number" style="width: 80px; text-align: center;" name="nomor_pib[]" value="<?php echo $value->nomor_pib; ?>"></td>
							<?php
							if($value->tgl_pib != '0000-00-00'){
?>
<td>
<input type="text" style="width: 60px; text-align: center;" name="tgl_pib[]" value="<?php echo $value->tgl_pib; ?>" >

</td>
<?php
							}else{
							?>
							<input type="text" style="width: 60px; text-align: center;" name="tgl_pib[]" >
							<?php
							}
							?>
							
							<?php
							echo '</tr>';
						}
						?>
						

						</tbody>
						</table>

						</div>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->

        
<!--<link href="<?php echo base_url()?>assets/roynotif/css/bootstrap.min.css" rel="stylesheet">-->
<link href="<?php echo base_url()?>assets/roynotif/css/style.css" rel="stylesheet">
<!-- jquery core -->
<script src="<?php echo base_url()?>assets/roynotif/js/jquery.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url()?>assets/roynotif/js/bootstrap.min.js"></script>
              <script>
             var jq = $.noConflict();
setInterval(function(){
jq("#load_row").load('<?php base_url()?>main/laporanapiuser/load_row/<?php echo $id_tmpemohon;?>')
}, 1000);
setInterval(function(){
jq("#load_data").load('<?php base_url()?>main/laporanapiuser/load_data/<?php echo $id_tmpemohon;?>')
}, 1000);
</script>

<script type="text/javascript" src="<?php echo base_url(''); ?>assets/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript">
	 var u = jQuery.noConflict();
		u(document).ready(function() {
			u("input[name='checkAll']").click(function() {
				var checked = u(this).attr("checked");
				u("#myTable tr td input:checkbox").attr("checked", checked);
			});
		});
	</script>
	<script src="js/jquery.min.2.0.2.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="datepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.tanggal').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose:true
                });
                
            });
        </script>