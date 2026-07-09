<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php echo form_open('monitoring/perketegori_tertentu'); ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Kategori Pencarian', 'label_pencarian');
    		    echo form_hidden('mark', 'next');
            ?>
    	    </div>
    	    <div id="rightRail">
    	      <?php
            $kat_cari = array('1' => 'NOMOR PENDAFTARAN',
                              '2' => 'NOMOR SK',
                              '3' => 'NAMA PEMOHON',
    		                      '4' => 'NAMA PERUSAHAAN',
    		                      '5' => 'OBJEK IZIN');
            //if($mark == "") {
            //  echo form_dropdown('list_state', $kat_cari, '1', 'class = "input-select-wrc" id="selector"');
            //}else{
            echo form_dropdown('list_state', $kat_cari, $list_state, 'class = "input-select-wrc" id="selector"');
            //}
            ?>
          </div>
        </div>

        <div id="statusRail">
          <div id="leftRail">
            <?php
              echo form_label('Kata Pencarian', 'kt_cari');
            ?>
          </div>
          <div id="rightRail">
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
          </div>
        </div>
        
        <div id="statusRail">
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Cari Data',
                                 'value' => 'Cari Data'
                                );
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php echo form_close(); ?>
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
      //if($group == "4") // Evaluator 
      //$jdl = 'Nomor Surat Keputusan';
      //else
      $jdl = 'Status';
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Asal Pendaftaran<br>No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
              <?php
              if($admin){
                ?>
                <th width="9%">Nomor SK<br>Target Selesai<br>Tanggal Daftar<br>Tanggal Daftar Real</th>
                <?php
              }else{
                ?>
            	  <th width="9%">Nomor SK<br>Target Selesai<br>Tanggal Daftar</th>
                <?php
              }
              ?>
              <!--<th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>-->
            <th width="26%">Jenis Izin</th>
            <th width="25%">Objek Izin</th>
            <th width="13%">Status Sekarang</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $dtclear = '';
          $results = mysql_query($list);
          while ($rows = mysql_fetch_assoc(@$results)){
            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
            $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
            $n_perusahaan = $perusahaan->n_perusahaan;
            $a_perusahaan = $perusahaan->a_perusahaan;
            
            $detail_gis = new dpmptsp_detail_data();
            $detail_gis->where('id_data', $rows['pendaftaran_id'])->get();       // ambil key permohonan
            
            $kelompok = new trkelompok_perizinan_trperizinan();
            $kelompok->where('trperizinan_id', $rows['idizin'])->get();
            $kel_izin = $kelompok->trkelompok_perizinan_id;
            
            $tmpermohonan_tmsk = new tmpermohonan_tmsk();
            $tmpermohonan_tmsk->where('tmpermohonan_id', $rows['id'])->get();
            $tmsk = new tmsk();
            $tmsk->where('id', $tmpermohonan_tmsk->tmsk_id)->get();
            $nomor_sk = $tmsk->no_surat_edit;
            $tgl_sk = $tmsk->tgl_surat_edit;
            
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
                        
            //if($jumlah_entry || $cek_teknis) {
            $red = FALSE;
            $b = '';
            $be = '';
            //}else{
            //$dtclear .= $rows['id'].' ';
            //$red = TRUE;
            //$b = '<span style="color: Red">';
            //$be = '</span>';
            //}
            ?>
            <tr>
              <td valign='top' width="2%"><?php echo $i; ?></td>
              <td valign='top' width="20%"><?php echo $b.$rows['kd_gerai'].'<br>'.$rows['pendaftaran_id'].'<br>'.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be; ?></td>
              <td valign='top' width="9%">
                <?php 
                //echo $b.$rows['pendaftaran_id'].'<br>'.$be;
                //echo $b.$rows['kd_gerai'].'<br>'.$be;
                if($rows['idjenis'] == '1'){ $tgl_permohonan = $rows['d_terima_berkas']; $tgl_permohonan_asli = $rows['d_terima_berkas_asli']; }
                if($rows['idjenis'] == '2'){ $tgl_permohonan = $rows['d_perubahan'];     $tgl_permohonan_asli = '0000-00-00'; }
                if($rows['idjenis'] == '3'){ $tgl_permohonan = $rows['d_perpanjangan'];  $tgl_permohonan_asli = '0000-00-00'; }
                if($rows['idjenis'] == '4'){ $tgl_permohonan = $rows['d_daftarulang'];   $tgl_permohonan_asli = '0000-00-00'; }
                if($tgl_permohonan){
                  if($tgl_permohonan != '0000-00-00')
                  if($admin){
                    echo $b.$nomor_sk.'<br>'.
                            $this->lib_date->mysql_to_human($tgl_sk).'<br>'.
                            $this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.
                            $this->lib_date->mysql_to_human($tgl_permohonan_asli).
                         $be; //$rows['d_selesai_proses']
                  }else{
                    echo $b.$nomor_sk.'<br>'.
                            $this->lib_date->mysql_to_human($tgl_sk).'<br>'.
                            $this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.
                         $be; //$rows['d_selesai_proses']
                  }
                }
                ?>
              </td>
              <!--<td width="9%"><?php echo $rows['no_referensi'];?></td>-->
              <td valign='top' width="26%"><?php echo $b.$rows['n_perizinan'].$be;?></td>
              <td valign='top' width="25%">
                <?php 
                if($rows['keterangan'] == '')
                  echo $b.$rows['a_izin'].$be;
                else
                  echo $b.$rows['a_izin'].'<br>[ Ket : '.$rows['keterangan'].' ]'.$be;
                ?>
              </td>
              <td valign='top' width="13%"><?php
                /*if($jumlah_entry || $cek_teknis) {
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
                	$jdl_icn = 'Edit Data Teknis';
                  }else{
                	$jdl_icn = 'Input Data Teknis';
                  echo $b."Belum di-entry".$be;
                }*/
                if($rows['status_berkas'] == 'proses') {
                  if($kel_izin != '1' && $kel_izin != '3' && $kel_izin != '5' || $rows['kd_status'] <= 1){    // 1,3,5 tanpa tinjauan
                    echo $b.$this->terbilang->cek_status($rows['kd_status']).$be;
                  }else{
                    echo $b.$this->terbilang->cek_status('5').$be;
                  }
                }else{
                  if($rows['desc_arsip'] == '') {
                    $b1 = '<span style="color: Red">';
                    $be1 = '</span>';
                  }else{
                    if($rows['nama_file'] == '') {
                      $b1 = '<span style="color: Blue">';
                      $be1 = '</span>';
                    }else{
                      $b1 = '';
                      $be1 = '';
                    }
                  }
                  echo $b.'- '.$rows['status_berkas'].$be;
                  if($rows['status_berkas'] != 'Izin Ditolak FO') {
                    if($rows['kd_status'] < 7){ 
                      if($rows['c_izin_selesai'] == 1){
                        echo $b.'<br>'.'- '.$this->terbilang->cek_status('9').$be;
                      }else{
                        echo $b.'<br>'.'- '.'Penyusunan Berkas'.$be;
                      }
                    }else{
                      echo $b.'<br>'.'- '.$this->terbilang->cek_status($rows['kd_status']).$be;
                    }
                    echo $b1.'<br>'.'- '.' ARSIP'.$be1;
                  }
                }
                ?>
              </td>
              <td valign='top' width="5%">
                <!--<center>-->
                <?php
                $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                   'alt' => 'Lihat Detail',
                                   'title' => 'Lihat Detail',
                                   'border' => '0',
                                  );
                echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/6', img($img_lihat))."&nbsp;";
                
                $img_kirim = array('src' => base_url().'assets/images/icon/tick.png', 
                                   'alt' => 'Coba kirim data ke BKPM (PBS)',
                                   'title' => 'Coba kirim data ke BKPM (PBS)',
                                   'border' => '0',
                                  );
                
                $img_bukti = array('src' => base_url().'assets/images/icon/clipboard.png', 
                                   'alt' => 'Cetak Bukti Pendaftaran (Khs. Admin)',
                                   'title' => 'Cetak Bukti Pendaftaran (Khs. Admin)',
                                   'border' => '0',
                                  );
                if($id_user == 05) { // Hanya PBS
                  echo anchor(site_url('pelayanan/pendaftaran/cetak_bukti') .'/'. $rows['id'], img($img_bukti))."&nbsp;";
                  echo anchor(site_url('pelayanan/pendaftaran/coba_kirim') .'/'. $rows['id'], img($img_kirim))."&nbsp;";
                }        
                
                $ctk_gis = array('src' => 'assets/images/icon/look.png',
                                 'alt' => 'Lihat Lokasi Visitasi',
                                 'title' => 'Lihat Lokasi Visitasi',
                                 'border' => '0',
                                );
                if($detail_gis->id_data){
                  echo anchor(site_url('survey/view_visit') .'/'.$detail_gis->id_data.'/3', img($ctk_gis));
                }
                
                $confirm_text = 'Apakah Anda yakin akan menghapusnya ?';
                $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                    'alt' => 'Hapus Data',
                                    'title' => 'Hapus Data',
                                    'border' => '0',
                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                   );
                //if($group == "1"){// || $group == "2"){     // utk Admin, supervisor
                if($id_user == 05) { // Hanya PBS
                  echo anchor(site_url('pendataan/delete').'/'.$rows['id'].'/'.'1', img($img_delete))."&nbsp;"; // 1 = asal menu dari monitoring
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