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
if($this->session->userdata("nama") == null){
  redirect('login');
}else{
  include 'v_header.php'; 
  ?>
  <body>
    <?php
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
    $ambileselon =  $otherdb->get();
    if($ambileselon->num_rows() > 0) {
      foreach ($ambileselon->result() as $data2) {
        $h = $data2->eselon;
      }
    }else{
      $h = '9';
      //echo $h;
    }
    ?>
    <div class="container" style="margin-top: 30px;">
      <div class="section">
        <div class="row">
          <?php
          $i=1;
          if(count($detail_cetak)>0) {
         	  foreach($detail_cetak as $data){ //:
        	    ?>
       						<h5><center>DETAIL PERMOHONAN</center></h5>
	        				<?php
			        		$iduser =  $this->session->userdata("id");
                  // echo site_url('approve_pengawasanoss/update_multiple_ossrba');
					        ?>
    					<form action="<?php echo site_url('approve_ossrba/update_multiple_ossrba'); ?>" method="post">
                            <input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                            <?php
                           // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                              if($h==4 || $h==3){
                            ?>
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" id="closeModalBtn">&times;</span>
                                                            
                                    <span>Tulis Pernyataan :</span>
                                    <textarea name="keterangan_ky" id="" rows="4" cols="50" required></textarea><br><br>
                                    <!-- <span>Passphrase :</span> -->
                                    <!-- <input type="password" name="passphrase" id="" rows="4" cols="50" required> -->
                                    <br>
                                    <br>
                                    <input type="submit" name="submit"  value="Approve"  class="btn">
                                </div>
                            </div>
                                <?php
                            }elseif($h == 2){
                              ?>
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" id="closeModalBtn">&times;</span>
                                                            
                                    <!-- <span>Tulis Pernyataan :</span> -->
                                    <input type="hidden" name="keterangan_ky" id="" rows="4" cols="50" value="ttd kadis eselon 2-------------------------------" required><br><br>
                                    <!-- <span>Passphrase :</span> -->
                                    <!-- <input type="password" name="passphrase" id="" rows="4" cols="50" required> -->
                                    <br>
                                    <br>
                                    <input type="submit" name="submit"  value="Approve"  class="btn">
                                </div>
                            </div>
                              <?php 
                            }
                            if($h==4 || $h==3){
                            ?>
                               <!-- <a href="<?php echo site_url('approve_pengawasanoss/revisi_approve/').'/'.$data->id; ?> " class="btn" >Revisi</a> -->&nbsp;&nbsp;
                                <?php
                            }
                                ?>
   						</form>
              <center><button id="openModalBtn" class="btn">APPROVE</button>&nbsp;&nbsp;<a href="<?php echo site_url('approve_ossrba'); ?> " class="btn" >Kembali</a></center>
        	    <?php
        	    
        	    echo '<label><center>Nomor Permohonan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nomorpermohonan.'</p>';
              
              echo '<label><center>Status Permohonan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_status($data->status).'</p>';
              
              echo '<label><center>Fiktif Positif</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_fiktifpositif($data->fiktif_positif).'</p>';
              
              echo '<label><center>Tanggal Permohonan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.date('d F Y', strtotime($data->tanggalpermohonan)).'</p>';
              
              echo '<label><center>NIB</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nib.'</p>';
        	    
              echo '<label><center>KBLI</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->kbli.'</p>';
              
              echo '<label><center>Sektor</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_n_sektor($data->sektor).'</p>';

              echo '<label><center>Tipe Aplikasi</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_tipe_aplikasi($data->tipe_aplikasi).'</p>';
        	    
              echo '<label><center>Jenis Perusahaan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_jenisperusahaan($data->jenis_perusahaan).'</p>';
        	    
              echo '<label><center>Nama Perusahaan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nama_perusahaan.'</p>';
              
              
              echo '<label><center>Modal Usaha</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->modal_usaha.'</p>';
              
              echo '<label><center>Alamat Perusahaan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->alamat.'</p>';
              
              echo '<label><center>Jenis Proyek</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->jenis_proyek.'</p>';
              
              echo '<label><center>Nama Perizinan</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_namaperizinan($data->nama_perizinan).'</p>';
              
              echo '<label><center>Skala Usaha</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->skala_usaha.'</p>';
              
              echo '<label><center>Risiko</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_risiko($data->risiko).'</p>';
        	  }
        	  //  endforeach;
        	  $i++;
        	}
          ?>
        </div>
      </div>
    </div>
  </body>
  <?php
}
?>

<footer class="page-footer teal" style="visibility: hidden;">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5 class="white-text">Tentang BPMPT</h5>
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
<script>
  

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