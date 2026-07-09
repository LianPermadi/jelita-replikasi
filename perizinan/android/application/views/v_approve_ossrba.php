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
		body {
    font-family: Arial, sans-serif;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 100;
    width: 100%;
    height: 65%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 5px;
    border: 1px solid #888;
    width: 90%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
	</style>
  <?php 
  $clean_uri  = $_SERVER['PHP_SELF'];
// Periksa apakah 'index.php' ada dalam URL
if (strpos($clean_uri, 'index.php') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri = str_replace('index.php', '', $clean_uri);
}
// var_dump($clean_uri);
$request_uri = $clean_uri;
$clean_uri_luar  = $request_uri;
// Periksa apakah 'index.php' ada dalam URL
if (strpos($request_uri, 'index.php') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri_luar = str_replace('index.php', '', $request_uri);
}
if (strpos($request_uri, 'android/') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri_luar = str_replace('android/', '', $request_uri);
}
  if($this->session->userdata("nama") == null){
  	redirect('login');
  }else{
                        ?>
<body>
<?php  include 'v_header.php';
$email = '';
$sektor = '';
$ambilttd = '';
$ambilttd2 = '';
$otherdb = $this->load->database('otherdb',TRUE);

 $otherdb->select('eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
       	$ambileselon =  $otherdb->get();
       if ($ambileselon->num_rows() > 0) {
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}
		}else{
			if($this->session->userdata("group") == 1) {
				$h = '2';
			} else {
				$h = '9';
			}
			//echo $h;
		}


		//echo $h;
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
    <div class="section">
    <div class="row">
    <!--<form class="col s12">--><!--<form action="<?php //echo site_url('approve_permohonana/cari_data'); ?>" method="post">
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
<form action="<?php echo site_url('approve_ossrba/cari_data_no_pendaftaran'); ?>" method="post">
      <div class="row">
        <div class="input-field col s12">
          
          <input type="text" class="" placeholder="Masukan Kata Kunci" style="text-align: center" name="no_pendaftaran" value="<?php echo $no_pendaftaran;?>" >
         
          <center> <input type="submit" name="submit"  value="Cari" class="btn"></center>
        </div>

       
 
</div>
<!-- end cari pemohon---->

</form>

<?php
if (count($query_ossrba)>0) {
					
					foreach ($query_ossrba as $data):
						$sektor = $data->sektor;
						endforeach;
				}
		$otherdb->distinct();
		$otherdb->select('ttd_nota');
        $otherdb->from('trsektor');
        $otherdb->where('n_sektor',$sektor);
       	$ambilttd =  $otherdb->get();
       	if ($ambilttd->num_rows() > 0) {
	        foreach ($ambilttd->result() as $data2) {
					$ambilttd = $data2->ttd_nota;
				}
				$ambilttd2 = $ambilttd;
		}
		$otherdb->select('email');
        $otherdb->from('user');
        $otherdb->join('tmpegawai_user','tmpegawai_user.user_id = user.id','left');
        $otherdb->where('tmpegawai_user.tmpegawai_id',$ambilttd2);
       	$ambilemail =  $otherdb->get();
       if ($ambilemail->num_rows() > 0) {
        foreach ($ambilemail->result() as $data2) {
				$email = $data2->email;
			}
		}


			if($h == '3'){
				?>
			<form action="<?php echo site_url('approve_nonesign/notifikasi'); ?>" method="post">
<input type="hidden" name="email" value="">
<input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
			</form>
				<?php
			}
			if($h == '4'){
				
				?>

			<form action="<?php echo site_url('approve_nonesign/notifikasi'); ?>" method="post">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
			</form>
				<?php
			}

	?>

	<!--	<select name="action">
			<option value="null">Bulk Action</option>
			<option value="delete">Delete</option>
			<option value="update">Update</option>
		</select>-->
		<?php
		echo '<h5><center>APPROVE PERSETUJUAN PERMOHONAN OSS RBA</center></h5>';
		echo '<center>'.$this->session->userdata("oriname").'</center>';
	?>
<?php
if($h==2){
?>
<center><button id="openModalBtn" class="btn">APPROVE OSS RBA</button></center>
<?php } ?>
<form action="<?php echo site_url('approve_ossrba/update_multiple_ossrba'); ?>" method="post">
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
<input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
	
		<!--<button class="btn waves-effect waves-light" type="submit" name="action">Submit
    <i class="material-icons right">send</i>-->
<?php
$iduser =  $this->session->userdata("id");
 //echo '<label style="text-align:center">Periode KP <br>'.date('d F Y', strtotime($tgl1)).' - '. date('d F Y', strtotime($tgl2)).'</label><br>'; 

//if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
if($h==4 || $h==3 || $h==2){
?>
		<span>Anda yakin akan menyetujui seluruhnya ?</span>
        <!-- <textarea name="keterangan_ky" id="" rows="4" cols="50" required></textarea> -->
		<br>
		<br>
		<input type="submit" name="submit"  value="Approve OSS RBA"  class="btn">
    </div>
</div>
		<center>
		<br>Font Merah : Metode Pencarian Search, Font Hitam : Ada di Dashboard</center>
		<?php
	}else{ 
 
		}
		?>
		<p></p>
		<table border="0" id="myTable" >
			<thead>
				<tr>
				<?php
				//if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
				if($h==4 || $h==3 || $h==2){
				?>
					<th><!--<input type="checkbox" id="checkAll" name="checkAll">-->
						<input type="checkbox" id="checkAll" name="checkAll">
						<label style="font-size: 11px;" for="checkAll">No</label>
					</th>
					<?php
					}else{
					}
					?>
					<th >No Permohonan/NIB/Tgl Permohonan/Nama Perusahaan/Skala usaha/Risiko/Sektor</th>
					<!--<th >Tgl Berkas</th>-->
					<th >Aksi</th>
					<!--<th ><center>Approve</center></th>-->
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				if (count($query_ossrba) > 0 && $this->session->userdata('approve') == 1) {
					
					foreach ($query_ossrba as $data):
						if($data->metode_cari == 1) {
			              $b = '<span style="color: Red">';
			              $be = '</span>';
			              // $c = '<br>Revisi : '.$row->revisi;
			            }else{
			              $b = '';
			              $be = '';
			              // $c = '<br>'.$row->revisi; 
			            }

						if (!file_exists($_SERVER['DOCUMENT_ROOT'].$clean_uri_luar.'backoffice/assets/skpdf/SK_'.$data->id.".pdf")) {
						?>
						<tr>
						<?php //if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
							
								if($h==4 || $h==3 || $h==2){
							?>
							<td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;"><!--<input type="checkbox" name="msg[]" value="<?php echo $data->id; ?>">-->
								<input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
						<label style="font-size: 11px;" for="<?php echo $i;?>">
						<?php echo $i++;?></label>
							</td>
							<?php
							}else{} 
							?>
							<td><?php echo  $b.$data->nomorpermohonan.$be; ?>
								<?php echo '<br>'.$b.$data->nib.$be; ?>
							</td>
							<!--<td><?php echo $data->d_terima_berkas; ?></td>-->
							</form>
							<td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;"><?php //echo $data->n_perizinan; ?>
								<form action="<?php echo site_url('approve_ossrba/detail_permohonan').'/'.$data->id; ?>" method="post">
							<input type="submit" name="submit"  value="Detail & Approve"  class="btn">
						</form> <br> <form>
							<?php  
							if (file_exists($_SERVER['DOCUMENT_ROOT'].$clean_uri_luar.'backoffice/assets/ossrba/naskah/NASKAH_'.$data->id.".pdf")) { ?>
								<a href="<?php echo site_url('approve_ossrba').'/preview_oss/'.$data->id.'.pdf'; ?>" class="btn">preview Naskah</a><br>
							<?php } else {
								echo "NASKAH TIDAK TERSEDIA ";
								// echo $clean_uri. ' && '.$clean_uri_luar;
							} ?>
							</form>	
							<form>
								<a href="<?php echo site_url('approve_ossrba').'/pernyataan_ky/'.$data->id.'.pdf'; ?>" class="btn">Pernyataan</a>
						</form>

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
						 	<tr>
    						<td><?php echo $b.date('d F Y', strtotime($data->tanggalpermohonan)).$be.'<br>Status Permohonan: '.$b.$this->m_approve_ossrba->get_status($data->status).$be; ?></td>
    						</tr>
							<tr>
								<td style="border-bottom: 1px solid silver;border-collapse: none;">
								
								<?php echo '<br>'.$b.$data->nama_perusahaan.$be; ?> 
								<?php echo '<br>'.$b.$data->skala_usaha.$be; ?> 
								<?php 
								if($data->tipe_aplikasi == '1'){
								echo '<br>Tipe App: <b><span style="color : red;">'.$this->m_approve_ossrba->get_tipe_aplikasi($data->tipe_aplikasi).'</span></b>'; 
							}elseif($data->tipe_aplikasi == '2'){
								echo '<br>Tipe App: <span style="color : blue;"><b>'.$this->m_approve_ossrba->get_tipe_aplikasi($data->tipe_aplikasi).'</b></span>'; 
							}elseif($data->tipe_aplikasi == '3'){
								echo '<br>Tipe App: <span  style="color : green;"><b>'.$this->m_approve_ossrba->get_tipe_aplikasi($data->tipe_aplikasi).'</b></span>'; 
							}else{
								echo '<br>Tipe App: <b>'.$this->m_approve_ossrba->get_tipe_aplikasi($data->tipe_aplikasi).'</b>'; 
							}
								?> 
								<?php echo '<br>Tingkat Risiko: '.$b.$this->m_approve_ossrba->get_risiko($data->risiko).$be; ?> 
								<?php echo '<br>'.$b.$this->m_approve_ossrba->get_n_sektor($data->sektor).$be; ?>
								</td>
							</tr>
						<?php
						}
					endforeach;
					$i++;
				} else {
					echo "<tr><td colspan=5>DATA KOSONG !</td></tr>";
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
          <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Jawa Barat berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div>
  </footer>

  <footer class="page-footer teal">
    <div class="footer-copyright">
      <div class="container">
        2017 © DPMPTSP Provinsi Jawa Barat v 3.0
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

		// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var span = document.getElementById("closeModalBtn");

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
	</script>

	
  </body>
</html>
<?php


}
?>