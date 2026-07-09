<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Entry Surat Masuk Awal</legend>
        <?php
        echo form_open('persuratan');
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
            <td> <?php echo 'Tanggal Entry Surat Masuk Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Entry Surat Masuk Akhir : '. form_input($periodeakhir_input); ?> </td>
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
                        'content' => 'Entry Surat Masuk',
                        'value' => 'Entry Surat Masuk',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('persuratan/add_masuk').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">Tanggal Entri</th>
            <th width="23%">Pembuat Surat<br>Sifat<br>Lampiran<br>Hal</th>
            <th width="16%">Kepada</th>
            <th width="23%">Eselon Approve</th>
            <th width="15%">Status</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($surat as $row) { 
            $stat_tolak = $this->m_persuratan->get_data_tolak($row->id);
          	if($row->hapus == 1) {
              $b = '<span style="color: Red">';
              $be = '</span>';
            }else{
              $b = '';
              $be = '';
            }?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$this->lib_date->mysql_to_human($row->tgl_entry).$be; ?></td>
              <td><?php echo $b.$this->m_persuratan->get_n_user($row->user_id)."<br>".$row->sifat_surat."<br>".$row->lampiran."<br>".$row->hal.$be; ?></td>
              <td><?php echo $b.$row->kepada.$be; ?></td>
              <td><?php echo $b.$this->m_persuratan->get_n_eselon($row->ess2)."<br>".$this->m_persuratan->get_n_eselon($row->sekdis)."<br>".$this->m_persuratan->get_n_eselon($row->ess3)."<br>".$this->m_persuratan->get_n_eselon($row->ess4).$be; ?></td>
              <td>
                <?php 
                if ($row->revisi == 1) {
                  echo "<span style='color : Red;'>Revisi : ".$row->pesan_revisi."</span>";
                } else {
                  if ($row->approve == 5 && $row->revisi == 0) {
                    echo "<span style='color : Orange;'>Approval Menunggu Penomoran</span>";
                  } else {
                    if (file_exists('assets/docx-surat/SRT_'.$row->id.'.docx')) {
                      echo "<span style='color : Green;'>Naskah DOCX Siap</span>";
                    } elseif($stat_tolak) {
                      echo "<span style='color : Green;'>Naskah Penolakan</span>";
                    } else {
                      echo '<span style="color : Red;">Naskah DOCX Kosong</span>';
                    }
                    // echo (file_exists('assets/docx-surat/SRT_'.$row->id.'.docx') ? "<span style='color : Green;'>Naskah DOCX Siap</span>" : '<span style="color : Red;">Naskah DOCX Kosong</span>');
                    if ((!file_exists('assets/docx-surat/SRT_'.$row->id.'.docx') || $this->All) && !$stat_tolak) {
                      echo '<a href="'.base_url().'persuratan/refresh_docx/'.$row->id.'"><img src="'.base_url().'assets/images/icon/clipboard.png" alt="Create Naskah" title="Create Naskah" border="0"></a>';
                    }
                    echo "<br>";
                    echo (file_exists('assets/pdf-surat/SRT_'.$row->id.'.pdf') ? "<span style='color : Green;'>Naskah PDF Siap</span>" : '<span style="color : Red;">Naskah PDF Kosong</span>');
                    
                  }
                }
                
                 ?>
              </td>
              <td>
                <?php 
                // if ($row->approve == 2) {
                //   echo '<a href="'.base_url().'persuratan/unduh/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Cetak Surat" title="Cetak Surat" border="0"></a>
                // &nbsp;';
                // } else {
                //   echo '<a href="'.base_url().'persuratan/unduh_preview/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print_off.png" alt="Preview Surat" title="Preview Surat" border="0"></a>
                // &nbsp;';
                // }
                if($row->hapus == 1) {
                  echo $b.'AJUKAN HAPUS'.$be.'<br>';
                }
                if($row->hapus == 0) {
                  echo '<a href="'.base_url().'persuratan/ubah/'.$row->id.'"><img src="'.
                           base_url().'assets/images/icon/property.png" alt="Edit Surat" title="Edit Surat" border="0"></a>
                           &nbsp;';
                }
                if ($this->All) {
                  echo '<a href="'.base_url().'persuratan/hapus/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Surat Permanen (Admin)" title="Hapus Surat Permanen (Admin)" border="0"></a>'; 
                }else{
                	if($row->hapus == 0) {
                	  $confirm_text = $this->session->userdata('username').', Apakah Anda yakin akan ajukan penghapusan '.'?';
                	  $img_delete = array('src' => 'assets/images/icon/cross.png',
                                        'alt' => 'Ajukan Penghapusan',
                                        'title' => 'Ajukan Penghapusan',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                    echo anchor(site_url('persuratan/ajukan_delete')."/".$row->id, img($img_delete))."&nbsp;";
                  }
                }  
                
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