<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>DPMPTSP Provinsi Jawa Barat</title>
  <link rel="icon" type="image/png" href="ttps://dpmptsp.jabarprov.go.id/android/assets/img/favicon.png">
  
  <!-- CSS  -->
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/fonts.css" rel="stylesheet">
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/materialize_new.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style>
body {
  /* display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 100%;
  margin: 0;
  background-color: #f0f0f0; */
  transform: scale(1.0);
}

.zoom-in-element {
  /* width: 200px;
  height: 200px;
  background-color: #3498db;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px; */
  /* transition: transform 0.3s ease-in-out; Properti animasi */
}

.zoom-in-element:hover {
  /* transform: scale(1.2); Scale factor untuk zoom in */
}
    </style>
</head>
    <?php
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");
	?>
    <body>
      <!-- <div class="zoom-in-element"> -->
    <?php 
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select('eselon');
    // $otherdb->from('tmpegawai');
    // $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
    // $ambileselon =  $otherdb->get();
    $jumlah = $this->db->select('eselon')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai_user.user_id',$this->session->userdata("id"))
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambileselon = $data;
    if($ambileselon->num_rows() > 0) {
      foreach($ambileselon->result() as $data2) {
        $h = $data2->eselon;
      }
    }else{
      $h = '9';
    }
    ?>
    
    <br><br><center><a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/history_user" class="btn red">Kembali</a></center>
    <?php
    if($page == 'mobil'){
    ?>
    <form action="<?php echo site_url('peminjamanmobil/approve_surat/update_multiple_mobil'); ?>" method="post">
    <?php
    }else{
    ?>
    <form action="<?php echo site_url('peminjamanmobil/approve_surat/update_multiple'); ?>" method="post">
    <?php
    }
    ?>
      <h5><center>PREVIEW PERSURATAN</center></h5>
      <?php
      $iduser =  $this->session->userdata("id");
      ?>
      
      <input type="hidden" value="<?php echo $this->session->userdata('id_auth');;?>"  name="id_user">
      <input type="hidden" name="msg[]" value="<?php echo $id;?>">
      
      <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
      <input type="hidden" name="n_file[]" value="<?php echo $n_file; ?>">
      <input type="hidden" name="no_surat[]" value="<?php echo $no_surat; ?>">
      <input type="hidden" name="tgl_surat[]" value="<?php echo $tgl_surat; ?>">
      
      <?php
      //if($h==4 || $h==3){
        ?>
        <!-- <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp; -->
          <?php
      //}else if($h==2){
        ?>
        <center>
          <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp; &nbsp; 
      
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
          <div class="modal-content">
            <center>PASSPHRASE</center>
            <input type="password" name="passphrase">
            <br>
            <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
            <a href="" class="btn" >Kembali</a>
          </div>
        </div>
        <?php
      //}
      ?>
      <a href="<?php echo site_url('approve_surat/revisi').'/'.$id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
    </form>
    <?php
    $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat/'.$n_file;   //Lokasi File Tanpa WaterMark
    $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat-wm/'.$n_file; //Lokasi File WaterMark
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
            $img = base_url('https://dpmptsp.jabarprov.go.id/android/assets/img/watermark.png');
            $pdf->Image($img,10,50,243,350);
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filenameW,'F');
        }
        catch (Exception $e) {
          var_dump($e);die; 
        }
      }  
    	//EOFCreate pdf watermark
    }else{	
      echo '<center><br>Draft Surat Belum Tersedia</center>';
    }
	//Ambil data pegawai
    $konsep = $id_konseptor;
	// $xotherdb = $this->load->database('otherdb',TRUE);
    // $xotherdb->select('*');
    // $xotherdb->from('tmpegawai');
    // $xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $xotherdb->where('tmpegawai_user.user_id',$id_konseptor);
        $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai_user.user_id',$id_konseptor)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg = $data;
    // $ambilpeg =  $xotherdb->get();
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $konsep = $data2->n_pegawai;
      }
    }
	$ess4 = $id_ess4;
	// $xotherdb = $this->load->database('otherdb',TRUE);
    // $xotherdb->select('*');
    // $xotherdb->from('tmpegawai');
    // //$xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $xotherdb->where('tmpegawai.id',$id_ess4);
    // $ambilpeg =  $xotherdb->get();
    $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai.id',$id_ess4)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg =  $data;
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $ess4 = $data2->n_pegawai;
      }
    }

    $jfah = $id_jfah;
//   $xotherdb = $this->load->database('otherdb',TRUE);
//     $xotherdb->select('*');
//     $xotherdb->from('tmpegawai');
//     //$xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
//     $xotherdb->where('tmpegawai.id',$id_jfah);
//     $ambilpeg =  $xotherdb->get();
    $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai.id',$id_jfah)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg =  $data;
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $jfah = $data2->n_pegawai;
      }
    }
    else{
      if($analis_hukum == 1){
        $jfah = "BELUM MELALUI ANALISA HUKUM";  
      }
      else {
        $jfah = "TANPA ANALISA HUKUM";
      }
    }


	$ess3 = $id_ess3;
	// $xotherdb = $this->load->database('otherdb',TRUE);
    // $xotherdb->select('*');
    // $xotherdb->from('tmpegawai');
    // //$xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $xotherdb->where('tmpegawai.id',$id_ess3);
    // $ambilpeg =  $xotherdb->get();
        $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai.id',$id_ess3)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg =  $data;
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $ess3 = $data2->n_pegawai;
      }
    }

	$sekdis = $id_sekdis;
	// $xotherdb = $this->load->database('otherdb',TRUE);
    // $xotherdb->select('*');
    // $xotherdb->from('tmpegawai');
    // //$xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $xotherdb->where('tmpegawai.id',$id_sekdis);
    // $ambilpeg =  $xotherdb->get();
    $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai.id',$id_sekdis)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg =  $data;
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $sekdis = $data2->n_pegawai;
      }
    }
	$kadis = $id_ess2;
	// $xotherdb = $this->load->database('otherdb',TRUE);
    // $xotherdb->select('*');
    // $xotherdb->from('tmpegawai');
    // //$xotherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $xotherdb->where('tmpegawai.id',$id_ess2);

    $jumlah = $this->db->select('*')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai.id',$id_ess2)
            ->get();

    if (!empty($jumlah)) {
        $data = $jumlah;
    }
    $ambilpeg =  $data;
    if($ambilpeg->num_rows() > 0) {
      foreach($ambilpeg->result() as $data2) {
        $kadis = $data2->n_pegawai;
      }
    }
	echo '<center><br>Proses Approve Surat</center>';
    if($kadis != '0')    echo '<center>Kepala Dinas : '.$kadis.'</center>';
	  if($sekdis != '0')   echo '<center>SekDis : '.$sekdis.'</center>';
    if($jfah != '0')     echo '<center>Analis Hukum : '.$jfah.'</center>';
    if($ess3 != '0')     echo '<center>Koordinator : '.$ess3.'</center>';
	  if($ess4 != '0')     echo '<center>JF Ahmud : '.$ess4.'</center>';
	  if($konsep != '0')   echo '<center>Konseptor : '.$konsep.'</center>';
	//EOF() Ambil data pegawai
    ?>
    <center>
      <br>
      <br>
      <iframe src='https://docs.google.com/gview?url=https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/pdf-surat-wm/<?php echo $n_file; ?>&embedded=true' width='90%' height='988px'></iframe>
      <!-- <iframe src='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/pdf-surat-wm/<?php echo $n_file; ?>' width='90%' height='488px'></iframe> -->
    </center>
    <br><br>
    <form action="<?php echo site_url('approve_surat/update_multiple'); ?>" method="post">
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
      //if($h==4 || $h==3){
        ?>
        <!-- <center><input type="submit" name="submit"  value="Approve"  class="btn">&nbsp;&nbsp; -->
          <?php
      //}else if($h==2){
        ?>
        <center>
          <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>&nbsp;&nbsp; 
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
          <div class="modal-content">
            <center>PASSPHRASE</center>
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
      //}
      ?>
      <a href="<?php echo site_url('approve_surat/revisi').'/'.$id; ?> " class="btn" >Revisi</a>&nbsp;&nbsp;
      <br>
      <br>
      <a href="<?php echo site_url('approve_surat'); ?> " class="btn red" >Kembali</a></center>
    </form>
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
<!-- </div> -->
    <!--  Scripts-->
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/jquery-2.1.1.min.js"></script>
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/materialize.js"></script>
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/init.js"></script>
    <script type="text/javascript" src="https://dpmptsp.jabarprov.go.id/android/assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript">

    </script>
    
  </body>
</html>
<?php
?>