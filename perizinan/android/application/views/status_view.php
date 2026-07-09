<!DOCTYPE html>
<html>
<head>
  <title>DPMPTSP Kabupaten Tasikmalaya</title>
  <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url()?>assets/css/styles.css" rel="stylesheet">
  
  <link rel="icon" href="<?php echo base_url()?>assets/img/favicon.png">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/off-canvas-menu.js"></script>
  
  <script>
    "use strict";
    
    $(document).ready(function(){
    
        new OffCanvasMenuController({
            $menu: $('#right-menu'),
            $menuToggle: $('#right-menu-toggle'),
            menuExpandedClass: 'show-right-menu',
            position: 'right'
        });
		
    });
  </script>
</head>
<body>

	<div class="stripe"></div>
	
    <div id="outer-wrapper">
        <div id="inner-wrapper">

          <nav id="right-menu" class="off-canvas-menu">
			<div class="col-md-12 user">
				<span class="glyphicon glyphicon-user avatar" aria-hidden="true"></span>
				<h4><?php echo $username; ?></h4>
			</div>
            <div class="list-group">
			  <a href="status.html" class="list-group-item active">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 
				<span class="title">Status Proses</span>
			  </a>
			  <a href="mohon.html" class="list-group-item">
				<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 
				<span class="title">Permohonan</span>
			  </a>
			  <a href="izin.html" class="list-group-item">
				<span class="glyphicon glyphicon-check" aria-hidden="true"></span> 
				<span class="title">Perizinan</span>
			  </a>
			  <a href="data.html" class="list-group-item">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
				<span class="title">Data Pemohon</span>
			  </a>
			  <a href="dokumen.html" class="list-group-item">
				<span class="glyphicon glyphicon-file" aria-hidden="true"></span> 
				<span class="title">Dokumen Pemohon</span>
			  </a>
			  <a href="status/logout" class="list-group-item">
				<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
				<span class="title">Logout</span>
			  </a>
			</div>
          </nav>

			
		  
            <div class="navbar navbar-inverse navbar-fixed-top">
              <div class="navbar-inner">
				<div class="pull-left">
				  <img class="logo" src="<?php echo base_url()?>assets/img/bpmpt.png" alt="Logo"/>
				</div>
				<!-- <div class="container-fluid">
					<div class="navbar-header">
					  <a class="navbar-brand" href="#">
						<img class="logo" alt="Logo" src="<?php echo base_url()?>assets/img/bpmpt.png">
					  </a>
					</div>
				</div> -->
				<!-- <div class="pull-left">
                  <button type="button" id="right-menu-toggle" class="btn btn-default off-canvas-menu-toggle">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                  </button>
                </div> -->
                <div class="pull-right">
                  <button type="button" id="right-menu-toggle" class="btn btn-primary off-canvas-menu-toggle">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                  </button>
                </div>
              </div>
            </div>
			
			<ol class="breadcrumb">
			  <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span></li>
			  <li class="active">Status Proses</li>
			</ol>
			
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h5>Permohonan Terakhir Anda</h5>
								</div>
								<div class="panel-body">
									<table class="table borderless">
										<tbody>
											<tr>
												<td>Perizinan yang Dipilih</td>
												<td>:</td>
												<td>Izin Pengumpulan Uang atau Barang (Pengumpulan Sumbangan)</td>
											</tr>
											<tr>
												<td>Tanggal Perizinan</td>
												<td>:</td>
												<td>Rabu, 8 Juli 2015</td>
											</tr>
										</tbody>
									</table>
									<div class="col-sm-2 pull-right">
										<a href="#" class="btn btn-primary btn-block">Detail</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h5>Permohonan Terakhir Anda</h5>
								</div>
								<div class="panel-body">
									<table class="table borderless">
										<tbody>
											<tr>
												<td>No. Pendaftaran</td>
												<td>:</td>
												<td></td>
											</tr>
											<tr>
												<td>Perizinan yang Dipilih</td>
												<td>:</td>
												<td>Rekomendasi Undian Gratsi Berhadiah (UGB)</td>
											</tr>
											<tr>
												<td>Tanggal Perizinan</td>
												<td>:</td>
												<td>Jumat, 24 Juli 2015</td>
											</tr>
										</tbody>
									</table>
									<div class="col-sm-2 pull-right">
										<a href="#" class="btn btn-primary btn-block">Detail</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
        </div>
    </div>
	

</body>
</html>