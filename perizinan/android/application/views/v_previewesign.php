
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

	

   	<br><br><center><a href="<?php echo base_url('approve_esign/');?>" class="btn red" style="margin:5px">Kembali</a></center>


     <form action="<?php echo site_url('approve_esign/update_multiple'); ?>" method="post">
                 
                 <?php
                 $iduser =  $this->session->userdata("id");
                 ?>
                           <input type="hidden" name="msg[]" value="<?php echo $no_id;?>">
                           <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                           <?php
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
                         <br>
                         <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
                           <a href="" class="btn" >Kembali</a>
                         </div>
                       </div>
                       <?php
                           }

                               ?>
                               
                           <a href="<?php echo site_url('approve_esign'); ?> " class="btn" >Kembali</a></center>
             </form>
<?php
$local = $_SERVER['SCRIPT_FILENAME'];
    $url = $local;
    
    // Cari posisi kata "android" dalam URL
    $pos = strpos($url, "/android");
    if ($pos !== false) {
        // Ambil bagian URL sebelum "android"
        $local = substr($url, 0, $pos);
    } else {
        // Jika tidak ada kata "android", gunakan URL asli
        $local = $url;
    }
$filename = $local .'/backoffice/assets/download/SK_'.$no_pendaftaran.'.docx';
 
if(file_exists($filename)){
?>  
<center>Catatan : Jika di preview tidak tampil sempurna silahkan download file .docx nya untuk lebih jelas
<a href="<?php echo base_url('approve_esign/tes_watermark/'.$no_pendaftaran);?>" class="btn red">Download</a>

</center>
<?php
}else{
  echo '<center><br>Data Naskah Belum Tersedia</center>';
}
?>
  <center>
<br>
<br>
<?php
      $url_now = $_SERVER['REDIRECT_URL'];
      $url = $url_now;
      
      // Cari posisi kata "android" dalam URL
      $pos = strpos($url, "/android");
      if ($pos !== false) {
          // Ambil bagian URL sebelum "android"
          $clean_url = substr($url, 0, $pos);
      } else {
          // Jika tidak ada kata "android", gunakan URL asli
          $clean_url = $url;
      }
      $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "s") . "://";
?>
<h6><b>SK</b></h6>
  <iframe src='<?php echo $link.$_SERVER['HTTP_HOST'].$clean_url; ?>/backoffice/assets/skpdf/SK_<?php echo $no_pendaftaran;?>.pdf' width='90%' height='488px'></iframe>
 </center>
<br><br>
<?php if (file_exists($local .'/backoffice/assets/pertek/PT_'.$no_pendaftaran.".pdf")) { ?>
  <h6><b>Pertek</b></h6>
  <iframe src='<?php echo $link.$_SERVER['HTTP_HOST'].$clean_url; ?>/backoffice/assets/pertek/PT_<?php echo $no_pendaftaran;?>.pdf' width='90%' height='488px'></iframe>
<?php } ?>
<br><br>
<form action="<?php echo site_url('approve_esign/update_multiple'); ?>" method="post">
                 
                  <?php
                  $iduser =  $this->session->userdata("id");
                  ?>
                            <input type="hidden" name="msg[]" value="<?php echo $no_id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                            <?php
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
                          <br>
                          <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
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
          <h5 class="white-text">Tentang DPMPTSP</h5>
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


//}
?>

