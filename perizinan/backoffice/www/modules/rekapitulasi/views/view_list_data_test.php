<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

    <div class="entry">
      <?php 
      if($gerai=='0') $n_gerai = 'SELURUHNYA'; else $n_gerai = $gerai; 
  	  ?>
      <h2 align="center">
        <?php 
        echo 'DATA PERMOHONAN ' . $katagori;

        switch ($list_kat) {
          case 0:
            $dasar = 'TANGGAL PERMOHONAN';
            break;
          case 1:
            $dasar = 'TANGGAL SELESAI';
            break;
          case 2:
            $dasar = 'TANGGAL PERMOHONAN & TANGGAL SELESAI';
            break;
        }
        
        echo '<br>'.$n_menu . ', BERDASAR '.$dasar.', PERIODE : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
        echo '<br>'.'ASAL PERMOHONAN : '. ($list_state == 0 ? 'SELURUHNYA' : $list_state);
        ?>
      </h2>
      <table align=left>
        <tr>
          <td align="center">
            <?php
            $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                               'alt' => 'Lihat di HTML to Openoffice',
                               'title' => 'Kembali'
                              );
            //echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                             
            
              $img_cetak_pdf = array('src' => base_url().'assets/images/icon/pdf.png',
                                   'alt' => 'Cetak PDF',
                                   'title' => 'Cetak Detail ke PDF'
                                  );
              echo anchor(site_url('rekapitulasi/izin/cetak_list_test').'/'.$tipe_rekap.'/'.$id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/'.$jenis_jumlah, img($img_cetak_pdf));
            
            $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Detail ke Excel'
                                    );
            echo anchor(site_url('rekapitulasi/izin/cetak_list_excel_test').'/'.$tipe_rekap.'/'.$id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/'.$jenis_jumlah, img($img_cetak_excel));
            
            ?>
          </td>
        </tr>
      </table>
      
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="listdataizin">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai<br>Tanggal Selesai</th>
            <th width="22%">Jenis Izin</th>
            <th width="21%">Objek Izin</th>
            <th width="9%">Masa Berlaku<br>Retribusi</th>
            <th width="12%">Status Terakhir</th>
            <th width="3%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $a = 0;
          foreach($result as $list) {
          	$a++;
            $status = '';
            if($list->status_berkas == 'proses') {
              if($list->id_trkel != '1' && $list->id_trkel != '3' && $list->id_trkel != '5')
                $status = $this->terbilang->cek_status($list->kd_status);
              else
                $status = $this->terbilang->cek_status('5');
            }else{
              if($list->desc_arsip == '') {
               $b1 = '<span style="color: Red">';
                $be1 = '</span>';
              }else{
                if($list->nama_file == '') {
                  $b1 = '<span style="color: Blue">';
                  $be1 = '</span>';
                }else{
                  $b1 = '';
                  $be1 = '';
                }
              }
              $status = '- '.$list->status_berkas;
              if($list->status_berkas != 'Izin Ditolak FO') {
                if($list->kd_status < 7){ 
                  if($list->c_izin_selesai == 1){
                    $status .= '<br>'.'- '.$this->terbilang->cek_status('9');
                  }else{
                    $status .= '<br>'.'- '.'Penyusunan Berkas';
                  }
                }else{
                  $status .= '<br>'.'- '.$this->terbilang->cek_status($list->kd_status);
                }
                $status .= $b1.'<br>'.'- '.' ARSIP '.$be1;
              }
            }
            
            $tampil = TRUE;
            if ($list_kat == 2 && $jenis_jumlah == 7) {
              if ($list->tgl_surat_edit >= $tgla && $list->tgl_surat_edit <= $tglb) {
                $tampil = FALSE;
              }
            }

            if ($tampil) {
            ?>
            <tr>
              <td><?php echo $a; ?></td>
              <td><?php echo $list->pendaftaran_id.'<br>'.$list->n_pemohon.'<br>'.$list->n_perusahaan ?></td>
              <td>
                <?php
                //echo $list->kd_gerai.'<br>'.$this->lib_date->mysql_to_human($list->d_terima_berkas).'<br>'.$this->lib_date->mysql_to_human($list->d_selesai_proses);
                if($list->d_selesai_proses < $list->tgl_surat_edit){
                  $c1 = '<span style="color: Red">';
                  $ce1 = '</span>';
                }else{
                  $c1 = '';
                  $ce1 = '';
                }
                echo $list->kd_gerai.'<br>'.$this->lib_date->mysql_to_human($list->d_terima_berkas_asli).'<br>'.$this->lib_date->mysql_to_human($list->d_selesai_proses).'<br>'.$c1.$this->lib_date->mysql_to_human($list->tgl_surat_edit).$ce1;
                ?>
              </td>
              <td><?php echo $list->n_perizinan; ?></td>
              <td><?php echo $list->a_izin; ?> </td>
              <td><?php echo $this->lib_date->mysql_to_human($list->d_berlaku_izin).'<br>'.'';?></td>
              <td><?php echo $status; ?> </td>
              <td>
                <?php
                $img_info = array('src' => base_url().'assets/images/icon/information.png',
                                  'alt' => 'Lihat Detail',
                                  'title' => 'Lihat Detail',
                                  'border' => '0',
                                 );
                echo anchor(site_url('arsip/edit') .'/L/'. $list->tmpermohonan_id.'/3', img($img_info))."&nbsp;";
                ?>
              </td>
            </tr>
            <?php
            }
          }
          ?>
        </tbody>
        <!--<tbody>
          <tr>
            <td colspan="8" align="center">Loading data from server.</td>
          </tr>
        </tbody>-->
      </table>
    </div>
    <div class="entry">
      <table align=left>
        <tr>
          <td align="left">
            <?php
            $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                               'alt' => 'Lihat di HTML to Openoffice',
                               'title' => 'Kembali'
                              );
            //echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
            
            if ($this->session->userdata('id_auth') == 266) {
              $img_cetak = array('src' => base_url().'assets/images/icon/pdf.png',
                               'alt' => 'Cetak',
                               'title' => 'CetaK Detail ke PDF'
                              );
            echo anchor(site_url('rekapitulasi/izin/list_data_test').'/'.$tipe_rekap.'/'.$id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/'.$jenis_jumlah, img($img_cetak));
            
            $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Detail ke Excel'
                                    );
            echo anchor(site_url('rekapitulasi/izin/list_data_test').'/'.$tipe_rekap.'/'.$id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/'.$jenis_jumlah, img($img_cetak_excel));
            }
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>