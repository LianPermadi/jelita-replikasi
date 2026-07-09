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
	table{
		font-size: 10px;
	}
	.th-inner{
font-size: 10px;
font-weight: bold;

	}
</style>
<?php
$no_api = "";

							foreach ($data_noapi as $key => $value) {
								//echo $value->no_api;
								$no_api = $value->no_api;
							}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Laporan API</li>
			<li >Tambah Data</li>
			
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
				<!--<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Nomor API :<a class="buton"> <?php echo $no_api;?></a></div>
					</div>
				</div>-->
				<div class="panel-body">
					<div class="col-md-12">
						Perhatian : sebelum memulai upload data pastikan <a class="buton">Nomor API </a> yang ada input sudah benar.<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jika ada kesalahan saat mengisi no API segera hubungi call center di <a class="buton"> ##### </a>
					
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
			<!--	<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Data <?php echo ucfirst($data->jenis); ?></div>
						<div class="col-md-2">
							<?php //echo anchor('main/user/datapemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>-->
				<div class="panel-body">
					<div class="col-md-12">
						
						
						
						
						
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

<form action="<?php echo base_url();?>main/laporanapiuser/save_dataapi" method="post" enctype="multipart/form-data">

           					<div class="form-group">
								<label class="col-md-2 text">Nomor API </label>
								<div class="col-md-2">
								<input type="text" class="form-control" name="no_api" value="<?php echo $no_api;?>" readonly required>
								</div>
							</div>
 <div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>
							<div class="form-group">
								<label class="col-md-2 text">Nama Perusahaan </label>
								<div class="col-md-5">
								<input type="text" class="form-control" name="nama" value="<?php echo $data->namaPerusahaan;?>"  required>
								</div>
							</div>
							<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>
							<div class="form-group">
								<label class="col-md-2 text">Almt Perusahaan </label>
								<div class="col-md-9">
								<input type="text" class="form-control" name="alamat" value="<?php echo $data->almtPerusahaan;?>" readonly required>
								</div>
							</div>

<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-2 text">Jenis API </label>
								<div class="col-md-3">
									<select class="form-control" name="jenis_api" required>
										<option selected="true" value="API-P">PRODUSEN</option>
										<option  value="API-U">UMUM</option>
									</select>
								</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>
							<div class="form-group">
								<label class="col-md-2 text">Uraian Barang </label>
								<div class="col-md-8">
								<input type="text" class="form-control" name="uraian_barang" required>
								</div>
							</div>

<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Pos Tarif/HS10DIGIT </label>
								<div class="col-md-3">
								<input type="text" class="form-control" name="hs10digit" required>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-2 text">Volume </label>
								<div class="col-md-3">
								<input type="text" class="form-control" name="volume" placeholder="10000.5(pecahan gunakan titik)"min="0" required>
								</div>
							</div>

<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Satuan </label>
								<div class="col-md-3">
								<!--<input type="text" class="form-control" name="satuan" required>-->
								
								<select id="satuan" class="selectpicker form-control" data-live-search="true" style="background:white" name="satuan">
									background:white">
									  <option value="ACR">Acre (4840 yd2)</option>
									  <?php foreach($satuan as $row){ ?>
									  <option value="<?php echo $row->kode_satuan; ?>"><?php echo $row->kode_satuan . ' - ' .$row->uraian_satuan; ?></option>
									  <?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Harga Satuan</label>
								<div class="col-md-3">
								<input type="text" placeholder="10000.5(pecahan gunakan titik)" min="0" class="form-control" name="harga_satuan" required>
								</div>
							</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Nilai CIF </label>
								<div class="col-md-3">
								<input type="text" min="0" class="form-control" name="nilai_cif" placeholder="10000.5(pecahan gunakan titik)" required>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-2 text">Nilai CNF</label>
								<div class="col-md-3">
								<input type="text" min="0" class="form-control" name="nilai_cnf" placeholder="10000.5(pecahan gunakan titik)" required>
								</div>
							</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Nilai FOB </label>
								<div class="col-md-3">
								<input type="text" min="0" placeholder="10000.5(pecahan gunakan titik)" class="form-control" name="nilai_fob" required>
								</div>
							</div>


						<!--	<div class="form-group">
								<label class="col-md-2 text">Nilai Impor </label>
								<div class="col-md-3">
								<input type="number" class="form-control" name="nilai_impor" required>
								</div>
							</div>-->

<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Mata Uang </label>
								<div class="col-md-3">
									<select id="currency" class="selectpicker form-control" data-live-search="true" style="background:white" name="currency">
									background:white">
									  <option value="USD">USD - US Dollar</option>
									  <?php foreach($matauang as $row){ ?>
									  <option value="<?php echo $row->kode_currency; ?>"><?php echo $row->kode_currency . ' - ' .$row->uraian_currency; ?></option>
									  <?php } ?>
									</select>
									
								</div>
							</div>
								
							</div>


						<!--	<div class="form-group">
								<label class="col-md-2 text">Kurs </label>
								<div class="col-md-3">
								<input type="text" class="form-control" name="kurs" required>
								</div>
							</div>-->
							<div class="form-group">
								<label class="col-md-2 text">Pelabuhan Asal </label>
								<div class="col-md-3">
								<!--<input type="text" class="form-control" name="pelabuhan_asal" required>-->
								<select id="negara_asal" class="selectpicker form-control" data-live-search="true" style="background:white" name="pelabuhan_asal">
									  <option value="-"> - </option>
									  <?php foreach($pelabuhan_asal as $row){ ?>
									  <option value="<?php echo $row->kode_pelabuhan_asal; ?>"><?php echo $row->kode_pelabuhan_asal.' - '.$row->nama_pelabuhan_asal.' - '.$row->negara; ?></option>
									  <?php } ?>
									</select>
								</div>
							</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Negara Asal </label>
								<div class="col-md-3">
									<select id="negara_asal" class="selectpicker form-control" data-live-search="true" style="background:white" name="negara_asal">
									  <option value="US">US - Amerika Serikat</option>
									  <?php foreach($negara as $row){ ?>
									  <option value="<?php echo $row->kode_negara; ?>"><?php echo $row->kode_negara.' - '.$row->nama_negara; ?></option>
									  <?php } ?>
									</select>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-2 text">Pelabuhan Tujuan </label>
								<div class="col-md-3">
								<!--<input type="text" class="form-control" name="pelabuhan_tujuan" required>-->
								<select id="pelabuhan_tujuan" class="selectpicker form-control" data-live-search="true" style="background:white" name="pelabuhan_tujuan">
									  <option value="IDTPP">IDTPP - TANJUNG PRIOK</option>
									  <?php foreach($pelabuhan_tujuan as $row){ ?>
									  <option value="<?php echo $row->kode_pelabuhan_tujuan; ?>"><?php echo $row->kode_pelabuhan_tujuan.' - '.$row->nama_pelabuhan_tujuan; ?></option>
									  <?php } ?>
									</select>
								</div>
							</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Nomor Ls </label>
								<div class="col-md-3">
								<input type="text" class="form-control" name="nomor_ls" required>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-2 text">Tgl LS </label>
								<div class="col-md-3">
								<input type="text" class="form-control tanggal"   placeholder="" name="tgl_ls"  readonly="true" >
								</div>
							</div>
<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>

							<div class="form-group">
								<label class="col-md-2 text">Nomor PIB </label>
								<div class="col-md-3">
								<input type="text" class="form-control" name="nomor_pib" required>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-2 text">Tgl PIB </label>
								<div class="col-md-3">
								
								<input type="text" class="form-control tanggal"  value="<?php echo date("Y-m-d");?>" placeholder="" name="tgl_pib"  readonly="true">
								</div>
							</div>


						


						


</div>
							<div class="form-group">
							<label class="col-md-12 text"> </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
											Simpan Data
									</button>
									
								</div>
								<div class="col-md-3">
									<a href="<?php echo base_url();?>main/laporanapiuser/dataapi" class="btn btn-block btn-primary">Batal</a>
									
								</div>
							</div>
							
							</form>
							<?php
							}

							} ?>
<br>
							<!--<center><a class="buton"><?php echo $data->namaPerusahaan;?></a> 
<br>
<?php echo $data->almtPerusahaan .' Telepon : '. $data->telpPerusahaan;?>
</center>-->


							
								
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->

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