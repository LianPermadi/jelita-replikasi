<div id="content">
  <div class="post"> 
    <div class="title">
      <?php
      if($this->username != 'Guest'){
        echo $this->lib_date->view_title($page_name);
      }else{
        echo 'LIST Dalam Pengembangan '.$this->session->userdata('lokasi').' '.$this->session->userdata('nip');
      }  
      ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Pemakaian</legend>
        <?php
        echo form_open('ruangan');
        $periodeawal_input = array('name'  => 'tgla',
                                   'value' => $tgla,
                                   'class' => 'input-wrc',
                                   'readOnly'=>TRUE,
                                   'class' => 'monbulan'
                                  );
        $periodeakhir_input = array('name'  => 'tglb',
                                    'value' => $tglb,
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'class' => 'monbulan'
                                   );
        $filter_data = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Cari Data',
                             'value' => 'Cari Data'
                            );

        $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Excel'
                                     // 'onclick' => 'window.open(\''.site_url('persuratan/cetak_excel').'\')'
                                    );
      
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Pakai Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Pakai Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();

        // Cetak excel
        // $iduser = $this->session->userdata('id_auth');
        // if ($iduser == 553 || $iduser == 114 || $iduser == 54 || $iduser == 64 ||  $iduser == 563 ||  $iduser == 266 || $iduser == 626) {
        //   echo anchor(site_url('ruangan/print_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
        // }
        // echo form_close();
        if($this->username != 'Guest'){
          echo anchor(site_url('ruangan/print_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
        }  
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
      <?php
    }
    ?>

    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <div class="entry">
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Booking Ruangan',
                        'value' => 'Booking Ruangan',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('ruangan/add').'\')'
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">#ID<br>Nama Ruangan<br>Lokasi<br>Tanggal, Jam</th>
            <th width="15%">Tim<br>Koordinator<br>Ketua Tim<br>Peminjam</th>
            <th width="15%">Acara<br>Kegiatan</th>
            <th width="16%">Target Undangan | Snack | Mamin<br>Keterangan</th>
            <th width="10%">Penanggung Jawab<br> Eviden</th>
            <th width="10%">Dokumen Eviden</th>
            <th width="8%">Presensi</th>
            <th width="8%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $iduser = $this->session->userdata('id_auth');
          $i = 1;
          //Rekapitulasi Mekanisme Presensi
          $id_card =     $this->m_ruangan->count_all_idcard(); 
          $euis_cantik = $this->m_ruangan->count_all_euis();
          $agenda =      $this->m_ruangan->count_all_agenda();
          //EOF() Rekapitulasi Mekanisme Presensi
          
          //$now = $this->lib_date->get_date_now();
          $hari_ini = date('Y-m-d');//$this->lib_date->set_date($now, -1); //date('Y-m-d');
          $jum_Blue=$jumYellow=$jum_Red=$jum_Done=$kirim_notif=$belum_notif=$total=0;
          $id_red = array();
          foreach ($ruangan as $row) { 
        	  $tgl = $row->tanggal.' '.$row->waktu_awal;
            $tanggal = $row->tanggal;
            $waktu_akhir = $row->waktu_akhir;
            $waktu_sekarang = date("G:i:s");
            $target_undangan = $row->target_undangan;
            if($target_undangan == 0){
              $target_undangan = '∅';
            }
            $notulen = FALSE;
            if($row->status_pembatalan == 1 ){
            	$batal = false;//true;
              $b = '<span style="color: Green">';
              $be = '</span>';
              $jumYellow++;
            }else{
            	$batal = false;
              if($tanggal >= $hari_ini) {
                $b = '<span style="color: Blue">';
                $be = '</span>';
                $jum_Blue++;
              }else{
                $id = $row->id;
                $pattern = 'assets/ruangan/notulen/NOTULEN_' . $id . '.pdf';
                $pattern_wildcard = 'assets/ruangan/notulen/NOTULEN_*' . $id . '*.pdf';

                if (file_exists($pattern) || glob($pattern_wildcard)) {
                    $notulen = TRUE;
                    $b = '';
                    $be = '';
                    $jum_Done++;
                } else {
                    $b = '<span style="color: Red">';
                    $be = '</span>';
                    $jum_Red++;
                    if ($row->sts_notif == 0) {
                        $kirim_notif++;
                        array_push($id_red, $row->id);
                    }
                }
              }
            }
            //$tim_kerja = $this->m_ruangan->get_seksi($row->seksi);
            $tim_kerja = $this->m_ruangan->get_tot($row->seksi);
            $koor = $this->m_ruangan->get_koor($row->seksi,'nm'); // tampilkan 1: id pegawai, 2: nama pegawai
            $kt = '-';
            if(!$batal || $row->user_id == $iduser || $this->Aspri || $this->All){
          	?>
            <tr>
              <td valign='top'><?php echo $i; ?></td>
              <td valign='top'>
              	<?php
                $waktu_awal = new DateTime($row->waktu_awal);
                $waktu_akhir = new DateTime($row->waktu_akhir);
              	echo $b."[#".$row->id."]<br>".$this->m_ruangan->get_nama($row->id_ruangan).
              	        "<br> Lantai ".$this->m_ruangan->get_lantai($row->id_ruangan).'<br>'.
              	        $this->lib_date->mysql_to_human($row->tanggal).", ".$waktu_awal->format('H:s')." - ".$waktu_akhir->format('H:s').$be;
              	?>
              </td>
              <td valign='top'><?php echo $b.'<b>'.$tim_kerja.'</b><br>'.$koor."<br>".$kt."<br>".$this->m_ruangan->get_n_user($row->user_id).$be; ?></td>
              <td valign='top'><?php echo $b.$row->acara."<br>".$this->m_ruangan->get_kegiatan($row->kegiatan).$be; ?></td>
              <td valign='top'><?php echo $b.$target_undangan." | ".$row->snack." | ".$row->mamin."<br>".$row->keterangan.$be; ?></td>
              <td valign='top'>
                <?php
                $nn = 1;
                $pegawai = $this->m_ruangan->get_id_user_pic($row->id);
                foreach ($pegawai as $cc) {
                  $nama_pegawai = $this->m_ruangan->get_n_pegawai($cc->id_pegawai);
                  $text = $nn.'. '.$nama_pegawai.'<br>';
                  echo $b.$text.$be;
                  $nn++;
                }
                // if(){

                // }else{

                // }
                ?>
              </td>
              <td valign='top'>
              	<?php
              	//if($row->sts_notif == 0 && $this->All){
              	//	$this->m_ruangan->get_n_user($id);
              	//  echo $b.'Sender '.'Peg'.'<br>'.$be;
              	//}
              	if($row->notulen != ''){
              	  echo $b.$row->notulen.'<br>'.$be;
              	}  
                if($row->status_pembatalan == 0){ 
                	$isFile = False;
                  if(empty($pegawai)){
                    if (file_exists('assets/ruangan/notulen/NOTULEN_'.$row->id.'.pdf')) {
                      $isFile = True;
                      echo '<a href="'.base_url().'ruangan/unduh_notulen/'.$row->id.'">';
                      echo '<img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh Notulensi" title="Unduh Notulensi" border="0">';
                      echo '</a>&nbsp;';
                    } 
                    $isFile = False;
                    if (file_exists('assets/ruangan/undangan/undangan_'.$row->id.'.pdf')) {
                      $isFile = True;
                      echo '<a href="'.base_url().'ruangan/unduh_undangan/'.$row->id.'">';
                      echo '<img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh Undangan" title="Unduh Undangan" border="0">';
                      echo '</a>&nbsp;';
                    } 
                    $isFile = False;
                    if (file_exists('assets/ruangan/dasarsurat/dasar_surat_'.$row->id.'.pdf')) {
                      $isFile = True;
                      echo '<a href="'.base_url().'ruangan/unduh_dasar_surat/'.$row->id.'">';
                      echo '<img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh dasar surat" title="Unduh dasar surat" border="0">';
                      echo '</a>&nbsp;';
                    }
                  }else{
                    foreach($pegawai as $aaa){
                      if(file_exists('assets/ruangan/notulen/NOTULEN_'.$row->id.'_'.$aaa->id_pegawai.'.pdf')){
                        $isFile = True;
                        echo '<a href="'.base_url().'ruangan/unduh_notulen/'.$row->id.'/'.$aaa->id_pegawai.'">';
                        echo '<img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh Notulensi" title="Unduh Notulensi dari '.$this->m_ruangan->get_n_pegawai($aaa->id_pegawai).'" border="0">';
                        echo '</a>&nbsp;';
                      } 
                    }
                  }
                }else{
                  echo $b.'<b>'.'Dibatalkan &nbsp;'.'</b>'.$be;
                }
                ?>
              </td>
              <td valign='top'>
              	<?php
              	echo $b.''.$be;
              	if($row->status_pembatalan == 0){
                	echo anchor_popup(site_url('ruangan/QRview/'.$row->id), '<img src="'.base_url().'assets/images/icon/qrcode2.png" alt="View Link Absensi" title="View Link Absensi" border="0">', 'rel="daftar_box"').'&nbsp;';
                  echo '<a href="'.base_url().'ruangan/view_absen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print.png" alt="Cetak Daftar Hadir" title="View Daftar Hadir" border="0" width="20px" height="20px"></a>&nbsp;';                	
              	  if(!empty($pegawai)){
                    echo '<a href="'.base_url().'ruangan/view_notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation-down.png" alt="Cetak Daftar Eviden" title="View Daftar Eviden" border="0" width="20px" height="20px"></a>&nbsp;';
                  }
                }
                //Rekapitulasi Mekanisme Presensi
                $k_id_card =     $this->m_ruangan->count_idcard($row->id); 
                $k_euis_cantik = $this->m_ruangan->count_euis($row->id);
                $k_agenda =      $this->m_ruangan->count_agenda($row->id);
                //EOF() Rekapitulasi Mekanisme Presensi
                echo '<br>'.$b;
        	      echo 'ID Card : '.number_format($k_id_card, 0).'<br>';
                echo 'EuIS Cantik : '.number_format($k_euis_cantik, 0).'<br>';
                echo 'Agenda : '.number_format($k_agenda, 0);
                echo $be;
              	?>
              </td>
              <td valign='top'>
                <?php
                echo $b;
                if($row->status_pembatalan == 0){
                  if($row->sts_notif != 0){
                    echo '<b>'.$row->sts_notif.' x Notifikasi</b><br>';
                  }
                  if(file_exists('assets/ruangan/notdin/NOTAMAMIN_'.$row->id.'.pdf')) {
                    echo '<a href="'.base_url().'ruangan/unduh_naskah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Unduh Notdin" title="Unduh Notdin" border="0"></a>&nbsp;';
                  }
                  // var_dump($akbar);die();
                  // if($tanggal >= $hari_ini || $this->All || $user == '491'|| $iduser == 560 || $iduser == $row->user_id) { // 491 ID akbar
                    $user_aktif = FALSE;
                    // if($this->All){
                    //   var_dump($pegawai);
                    // }
                    if(!empty($pegawai)){
                      $id_peg = $this->m_ruangan->get_id_pegawai($iduser);
                      foreach ($pegawai as $dd) {
                        // var_dump($id_peg == $dd->id_pegawai);
                        // echo $id_peg. ' == ' .$dd->id_pegawai.'<br>';
                        if($id_peg == $dd->id_pegawai){
                          $user_aktif = TRUE;
                        }
                      }
                    }else{
                      $user_aktif = TRUE;
                    }
                    if($this->All){
                      $user_aktif = TRUE;
                    }
                  //  
                  if($tanggal >= $hari_ini || $this->All || $iduser == $row->user_id || $user_aktif) { // 491 ID akbar
                      $id_peg = $this->m_ruangan->get_id_pegawai($iduser);
                      $id_pic = $this->m_ruangan->get_pic_one($id_peg, $row->id);
                      // var_dump(!empty($id_pic));
                      // var_dump(!empty($id_pic) || $iduser == $row->user_id);
                      if(!empty($id_pic) || $iduser == $row->user_id || $user_aktif){
                      	$img_notulen = array('src' => base_url().'assets/images/icon/navigation.png',
                                             'alt' => 'Upload Notulensi',
                                             'title' => 'Upload Notulensi',
                                             'border' => '0'
                                            );
                        	// echo anchor(site_url('ruangan/notulen/').$row->id, img($img_notulen)).' ';
                          echo '<a href="'.base_url().'ruangan/notulen/'.$row->id.'">
                                <img src="'.base_url().'assets/images/icon/navigation.png" alt="Upload Notulensi" title="Upload Notulensi" border="0"></a>&nbsp;';
                      }

                    // if(intval(str_replace(":","",$waktu_akhir)) <= intval(date("Gis"))) {
                      if(!$isFile) :
                      // echo '<a href="'.base_url().'ruangan/notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation.png" alt="Upload Notulensi" title="Upload Notulensi" border="0"></a>&nbsp;';	
                      endif;
                    // }else{
                      
                      if($this->All || $iduser == 560 || $iduser == $row->user_id) { // posisi tampilkan QRCode // iduser pak feba 560
                        echo '<a href="'.base_url().'ruangan/ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';                  	
                      }	
                    // } 
                  }else{
                    // if(!$isFile) echo '<a href="'.base_url().'ruangan/notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation.png" alt="Upload Notulensi" title="Upload Notulensi" border="0"></a>&nbsp;';
                  }

                  //if(!empty($pegawai)){
                  //  echo '<a href="'.base_url().'ruangan/view_notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation-down.png" alt="Cetak Daftar Hadir" title="View Daftar Hadir" border="0" width="20px" height="20px"></a>&nbsp;';
                  //}
                  //echo '<a href="'.base_url().'ruangan/view_absen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print.png" alt="Cetak Daftar Hadir" title="View Daftar Hadir" border="0" width="20px" height="20px"></a>&nbsp;';
                	//echo anchor_popup(site_url('ruangan/QRview/'.$row->id), '<img src="'.base_url().'assets/images/icon/qrcode2.png" alt="View Link Absensi" title="View Link Absensi" border="0">', 'rel="daftar_box"');
                // }
                }
                if($tanggal >= $hari_ini || $this->All) {
                  if($admin || $user == '563' || $user == '626' || $iduser == $row->user_id ){
                  ?>
                  <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('ruangan/hapus/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
                  <?php
                  }
                }
                echo $be;
                if($this->Aspri || $row->user_id == $iduser || $this->All){
                  echo '';
                  if($row->status_pembatalan == 0){
                ?>              
                <a href="#" onclick="if (confirm('Yakin cancel Data?')) parent.location='<?php echo  site_url('ruangan/cancel/'.$row->id); ?>'"><img src="https://cdn-icons-png.freepik.com/256/8573/8573413.png?semt=ais_hybrid" alt="Cancel" title="Bekukan" border="0" width="20px"></a>&nbsp;
                <?php }elseif($this->All || $this->Aspri){ ?>           
                <a href="#" onclick="if (confirm('Yakin Pulihkan Data?')) parent.location='<?php echo  site_url('ruangan/balikin/'.$row->id); ?>'"><img src="https://cdn.pixabay.com/photo/2022/03/29/06/26/arrows-7098828_1280.png" alt="Cancel" title="Pulihkan" border="0" width="20px"></a>&nbsp;
                <?php }
                } ?>
              </td>
            </tr>
            <?php
            $belum_notif = $jum_Red;
            $total = $i;
            $i++;
            }
          }
          
          //if($iduser == 5 ){
          echo '<div style="text-align:right">';
          if($this->All || $this->Arsiparis || $this->Saparapat){
         	  $notif = array('name' => 'button',
                           'content' => 'Kirim '.$kirim_notif.' Notifikasi Belum Melengkapi Laporan',
                           'value' => 'Kirim '.$kirim_notif.' Notifikasi Belum Melengkapi Laporan',
                           'class' => 'button-wrc',
                           'id' => 'notif',
                           'onclick' => 'parent.location=\''.site_url('ruangan/ruangan/notif').'/'.$jum_Red.'/'.$tgla.'/'.$tglb.'\'');
            
            if($total != 0){
              echo '<span style="color: Red"><b>'.$belum_notif.'/'.$total.' Agenda Belum Melengkapi Laporan </b></span>&nbsp;&nbsp;';
            }
            if($kirim_notif != 0){
              echo form_button($notif);
            } //else{
            //	echo $jum_Red.' Telah Terkirim Notifikasi';
            //}  
            session_start();
            $_SESSION['Data_Notif'] = $id_red;
          }  
          echo '<br><span style="color: Blue"><b>'.'Jumlah Agenda : '.$total.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color: Blue"><b>'.'Belum/Masih Dilaksanakan : '.$jum_Blue.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:  Red"><b>'.'Belum Upload Notulensi : '.$jum_Red.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:Black"><b>'.'Selesai : '.$jum_Done.' </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:Green"><b>'.'Dibatalkan : '.$jumYellow.' </b></span>&nbsp;&nbsp;';
        	if($this->All || $this->Saparapat){
        		echo '<br>';
        	  echo '<span style="color:Black"><b>'.'Total Mekanisme Presensi Scanning ID Card : '.number_format($id_card, 0).', </b></span>&nbsp;&nbsp;';
            echo '<span style="color:Black"><b>'.'APK EuIS Cantik : '.number_format($euis_cantik, 0).', </b></span>&nbsp;&nbsp;';
            echo '<span style="color:Black"><b>'.'Scanning Agenda : '.number_format($agenda, 0).' </b></span>&nbsp;&nbsp;';
          }
          echo '</div>';
          
          ?>      
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>