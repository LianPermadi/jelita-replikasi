<?php  include 'v_header.php'; ?>
<body>
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
?>

	

   

    <form action="<?php echo site_url('approve_nonesign/update_multiple'); ?>" method="post">
                  <h5><center>PREVIEW NASKAH</center></h5>
                  <?php
                  $iduser =  $this->session->userdata("id");
                  ?>
                            <input type="hidden" name="msg[]" value="<?php echo $id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
                           
                            <?php
                           // if ( $iduser == 48 || $iduser == 257 || $iduser == 178){
                              if($h==4 || $h==3 || $h==2){
                            ?>
                               <!--  <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp; -->
                                 <center><a href="<?php echo site_url('approve_ossrba'); ?> " class="btn" >Kembali</a></center>
                                <?php
                            }
                            ?>
                               <!-- <a href="<?php echo site_url('approve_nonesign/revisi_approve/').'/'.$id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp; -->
                                <?php
                                ?>
                            <!--<a href="<?php echo site_url('approve_nonesign'); ?> " class="btn" >Kembali</a></center>-->
              </form>
<?php
$filename = $_SERVER['DOCUMENT_ROOT'] .$clean_uri_luar.'backoffice/assets/ossrba/naskah/NASKAH_'.$id;
if(file_exists($filename)){
?>  
<!-- <center>Catatan : Jika di preview tidak tampil sempurna silahkan download file .docx nya untuk lebih jelas -->
<!--<a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/download/<?php echo 'SK_'.$no_pendaftaran.'.docx';?>" class="btn red">Download</a></center>
-->


</center>
<?php
}else{
  echo '<center><br>Data Naskah Belum Tersedia</center>';
}
?>
  <center>
<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https%3A%2F%2Fdpmptsp%2Ejabarprov%2Ego%2Eid%3A443%2Fsicantik%2Fbackoffice%2Fassets%2Fdownload%2FSK%5F<?php echo $no_pendaftaran ?>%2Edocx&wdStartOn=1' width='90%' height='488px' frameborder='0'>Ini adalah Dokumen <a target='_blank' href='https://office.com'>Microsoft Office</a> yang disematkan, didukung oleh <a target='_blank' href='https://office.com/webapps'>Office Online</a>.</iframe>
 -->
<br>
<br>

  <!-- <iframe src='https://docs.google.com/gview?url=https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/ossrba/naskah/NASKAH_<?php echo $id;?>&embedded=true' width='90%' height='488px'></iframe> -->
   <!-- <iframe src='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/ossrba/naskah/NASKAH_<?php echo $id;?>' width='90%' height='488px'></iframe> -->
    <iframe src="<?= $pdf_url_oss ?>" width="1000" height="1200"></iframe>
 </center>
<br><br>

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
	</script>

	
  </body>
</html>
<?php


//}
?>

