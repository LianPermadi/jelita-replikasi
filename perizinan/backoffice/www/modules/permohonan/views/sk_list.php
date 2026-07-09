<!--
 * Update  : PBS, 14 Okt 2016 -> mencetak sk dengan pdf 
-->

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('permohonan/sk'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php echo form_label('Nomor Pendaftaran', 'kt_cari');?>
            </div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
            <?php
            $cari_data = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Cari Data',
                               'value' => 'Cari Data'
                              );
            echo form_submit($cari_data);
            ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '1');
        echo form_close();
        ?>
      </fieldset>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Tanggal</legend>
        <?php
        echo form_open('permohonan/sk');
        ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            $status1 = array('name' => "sts_pil",
                             'value' => "1",
                             'id'=>'sts_pil',
                             'checked' => $cek1,
                             'onclick' => 'gantiStatus(this.value)');
            echo form_radio($status1) . " PERMOHONAN";
            ?>
          </div>
          <div id="rightRail">
            <?php 
            $status2 = array('name' => "sts_pil",
                             'value' => "2",
                             'id'=>'sts_pil',
                             'checked' => $cek2,
                             'onclick' => 'gantiStatus(this.value)');
            echo form_radio($status2) . " PENETAPAN"; ?>
            &nbsp;&nbsp;&nbsp;
            <?php
            $status3 = array('name' => "sts_pil",
                             'value' => "3",
                             'id'=>'sts_pil',
                             'checked' => $cek3,
                             'onclick' => 'gantiStatus(this.value)');

            $img_esl2 = array('src' => base_url().'assets/images/icon/dsign.png',
                                   'alt' => 'Digital Signature Esl II',
                                   'title' => 'Digital Signature Esl II',
                                   'border' => '0');
            //echo form_radio($status3) . " ESL II ".img($img_esl2);
            echo form_radio($status3) . " Approve ESL II ";
            ?>
          </div>
        </div>  

        <div id="statusRail">  
          <div id="leftRail">
            <?php
            echo form_label('Tanggal Awal','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan');
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tanggal Akhir','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail"></div>
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            $ctk_list = array('name' => 'button',
                              'content' => 'Cetak Nota Pengantar',
                              'value' => 'Cetak Nota Pengantar',
                              'class' => 'button-wrc',
                              'onclick' => 'parent.location=\''.site_url('permohonan/sk/cetak_nota/'.$tgla.'/'.$tglb).'\'');
            echo form_submit($filter_data);
            //echo form_button($ctk_list);  // Sudah tanpa cetak nota pengantar
            
            
            ?>
          </div>
        </div>
        <?php
        echo form_close();
        ?>
      </fieldset>
    </div>

    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
    <div class="entry">
      <?php 
      if ($cek3) {
        if (!empty($kt_cari)) {
              $key = $kt_cari;
            } else{
              $key = 0;
            }
            $notif = array('name' => 'button',
                           'content' => 'Kirim Notifikasi Izin Selesai (s|Print)',
                           'value' => 'Kirim Notifikasi Izin Selesai (s|Print)',
                           'class' => 'button-wrc',
                           'id' => 'notif',
                           'onclick' => 'parent.location=\''.site_url('permohonan/sk/notif/'.$tgla.'/'.$tglb.'/'.$key).'\'');
              echo '<div style="text-align:right">'.form_button($notif).'</div>';
            }
       ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
            <th width="15%">Pemohon</th>
            <th width="38%">Jenis Izin<br>Objek Izin/Lokasi Izin</th>
            <th width="20%">Tanggal Penetapan<br>No Surat Keputusan<br>Tanggal Surat Keputusan</th>
            <th width="10%">Status</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          while ($rows = mysql_fetch_assoc(@$results)){
            // //cek Mengisi SKM
            // $isi_skm = $rows['stat_skm'];
            //$isi_skm->where('permohonan_id', $rows['id'])->get();
            //$isi_skm->where('resi', $rows['pendaftaran_id'])->where('flag_skm', 1)->get();
            //$isi_skm->where('resi', $rows['pendaftaran_id'])->get();
            $skm = TRUE;
            $file_skm =  'skm_merah.png';
            $ket_skm = 'Belum Mengisi Survei';
            // if($isi_skm == 1){ //jika ditemukan No id
            //   $skm = TRUE;
            //   $file_skm =  'skm_ijo.png';
            //   $ket_skm = 'Sudah Mengisi Survei';
            // }
            // //EOF() cek Mengisi SKM
            $no_surat = $rows['no_surat'];
            if($rows['no_surat_edit'] == '') {
              $tgl_surat = $rows['tgl_surat'];
            } else {
              $no_surat = $rows['no_surat_edit'];
              $tgl_surat = $rows['tgl_surat_edit'];
            }

            $c_cetak = $rows['c_cetak'];
            if($c_cetak == "0") {
              $b = '<span style="color: Red">';
              $be = '</span>';
            } else {
              $b = '';
              $be = '';
            }
            switch($rows['approve']){
                  //case 1 : $cetakOK = FALSE; $approve = 'Menunggu Approve ESL IV' ; $ky_esl = 'esl4mrh.png';  break;
                  case 1 : $cetakOK = FALSE; $approve = 'Menunggu Approve ESL IV' ; $ky_esl = 'esl4ijo.png';  break;
                  case 4 : $cetakOK = FALSE; $approve = 'Menunggu Approve ESL III'; $ky_esl = 'esl3ijo.png';  break; //esl3mrh.png
                  case 3 : $cetakOK = FALSE; $approve = 'Menunggu Approve Kepala' ; $ky_esl = 'kepalamerah.png';break; //kepalamrh.png
                  case 2 : $cetakOK = TRUE ; $approve = ''                        ; $ky_esl = 'kepalaijo.png';break;
                  default: $cetakOK = FALSE; $approve = 'Menunggu Penguncian Data'; $ky_esl = 'pengolahmrh.png';break;
            }
            
            if($cetakOK && $c_cetak == '0') {
              $b = '<span style="color: Blue">';
              $be = '</span>';
            }
            if(!$skm){
              $b = '<span style="color: Blue">';
              $be = '</span>';
            }
          ?>
            <tr>
              <td valign='top'><?php echo $i; ?></td>
              <td valign='top'>
                <?php
                echo $b.$rows['pendaftaran_id'].$be."<br>";
                if($rows['idjenis'] == '1') $b.$tgl_permohonan = $rows['d_terima_berkas']; 
                  else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                  else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                  else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                  if($tgl_permohonan){
                    if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).$be."<br>";
                  }
                  echo $b.$rows['kd_gerai'].$be;
                ?>
              </td>
              <td valign='top'><?php echo $b.$rows['n_pemohon'].$be; ?></td>
              <td valign='top'><?php echo $b.$rows['n_perizinan']."<br>".$rows['a_izin'].$be;?></td>
              <td valign='top'>
                <?php 
                //echo $b.$this->lib_date->mysql_to_human($rows['tgl_penetapan']).$be."<br>";
                $posisi=strpos($no_surat,"No.KP");
                $ctk_no_surat = $no_surat;
                $ctk_no_surat1 = '';
                if($posisi > 0){
                  $ctk_no_surat = substr($no_surat,0,$posisi);
                  $ctk_no_surat1 = substr($no_surat,$posisi,strlen($no_surat));
                }
                echo $b.$this->lib_date->mysql_to_human($rows['tgl_penetapan']).$be."<br>";
                if($ctk_no_surat1 == ''){
                  echo $b.$no_surat.$be."<br>";
                }else{
                  echo $b.$ctk_no_surat.'<br>'.$ctk_no_surat1.$be.'<br>';
                }
                if($tgl_surat){
                  if($tgl_surat != '0000-00-00') 
                    //if($rows['tg_kyKaPTSP'] == '0000-00-00'){
                      echo $b.$this->lib_date->mysql_to_human($tgl_surat).$be;
                    //}else{  
                      //echo $b.$this->lib_date->mysql_to_human($rows['tg_kyKaPTSP']).$be;
                    //  echo $b.$rows['tg_kyKaPTSP'].$be;
                    //}
                  else
                    echo $b.'-'.$be;
                }else{
                  echo $b.'-'.$be;
                }
                ?>
              </td>
              <td valign='top'>
                <?php
                switch($rows['e_sertifikat']){
                  case 0 : $SE = " 'non SE'"; break;
                  case 1 : $SE = " 'SE BSrE'"; break;
                }
                if($rows['e_ttd'] == 0) echo $b."ttd Basah".'<br>'.$be;
                if($rows['e_ttd'] == 1) echo $b."Templete".$SE.'<br>'.$be;
                if($rows['e_ttd'] == 2) echo $b."Upload".$SE.'<br>'.$be;
                $retribusi = FALSE;
                if($rows['c_status_bayar'] == '1'){
                  $retribusi = TRUE;
                }
                if($skm){
                  if($c_cetak == '0'){
                    //if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  )
                    if($rows['trkelompok_perizinan_id'] === '1' || $rows['trkelompok_perizinan_id'] === '2' || $rows['trkelompok_perizinan_id'] === '5'){
                      echo $b."Belum Dicetak".$be;
                    }else{
                      if($retribusi){
                        echo $b."Belum Dicetak".$be;
                      }else{
                        echo $b."Belum Bayar Retribusi".$be;
                      }
                    }
                  }else{
                    if($rows['e_sertifikat'] == 1 || $retribusi){
                      echo $b."<b>Download ".$c_cetak." kali</b>".$be;
                    }else{
                      echo $b."<b>Dicetak ".$c_cetak." kali</b>".$be;  
                    }
                  }  
                }
                ?>
              </td>
              <td valign='top'>
                <!--<center>-->
                <?php
                $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                   'alt' => 'Lihat Detail',
                                   'title' => 'Lihat Detail',
                                   'border' => '0');
                $img_edit = array('src' => base_url().'assets/images/icon/property.png',
                                   'alt' => 'Edit',
                                   'title' => 'Edit',
                                   'border' => '0');
                $img_cetak = array('src' => base_url().'assets/images/icon/print1.png',
                                   'alt' => 'Cetak Surat Keputusan',
                                   'title' => 'Cetak Surat Keputusan',
                                   'border' => '0');
                $img_preview = array('src' => base_url().'assets/images/icon/print_off.png',
                                   'alt' => 'Cetak Draft Surat Keputusan',
                                   'title' => 'Cetak Draft Surat Keputusan',
                                   'border' => '0');
                $img_cetak_off = array('src' => base_url().'assets/images/icon/'.$ky_esl,
                                   'alt' => 'Cetak SK '.$approve,
                                   'title' => 'Cetak SK '.$approve,
                                   'border' => '0');
                $img_cetak3 = array('src' => base_url().'assets/images/icon/clipboard-doc.png',
                                  'alt' => 'Cetak Izin (Keputusan) (Gubernur)',
                                  'title' => 'Cetak Izin (Keputusan) (Gubernur)',
                                  'border' => '0');
                $img_excel = array('src' => base_url().'assets/images/icon/navigation-down.png',
                                  'alt' => 'Download Data Excel',
                                  'title' => 'Download Data Excel',
                                  'border' => '0');
                $img_warning = array('src' => base_url().'assets/images/icon/wrn.png',
                                  'alt' => 'Approval Menunggu Upload File PDF',
                                  'title' => 'Approval Menunggu Upload File PDF',
                                  'border' => '0');
                $vskm = array('src' => base_url().'assets/images/icon/'.$file_skm,
                              'title' => $ket_skm,
                              'border' => '0');
                                  
                echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/4', img($img_lihat))."&nbsp;";
                echo anchor(site_url('permohonan/sk/cetak_excel') .'/'. $rows['id'], img($img_excel))."&nbsp;";
                // echo img($vskm);
                // kondisi jika berbayar maka sk bisa di cetak jika sudah di bayar
                if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  ){
                    echo '<br>';
                    if($rows['template']!=""){   // jika ditemukan templete dan harus cetak
                      switch($rows['e_ttd']){ 
                        case 0 : // jika ttd Manual
                          //cetak($id_daftar,$jenis,$menu) ($jenis => 0:tanpa templet; 1:dengan templete; $menu => 1:SK 2:Sartek 3:Upload)
                          // if($skm){
                            echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/1/1', img($img_cetak))."&nbsp;"; // ada templet '/1/x'
                          // }
                          break;
                        case 1 : // jika ttd elektronik
                          if(!$cetakOK){     // belum dikunci pengolah
                            echo anchor(site_url('permohonan/sk/cetak_preview').'/'.$rows['id'].'/1', img($img_preview)); // ada templet '/1/x
                            // var_dump(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf'));
                            if(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                              echo '<br>'.img($img_cetak_off)."&nbsp;";
                            } else {
                              //echo '<br>'.img($img_warning)."&nbsp;";
                            }
                            
                          }else{
                            //if (file_exists('assets/esignfile/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                            if($skm){
                              echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/1/1', img($img_cetak))."&nbsp;"; // ada templet '/1/x'
                            }
                            // } else {
                            //   echo "<span style='color : red;'>Dokumen PDF E-Sign Tidak Ditemukan.</span>";
                            // }
                          }
                          break;
                        case 2 : // jika ttd Upload berkas
                          if(!$cetakOK){
                            if(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                              echo img($img_cetak_off)."&nbsp;";
                            } else {
                              //echo img($img_warning)."&nbsp;";
                            }
                          }else{
                            if($skm){
                              echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/1/3', img($img_cetak))."&nbsp;"; // ada templet '/1/x'
                            }
                          }
                          break;
                      }
                    }else{                       // jika tidak ada templete
                      switch($rows['e_ttd']){  
                        case 0 : // jika ttd Manual
                          if (file_exists('assets/esignfile/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                            if($skm){
                              echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/0/1', img($img_cetak))."&nbsp;"; // tdk ada templete '/0/x'
                            }
                          }                         
                          break;
                        case 1 : // jika ttd elektronik
                          $img_cetak_off = array('src' => base_url().'assets/images/icon/print_off.png',
                                                 'alt' => 'Belum Tersedia Templete',
                                                 'title' => 'Belum Tersedia Templete',
                                                 'border' => '0');
                          echo img($img_cetak_off)."&nbsp;";
                          break;
                        case 2 : // jika ttd Upload berkas
                          if(!$cetakOK){
                            if(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                              echo img($img_cetak_off)."&nbsp;";
                            } else {
                              //echo img($img_warning)."&nbsp;";
                            }
                          }else{
                            // echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/1/3', img($img_cetak))."&nbsp;"; // ada templet '/1/x'
                            if (file_exists('assets/esignfile/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                              if($skm){
                                echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/0/1', img($img_cetak))."&nbsp;"; // tdk ada templete '/0/x'
                              }
                            }  else {
                              echo "<span style='color : red;'>Dokumen PDF Tidak Ditemukan.</span>";
                            }
                          }
                          break;
                      }
                    }
                  //}
                }
                $ky_notif = array('src' => 'assets/images/icon/sprint.png',
                                  'title' => 'Kirim Ulang Notifikasi',
                                  'border' => '0');
                $statnotif = $this->lib_date->statNotif($rows['id']);
                //echo $rows['id']."&nbsp;";
                if ($statnotif) {
                  echo anchor(site_url('permohonan/sk/resend_notif').'/'.$rows['id'].'/'.$tgla.'/'.$tglb, img($ky_notif))."&nbsp;";
                }
                ?>
                <!--</center>-->
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<script>
  $(document).ready(function(){
    window.open(url, "_blank"); // will open new tab on document ready
    location.reload();
  });

  function notif(){
    alert("izin ini belum memiliki template Kabad !");
  }

  function notif2(){
    alert("izin ini belum memiliki template Gubernur !");
  }

  function reload1(){
    setTimeout(function(){ window.location = "<?=base_url();?>permohonan/sk/index_next"},700);
  }

  function reload(){
    setTimeout(function(){ window.location = "<?=base_url();?>permohonan/sk"},700);
  }
</script>