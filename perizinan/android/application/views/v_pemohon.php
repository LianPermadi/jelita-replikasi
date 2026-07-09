<!--<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="<?php echo base_url(''); ?>assets/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("input[name='checkAll']").click(function() {
				var checked = $(this).attr("checked");
				$("#myTable tr td input:checkbox").attr("checked", checked);
			});
		});
	</script>-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <title>DPMPTSP Kabupaten Tasikmalaya</title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

        <!-- CSS  -->
        <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <style type="text/css">
        	table{
        		border: 1px solid red; 
        	}

        </style>
    </head>
<nav class="white" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo">
                    <img src="<?php echo base_url(); ?>assets/img/bpmpt.png" class="logo"/>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
                    <li><a href="<?php echo base_url(); ?>ceksyarat">Cek Persyaratan</a></li>
                    <li><a href="<?php echo base_url(); ?>cekmohon">Cek Permohonan</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>gerai">Gerai Layanan</a></li>
                    
<?php if($this->session->userdata("nama") == null){
    ?>
    <li ><a href="<?php echo base_url('login/login_form'); ?>">Login</a></li>\
    <?php
}else {

    ?>
                    <li ><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
                    <li ><a href="#"><?php echo $this->session->userdata("nama"); ?></a></li>
<?php 
}
?>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-image">
                                    <img src="<?php echo base_url(); ?>assets/img/preview.jpg">
                                    <!-- <img class="card-title-image logo-side-nav" src="<?php // echo base_url(); ?>assets/img/jabar.png"/> -->
                                    <!-- <span class="card-title">
                                         BPMPT
                                         </span> -->
                                    <span class="card-title-description">DPMPTSP Kabupaten Tasikmalaya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <li><a href="<?php echo base_url(); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/home.png"/> Beranda</a></li>
                    <li><a href="<?php echo base_url(); ?>ceksyarat"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/checklist.png"/> Cek Persyaratan</a></li>
                    <li><a href="<?php echo base_url(); ?>cekmohon"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/process.png"/> Cek Permohonan</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>gerai"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/location.png"/> Gerai Layanan</a></li>
                    <?php if($this->session->userdata("nama") == null){
                        ?>
                         <li><a href="<?php echo base_url('login/login_form');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Login</a></li>
                        <?php }else{
                            ?>
                    <li><a href="<?php echo base_url('login/logout');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Logout</a></li>
                    <?php
                }
                ?>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><img class="icon-menu" src="<?php echo base_url(); ?>assets/img/menu.png"/></a>
            </div>
        </nav>
<body>
<?php // include 'v_header.php';?>

<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <h4 class="header center">Cek <br /> Permohonan</h4>
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>

<div class="container" style="margin-top: 30px;">
    <div class="section">

	<form action="<?php echo site_url('pemohon/update_multiple'); ?>" method="post">
	<!--	<select name="action">
			<option value="null">Bulk Action</option>
			<option value="delete">Delete</option>
			<option value="update">Update</option>
		</select>-->
		<br>
		<input type="submit" name="submit" value="Approve">
		<p></p>
		<table border="1" id="myTable" >
			<thead>
				<tr>
					<th><!--<input type="checkbox" id="checkAll" name="checkAll">-->
						<input type="checkbox" id="checkAll" name="checkAll">
						<label for="checkAll">Yellow</label>
					</th>
					<th>No.Ref</th>
					<th>Pemohon</th>
					<th>Telepon</th>
					<th>I_USER</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				if (count($hasilpemohon)>0) {
					
					foreach ($hasilpemohon as $data):
						?>
						<tr>
							<td><!--<input type="checkbox" name="msg[]" value="<?php echo $data->id; ?>">-->
								<input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
						<label for="<?php echo $i;?>"><?php echo $i++;?></label>
							</td>
							<td><?php echo $data->no_referensi; ?></td>
							<td><?php echo $data->n_pemohon; ?></td>
							<td><?php echo $data->telp_pemohon; ?></td>
							<td><?php echo $data->i_user; ?></td>
						</tr>
						<?php
					endforeach;
					$i++;
				}

				else {
					echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
				}
				?>
			</tbody>
		</table>
	</form>

</div>
</div>

<footer class="page-footer teal" style="visibility: hidden;">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">Tentang BPMPT</h5>
          <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Kabupaten Tasikmalaya berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div>
  </footer>

  <footer class="page-footer teal">
    <div class="footer-copyright">
      <div class="container">
        <center>2018 © DPMPTSP Kabupaten Tasikmalaya v.1</center>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>



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
  </body>
</html>
