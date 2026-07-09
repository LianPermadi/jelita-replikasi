<!DOCTYPE html>
<html>
  <head>
  </head>
  	
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
      foreach($ambileselon->result() as $data2) {
        $h = $data2->eselon;
      }
    }else{
      $h = '9';
    }
    ?>
    
    <br><br><center><a href="<?php echo base_url('approve_per_pertek/');?>" class="btn red">Kembali</a></center>
    <form action="<?php echo site_url('approve_per_pertek/update_multiple'); ?>" method="post">
      <h5><center>PREVIEW SURAT PERMOHONAN PERTEK</center></h5>
      <?php
      $iduser =  $this->session->userdata("id");
      ?>
      
      <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id_user">
      <input type="hidden" name="msg[]" value="<?php echo $id;?>">
      
      <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
      <input type="hidden" name="n_file[]" value="<?php echo $n_file; ?>">
      <input type="hidden" name="no_surat[]" value="<?php echo $no_surat; ?>">
      <input type="hidden" name="tgl_surat[]" value="<?php echo $tgl_surat; ?>">
      
      <?php
      if($h==4){
        ?>
        <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
          <!--<a href="<?php echo site_url('approve_per_pertek/revisi_approve/').'/'.$id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;-->
          <?php
      }else if($h==3){
        ?>
        <center>
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
      ?>
    </form>
    <?php
    $filename  = $_SERVER['DOCUMENT_ROOT'] .'/kaltara/backoffice/assets/file_mohon_sartek/'.$n_file;   //Lokasi File Tanpa WaterMark
    $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/kaltara/backoffice/assets/file_mohon_sartekWM/'.$n_file; //Lokasi File WaterMark
    if(file_exists($filename)){
    	echo '<center><br>Draft Surat Ditemukan</center>';
    	//Create pdf watermark
    	if(!file_exists($filenameW)){
    	  $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
    	  try{
          $pageCount = $pdf->setSourceFile($filename);
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $Wpaper = 262;
            $Hpaper = 450;
            $pdf->AddPage('P',array($Hpaper,$Wpaper));
            $img = base_url('assets/img/watermark.png');
            $pdf->Image($img,10,50,243,350);
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filenameW,'F');
        }
        catch (Exception $e) {}
      }  
    	//EOFCreate pdf watermark
    }else{	
      echo '<center><br>Draft Surat Belum Tersedia</center>';
    }
    ?>
    <center>
      <br>
      <br>
      <iframe src='https://docs.google.com/gview?url=https://dpmptsp.kaltaraprov.go.id/kaltara/backoffice/assets/file_mohon_sartekWM/<?php echo $n_file; ?>&embedded=true' width='90%' height='488px'></iframe>
    </center>
    <br><br>
    <form action="<?php echo site_url('approve_per_pertek/update_multiple'); ?>" method="post">
      <?php
      $iduser =  $this->session->userdata("id");
      ?>
      <input type="hidden" name="msg[]" value="<?php echo $id;?>">
      <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
      <input type="hidden" name="n_file[]" value="<?php echo $n_file; ?>">
      <input type="hidden" name="no_surat[]" value="<?php echo $no_surat; ?>">
      <input type="hidden" name="tgl_surat[]" value="<?php echo $tgl_surat; ?>">
      <?php
      if($h==4){
        ?>
        <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
          <!--<a href="<?php echo site_url('approve_per_pertek/revisi_approve/').'/0'; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;-->
          <?php
      }else if($h==3){
        ?>
        <center>
          <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp; &nbsp; 
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
          <div class="modal-content">
            <center>KODE E-SIGN</center>
            <input type="text" name="passphrase">
          <!--</div>
          <div class="modal-footer">-->
          <br>
            <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
            <!--<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
            <a href="" class="btn" >Kembali</a>
          </div>
        </div>
        <?php
      }
      ?>
      <a href="<?php echo site_url('approve_per_pertek'); ?> " class="btn" >Kembali</a></center>
    </form>
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
          2017 © DPMPTSP Provinsi Kalimantan Utara v 1.5
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
?>

