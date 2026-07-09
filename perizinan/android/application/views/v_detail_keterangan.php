<style type="text/css">
  td,th{
    font-size: 11px;
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
              <form action="<?php echo site_url('approve_ossrba/update_multiple_ossrba'); ?>" method="post">
                <h5><center>DETAIL PERMOHONAN</center></h5>
                <?php
        	      $iduser = $this->session->userdata("id");
        	      ?>
                <input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
                <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                <?php
                // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                if($h==4 || $h==3 || $h==2){
                  ?><br>
                  <center><label for="keterangan_ky"><h6 style="color:black;"><b>Pernyataan :</b></h6></label></center>
                <!-- <center><textarea name="keterangan_ky" class = 'input-wrc' id="" cols="30" rows="10" style = 'width:80%; background-color:white; border: 1px solid #ccc;margin:10px' required = 'required'></textarea></center> -->
                  <center>
                    <!-- <input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp; -->
                  <?php
                  // Replace the form_input with form_textarea

                  // echo form_textarea($data);
                }
                if($h==4 || $h==3){
                  ?>
                  <!-- <a href="<?php echo site_url('approve_ossrba/revisi_approve/').'/'.$data->id; ?> " class="btn" >Revisi</a> -->&nbsp;&nbsp;
                  <?php
                }
                ?>
                 <a href="<?php echo site_url('approve_ossrba'); ?> " class="btn" >Kembali</a></center>
         	    </form>
        	    <?php
        	    $id_pegawai4 = $this->m_approve_ossrba->get_tmpegawai_id($data->id_ess4);
        	    $id_pegawai3 = $this->m_approve_ossrba->get_tmpegawai_id($data->id_ess3);
        	    $id_pegawai2 = $this->m_approve_ossrba->get_tmpegawai_id($data->id_ess2);
        	    $id_pengolah = $this->m_approve_ossrba->get_tmpegawai_id($data->id_pengolah);

              // Tanggal dan waktu awal
              $originalDateTime = $this->m_approve_ossrba->created_date($data->oss_id);
              // Ubah format
              $timepengolah = date("d F Y", strtotime($originalDateTime)) . ' Jam ' . date("H:i", strtotime($originalDateTime));
        	    echo '<label><center>Pengolah</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$timepengolah.'</p>';
              
              echo '<label><center>Approve Pengolah</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_tmpegawai_n_pegawai($id_pengolah).'</p>';

              echo '<label><center>Pernyataan Pengolah</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket_pengolah.'</p>';

            if($h==2 || $h==3){
              
              // Tanggal dan waktu awal
              $originalDateTime1 = $data->tg_kyEsl4PTSP;
              // Ubah format
              $tg_kyEsl4PTSP = date("d F Y", strtotime($originalDateTime1)) . ' Jam ' . date("H:i", strtotime($originalDateTime1));
        	    echo '<label><center>Tgl Approve eselon 4</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$tg_kyEsl4PTSP.'</p>';
              
              echo '<label><center>Approve Eselon 4</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_tmpegawai_n_pegawai($id_pegawai4).'</p>';

              echo '<label><center>Pernyataan eselon 4</center></label>';
              if($data->ket_esl4 == NULL || $data->ket_esl4 == '' || $data->ket_esl4 == '0'){
              echo '<p style="border-bottom:1px dotted gray;text-align:center; color:red;">Tidak Di cantumkan</p>';
              }else{
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket_esl4.'</p>';
              }
            }

            if($h==2){
              // Tanggal dan waktu awal
              $originalDateTime2 = $data->tg_kyEsl3PTSP;
              // Ubah format
              $tg_kyEsl3PTSP = date("d F Y", strtotime($originalDateTime2)) . ' Jam ' . date("H:i", strtotime($originalDateTime2));
        	    echo '<label><center>Tgl Approve eselon 3</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$tg_kyEsl3PTSP.'</p>';
              
              echo '<label><center>Approve Eselon 3</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_tmpegawai_n_pegawai($id_pegawai3).'</p>';

              echo '<label><center>Pernyataan eselon 3</center></label>';
              if($data->ket_esl3 == NULL || $data->ket_esl3 == '' || $data->ket_esl3 == '0'){
              echo '<p style="border-bottom:1px dotted gray;text-align:center; color:red;">Tidak Di cantumkan</p>';
              }else{
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket_esl3.'</p>';
              }
            }

            if($h==2){
              // Tanggal dan waktu awal
              $originalDateTime3 = $data->tg_kyKaPTSP;
              // Ubah format
              $tg_kyKaPTSP = date("d F Y", strtotime($originalDateTime3)) . ' Jam ' . date("H:i", strtotime($originalDateTime3));
        	    echo '<label><center>Tgl Approve eselon 2</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$tg_kyKaPTSP.'</p>';
              
              echo '<label><center>Approve Eselon 2</center></label>';
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$this->m_approve_ossrba->get_tmpegawai_n_pegawai($id_pegawai2).'</p>';

              echo '<label><center>Pernyataan eselon 2</center></label>';
              if($data->ket_esl2 == NULL || $data->ket_esl2 == '' || $data->ket_esl2 == '0'){
              echo '<p style="border-bottom:1px dotted gray;text-align:center; color:red;">Tidak Di cantumkan</p>';
              }else{
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket_esl2.'</p>';
              }
            }
              // echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket_esl2.'</p>';
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