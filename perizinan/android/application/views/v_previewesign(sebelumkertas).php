
<!DOCTYPE html>
<html>
<head>
	
	</head>
	
<body>
<?php  include 'v_header.php';



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
?>

	

   	<br><br><center><a href="<?php echo base_url('approve_esign/');?>" class="btn red">Kembali</a></center>

    <form action="<?php echo site_url('approve_esign/update_multiple'); ?>" method="post">
                  <h5><center>PREVIEW NASKAH ESIGN</center></h5>
                  <?php
                  $iduser =  $this->session->userdata("id");
                  ?>
                            <input type="hidden" name="msg[]" value="<?php echo $no_id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                           <input type="hidden" name="nodaftar[]" value="<?php echo $no_pendaftaran; ?>">
                            <?php
                           // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                             /* if($h==4 || $h==3 || $h==2){
                            ?>
                                <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
                                <?php
                            }*/
                            if($h==4 || $h==3){
                            ?>
                             <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
                               <a href="<?php echo site_url('approve_esign/revisi_approve/').'/'.$no_id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
                                <?php
                            }else if($h==2){
                              ?>
                              <center>
                              <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp; &nbsp; 

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
  </div>
  <?php
                            }

                                ?>
                            <!--<a href="<?php echo site_url('approve_esign'); ?> " class="btn" >Kembali</a></center>-->
              </form>
<?php
$filename = $_SERVER['DOCUMENT_ROOT'] .'/kaltara/backoffice/assets/download/SK_'.$no_pendaftaran.'.docx';
 
if(file_exists($filename)){
?>  
<center>Catatan : Jika di preview tidak tampil sempurna silahkan download file .docx nya untuk lebih jelas
<!--<a href="https://dpmptsp.kaltaraprov.go.id/kaltara/backoffice/assets/download/<?php echo 'SK_'.$no_pendaftaran.'.docx';?>" class="btn red">Download</a></center>
-->
<a href="<?php echo base_url('approve_esign/tes_watermark/'.$no_pendaftaran);?>" class="btn red">Download</a>

</center>
<?php
}else{
  echo '<center><br>Data Naskah Belum Tersedia</center>';
}
?>
  <center>
<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https%3A%2F%2Fdpmptsp%2Ekaltaraprov%2Ego%2Eid%3A443%2Fkaltara%2Fbackoffice%2Fassets%2Fdownload%2FSK%5F<?php echo $no_pendaftaran ?>%2Edocx&wdStartOn=1' width='90%' height='488px' frameborder='0'>Ini adalah Dokumen <a target='_blank' href='https://office.com'>Microsoft Office</a> yang disematkan, didukung oleh <a target='_blank' href='https://office.com/webapps'>Office Online</a>.</iframe>
 -->
<br>
<br>
  <iframe src='https://docs.google.com/gview?url=https://dpmptsp.kaltaraprov.go.id/kaltara/backoffice/assets/download/SK_<?php echo $no_pendaftaran;?>.docx&embedded=true' width='90%' height='488px'></iframe>
 </center>
<br><br>
<form action="<?php echo site_url('approve_esign/update_multiple'); ?>" method="post">
                 
                  <?php
                  $iduser =  $this->session->userdata("id");
                  ?>
                            <input type="hidden" name="msg[]" value="<?php echo $no_id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                            <?php
                           // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                            /*  if($h==4 || $h==3 || $h==2){
                            ?>
                                <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
                                <?php
                            }*/
                           if($h==4 || $h==3){
                            ?>
                             <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp;
                               <a href="<?php echo site_url('approve_esign/revisi_approve/').'/'.$no_id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
                                <?php
                            }else if($h==2){
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
                                
                            <a href="<?php echo site_url('approve_esign'); ?> " class="btn" >Kembali</a></center>
              </form>
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


//}
?>

