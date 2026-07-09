<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Surat Awal</legend>
        <?php
        echo form_open('persuratan/penomoran');
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
                        'content' => 'Tambah Surat',
                        'value' => 'Tambah Surat',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('persuratan/add').'\''
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
            <th width="15%">Tanggal Surat<br>Nomor Surat</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          if ($this->Penomoran_surat || $this->All) {
          foreach ($surat as $row) {
            $data_tolak = $this->m_persuratan->get_data_tolak($row->id);

            if (!$data_tolak) {
            if(empty($row->nomor_surat)) {
              $b = "<span style='color : Red;'>";
              $be = "</span>";
            } else {
              $b = "";
              $be = "";
            }
           ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$this->lib_date->mysql_to_human($row->tgl_entry).$be; ?></td>
              <td><?php echo $b.$this->m_persuratan->get_n_user($row->user_id)."<br>".$row->sifat_surat."<br>".$row->lampiran."<br>".$row->hal.$be; ?></td>
              <td><?php echo $b.$row->kepada.$be; ?></td>
              <td><?php echo $b.$this->m_persuratan->get_n_eselon($row->ess2)."<br>".$this->m_persuratan->get_n_eselon($row->sekdis)."<br>".$this->m_persuratan->get_n_eselon($row->ess3)."<br>".$this->m_persuratan->get_n_eselon($row->ess4).$be; ?></td>
              <td><?php echo $b.$this->lib_date->mysql_to_human($row->tgl_surat)."<br>".
                                (empty($row->nomor_surat) ? "Belum penomoran." : $row->nomor_surat).$be; ?>
              </td>
              <td>
                <?php
                if($row->hapus == 1) {
                  echo $b."<span style='color : Red;'>".'AJUKAN HAPUS'."</span>".$be.'<br>';
                }
                if($row->hapus == 0) {
                  echo '<a href="'.base_url().'persuratan/ubah_penomoran/'.$row->id.'"><img src="'.
                       base_url().'assets/images/icon/property.png" alt="Edit Surat" title="Edit Surat" border="0"></a>
                       &nbsp;';
                }
                if ($this->All) {
                  echo '<a href="'.base_url().'persuratan/hapus_penomoran/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Surat Permanen (Admin)" title="Hapus Surat Permanen (Admin)" border="0"></a>'; 
                }
                ?>
                <br>
              </td>
            </tr>
          <?php 
            }
          $i++; }
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>