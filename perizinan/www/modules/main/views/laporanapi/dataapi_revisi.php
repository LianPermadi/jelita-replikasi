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
		font-size: 10px;
	}
	.th-inner{
font-size: 10px;
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

							<form role="form" method="post" action="<?php 
							
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
</form>
					<div class="col-md-12">
					
							
<!--	<div class="form-group">
<div class="col-md-3">
								<a href="<?php echo base_url() . 'main/laporanapiuser/tambah_api'; ?>"><button type="submit" class="btn btn-block btn-primary">
										Tambah Data Baru
									</button></a>
									</div>
									</div>-->
								<div class="form-group">
								Data Laporan API yang harus dikirim ulang (Revisi) </center>
						<table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						<thead>
						<tr>
							<th data-field="No"  data-sortable="true" >No</th>
							<th data-field="no_api"  data-sortable="true" >No Api</th>
							<th data-field="jenis_api"  data-sortable="true" >Jenis Api</th>
							<th data-field="uraian_barang"  data-sortable="true" >Uraian Barang</th>
							<th data-field="hs10digit"  data-sortable="true" >hs10digit</th>
							<th data-field="volume"  data-sortable="true" >Volume</th>
							<th data-field="satuan"  data-sortable="true" >Satuan</th>
							<th data-field="harga_satuan"  data-sortable="true" >Harga Satuan</th>
							<th data-field="nilai_cif"  data-sortable="true" >Nilai CIF</th>
							<th data-field="nilai_cnf"  data-sortable="true" >Nilai CNF</th>
							<th data-field="nilai_fob"  data-sortable="true" >Nilai FOB</th>
							<!--<th data-field="nilai_impor"  data-sortable="true" >Nilai Impor</th>-->
							<th data-field="currency"  data-sortable="true" >Mata Uang</th>
							<!--<th data-field="kurs"  data-sortable="true" >Kurs</th>-->
							<th data-field="negara_asal"  data-sortable="true" >Negara Asal</th>
							<th data-field="pelabuhan_asal"  data-sortable="true" >Pelabuhan Asal</th>
							<th data-field="pelabuhan_tujuan"  data-sortable="true" >Pelabuhan Tujuan</th>
							<th data-field="nomor_ls"  data-sortable="true" >No LS</th>
							<th data-field="tgl_ls"  data-sortable="true" >Tgl LS</th>
							<th data-field="nomor_pib"  data-sortable="true" >No PIB</th>
							<th data-field="tgl_pib"  data-sortable="true" >Tgl PIB</th>
							<th data-field="flag"  data-sortable="true" >Status</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach ($data_api as $key => $value) {
							echo '<tr>';
							echo '<td>'. $i++ .'</td>';
							echo '<td>'. $value->no_api .'</td>';
							echo '<td>'. $value->jenis_api .'</td>';
							echo '<td>'. $value->uraian_barang .'</td>';
							echo '<td>'. $value->hs10digit .'</td>';
							echo '<td>'. $value->volume .'</td>';
							echo '<td>'. $value->satuan .'</td>';
							echo '<td>'. $value->harga_satuan .'</td>';
							echo '<td>'. $value->nilai_cif .'</td>';
							echo '<td>'. $value->nilai_cnf .'</td>';
							echo '<td>'. $value->nilai_fob .'</td>';
							//echo '<td>'. $value->nilai_impor .'</td>';
							echo '<td>'. $value->currency .'</td>';
							//echo '<td>'. $value->kurs .'</td>';
							echo '<td>'. $value->negara_asal .'</td>';
							echo '<td>'. $value->pelabuhan_asal .'</td>';
							echo '<td>'. $value->pelabuhan_tujuan .'</td>';
							echo '<td>'. $value->nomor_ls .'</td>';
							if($value->tgl_ls != '0000-00-00'){
echo '<td>'. $value->tgl_ls .'</td>';
							}else{
								echo '<td> </td>';
							}
							
							echo '<td>'. $value->nomor_pib .'</td>';
							if($value->tgl_pib != '0000-00-00'){
echo '<td>'. $value->tgl_pib .'</td>';
							}else{
								echo '<td> </td>';
							}
							echo '<td>'. $value->flag .'</td>';
							echo '</tr>';
						}
						?>
						

						</tbody>
						</table>
						</div>


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


  
  



