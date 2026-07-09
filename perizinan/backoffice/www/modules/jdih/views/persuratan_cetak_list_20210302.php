<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Surat Awal</legend>
        <?php
        echo form_open('persuratan/cetak_surat');
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
            <td> <?php echo 'Tanggal Surat Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Surat Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
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
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Surat</th>
            <th>Nomor Surat</th>
            <th>Pembuat Surat<br>Sifat<br>Lampiran<br>Hal</th>
            <th>Kepada</th>
            <th>Eselon Approve</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          $vesl4 = 0;
          $vesl3 = 0;
          $vskret = 0;
          $vesl2 = 0;
          foreach ($surat as $row) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->lib_date->mysql_to_human($row->tgl_surat); ?></td>
              <td><?php echo $row->nomor_surat; ?></td>
              <td><?php echo $this->m_persuratan->get_n_user($row->user_id)."<br>".$row->sifat_surat."<br>".$row->lampiran."<br>".$row->hal; ?></td>
              <td><?php echo $row->kepada; ?></td>
              <td><?php echo $this->m_persuratan->get_n_eselon($row->ess2)."<br>".$this->m_persuratan->get_n_eselon($row->sekdis)."<br>".$this->m_persuratan->get_n_eselon($row->ess3)."<br>".$this->m_persuratan->get_n_eselon($row->ess4); ?></td>
              <td>
                <?php 
                if ($row->approve == 0) {
                  echo '<a href="'.base_url().'persuratan/unduh/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Cetak Surat" title="Cetak Surat" border="0"></a>
                &nbsp;';
                } else {
                  echo '<a href="'.base_url().'persuratan/unduh_preview/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print_off.png" alt="Preview Surat" title="Preview Surat" border="0"></a>
                &nbsp;';
                
                if (!file_exists('assets/pdf-surat/SRT_'.$row->id.'.pdf') || $this->All) {
                    echo '<a href="'.base_url().'persuratan/refresh_pdf/'.$row->id.'"><img src="'.base_url().'assets/images/icon/clipboard.png" alt="Create Naskah" title="Create Naskah PDF" border="0"></a>';
                  }
                }
                
                // echo '<a href="'.base_url().'persuratan/ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Surat" title="Edit Surat" border="0"></a>
                // &nbsp;';
                // if ($this->All) {
                //   echo '<a href="'.base_url().'persuratan/hapus/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Surat" title="Hapus Surat" border="0"></a>'; 
                // }
                ?>
                <br>
                <?php 
                if ($row->approve != 0) {
                  switch ($row->approve) {
                    case 1:
                      echo '<img src="'.base_url().'assets/images/icon/esl4mrh.png" alt="Cetak Surat Menunggu Approve ESL IV" title="Cetak Surat Menunggu Approve ESL IV" border="0">';
                      $vesl4++;
                      break;
                    case 2:
                      echo '<img src="'.base_url().'assets/images/icon/kepalamrh.png" alt="Cetak Surat Menunggu Approve Kepala" title="Cetak Surat Menunggu Approve Kepala" border="0">';
                      $vesl2++;
                      break;
                    case 3:
                      echo '<img src="'.base_url().'assets/images/icon/sekdismrh.png" alt="Cetak Surat Menunggu Approve Sekretaris Dinas" title="Cetak Surat Menunggu Approve Sekretaris Dinas" border="0">';
                      $vskret++;
                      break;
                    case 4:
                      echo '<img src="'.base_url().'assets/images/icon/esl3mrh.png" alt="Cetak Surat Menunggu Approve ESL III" title="Cetak Surat Menunggu Approve ESL III" border="0">';
                      $vesl3++;
                      break;
                    default:
                      echo '<img src="'.base_url().'assets/images/icon/pengolahmrh.png" alt="Cetak Surat Menunggu Penomoran" title="Cetak Surat Menunggu Penomoran" border="0">';
                      break;
                  }
                }
                ?>
              </td>
            </tr>
            <?php
            $i++;
          }
          echo '<center><b>'.
               'Belum Approve Esl IV : ' .$vesl4.
               '; Esl III : '.$vesl3.
               '; Sekdis : ' .$vskret.
               '; Kadis : '  .$vesl2.
               '</center>';
          ?>
         </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>