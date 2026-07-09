<div id="content">
  <div class="post"> 
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Pemakaian</legend>
        <?php
        echo form_open('ruangan/detail_list');
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
        $notif = array('name' => 'button',
                       'content' => 'Clear Filter',
                       'value' => 'Clear Filter',
                       'class' => 'button-wrc',
                       'onclick' => 'parent.location=\''.site_url('ruangan/detail_list').'/'.$id_ruang.'/0/0');
        $kembali = array('name' => 'button',
                         'content' => 'Kembali',
                         'value' => 'Kembali',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\''.site_url('ruangan/monitoring'));               
              
        echo form_hidden('kd_filter', '2');
        echo form_hidden('id_ruang', $id_ruang);
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Pakai Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Pakai Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
              <?php
              echo form_submit($filter_data);
              echo form_close();
              ?>
            </td>
            <td>
              <?php
              echo form_open('ruangan/detail_list'.'/'.$id_ruang.'/0/0');
              echo form_submit($notif);
              echo form_close();
              ?>
            </td>
            <td>
              <?php
              echo form_open('ruangan/monitoring');
              echo form_submit($kembali);
              echo form_close();
              ?>
            </td>
          </tr>
        </table>
      </fieldset>
    </div>
 
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="detail_ruang">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="11%">Nama Ruangan<br>Lokasi</th>
            <th width="15%">Tim<br>Koordinator<br>Ketua Tim<br>Peminjam</th>
            <th width="15%">Acara<br>Kegiatan</th>
            <th width="12%">Tanggal<br>Waktu Awal - Waktu Akhir</th>
            <th width="10%">Target Undangan | Snack | Mamin<br>Keterangan</th>
            <th width="15%">Dokumen Eviden</th>
            <th width="10%">Penanggung Jawab<br> Eviden</th>
            <th width="10%">Aksi<br>Mekanisme Presensi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $iduser = $this->session->userdata('id_auth');
          $i = 1;
          $hari_ini = date('Y-m-d');
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
            $tim_kerja = $this->m_ruangan->get_tot($row->seksi);
            $koor = $this->m_ruangan->get_koor($row->seksi,'nm'); // tampilkan 1: id pegawai, 2: nama pegawai
            $kt = '-';
            if(!$batal || $row->user_id == $iduser || $this->Aspri || $this->All){
          	?>
            <tr>
              <td valign='top'><?php echo $i; ?></td>
              <td valign='top'><?php echo $b."[#".$row->id."]<br>".$this->m_ruangan->get_nama($row->id_ruangan)."<br> Lantai ".$this->m_ruangan->get_lantai($row->id_ruangan).$be; ?></td>
              <td valign='top'><?php echo $b.'<b>'.$tim_kerja.'</b><br>'.$koor."<br>".$kt."<br>".$this->m_ruangan->get_n_user($row->user_id).$be; ?></td>
              <td valign='top'><?php echo $b.$row->acara."<br>".$this->m_ruangan->get_kegiatan($row->kegiatan).$be; ?></td>
              <td valign='top'><?php echo $b.$this->lib_date->mysql_to_human($row->tanggal)."<br>".$row->waktu_awal." - ".$row->waktu_akhir.$be; ?></td>
              <td valign='top'><?php echo $b.$target_undangan." | ".$row->snack." | ".$row->mamin."<br>".$row->keterangan.$be; ?></td>
              <td valign='top'>
              	<?php 
              	if($row->notulen != ''){
              	  echo $b.$row->notulen.'<br>'.$be;
              	}  
                $pegawai = $this->m_ruangan->get_id_user_pic($row->id);
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
                  $nn = 1;
                  foreach ($pegawai as $cc) {
                      $nama_pegawai = $this->m_ruangan->get_n_pegawai($cc->id_pegawai);
                      $text = $nn.'. '.$nama_pegawai.'<br>';
                      echo $b.$text.$be;
                      $nn++;
                  } 
                ?>
              </td>
              <td valign='top'>
                <?php
                echo $b;
                if($row->status_pembatalan == 0){
                  if($row->sts_notif != 0){
                    echo '<b>'.$row->sts_notif.' x Notifikasi</b><br>';
                  }
                  echo '<a href="'.base_url().'ruangan/view_absen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print.png" alt="Cetak Daftar Hadir" title="View Daftar Hadir" border="0" width="20px" height="20px"></a>&nbsp;';
                }
                echo $be;
                //Rekapitulasi Mekanisme Presensi
          	    $id_card =     $this->m_ruangan->count_idcard($row->id);
                $euis_cantik = $this->m_ruangan->count_euis($row->id);
          	    $agenda =      $this->m_ruangan->count_agenda($row->id);
          	    //EOF() Rekapitulasi Mekanisme Presensi
                echo '<br>';
                echo 'Scanning ID Card : '.$id_card.'<br>';
                echo 'APK EuIS Cantik : '.$euis_cantik.'<br>';
                echo 'Scanning Kegiatan : '.$agenda.'<br>';  
                ?>
              </td>
            </tr>
            <?php
            $belum_notif = $jum_Red;
            $total = $i;
            $i++;
            }
          }
          
          echo '<div style="text-align:right">';
          if($this->All || $this->Arsiparis){
            if($total != 0){
              echo '<span style="color: Red"><b>'.$belum_notif.'/'.$total.' Agenda Belum Melengkapi Laporan </b></span>&nbsp;&nbsp;';
            }
          }  
          echo '<br><span style="color: Blue"><b>'.'Jumlah Agenda : '.$total.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color: Blue"><b>'.'Belum/Masih Dilaksanakan : '.$jum_Blue.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:  Red"><b>'.'Belum Upload Notulensi : '.$jum_Red.', </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:Black"><b>'.'Selesai : '.$jum_Done.' </b></span>&nbsp;&nbsp;';
        	echo '<span style="color:Green"><b>'.'Dibatalkan : '.$jumYellow.' </b></span>&nbsp;&nbsp;';
          echo '</div>';
          ?>      
        </tbody>
      </table>
    </div>
  </div>
</div>