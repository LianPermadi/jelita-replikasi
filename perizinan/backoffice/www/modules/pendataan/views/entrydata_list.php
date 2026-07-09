<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <?php //if($kd_auth != 2){ ?>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('pendataan'); ?>
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
    <?php //} ?>
    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Permohonan</legend>
        <?php
        echo form_open('pendataan');
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
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Permohonan Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp&nbsp&nbsp&nbsp&nbsp;</td>
            <td> <?php echo 'Tanggal Permohonan Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp&nbsp&nbsp&nbsp&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div>
    
    <div class="entry">
      <?php
      $user = new user();
      $user->where('username', $this->session->userdata('username'))->get();
      $id_user = $user->id;
      if(isset($warning)) {
        ?>
        <p align="center" style="font-weight: bold; color: red"><?php echo $warning; ?></p>
        <br>
        <?php 
     	}   
      ?>
      <div style="text-align:right">
        <?php
        $ctk_list = array('name' => 'button',
                          'content' => 'Approve Permohonan Pertimbangan Teknis (Multi)',
                          'value' => 'Approve Permohonan Pertimbangan Teknis (Multi)',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\''.site_url('pendataan/cetak_pertek/'.$tgla.'/'.$tglb).'\''
                         );
      	if($kd_filter != 1) echo form_button($ctk_list);
        ?>
      </div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="10%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th width="26%">Jenis Izin</th>
            <th width="26%">Objek Izin</th>
            <th width="10%">Status<br>No Per.Pertek<br>Tgl Per.Pertek</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $dtclear = '';
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
            $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
            $n_perusahaan = $perusahaan->n_perusahaan;
            $a_perusahaan = $perusahaan->a_perusahaan;
            $idproperty = NULL;
            $query_data = "SELECT tmproperty_jenisperizinan_id idproperty
                           FROM tmpermohonan_tmproperty_jenisperizinan
                           WHERE tmpermohonan_id = '".$rows['id']."'";
            $hasil_data = mysql_query($query_data);
            $rows_data = mysql_fetch_object(@$hasil_data);
            @$idproperty = $rows_data->idproperty;
            $entry_data = new tmpermohonan_tmproperty_jenisperizinan();
            $jumlah_entry = $entry_data->where('tmpermohonan_id', $rows['id'])->count();
            // Create PBS
            if($rows['dt_teknis1'] == '') $cek_teknis = FALSE; else $cek_teknis = TRUE;
            // EOF PBS
                        
            if($jumlah_entry || $cek_teknis) {
              $red = FALSE;
              $b = '';
              $be = '';
            }else{
              $dtclear .= $rows['id'].' ';
              $red = TRUE;
              $b = '<span style="color: Red">';
              $be = '</span>';
            }
            if($rows['status_berkas'] != 'Izin Ditolak FO'){ // Khusus tidak ditolak di FO
              ?>
              <tr>
                <td valign='top'><?php echo $no; ?></td>
                <td valign='top'> <?php echo $b.$rows['pendaftaran_id'].'<br>'.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be; ?></td>
                <td valign='top'>
                  <?php 
                  //echo $b.$rows['pendaftaran_id'].'<br>'.$be;
                  echo $b.$rows['kd_gerai'].'<br>'.$be;
                  if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                  if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                  if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                  if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                  if($tgl_permohonan){
                    if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$this->lib_date->mysql_to_human($rows['d_selesai_proses']).$be;
                  }
                  ?>
                </td>
                <td valign='top'><?php echo $b.$rows['n_perizinan'].' <br><b>[ '.strtoupper($rows['n_permohonan']).' ]</b>'.$be;?></td>
                <td valign='top'>
                  <?php 
                  if($rows['keterangan'] == '')
                    echo $b.$rows['a_izin'].$be;
                  else
                    echo $b.$rows['a_izin'].'<br>[ Ket : '.$rows['keterangan'].' ]'.$be;
                  ?>
                </td>
                <td valign='top'>
                  <?php
                  $look = FALSE;
                  $no_pertek = '-';
                  if($jumlah_entry || $cek_teknis) {
                    if($rows['no_per_pertek'] == '') {
                      $look = FALSE;
                      $no_pertek = '-';
                      $no_surat = '';
                      $tgl_surat = '';
                      $approve_per_pertek = 0;
                    }else{
                      $look = TRUE;
                      $no_urut_pertek = $rows['no_per_pertek'];
                      $suratkeluar = new tmsurat_keluar();
                      $suratkeluar->where('tmpermohonan_id', $rows['id'])->where('no_surat', $rows['no_per_pertek'])->get();
                      $no_pertek = $suratkeluar->no_pertek_awal.$suratkeluar->no_surat.$suratkeluar->no_pertek_akhir;
                      $no_surat = $suratkeluar->no_surat;
                      $tgl_surat = $suratkeluar->tgl_surat;
                      $approve_per_pertek = $suratkeluar->approve;
                    }
                    if($rows['tg_per_pertek'] == '0000-00-00 00:00:00') 
                      $tg_pertek = '-';
                    else 
                      $tg_pertek = $this->lib_date->mysql_to_human($rows['tg_per_pertek']);
                    if($rows['id_lama'] <> 0) { // adalah bukan izin baru
                      if($rows['kd_status'] == 0)
                        echo $b."Data Lama".$be;
                      else
                        echo $b."<b>Sudah di-entry</b>".$be;
                    }else{
                      if($group == "4"){ // Evaluator
                        echo $b.$rows['status_berkas'].$be;
                      }else{
                        echo $b."<b>Sudah di-entry</b>".$be;
                      }
                    }
                    echo $b.'<br>'.$no_pertek.'<br>'.$tg_pertek.$be;
                    $jdl_icn = 'Edit Data Teknis';
                  }else{
                  	$jdl_icn = 'Input Data Teknis';
                    echo $b."Belum di-entry".'<br>'.'-'.'<br>'.'-'.$be;
                  }
                  ?>
                </td>
                <td valign='top'>
                  <!--<center>-->
                  <?php

                  //Tampilkan Loading saat klik link
                  $onclick = '';
                  //End tampil loading

                  $img_parent = array('src' => base_url().'assets/images/icon/information.png',
                                      'alt' => 'Data Awal',
                                      'title' => 'Data Awal',
                                      'border' => '0',
                                     );
                                            
                  $img_edit = array('src' => base_url().'assets/images/icon/property.png',
                                    'alt' => $jdl_icn,
                                    'title' => $jdl_icn,
                                    'border' => '0',
                                   );
                  
                  $img_bukti = array('src' => base_url().'assets/images/icon/clipboard.png', 
                                     'alt' => 'Cetak Bukti Pendaftaran',
                                     'title' => 'Cetak Bukti Pendaftaran',
                                     'border' => '0',
                                    );
                                    
                  $approve = ''; $ky_esl = '';
                  if($no_pertek != '-'){
                    $icon = 'print1.png';
                    $text_recom = 'Cetak Permohonan Pertimbangan Teknis';
                    
                    $lok_fileSE = 'assets/file_mohon_sartekSE/';
                    $i_urut = strlen($no_surat);
                    $bcno_urut_pertek = $no_surat;
                    for($i = 5; $i > $i_urut; $i--) {
                      $bcno_urut_pertek = "0" . $bcno_urut_pertek;
                    }
  		              $file = 'PT_'.$bcno_urut_pertek.date("Y",strtotime($tgl_surat)).'.pdf';
                    if(!file_exists($lok_fileSE.$file)){        // cek PDF SE){
                      $icon = 'print_off.png';                              
                      $text_recom = 'Draft Permohonan Pertimbangan Teknis';
                      switch($approve_per_pertek){
                        case 1 : $approve = 'Menunggu Approve ESL IV' ; $ky_esl = 'esl4mrh.png';  break;
                        case 4 : $approve = 'Menunggu Approve ESL III'; $ky_esl = 'esl3mrh.png';  break;
			                  default: $approve = ''                        ; $ky_esl = '';break;
                      }
                    }
                  }else{
                    //Tampilkan Loading saat klik link
                    $onclick = array('onclick'=>"$('#pageloader').fadeIn();");
                    //End tampil loading
                    $icon = 'navigation.png';
                    $text_recom = 'Approve Permohonan Pertimbangan Teknis';
                  }  
                                            
                  $data_jenis = $rows['idjenis'];
                  if($data_jenis == "1") $url_awal = site_url('pelayanan/pendaftaran/edit'); // PBS Edit Permohonan Izin Baru
                  if($data_jenis == "2") $url_awal = site_url ('pendaftaran/edit/2');        // PBS Edit Permohonan Perubahan Izin
                  if($data_jenis == "3") $url_awal = site_url ('pendaftaran/edit/3');        // PBS Edit Permohonan Perpanjangan Izin
                  if($data_jenis == "4") $url_awal = site_url ('pendaftaran/edit/4');        // PBS Edit Permohonan Daftar Ulang Izin
                  
                  if($approve != ''){
                  	$img_cetak_off = array('src' => base_url().'assets/images/icon/'.$ky_esl,
                                           'alt' => 'Cetak Surat '.$approve,
                                           'title' => 'Cetak Surat '.$approve,
                                           'border' => '0',
                                          );
                    echo img($img_cetak_off).'<br>';
                  }  
                                    
                  if($group <> "4"){ // Evaluator
                    echo anchor($url_awal .'/'. $rows['id'] .'/1', img($img_parent))."&nbsp;";
                  }
                  $kd_izin = $rows['trperizinan_id'];
                  // jika trayek (kode 89, 91 dan 92 )ke program perhubungan
                  //if($kd_izin == "89" || $kd_izin == "91" || $kd_izin == "92" ) { 
                  //    echo anchor(site_url().'www/modules/eperizinan/index.php?id='.$rows['tmpermohonan_id'], img($img_edit))."&nbsp;";
                  //} else {  // jika bukan Trayek
                  //echo anchor(site_url('pendataan/edit').'/'.$rows['id'].'/'.$tgla.'/'.$tglb, img($img_edit))."&nbsp;";
                  echo anchor(site_url('pendataan/edit').'/'.$rows['id'].'/'.$look, img($img_edit))."&nbsp;";                               
                  //}
                                    
                  if($group == "1" || $group == "2"){ // Khusus Administrator dan Koordinator
                    echo anchor(site_url('pelayanan/pendaftaran/cetak_bukti') .'/'. $rows['id'], img($img_bukti))."&nbsp;";
                  }else{
                    if($rows['kd_gerai'] == "OnLine"){ // Online
                      echo anchor(site_url('pelayanan/pendaftaran/cetak_bukti') .'/'. $rows['id'], img($img_bukti))."&nbsp;";
                    }
                  }
                  
                  $img_recom = array('src' => base_url().'assets/images/icon/'.$icon,
                                     'alt' => $text_recom,
                                     'title' => $text_recom,
                                     'border' => '0',
                                    );
                  
                  $confirm_text = 'Apakah Anda yakin akan hapus Nomor Pertek ?';
                  $img_del_recom = array('src' => base_url().'assets/images/icon/print2.png',
                                         'alt' => 'Hapus Nomor Permohonan Pertimbangan Teknis',
                                         'title' => 'Hapus Nomor Permohonan Pertimbangan Teknis',
                                         'border' => '0',
                                         'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                        );
                                            
                  $kelompok = new trkelompok_perizinan_trperizinan();
                  $kelompok->where('trperizinan_id', $rows['idizin'])->get();
                  
                  if($group <> "4" && !$red ){
                    if($kelompok->trkelompok_perizinan_id != '1' && $kelompok->trkelompok_perizinan_id != '3' && $kelompok->trkelompok_perizinan_id != '5' // Evaluator dan kelompok tanpa tinjauan lapangan
                    || ($rows['kd_izin'] == '051011' || $rows['kd_izin'] == '051012' || $rows['kd_izin'] == '051013' )){ // Untuk AKDP 
                      echo anchor(site_url('pendataan/print_pertek').'/'.$rows['id'].'/'.$rows['tg_per_pertek'].'/'.$rows['no_per_pertek'], img($img_recom), $onclick)."&nbsp;";
                      if($no_pertek != '-' && $group == "1")
                        echo anchor(site_url('pendataan/del_no_pertek').'/'.$rows['id'].'/'.$rows['tg_per_pertek'].'/'.$rows['no_per_pertek'], img($img_del_recom))."&nbsp;";
                    }
                  }
                  
                  $confirm_text = 'Apakah Anda yakin akan menghapusnya ?';
                  $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                      'alt' => 'Hapus Data',
                                      'title' => 'Hapus Data',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                     );
                  if($group == "1" || $penghapusan == "25"){     // utk Admin, Hapus Data
                    echo anchor(site_url('pendataan/delete') .'/'. $rows['id'], img($img_delete))."&nbsp;";
                  }
                  ?>
                  <!--</center>-->
                </td>
              </tr>
              <?php
            }
            $no++;
          }
          ?>
        </tbody>
      </table>
      <div style="text-align:right">
        <?php
        $ctk_list = array('name' => 'button',
                          'content' => 'Approve Permohonan Pertimbangan Teknis (Multi)',
                          'value' => 'Approve Permohonan Pertimbangan Teknis (Multi)',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\''.site_url('pendataan/cetak_pertek/'.$tgla.'/'.$tglb).'\''
                         );
        if($kd_filter != 1)
          echo form_button($ctk_list);
        ?>
      </div>
    </div>
  </div>
  <br style="clear: both;" />
</div>