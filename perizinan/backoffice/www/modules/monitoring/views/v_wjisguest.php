<head>
  <style>
    /* Style untuk modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    
    /* Style untuk konten modal */
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 70%;
    }
    
    /* Style untuk tombol penutup modal */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
    }
    
    /* Menghilangkan border dari tombol */
    .button-no-border {
      border: none;
      background: none;
      padding: 0;
      cursor: pointer;
    }
    input {
      appearance: none;
      padding: 16px 32px;
      border-radius: 16px;
      background: radial-gradient(circle 12px, white 100%, transparent calc(100% + 1px)) #ccc -16px;
      transition: 0.3s ease-in-out;
    }

    :checked {
      background-color: dodgerBlue;
      background-position: 16px;
    }
  </style>
 
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=KQ3jY54s"></script>
  
</head>

<div id="content">
  <div class="post"> 
  	<div class="title">
 
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1"><strong>Guest (Registrants)</a></li>
        <li><a href="#tabs-2"><strong style="color: red;">Guest (Unconfirm)</a></li>
        <li><a href="#tabs-3"><strong style="color: blue;">Guest (Confirm Process)</a></li>
        <li><a href="#tabs-4"><strong style="color: green;">Guest (Present)</a></li>
        <li><a href="#tabs-5"><strong style="color: green;">Guest (Ceremony)</a></li>
        
        <li><a href="#tabs-6"><strong style="color: green;">Guest (Exhibition)</a></li>
        <li><a href="#tabs-7"><strong style="color: green;">Guest (Talkshow)</a></li>			
        <li><a href="#tabs-8"><strong style="color: brown;">Guest (Not Present)</a></li>
        <li><a href="#tabs-9"><strong>Data Project</a></li>
        <li><a href="#tabs-10"><strong>Data Rundown</a></li>
        <li><a href="#tabs-11"><strong style="color: green;">Guest (one on one meeting)</a></li>

      </ul>
      
      <div id="tabs-1"> <!--Registrants-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Registrants">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</><br>Keterangan</></th>
                <th width="14%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $jum_reg = $jml_unconfirm = $jum_present = $jml_process = $jum_npresent = 0;
              $b0 = '<span style="color: Red">';
              $b1 = '<span style="color: Blue">';
              $b2 = '<span style="color: Green">';
              $b3 = '<span style="color: Brown">';
              $be0 = $be1 = $be2 = $be3 = '</span>';
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
              	$no++;
              	$jum_reg++;
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                switch ($sts) {
                  case 0: // Belum Konfirmasi
                      $jml_unconfirm++;
                      $info = 'BELUM DIKONFIRMASI';
                      $file_QR = date("Y") . 'WJIS_' . $investasi->id . '.png';
                      $file_QR_Path = '/var/www/html/jelita/assets/qrcode_tamu_wjis/' . $file_QR; 
                      if (!file_exists($file_QR_Path)) {
                          $confirm = FALSE;
                          $b = '<span style="color: Red">';
                          $be= '</span>';
                      } else {
                          $confirm = TRUE;
                          $b;
                          $be;
                      }
                      break;
                  case 1: // Proses Konfirmasi
                      $jml_process++;
                      $info = 'DALAM PROSES KONFIRMASI Oleh : '.$data_user->oriname;
                      $b = '<span style="color: Blue">';
                      $be = '</span>';
                      break;
                  case 2: // Akan Hadir
                      $jum_present++;
                      $info = 'AKAN HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                      $b = '<span style="color: Green"><b>';
                      $be = '</b></span>';
                      $confirm = TRUE;

                      break;
                  case 3: // Tidak Hadir
                      $jum_npresent++;
                      $info = 'TIDAK HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                      $b = '<span style="color: Brown">';
                      $be = '</span>';
                      $confirm = TRUE;
                      break;
                  default:
                      $info = 'DEFAULT';
                      $b = '<span style="color: Red">';
                      $be = '</span>';
                      break;
                }
              
                // Pastikan $confirm diinisialisasi
                $confirm = isset($confirm) ? $confirm : FALSE;
                ?>
                <tr>
                  <td valign='top'><?php echo $no; ?></td>
                  <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br>';
                      echo $b.'keterangan : '.$investasi->keterangan.'<br>';
                      echo $b.'Nomer Kursi : '.$investasi->no_kursi.'<br>';

                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                  </td>
                  <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir DPMPTSP'.img($img_edit).$be; 
                      }
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir Bank Indonesia '.img($img_edit).$be; 
                      }
                      ?>
                  </td>
                  <td valign='top'>
                  	<?php
                  	foreach ($data_rowndown as $acara){
                      // Periksa apakah event_id ada dalam data_event_selection
                      foreach($data_event_selection as $event){
                        if($event->project_presentasion_event_id == $acara->id){
                          $no_pp++;
                          //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                          ?>
                          <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                            <tbody id="table-body">
                              <tr>
                                <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                              </tr>  
                            </tbody>
                          </table>
                          <?php
                          break;
                        }
                      }
                    }
                    ?>
                  </td>
                  <td valign='top'><?php
                      foreach ($data_rowndown as $acara){
                        foreach ($data_event_selection_one_on_meeting as $event){
                          if($event->one_on_one_meeting_id == $acara->id){
                          	$no_mm++;
                            //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                  </td>
                  <td valign='top'>
                      <?php
                      // Menampilkan QR code jika konfirmasi tersedia
                      $img_qr = array(
                          'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                          'alt' => 'Unduh QRcode',
                          'title' => 'Unduh QRcode',
                          'style' => 'width:16px',
                          'border' => '0'
                      );
                      if ($confirm) {
                          echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                      }

                      // Menampilkan ikon hapus dengan konfirmasi
                      if($this->All) {
                          $img_delete = array(
                              'src' => 'assets/images/icon/cross.png',
                              'alt' => 'Delete Kehadiran',
                              'title' => 'Delete Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/delete_kehadiran') . '/' . $investasi->id, img($img_delete), array('onclick' => "return confirm('Anda yakin ingin menghapus kehadiran ini?')")) . "&nbsp;";
                      }

                      // Menampilkan ikon edit
                      if($this->All) {
                        $img_edit = array(
                            'src' => 'assets/images/icon/property.png',
                            'alt' => 'Konfirmasi Kehadiran',
                            'title' => 'Konfirmasi Kehadiran',
                            'border' => '0'
                        );
                        echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                      }
                      ?>
                  </td>

                </tr>
                <?php
              }
              ?>
              <div style="display: flex; flex-direction: row; align-items: center;">
                        <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
                            <?php
                              echo '<b>'.'Registrants : '.$jum_reg.', '.
                              $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                              $b1.'Confirm Process : '.$jml_process.', '.$be1.
                              $b2.'Present : '.$jum_present.', '.$be2.
                              $b3.'Not Present : '.$jum_npresent.$be3.
                              '</b><br>';
                              echo '<b>'.
          
                              // $data_event_setting = $this->m_invesment->get_data_event_setting_selection();
                              // var_dump($data_event_setting);die();
                              $b2.'Event Ceremony : '.$jml_ceremony.$be2.' /'.$data_event_setting->jumlah.', '.$be2.
                              $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                              $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                              $b2.'Souvenir DPMPTSP : '.$jml_souvenir[0]->souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
                              $b2.'Souvenir Indonesia : '.$jml_souvenir[0]->souvenir_bank_indonesia.$be2.' /'.$data_event_setting_indonesia->jumlah.', '.$be2.
          
                            //  $b2.'Souvenir Dpmptsp : '.$jum_souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
          
                              '</b>';
                            ?>
                        </div>
                        <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                            <?php 
                            $tipe_rekap = "";
                            $id = "";
                            $jenis_jumlah="";
                            $img_cetak_excel = array(
                                'src' => base_url().'assets/images/icon/excel.png',
                                'alt' => 'Cetak Excel',
                                'title' => 'Cetak Detail ke Excel'
                            );
                            echo "Export Data Tamu Project Presentasion Dan One On One Meeting  (Excel) <br>";
                            echo anchor(site_url('monitoring/wjisguest/export_to_excel_one_on_one_meeting/'), img($img_cetak_excel));
                            ?>
                        </div>
                    </div>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-2"> <!--Unconfirm-->
        <div class="entry">
          
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Unconfirm">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 0) {
                  $info = 'BELUM DIKONFIRMASI';
                  $file_QR = date("Y") . 'WJIS_' . $investasi->id . '.png';
                  $file_QR_Path = '/var/www/html/jelita/assets/qrcode_tamu_wjis/' . $file_QR;
                  if(!file_exists($file_QR_Path)) {
                  	$no++;
                    $confirm = FALSE;
                    $b = '<span style="color: Red">';
                    $be= '</span>';
                  }else{
                    $confirm = TRUE;
                    $b;
                    $be;
                  }
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All) {
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                        }
                        echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        ?>
                    </td>
                  </tr>
                  <?php
                }  
              }
             
              ?>
                <div style="display: flex; flex-direction: row; align-items: center;">
                      <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
                          <?php
                          echo '<b>'.'Registrants : '.$jum_reg.', '.
                          $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                          $b1.'Confirm Process : '.$jml_process.', '.$be1.
                          $b2.'Present : '.$jum_present.', '.$be2.
                          $b3.'Not Present : '.$jum_npresent.$be3.
                          '</b><br>';
                          echo '<b>'.
                          $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                          $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                          $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                          $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                          '</b>';
                          ?>
                      </div>
                      <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                          <?php 
                          $tipe_rekap = "";
                          $id = "";
                          $jenis_jumlah="";
                          $img_cetak_excel = array(
                              'src' => base_url().'assets/images/icon/excel.png',
                              'alt' => 'Cetak Excel',
                              'title' => 'Cetak Detail ke Excel'
                          );
                          echo "Export Data Tamu (Excel) <br>";
                          echo anchor(site_url('monitoring/wjisguest/cetak_excel/0'), img($img_cetak_excel));
                          ?>
                      </div>
                </div>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-3"> <!--Process-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Process">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 1) {
                	$no++;
                  $info = 'DALAM PROSES KONFIRMASI Oleh : '.$data_user->oriname;
                  $b = '<span style="color: Blue">';
                  $be = '</span>';
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir DPMPTSP'.img($img_edit).$be;
                      }
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir Bank Indonesia'.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All) {
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
                }  
              }
              ?>
                   <div style="display: flex; flex-direction: row; align-items: center;">
                      <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
                          <?php
                          echo '<b>'.'Registrants : '.$jum_reg.', '.
                          $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                          $b1.'Confirm Process : '.$jml_process.', '.$be1.
                          $b2.'Present : '.$jum_present.', '.$be2.
                          $b3.'Not Present : '.$jum_npresent.$be3.
                          '</b><br>';
                          echo '<b>'.
                          $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                          $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                          $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                          $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                          '</b>';
                          ?>
                      </div>
                      <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                          <?php 
                          $tipe_rekap = "";
                          $id = "";
                          $jenis_jumlah="";
                          $img_cetak_excel = array(
                              'src' => base_url().'assets/images/icon/excel.png',
                              'alt' => 'Cetak Excel',
                              'title' => 'Cetak Detail ke Excel'
                          );
                          echo "Export Data Tamu (Excel) <br>";
                          echo anchor(site_url('monitoring/wjisguest/cetak_excel/1'), img($img_cetak_excel));
                          ?>
                      </div>
                </div>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-4"> <!--Present-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Present">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="23%">Purpose Of Visit<br>Project Presentation</th>
                <th width="23%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 2) {
                	$no++;
                  $info = 'AKAN HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                  $b = '<span style="color: Green"><b>';
                  $be = '</b></span>';
                  $confirm = TRUE;
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir DPMPTSP '.img($img_edit).$be;
                      }
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir Bank Indonesia'.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All){
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                          if($investasi->status_send_wa_email == 1){
                            $img_email = array('src' => 'assets/images/icon/email.png',
                                               'alt' => 'Send Email Anda Whatsapp',
                                               'title' => 'Send Email Anda Whatsapp',
                                               'border' => '0'
                                              );
                            echo anchor(site_url('monitoring/wjisguest/SendEmailApprove') . '/' . $investasi->id, img($img_email), array('onclick' => "return confirm('Anda yakin ingin mengirimkan notifikasi email ini?')")) . "&nbsp;";
                            $jum_souvenir++;
                            $img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                            echo '<br>';
                            echo $b.$investasi->sum_notif.' x send Notif'.img($img_edit).$be;
                          }else{
                            $img_email = array('src' => 'assets/images/icon/email.png',
                                               'alt' => 'Send Email Anda Whatsapp',
                                               'title' => 'Send Email Anda Whatsapp',
                                               'border' => '0'
                                              );
                            echo anchor(site_url('monitoring/wjisguest/SendEmailApprove') . '/' . $investasi->id, img($img_email), array('onclick' => "return confirm('Anda yakin ingin mengirimkan notifikasi email ini?')")) . "&nbsp;";
                          }
                        ?>
                    </td>
                  </tr>
                  <?php
                }
              }
             
              ?>
                  <div style="display: flex; flex-direction: row; align-items: center;">
                      <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
                          <?php
                         echo '<b>'.'Registrants : '.$jum_reg.', '.
                         $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                         $b1.'Confirm Process : '.$jml_process.', '.$be1.
                         $b2.'Present : '.$jum_present.', '.$be2.
                         $b3.'Not Present : '.$jum_npresent.$be3.
                         '</b><br>';
                          echo '<b>'.
      
                          // $data_event_setting = $this->m_invesment->get_data_event_setting_selection();
                          // var_dump($data_event_setting);die();
                         $b2.'Event Ceremony : '.$jml_ceremony.$be2.' /'.$data_event_setting->jumlah.', '.$be2.
                         $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                         $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                         $b2.'Souvenir DPMPTSP : '.$jml_souvenir[0]->souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
                         $b2.'Souvenir Indonesia : '.$jml_souvenir[0]->souvenir_bank_indonesia.$be2.' /'.$data_event_setting_indonesia->jumlah.', '.$be2.
      
                        //  $b2.'Souvenir Dpmptsp : '.$jum_souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
      
                         '</b>';
                          ?>
                      </div>
                      <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                          <?php 
                          $tipe_rekap = "";
                          $id = "";
                          $jenis_jumlah="";
                          $img_cetak_excel = array(
                              'src' => base_url().'assets/images/icon/excel.png',
                              'alt' => 'Cetak Excel',
                              'title' => 'Cetak Detail ke Excel'
                          );
                          echo "Export Data Tamu (Excel) <br>";
                          echo anchor(site_url('monitoring/wjisguest/cetak_excel/2'), img($img_cetak_excel));
                          ?>
                      </div>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-5"> <!--Ceremony-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Ceremony">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 2 && in_array("Ceremony", $rsvp_data)) {
                	$no++;
                  $info = 'AKAN HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                  $b = '<span style="color: Green"><b>';
                  $be = '</b></span>';
                  $confirm = TRUE;
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      } 
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All){
                            $img_edit = array(
                                'src' => 'assets/images/icon/property.png',
                                'alt' => 'Konfirmasi Kehadiran',
                                'title' => 'Konfirmasi Kehadiran',
                                'border' => '0'
                            );
                            echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              echo '<b>'.'Registrants : '.$jum_reg.', '.
                   $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                   $b1.'Confirm Process : '.$jml_process.', '.$be1.
                   $b2.'Present : '.$jum_present.', '.$be2.
                   $b3.'Not Present : '.$jum_npresent.$be3.
                   '</b><br>';
              echo '<b>'.
                   $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                   $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                   $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                   $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                   '</b>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-6"> <!--Exhibition-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Exhibition">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 2 && in_array("Exhibition", $rsvp_data)) {
                	$no++;
                  $info = 'AKAN HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                  $b = '<span style="color: Green"><b>';
                  $be = '</b></span>';
                  $confirm = TRUE;
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      } 
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All){
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              echo '<b>'.'Registrants : '.$jum_reg.', '.
                   $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                   $b1.'Confirm Process : '.$jml_process.', '.$be1.
                   $b2.'Present : '.$jum_present.', '.$be2.
                   $b3.'Not Present : '.$jum_npresent.$be3.
                   '</b><br>';
              echo '<b>'.
                   $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                   $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                   $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                   $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                   '</b>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-7"> <!--Talkshow-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Talkshow">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 2 && in_array("Talkshow", $rsvp_data)) {
                	$no++;
                  $info = 'AKAN HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                  $b = '<span style="color: Green"><b>';
                  $be = '</b></span>';
                  $confirm = TRUE;
              
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      if($investasi->souvenir_bank_indonesia == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All){
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              echo '<b>'.'Registrants : '.$jum_reg.', '.
                   $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                   $b1.'Confirm Process : '.$jml_process.', '.$be1.
                   $b2.'Present : '.$jum_present.', '.$be2.
                   $b3.'Not Present : '.$jum_npresent.$be3.
                   '</b><br>';
              echo '<b>'.
                   $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                   $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                   $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                   $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                   '</b>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-8">  <!--notPresent-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="notPresent">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</></th>
                <th width="10%">RSVP Information</th>
                <th width="27%">Purpose Of Visit<br>Project Presentation</th>
                <th width="27%">Purpose Of Visit<br>One On One Meeting</th> 
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              $no = $jml_ceremony = $jml_pp = $jum_oom = $jum_exhibition = $jum_talkshow = $jum_souvenir = 0;
              foreach ($data_attedance as $index => $investasi) {
                $sts = $investasi->status;
                $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);
                $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                $rsvp_data = explode(", ", $investasi->RSVP_Information); // Data RSVP_Information dari database
                $no_mm = $no_pp = 0;
                if($sts == 3) {
                	$no++;
                  $info = 'TIDAK HADIR, Dikonfirmasi oleh : '.$data_user->oriname;
                  $b = '<span style="color: Brown">';
                  $be = '</span>';
                  $confirm = TRUE;
                
                  // Pastikan $confirm diinisialisasi
                  $confirm = isset($confirm) ? $confirm : FALSE;
                  ?>
                  <tr>
                    <td valign='top'><?php echo $no; ?></td>
                    <td valign='top'><?php
                      echo $b.'[#'.$investasi->id.'] '.$investasi->full_name.$be;
                      echo '<br>';
                      echo $b.$investasi->address.$be;
                      echo '<br>';
                      echo $b.$investasi->phone_number.$be;
                      echo ' / ';
                      echo $b.$investasi->email.$be;
                      echo '<br>';
                      echo $b.'Position : '.$investasi->position.'<br>'.'Company : '.$investasi->company.', '.$investasi->countries.$be;
                      echo '<br><br>';
                      echo '<b>'.$b.$info.$be.'</b>';
                      ?>
                    </td>
                    <td valign='top'><?php
                      $num = 0;
                  	  foreach($rsvp_data as $value => $label){
                        $num++;
                        echo $b.$num.'. '.$label.$be.'<br>';
                        switch ($label) {
                          case "Ceremony":
                                $jml_ceremony++;
                                break;
                          case "Project Presentation":
                                $jml_pp++;
                                break;
                          case "One On One Meeting":
                                $jum_oom++;
                                break;
                          case "Exhibition":
                                $jum_exhibition++;
                                break;
                          case "Talkshow":
                                $jum_talkshow++;
                                break;    
                          default:
                                break;
                        }
                      }
                      if($investasi->souvenir == 1){
                      	$jum_souvenir++;
                      	$img_edit = array('src'=>'assets/images/icon/tick.png','border'=>'0');
                        echo '<br>';
                        echo $b.'Souvenir '.img($img_edit).$be;
                      }
                      ?>
                    </td>
                    <td valign='top'>
                    	<?php
                    	foreach ($data_rowndown as $acara){
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $no_pp++;
                            //echo $no_pp.'. '.$acara->waktu_start.'-'.$acara->waktu_end.' '.$acara->kegiatan.'<br>';
                            ?>
                            <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                              <tbody id="table-body">
                                <tr>
                                  <td valign='top' width="10%"><?php echo $b.$no_pp.'. '.$be; ?></td>
                                  <td valign='top' width="25%"><?php echo $b.$acara->waktu_start.' - '.$acara->waktu_end.$be; ?></td>
                                  <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                </tr>  
                              </tbody>
                            </table>
                            <?php
                            break;
                          }
                        }
                      }
                      ?>
                    </td>
                    <td valign='top'><?php
                        foreach ($data_rowndown as $acara){
                          foreach ($data_event_selection_one_on_meeting as $event){
                            if($event->one_on_one_meeting_id == $acara->id){
                            	$no_mm++;
                              //echo $no_mm.'. '.$acara->oom_start.'-'.$acara->oom_end.' '.$acara->kegiatan.'<br>';
                              ?>
                              <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                <tbody id="table-body">
                                  <tr>
                                    <td valign='top' width="10%"><?php echo $b.$no_mm.'. '.$be; ?></td>
                                    <td valign='top' width="25%"><?php echo $b.$acara->oom_start.' - '.$acara->oom_end.$be; ?></td>
                                    <td valign='top' width="65%"><?php echo $b.$acara->kegiatan.$be; ?></td>
                                  </tr>  
                                </tbody>
                              </table>
                              <?php
                              break;
                            }
                          }
                        }
                        ?>
                    </td>
                    <td valign='top'>
                        <?php
                        // Menampilkan QR code jika konfirmasi tersedia
                        $img_qr = array(
                            'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                            'alt' => 'Unduh QRcode',
                            'title' => 'Unduh QRcode',
                            'style' => 'width:16px',
                            'border' => '0'
                        );
                        if ($confirm) {
                            echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        } else {
                            // Uncomment jika Anda ingin menampilkan link untuk kondisi konfirmasi tidak ada
                            // echo anchor(site_url('wjisguest/qrcode') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                        }
                  
                        // Menampilkan ikon edit
                        if($this->All){
                          $img_edit = array(
                              'src' => 'assets/images/icon/property.png',
                              'alt' => 'Konfirmasi Kehadiran',
                              'title' => 'Konfirmasi Kehadiran',
                              'border' => '0'
                          );
                          echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
                }  
              }
              echo '<b>'.'Registrants : '.$jum_reg.', '.
                   $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                   $b1.'Confirm Process : '.$jml_process.', '.$be1.
                   $b2.'Present : '.$jum_present.', '.$be2.
                   $b3.'Not Present : '.$jum_npresent.$be3.
                   '</b><br>';
              echo '<b>'.
                   $b2.'Event Ceremony : '.$jml_ceremony.', '.$be2.
                   $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                   $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                   $b2.'Souvenir : '.$jum_souvenir.' '.$be2.
                   '</b>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="tabs-9"> <!--Project-->
        <div id="content">
          <div class="post">
            <div class="entry">
              <div style="display: flex; flex-direction: row; align-items: center;">
                <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                  <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/invesment/create'">Tambah Data</button>
                </div>
              </div>
              <table cellpadding="0" cellspacing="0" border="0" class="display" id="Project">
                <thead>
                  <tr>
                    <th width="2%">No</th>
                    <th width="13%">Judul Investasi</th>
                    <th width="40%">Mini Deskripsi</th>
                    <th width="20%">Lokasi</th>
                    <th width="10%">Long<br>Lat</></th>
                    <th width="10%">Image</th>
                    <th width="5%">Action</th>
                  </tr>
                </thead>
                <tbody id="table-body">
                  <?php
                  foreach ($data as $index => $investasi) {
                    ?>
                    <tr>
                      <td valign='top'><?php echo $index + 1; ?></td>
                      <td valign='top'><?php echo $investasi->judul_investasi; ?></td>
                      <td valign='top'><?php echo $investasi->mini_deskripsi; ?></td>
                      <td valign='top'><?php echo $investasi->lokasi; ?></td>
                      <td valign='top'><?php echo $investasi->long.'<br>'.$investasi->lat; ?></td>
                      <td valign='top'>
                        <button class="openModalBtn" data-modal="<?php echo $index; ?>" style="background-color: transparent; border: 0;">
                          <img src="<?php echo "https://dpmptsp.jabarprov.go.id/investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="100px">
                        </button>
                        <!-- Modal -->
                        <div id="modal<?php echo $index; ?>" class="modal">
                          <div class="modal-content">
                            <span class="close" data-modal="<?php echo $index; ?>">&times;</span>
                            <center>
                              <img src="<?php echo "https://dpmptsp.jabarprov.go.id/investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="1050px">
                            </center>
                          </div>
                        </div> 
                      </td>
                      
                      <td valign='top'>
                          <input type="checkbox" class="izin-checkbox" data-id="<?php echo $investasi->invest_id ?>" <?php echo $investasi->status_content ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <br style="clear: both;" />
          </div>
        </div>
      </div>
      
      <div id="tabs-10">  <!--Rundown-->
        <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="Rundown">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="7%">Mulai - Akhir</th>
                <th width="5%">Durasi</th>
                <th width="60%">Kegiatan</th>
                <th width="19%">Pembicara</th>
                <th width="3%">status</th>
                <th width="3%">Aksi</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
              foreach ($data_rundown as $index => $acara){
              	?>
                <tr>
                  <td valign='top'><?php echo $index + 1; ?></td>
                  <td valign='top' style="text-align: center;"><?php echo $acara->waktu_start.' - '.$acara->waktu_end; ?></td>
                  <td valign='top' style="text-align: center;"><?php echo $acara->durasi; ?></td>
                  <td valign='top'><?php echo $acara->kegiatan; ?></td>
                  <td valign='top'><?php echo $acara->pembicara_talent; ?></td>
                  <td valign='top'><?php echo $acara->status_tampil; ?></td>
                  <td valign='top'><?php echo ''; ?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <div id="tabs-11">  <!--One On One Meeting -->
          <div class="entry">
              <table cellpadding="0" cellspacing="0" border="0" class="display" id="one_on_one_meeting">
                  <thead>
                      <tr>
                          <th width="3%">No</th>
                          <th width="30%">Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</th>
                          <th width="10%">RSVP Information</th>
                          <th width="23%">Purpose Of Visit<br>One On One Meeting</th> 
                          <th width="20%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody id="table-body">
                      <?php
                      $no = $jum_oom = 0;
                      foreach ($data_attedance as $index => $investasi) {
                          $sts = $investasi->status;
                          $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
                          $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
                          $rsvp_data = explode(", ", $investasi->RSVP_Information); 
                          $no_mm = 0;

                          if ($sts == 2 && !empty($data_event_selection_one_on_meeting)) {  // Check if there is One On One Meeting data
                              $no++;
                              $info = 'AKAN HADIR, Dikonfirmasi oleh : ' . $data_user->oriname;
                              $b = '<span style="color: Green"><b>';
                              $be = '</b></span>';
                              $confirm = TRUE;

                              ?>
                              <tr>
                                  <td valign='top'><?php echo $no; ?></td>
                                  <td valign='top'><?php
                                      echo $b . '[#' . $investasi->id . '] ' . $investasi->full_name . $be;
                                      echo '<br>';
                                      echo $b . $investasi->address . $be;
                                      echo '<br>';
                                      echo $b . $investasi->phone_number . $be . ' / ' . $b . $investasi->email . $be;
                                      echo '<br>';
                                      echo $b . 'Position : ' . $investasi->position . '<br>' . 'Company : ' . $investasi->company . ', ' . $investasi->countries . $be;
                                      echo '<br><br>';
                                      echo '<b>' . $b . $info . $be . '</b>';
                                  ?></td>
                                  <td valign='top'>
                                    <?php
                                      $num = 0;
                                      foreach ($rsvp_data as $value => $label) {
                                          $num++;
                                          echo $b . $num . '. ' . $label . $be . '<br>';
                                          switch ($label) {
                                              case "One On One Meeting":
                                                  $jum_oom++;
                                                  break;
                                              default:
                                                  break;
                                          }
                                      }
                                      if ($investasi->souvenir == 1) {
                                          $img_edit = array('src' => 'assets/images/icon/tick.png', 'border' => '0');
                                          echo '<br>' . $b . 'Souvenir DPMPTSP ' . img($img_edit) . $be;
                                      }
                                      if ($investasi->souvenir_bank_indonesia == 1) {
                                          $img_edit = array('src' => 'assets/images/icon/tick.png', 'border' => '0');
                                          echo '<br>' . $b . 'Souvenir Bank Indonesia ' . img($img_edit) . $be;
                                      }
                                    ?>
                                  </td>
                                  <td valign='top'><?php
                                      foreach ($data_rowndown as $acara) {
                                          foreach ($data_event_selection_one_on_meeting as $event) {
                                              if ($event->one_on_one_meeting_id == $acara->id) {
                                                  $no_mm++;
                                                  ?>
                                                  <table style="border-collapse: collapse; border: none;" width="100%" cellpadding="0" cellspacing="0">
                                                      <tbody>
                                                          <tr>
                                                              <td valign='top' width="10%"><?php echo $b . $no_mm . '. ' . $be; ?></td>
                                                              <td valign='top' width="25%"><?php echo $b . $acara->oom_start . ' - ' . $acara->oom_end . $be; ?></td>
                                                              <td valign='top' width="65%"><?php echo $b . $acara->kegiatan . $be; ?></td>
                                                          </tr>  
                                                      </tbody>
                                                  </table>
                                                  <?php
                                                  break;
                                              }
                                          }
                                      }
                                  ?></td>
                                  <td valign='top'><?php
                                      $img_qr = array(
                                          'src' => 'https://cdn-icons-png.flaticon.com/512/1177/1177510.png',
                                          'alt' => 'Unduh QRcode',
                                          'title' => 'Unduh QRcode',
                                          'style' => 'width:16px',
                                          'border' => '0'
                                      );
                                      if ($confirm) {
                                          echo anchor(site_url('monitoring/wjisguest/qrcode_views') . '/' . $investasi->id, img($img_qr)) . "&nbsp;";
                                      }
                                      if($this->All){
                                        $img_edit = array(
                                            'src' => 'assets/images/icon/property.png',
                                            'alt' => 'Konfirmasi Kehadiran',
                                            'title' => 'Konfirmasi Kehadiran',
                                            'border' => '0'
                                        );
                                        echo anchor(site_url('monitoring/wjisguest/edit') . '/' . $investasi->id, img($img_edit)) . "&nbsp;";
                                      }
                                      if ($investasi->status_send_wa_email == 1) {
                                          $img_email = array('src' => 'assets/images/icon/email.png',
                                                            'alt' => 'Send Email Anda Whatsapp',
                                                            'title' => 'Send Email Anda Whatsapp',
                                                            'border' => '0'
                                                            );
                                          echo anchor(site_url('monitoring/wjisguest/SendEmailApprove') . '/' . $investasi->id, img($img_email), array('onclick' => "return confirm('Anda yakin ingin mengirimkan notifikasi email ini?')")) . "&nbsp;";
                                          $img_edit = array('src' => 'assets/images/icon/tick.png', 'border' => '0');
                                          echo '<br>' . $b . $investasi->sum_notif . ' x send Notif' . img($img_edit) . $be;
                                      } else {
                                          $img_email = array('src' => 'assets/images/icon/email.png',
                                                            'alt' => 'Send Email Anda Whatsapp',
                                                            'title' => 'Send Email Anda Whatsapp',
                                                            'border' => '0'
                                                            );
                                          echo anchor(site_url('monitoring/wjisguest/SendEmailApprove') . '/' . $investasi->id, img($img_email), array('onclick' => "return confirm('Anda yakin ingin mengirimkan notifikasi email ini?')")) . "&nbsp;";
                                      }
                                  ?></td>
                              </tr>
                              <?php
                          }
                      }
                      ?>
                      <div style="display: flex; flex-direction: row; align-items: center;">
                        <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
                            <?php
                              echo '<b>'.'Registrants : '.$jum_reg.', '.
                              $b0.'Unconfirm : '.$jml_unconfirm.', '.$be0.
                              $b1.'Confirm Process : '.$jml_process.', '.$be1.
                              $b2.'Present : '.$jum_present.', '.$be2.
                              $b3.'Not Present : '.$jum_npresent.$be3.
                              '</b><br>';
                              echo '<b>'.
          
                              // $data_event_setting = $this->m_invesment->get_data_event_setting_selection();
                              // var_dump($data_event_setting);die();
                              $b2.'Event Ceremony : '.$jml_ceremony.$be2.' /'.$data_event_setting->jumlah.', '.$be2.
                              $b2.'Event Exhibition : '.$jum_exhibition.', '.$be2.
                              $b2.'Event Talkshow : '.$jum_talkshow.', '.$be2.
                              $b2.'Souvenir DPMPTSP : '.$jml_souvenir[0]->souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
                              $b2.'Souvenir Indonesia : '.$jml_souvenir[0]->souvenir_bank_indonesia.$be2.' /'.$data_event_setting_indonesia->jumlah.', '.$be2.
          
                            //  $b2.'Souvenir Dpmptsp : '.$jum_souvenir.$be2.' /'.$data_event_setting_dpmptsp->jumlah.', '.$be2.
          
                              '</b>';
                            ?>
                        </div>
                        <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                            <?php 
                            $tipe_rekap = "";
                            $id = "";
                            $jenis_jumlah="";
                            $img_cetak_excel = array(
                                'src' => base_url().'assets/images/icon/excel.png',
                                'alt' => 'Cetak Excel',
                                'title' => 'Cetak Detail ke Excel'
                            );
                            echo "Export Data Tamu (Excel) <br>";
                            echo anchor(site_url('monitoring/wjisguest/export_to_excel_one_on_one_meeting/'), img($img_cetak_excel));
                            ?>
                        </div>
                    </div>
                  </tbody>
              </table>
          </div>
      </div>

      <br style="clear: both;" />
      
    </div>
  </div>  
</div>  

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('change', function(event) {
      if (event.target.classList.contains('izin-checkbox')) {
        var checkbox = event.target;

        // Mengambil ID dari atribut data-id
        var id = checkbox.getAttribute('data-id');
        // Mengambil status checkbox (1 jika checked, 0 jika unchecked)
        var checked = checkbox.checked ? 1 : 0;

        // Debugging
        console.log('ID:', id);
        console.log('Status Izin:', checked);

        if (id === null) {
          console.error('ID is null');
          return; // Hentikan fungsi jika ID tidak ditemukan
        }

        // URL sesuai dengan pola yang diinginkan
        var url = 'https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/invesment/update_status_content/' + id + '/' + checked;
        console.log('URL:', url); // Debugging URL

        // Mengirim data ke server menggunakan Fetch API
        fetch(url, {
          method: 'POST', // Sesuaikan dengan metode yang dibutuhkan
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'id': id,
            'status': checked
          })
        })
        .then(response => response.text()) // Mengambil respons sebagai teks
        .then(responseText => {
          console.log('Response:', responseText);
          if (responseText === 'success') {
            alert('Status izin telah diperbarui.');
          } else {
            alert('Gagal memperbarui status izin: ' + responseText);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan: ' + error);
        });
      }
    });
  });

</script>

<script>
  // Temukan semua elemen dengan kelas "openModalBtn" dan tambahkan event listener
  var modalBtns = document.querySelectorAll('.openModalBtn');
  
  modalBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
          var modalId = btn.getAttribute('data-modal'); // Dapatkan ID modal dari atribut data-modal
  
          // Temukan modal dengan ID yang sesuai
          var modal = document.getElementById('modal' + modalId);
  
          // Tampilkan modal
          modal.style.display = "block";
  
          // Saat pengguna mengklik tombol penutup, sembunyikan modal
          var closeBtn = modal.querySelector('.close');
          closeBtn.addEventListener('click', function() {
              modal.style.display = "none";
          });
  
          // Saat pengguna mengklik di luar modal, sembunyikan modal
          window.addEventListener('click', function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          });
      });
  });
</script>