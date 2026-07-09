<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Berdasarkan Tanggal Permohonan</legend>
        <?php
        echo form_open('pelayanan/komitmen_oss/');
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
            <td> <?php echo 'Tanggal Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
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
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah Data',
                        'value' => 'Tambah Data',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('pelayanan/komitmen_oss/add').'\''
                       );
      echo form_button($ctk_list);  
      ?>
       <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%"><b>PERMOHONAN :<b><br>Fiktif Positif<br>Nomor Permohonan <br>Tanggal Permohonan </th>
            <th width="25%"><b>DATA USAHA: <b><br>NIB - Tanggal NIB<br>SEKTOR - KBLI - Turunan KBLI<br> Jenis Perusahaan - Nama Perusahaan/Perorangan<br> Modal Usaha <br>Alamat <br>Jenis Proyek</th>
            <th width="15%"><b>Nama Perizinan</th>
            <th width="15%">Skala Usaha<br> Tingkat Risiko</th>
            <th width="14%">DATA OPTIONAL <br>No. - Tgl Dokumen <br> NPWP <br>Nomor Telepon <br>Alamat Lokasi Usaha<br>Kab/Kota Lokasi Usaha <br>Naskah Izin / Sertifikat </th>
            <th width="14%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ossrba as $row) { 
          /*  $stat_tolak = $this->m_persuratan->get_data_tolak($row->id);*/
            if($row->warning == 1) {
              $b = '<span style="color: Red">';
              $be = '</span>';
              $c = '<br>Belum di Approve di OSS RBA';
            }else{
              $b = '';
              $be = '';
              $c = '';
            }
       
            ?>
            <tr>
              <td><?php echo  $b.$i; ?></td>
              <td><?php echo  $b.$this->m_ossrba->get_fiktifpositif($row->fiktif_positif)."<br>".$row->nomorpermohonan."<br>".$this->lib_date->mysql_to_human($row->tanggalpermohonan); ?></td>
              <td><?php echo $b.$row->nib." - ".$this->lib_date->mysql_to_human($row->tgl_nib)."<br>".$this->m_ossrba->get_n_sektor($row->sektor)." - ".$row->kbli." - ".$row->turunan_kbli."<br>".$this->m_ossrba->get_jenisperusahaan($row->jenis_perusahaan)." - ".$row->nama_perusahaan."<br>Rp".number_format($row->modal_usaha,0,',','.')."<br>".$row->alamat."<br>".$row->jenis_proyek; ?></td>
              <td><?php echo $b.$this->m_ossrba->get_namaperizinan($row->nama_perizinan); ?></td>
              <td><?php echo $b.$row->skala_usaha."<br>".$this->m_ossrba->get_risiko($row->risiko); ?></td>
              <td><?php echo $b.$row->no_dokumen." - ".$this->lib_date->mysql_to_human($row->tgl_dokumen)."<br>".$row->npwp."<br>".$row->no_telp."<br>".$row->alamat_usaha."<br>".$this->m_ossrba->get_n_kabupaten($row->kab_usaha).$be;   ?></td>
          
              <td>
                <?php 
                // if ($row->approve == 2) {
                //   echo '<a href="'.base_url().'persuratan/unduh/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Cetak Surat" title="Cetak Surat" border="0"></a>
                // &nbsp;';
                // } else {
                //   echo '<a href="'.base_url().'persuratan/unduh_preview/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print_off.png" alt="Preview Surat" title="Preview Surat" border="0"></a>
                // &nbsp;';
                // }
                // if($row->id == 1) {
                //   echo $b.'AJUKAN HAPUS'.$be.'<br>';
                // }
                // if($row->id == 0) {
                //   echo '<a href="'.base_url().'persuratan/ubah/'.$row->id.'"><img src="'.
                //            base_url().'assets/images/icon/property.png" alt="Edit Surat" title="Edit Surat" border="0"></a>
                //            &nbsp;';
                // }
                // if ($this->All) {
                //   echo '<a href="'.base_url().'persuratan/hapus/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Surat Permanen (Admin)" title="Hapus Surat Permanen (Admin)" border="0"></a>'; 
                // }else{
                //  if($row->hapus == 0) {
                //    $confirm_text = $this->session->userdata('username').', Apakah Anda yakin akan ajukan penghapusan '.'?';
                //    $img_delete = array('src' => 'assets/images/icon/cross.png',
                //                         'alt' => 'Ajukan Penghapusan',
                //                         'title' => 'Ajukan Penghapusan',
                //                         'border' => '0',
                //                         'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                //                        );
                //     echo anchor(site_url('persuratan/ajukan_delete')."/".$row->id, img($img_delete))."&nbsp;";
                //   }
                // }  
              
                if($row->esselon == 5){
                  
                      if($row->risiko == 2 || $row->risiko ==3){
                          $confirm_text = $this->session->userdata('username').', Apakah Anda yakin mengirim ke Struktural? '.'?';
                           $img_sent = array('src' => 'assets/images/icon/tick.png',
                                                'alt' => 'Kirim ke Struktural',
                                                'title' => 'Kirim ke Struktural',
                                                'border' => '0',
                                                'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                               );
                            echo anchor(site_url('pelayanan/komitmen_oss/kirim')."/".$row->id, img($img_sent))."&nbsp;";
                        }
                   
                 }
                  if($row->esselon == 1){
                      echo '<img src="'.base_url().'assets/images/icon/esl4mrh.png" alt="Esselon 4" title="Esselon 4" border="0"></a>
                     &nbsp;';
                  }
                if($row->esselon == 4){
                  echo '<img src="'.base_url().'assets/images/icon/esl3mrh.png" alt="Esselon 3" title="Esselon 3" border="0"></a>
                 &nbsp;';
                }               
                if($row->esselon == 3){
                  echo '<img src="'.base_url().'assets/images/icon/kepalamrh.png" alt="Kepala Dinas" title="Kepala Dinas" border="0"></a>
                 &nbsp;';
                }
                 if($row->esselon == 2){              
                        if($this->All){
                          $confirm_text = $this->session->userdata('username').', Apakah Anda yakin sudah Approve di OSS RBA '.'?';
                          $img_delete = array('src' => 'assets/images/icon/selesaijelita.png',
                                        'alt' => 'Kirim Warning',
                                        'title' => 'Kirim Warning',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                           echo anchor(site_url('pelayanan/komitmen_oss/kirimselesai')."/".$row->id, img($img_delete))."&nbsp;";
                        }
                        else{
                             echo '<img src="'.base_url().'assets/images/icon/selesaijelita.png" alt="Kepala Dinas" title="Kepala Dinas" border="0"></a>
                            
                            &nbsp;';
                      }
                }
                if($row->esselon == 9){
                  echo '<img src="'.base_url().'assets/images/icon/Selesaiossrba.png" alt="Selesai" title="Selesai" border="0"></a>
                 &nbsp;';
                }
                if($row->esselon == 0){
                  echo '<img src="'.base_url().'assets/images/icon/chk.png" alt="Kirim ke Struktural" title="Kirim ke Struktural" border="0"></a>
                 &nbsp;';
                }

                if($row->esselon == 2 && $this->All){
                          
                          $confirm_text = $this->session->userdata('username').', Apakah Anda yakin mengirim WARNING '.'?';
                          $img_delete = array('src' => 'assets/images/icon/warningPemohon.png',
                                        'alt' => 'Kirim Warning',
                                        'title' => 'Kirim Warning',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                           echo anchor(site_url('pelayanan/komitmen_oss/kirimwarning')."/".$row->id, img($img_delete))."&nbsp;";
                        
                }

               if($row->esselon != 2 || $this->All){
                echo '<a href="'.base_url().'pelayanan/komitmen_oss/ubah/'.$row->id.'"><img src="'.
                            base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>
                            &nbsp;';

                   $confirm_text = $this->session->userdata('username').', Apakah Anda yakin menghapus data '.'?';
                   $img_delete = array('src' => 'assets/images/icon/cross.png',
                                        'alt' => 'Hapus Data',
                                        'title' => 'Hapus Data',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                    echo anchor(site_url('pelayanan/komitmen_oss/hapus')."/".$row->id, img($img_delete))."&nbsp;";
                  }

                  if($row->warning == 1){
                    $confirm_text = $this->session->userdata('username').', Apakah Anda yakin sudah Approve di OSS RBA '.'?';
                    $img_delete = array('src' => 'assets/images/icon/refresh.png',
                                        'alt' => 'Approve Data',
                                        'title' => 'Approve Data',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                    echo anchor(site_url('pelayanan/komitmen_oss/approveoss')."/".$row->id, img($img_delete))."&nbsp;";
                  }

                   if (file_exists('assets/ossrba/naskah/NASKAH_'.$row->id.'.pdf')) {
                              echo "<br><a href='".base_url()."pelayanan/komitmen_oss/unduh_naskah/".$row->id."' style='color:blue;' target='_blank' title='Unduh Naskah'>NASKAH SIAP</a>&nbsp;"; 
                            }
                                
                    echo $b.$c;
                // echo '<a href="'.base_url().'pajak/hapus/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Pajak Permanen" title="Hapus Pajak Permanen" border="0"></a>'; 
              

                
                // if (!file_exists('assets/pajak/pdfpajak/PAJAK_'.$row->id.'.pdf') || $this->All) {
                //     echo '<a href="'.base_url().'pajak/refresh_pdf/'.$row->id.'"><img src="'.base_url().'assets/images/icon/clipboard.png" alt="Create Naskah" title="Create Naskah PDF" border="0"></a>';
                //   }
                
                ?>
                <br>
                <?php 
                // if ($row->approve != 2) {
                //   switch ($row->approve) {
                //     case 1:
                //       echo '<img src="'.base_url().'assets/images/icon/esl4mrh.png" alt="Cetak Surat Menunggu Approve ESL IV" title="Cetak Surat Menunggu Approve ESL IV" border="0">';
                //       break;
                //     case 4:
                //       echo '<img src="'.base_url().'assets/images/icon/esl3mrh.png" alt="Cetak Surat Menunggu Approve ESL IV" title="Cetak Surat Menunggu Approve ESL III" border="0">';
                //       break;
                //     case 3:
                //       echo '<img src="'.base_url().'assets/images/icon/kepalamrh.png" alt="Cetak Surat Menunggu Approve ESL IV" title="Cetak Surat Menunggu Approve Kepala" border="0">';
                //       break;
                //     default:
                //       echo '<img src="'.base_url().'assets/images/icon/esl4mrh.png" alt="Cetak Surat Menunggu Approve ESL IV" title="Cetak Surat Menunggu Approve ESL IV" border="0">';
                //       break;
                //   }
                // }
                ?>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
  </div>
  </div>
  <br style="clear: both;" />
</div>