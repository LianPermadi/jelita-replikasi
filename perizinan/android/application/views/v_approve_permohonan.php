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
$email = '';
$bidang = '';
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
			$h = '9';
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
<form action="<?php echo site_url('approve_permohonan/cari_data_no_pendaftaran'); ?>" method="post">
      <div class="row">
        <div class="input-field col s12">
          
          <input type="text" class="" placeholder="Masukan Kata Kunci" style="text-align: center" name="no_pendaftaran" value="<?php echo $no_pendaftaran;?>" >
         
          <center> <input type="submit" name="submit"  value="Cari" class="btn"></center>
        </div>
</div>
<!-- end cari pemohon---->

</form>

<?php
if (count($hasilakdp_cetak)>0) {
					
					foreach ($hasilakdp_cetak as $data):
						$bidang = $data->bidang;
						endforeach;
				}
		$otherdb->distinct();
		$otherdb->select('ttd_nota');
        $otherdb->from('trsektor');
        $otherdb->where('n_sektor',$bidang);
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
			<form action="<?php echo site_url('approve_permohonan/notifikasi'); ?>" method="post">
<input type="hidden" name="email" value="">
<input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
			</form>
				<?php
			}
			if($h == '4'){
				
				?>

			<form action="<?php echo site_url('approve_permohonan/notifikasi'); ?>" method="post">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
			</form>
				<?php
			}

	?>

	<form action="<?php echo site_url('approve_permohonan/update_multiple'); ?>" method="post">
	<!--	<select name="action">
			<option value="null">Bulk Action</option>
			<option value="delete">Delete</option>
			<option value="update">Update</option>
		</select>-->
		<?php
		echo '<h5><center>APPROVE PERMOHONAN IZIN</center></h5>';
echo '<center>'.$this->session->userdata("oriname").'</center>';
	?>

<input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
	
		<!--<button class="btn waves-effect waves-light" type="submit" name="action">Submit
    <i class="material-icons right">send</i>-->
		<center>
<?php
$iduser =  $this->session->userdata("id");
 //echo '<label style="text-align:center">Periode KP <br>'.date('d F Y', strtotime($tgl1)).' - '. date('d F Y', strtotime($tgl2)).'</label><br>'; 

//if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
if($h==4 || $h==3){
?>
		<br><input type="submit" name="submit"  value="Approve Permohonan"  class="btn"></center>
		<?php
	}else if($h==2){

                            ?>
                               <center>

                                <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve Permohonan</a>

  <!-- Modal Structure -->
  <div id="modal1" class="modal">

    <div class="modal-content">

      <center>KODE E-SIGN</center>
      <input type="password" name="passphrase">
    <!--</div>
    <div class="modal-footer">-->
    <br>
     <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
      <!--<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
      <a href="" class="btn" >Kembali</a>
    </div>
    <div class="progress">
      <div class="indeterminate"></div>
  </div>
  </div>


                                <?php
                            
}else{ 
 
		}
		?>
		<p></p>
		<table border="0" id="myTable" >
			<thead>
				<tr>
				<?php
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
					<th >No/Jenis/Perusahaan/Tgl Berkas</th>
					<!--<th >Tgl Berkas</th>-->
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
						<?php //if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
							
								if($h==4 || $h==3 || $h==2){
							?>
							<td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;"><!--<input type="checkbox" name="msg[]" value="<?php echo $data->id; ?>">-->
								<input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">

						<label style="font-size: 11px;" for="<?php echo $i;?>">
						<?php echo $i++;?></label>
						<input type="hidden" name="nodaftar[]" value="<?php echo $data->pendaftaran_id; ?>">
							</td>
							<?php
							}else{} 
							?>
							<td><?php echo $data->pendaftaran_id; ?></td>
							<!--<td><?php echo $data->d_terima_berkas; ?></td>-->
							</form>
							<td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;"><?php //echo $data->n_perizinan; ?>
								<form action="<?php echo site_url('approve_permohonan/detail_permohonan').'/'.$data->id; ?>" method="post">
		<input type="submit" name="submit"  value="Detail"  class="btn">
<!--<a href="<?php echo site_url('../../../sicantik/backoffice/assets/download').'/sk_'.$data->pendaftaran_id.'.docx'; ?>" class="btn">preview sk</a>-->
		</br></br><a href="<?php echo site_url('approve_permohonan').'/preview/'.$data->pendaftaran_id.'/'.$data->id; ?>" class="btn">preview sk</a>
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
       
    <td  ><?php echo $data->n_perizinan; ?></td>
    </tr>
	<tr>
        <td style="border-bottom: 1px solid silver;border-collapse: none;">
		<?php echo $data->n_perusahaan; ?>
        <?php echo '<br>'.$data->d_terima_berkas; ?></td>
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
<?php
}
?>