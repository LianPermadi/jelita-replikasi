<style type="text/css">
		td,th{
			font-size: 11px;
		}
	</style>
<?php if($this->session->userdata("nama") == null){redirect('login');}else{?>
	<body>
<?php  include 'v_header.php';
//$e_sertifikat ="";
		$otherdb = $this->load->database('otherdb',TRUE);
?>


	<div class="container" style="margin-top: 30px;">
    <div class="section">
    <div class="row">
		<form action="<?php echo site_url('approve_permohonan/cari_list_approve'); ?>" method="post">
      		<div class="row">
        	<div class="input-field col s12">
          			<input type="date" class="datepicker" placeholder="Range 1" style="text-align: center" name="tg1" value="<?php echo $tg1;?>">
         			<input type="date" class="datepicker" placeholder="Range 2" style="text-align: center" name="tg2" value="<?php echo $tg2;?>">
          		<center><input type="submit" name="submit"  value="Cari" class="btn"></center>
        	</div> 
			</div>
		</form>
	<form action="<?php echo site_url('approve_permohonan/update_multiple'); ?>" method="post">
<?php
		echo '<h5><center>List Data Approve Izin</center></h5>';
		echo '<center>'.$this->session->userdata("oriname").'</center>';
?>
		<input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
<?php
		$iduser =  $this->session->userdata("id");

		?>
		<p></p>
		<table border="0" id="myTable" >
			<thead>
				<tr>
				<?php
					?>
					<th >No</th>
					<th >No. Pendaftaran</th>
					<th >Approve Esl 4</th>
					<th >Approve Esl 3</th>
					<th >Approve Esl 2</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				$j = $i;
				//echo $j;
				
				if (count($hasilakdp_cetak)>0) {
					foreach ($hasilakdp_cetak as $data):
?>
				<tr>
    				<td><?php echo $i++;?></td>
    				<td><?php 
/*if($data->e_sertifikat == 0){
	$status = 'Non Esign';
}else if($data->e_sertifikat == 1){
	$status = 'Esign';
}else{

}*/
//echo $data->e_sertifikat;
    				//echo $data->pendaftaran_id.' ( '.$status.' ) '.'<br>'.$data->n_perusahaan.'<br><br>'.$data->n_perizinan; 
echo $data->pendaftaran_id.'<br>'.$data->n_perusahaan.'<br><br>'.$data->n_perizinan; 
?></td>
<?php
				if($data->tg_kyEsl4PTSP == '0000-00-00 00:00:00'){
 					echo '<td style="color:red;">Belum Approve</td>';
				}else{
 					echo '<td>'.$data->tg_kyEsl4PTSP.'</td>';
				}

				if($data->tg_kyEsl3PTSP == '0000-00-00 00:00:00'){
 					echo '<td style="color:red;">Belum Approve</td>';
				}else{
 					echo '<td>'.$data->tg_kyEsl3PTSP.'</td>';
				}

				if($data->tg_kyKaPTSP == '0000-00-00 00:00:00'){
 					echo '<td style="color:red;">Belum Approve</td>';
				}else{
 					echo '<td>'.$data->tg_kyKaPTSP.'</td>';
				}
?>
    			</tr>
<?php
				endforeach;
					$i++;
				}else {
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