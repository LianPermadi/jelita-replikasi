<style type="text/css">
  td,th{
    font-size: 11px;
  }
</style>

<?php 
if($this->session->userdata("nama") == null){
  redirect('login');
}else{
  ?>
  <body> 
    <?php
    include 'v_header.php'; 
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
          //$i=1;
          //if (count($detail_cetak)>0) {
            //foreach ($detail_cetak as $data){
              ?>
              <form action="<?php echo site_url('approve_per_pertek/update_multiple'); ?>" method="post">
                <h5><center>DETAIL PERMOHONAN ESIGN</center></h5>
                <?php
                $iduser =  $this->session->userdata("id");
                ?>
                <!--<input type="hidden" name="msg[]" value="<?php echo $data->id;?>">                    -->
                <!--<input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id"> -->
                <!--<input type="hidden" name="nodaftar[]" value="<?php echo $data->pendaftaran_id; ?>">  -->
                <!--<input type="hidden" name="kordinatttd[]" value="<?php echo $data->kordinatttd; ?>">-->
                <!--<input type="hidden" name="kordinatqr[]" value="<?php echo $data->kordinatqr; ?>">-->
                <!--<input type="hidden" name="kertas[]" value="<?php echo $data->kertas; ?>">-->
                <?php
                // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                if($h==4){
                  ?>
                  <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
                  <?php
                }
                
                if($h==3){
                  ?>
                  <center>
                  <!-- Modal Trigger -->
                  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp; &nbsp; 
                  
                  <!-- Modal Structure -->
                  <div id="modal1" class="modal">
                    <div class="modal-content">
                      <center>KODE E-SIGN</center>
                      <input type="password" name="passphrase">
                    <br>
                     <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
                      <a href="" class="btn" >Kembali</a>
                    </div>
                  </div>
                  <?php
                }
                if($h==4 || $h==3){
                  ?>
                  <a href="<?php echo site_url('approve_per_pertek/revisi_approve/').'/0'; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
                  <?php
                }
                ?>
                <a href="<?php echo site_url('approve_per_pertek'); ?> " class="btn" >Kembali</a></center>
              </form>
              <?php
              $i=1;
              if (count($detail_cetak)>0) {
              	echo '<label><center>Nomor    Nomor Pendaftaran</center></label>';
                foreach ($detail_cetak as $data){
                	?>
                	<input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
                <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                <input type="hidden" name="nodaftar[]" value="<?php echo $data->pendaftaran_id; ?>">
                <?php
              
              echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$i.' '.$data->pendaftaran_id.'</p>';
              
              //echo '<label><center>Nama Pemohon</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->n_pemohon.'</p>';
              //
              //echo '<label><center>Alamat Pemohon</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->a_pemohon.'</p>';
              //
              //echo '<label><center>Jenis Perizinan</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->n_perizinan.'</p>';
              //
              //echo '<label><center>Bidang</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->bidang.'</p>';
              //
              //echo '<label><center>Bidang Teknis</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->bid_teknis.'</p>';
              //
              //echo '<label><center>Terima Berkas</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->d_terima_berkas.'</p>';
              //
              //
              //echo '<label><center>Nomor Pertek</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_per_pertek.'</p>';
              //
              //echo '<label><center>Tanggal Pertek</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->tg_per_pertek.'</p>';
              //
              //echo '<label><center>Tanggal Survey</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->d_survey.' s/d '.$data->survey_sd.'</p>';
              //
              //echo '<label><center>Status Berkas</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->status_berkas.'</p>';
              //
              //echo '<label><center>Nama Perusahaan</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->n_perusahaan.'</p>';
              
              //echo '<label><center>Alamat Perusahaan</center></label>';
              //echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->a_perusahaan.'</p>';
            }
            $i++;
          }
          ?>
        </div>
        <form action="<?php echo site_url('approve_per_pertek/update_multiple'); ?>" method="post">
          <h5><center></center></h5>
          <?php
          $iduser =  $this->session->userdata("id");
          ?>
          <input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
          <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
          <input type="hidden" name="nodaftar[]" value="<?php echo $data->pendaftaran_id; ?>">
          <!--<input type="hidden" name="kertas[]" value="<?php echo $data->kertas; ?>">           -->
          <!--<input type="hidden" name="kordinatttd[]" value="<?php echo $data->kordinatttd; ?>"> -->
          <!--<input type="hidden" name="kordinatqr[]" value="<?php echo $data->kordinatqr; ?>">   -->
          <!--<input type="hidden" name="kertas[]" value="<?php echo $data->kertas; ?>">           -->
          <?php
          // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
          if($h==4){
            ?>
            <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
            <?php
          }
          
          if($h==3){
            ?>
            <center>
            <!-- Modal Trigger -->
            <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp; &nbsp; 
            
            <!-- Modal Structure -->
            <div id="modal1" class="modal">
              <div class="modal-content">
                <center>KODE E-SIGN</center>
                <input type="text" name="passphrase">
                <br>
                <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
                <a href="" class="btn" >Kembali</a>
              </div>
            </div>
            <?php
          }
          if($h==4 || $h==3){
            ?>
            <a href="<?php echo site_url('approve_per_pertek/revisi_approve/').'/'.$data->id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
            <?php
          }
          ?>
          <a href="<?php echo site_url('approve_per_pertek'); ?> " class="btn" >Kembali</a></center>
        </form>
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
        <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Kalimantan Utara berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
      </div>
    </div>
  </div>
</footer>

<footer class="page-footer teal">
  <div class="footer-copyright">
    <div class="container">
      2017 © DPMPTSP Provinsi Kalimantan Utara v 1.5
    </div>
  </div>
</footer>

<!--  Scripts-->
<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/init.js"></script>