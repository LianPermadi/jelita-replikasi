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
	<style type="text/css">
		td,th{
			font-size: 11px;
		}
	</style>
  <?php if($this->session->userdata("nama") == null){
  	redirect('login');
  }else{
                        ?>
<body>
<?php  include 'v_header.php';

?>

<!--<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <h4 class="header center">Approve <br />AKDP</h4>
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>-->

<div class="container" style="margin-top: 30px;">
 <!-- Modal Trigger -->
  
  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      A bunch of text
    </div>
    <div class="modal-footer"> 
      <a href="#" class="modal-action modal-close waves-effect waves-green btn ">BATAL</a>
      <a href="#" class="modal-action modal-close waves-effect waves-green btn ">APPROVE</a>
     
    </div>
  </div>
    <div class="section">
    <div class="row">
<!--<form class="col s12">--><!--<form action="<?php //echo site_url('akdp_cetak/cari_data'); ?>" method="post">
      <!--<div class="row">
        <div class="input-field col s12">
          
          <input type="date" class="datepicker" placeholder="Range 1" style="text-align: center" name="tgl1" value="<?php echo $tgl1;?>">
          <label for="datepicker">Tanggal KP</label>
           <br>
           <input type="date" class="datepicker" placeholder="Range 2" style="text-align: center" name="tgl2" value="<?php echo $tgl2;?>">
           <br>
           <!--<a href="<?php echo site_url('akdp_cetak/cari_data');?>" class="waves-effect waves-light btn">Cari</a>-->
         <!-- <center> <input type="submit" name="submit"  value="Cari" class="btn"></center>
        </div>

       
 
</div>-->

<!----- cari no mobil---------->
<!--<form class="col s12">-->
<form action="<?php echo site_url('akdp_cetak/cari_data_no_mobil'); ?>" method="post">
      <div class="row">
        <div class="input-field col s12">
          
          <input type="text" class="" placeholder="Nomor Kendaraan" style="text-align: center" name="no_kend" value="<?php echo $no_kend;?>" >
         
          <center> <input type="submit" name="submit"  value="Cari" class="btn"></center>
        </div>

       
 
</div>
<!-- end cari no mobil---->
<?php 

if ( $this->session->userdata("id") == '178'){

}else if($this->session->userdata("id") == '176' || $this->session->userdata("id") == '175'){
?>
 <a href="<?php echo site_url('akdp_cetak/notifikasi'); ?> " class="btn" >Kirim Notifikasi</a></center>
<?php
}
	;?>
 

</form>	<form action="<?php echo site_url('akdp_cetak/update_multiple'); ?>" method="post">
	<!--	<select name="action">
			<option value="null">Bulk Action</option>
			<option value="delete">Delete</option>
			<option value="update">Update</option>
		</select>-->
		<?php
echo 'User Login : '.$this->session->userdata("oriname");
	?>

<input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
	
		<!--<button class="btn waves-effect waves-light" type="submit" name="action">Submit
    <i class="material-icons right">send</i>-->
		<center>
<?php
$iduser =  $this->session->userdata("id");
 //echo '<label style="text-align:center">Periode KP <br>'.date('d F Y', strtotime($tgl1)).' - '. date('d F Y', strtotime($tgl2)).'</label><br>'; 

if ( $iduser == 175 || $iduser == 176 || $iduser == $this->kepala){

?>
		</center><br><input type="submit" name="submit"  value="Approve"  class="btn">
		<?php
	}else{ 
		}
		?>
		<p></p>
		<table border="0" id="myTable" >
			<thead>
				<tr>
				<?php
				if ( $iduser == 175 || $iduser == 176 || $iduser == $this->kepala){
				?>
					<th><!--<input type="checkbox" id="checkAll" name="checkAll">-->
						<input type="checkbox" id="checkAll" name="checkAll">
						<label style="font-size: 11px;" for="checkAll">No</label>
					</th>
					<?php
					}else{
					}
					?>
					<th >No Kendaraan</th>
					<th >No Uji</th>
					<th >Aksi</th>
					<!--<th ><center>Approve</center></th>-->
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				if (count($hasilakdp_cetak)>0) {
					
					foreach ($hasilakdp_cetak as $data):
						?>
						<tr>
						<?php if ( $iduser == 175 || $iduser == 176 || $iduser == $this->kepala){
							?>
							<td><!--<input type="checkbox" name="msg[]" value="<?php echo $data->id; ?>">-->
								<input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
						<label style="font-size: 11px;" for="<?php echo $i;?>"><?php echo $i++;?></label>
							</td>
							<?php
							}else{} 
							?>
							<td><?php echo $data->no_kend; ?></td>
							<td><?php echo $data->no_uji; ?></td>
							</form>
							<td><?php //echo $data->nama_pemilik; ?>
	<form action="<?php echo site_url('approve_permohonan/detail').'/'.$data->id; ?>" method="post"	>
		<input type="submit" name="submit"  value="Detail"  class="btn">
	</form>							
<!---<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Detail</a>-->

							</td>
							<!--<td><?php 

							//echo $data->approve; 
if($data->approve == 2){
	?>
	<img src="<?php echo base_url(); ?>assets/img/eselon2.png">
	<?php
}else if($data->approve == 3){
	?>
	<img src="<?php echo base_url(); ?>assets/img/eselon3.png">
	<?php
}else if($data->approve == 4){
	?>
	<img src="<?php echo base_url(); ?>assets/img/eselon4.png">
	<?php
}else if($data->approve == 1){
	?>
	<img src="<?php echo base_url(); ?>assets/img/belum.png">
	<?php
}
							?></td>-->
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
	

<script type="text/javascript">
$('.datepicker').pickadate({

    selectMonths: true, // Creates a dropdown to control month
   selectYears: 15 // Creates a dropdown of 15 years to control year

   
  });


  </script>
 </div>
 </div>
 </div>


<footer class="page-footer teal" style="visibility: hidden;">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">Tentang DPMPTSP</h5>
          <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Kalimantan Utara berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div>
  </footer>

  <footer class="page-footer teal">
    <div class="footer-copyright">
      <div class="container">
        2017 Â© DPMPTSP Provinsi Kalimantan Utara v 1.5
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
<?php


}
?>