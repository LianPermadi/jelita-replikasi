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
						<div class="col-md-7">Nomor API :<a class="buton"> <?php echo $no_api;?></a></div>
					

					</div>

				</div>
				<div class="panel-body">
					<div class="col-md-12">
						Perhatian : sebelum memulai upload data pastikan <a class="buton">Nomor API </a> yang ada input sudah benar.<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jika ada kesalahan saat mengisi no API segera hubungi call center di <a class="buton"> ##### </a><br><br>
					
					</div>
					<div class="form-group">
								<div class="col-md-2">
									<a href="<?php echo base_url() . 'main/laporanapiuser/tambah_api_form';?>"><button type="submit" class="btn btn-block btn-primary" >
										Add API
									</button></a>
									
								</div>
					
								<div class="col-md-2">
								<a href="<?php echo base_url() . 'main/laporanapiuser/tambah_api'; ?>"><button type="submit" class="btn btn-block btn-primary" >
										Add API (Excel)
									</button></a>
									
								</div>
						
							<div class="col-md-2">
								<a href="<?php echo base_url() . 'main/laporanapiuser/dataapi_ok'; ?>"><button type="submit" class="btn btn-block btn-primary" >
										Data API 
									</button></a>
									
								</div>
							
							<div class="col-md-3">
								<a href="<?php echo base_url() . 'main/laporanapiuser/dataapi_not'; ?>"><button type="submit" class="btn btn-block btn-primary" >
										Data API Belum Validasi
									</button></a>
									
								</div>
							</div>
							<div class="col-md-3">
								<a href="<?php echo base_url() . 'main/laporanapiuser/dataapi_revisi2'; ?>"><button type="submit" class="btn btn-block btn-primary" >
										Permintaan Revisi
									</button></a>
									
								</div>
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