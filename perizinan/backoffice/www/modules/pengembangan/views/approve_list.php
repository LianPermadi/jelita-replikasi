<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Pemakaian</legend>
        <?php
        echo form_open('pengembangan');
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
                                     // 'onclick' => 'window.open(\''.site_url('pengembangan/cetak_excel').'\')'
                                    );
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Pakai Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Pakai Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
            <!-- <td> <?php echo form_submit($img_cetak_excel);?> </td> -->
          </tr>
        </table>
        <?php
        $iduser = $this->session->userdata('id_auth');
        if ($iduser == 626 ) {
          
            echo anchor(site_url('pengembangan/cetak_excel'),img($img_cetak_excel));
        }
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
      <a href="/jelita/backoffice/pengembangan/add"><button class = 'button-wrc'>Tambah Pengembangan</button></a>
      <br>
      <a href="/jelita/backoffice/pengembangan"><button class='button-wrc'>History</button></a>
      <a href="/jelita/backoffice/pengembangan/list_aa"><button class='button-wrc'>List Permintaan</button></a>
      <a href="/jelita/backoffice/pengembangan/proses"><button class = 'button-wrc'>In Proses</button></a>
      <a href="/jelita/backoffice/pengembangan/uat_list"><button class = 'button-wrc'>Asistensi User</button></a>
      <a href="/jelita/backoffice/pengembangan/selesai"><button class = 'button-wrc'>Selesai</button></a>
      <?php
            if($this->All){
      $ctk_list = array('name' => 'button',
                        'content' => 'Approve Pertimbangan',
                        'value' => 'Approve Pertimbangan',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('pengembangan/approve').'\')'
                       );
      echo form_button($ctk_list);  
                      }
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul Pengembangan</th>
            <th>Deskripsi Pengajuan</th>
            <th>Tanggal</th>
            <th>Tingkat Kebutuhan</th>
            <th>Bidang/TIM</th>
            <th>Nama User</th>
            <th>Status</th>
            <?php
            if($this->All){
            ?>
            <th>Aksi</th>
            <?php
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          $akf = '<span style="color:green;">';
          $dgr = '<span style="color:red;">';
          $wrg = '<span style="color:yellow;">';
          $wrg = '</span>';
          $i = 1;
          foreach ($list_pengembangan as $row) { 
            if($row->status == '0'){
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->isi_pengajuan; ?></td>
              <td><?php echo $row->deskripsi_pengembangan; ?></td>
              <td><?php echo $row->tanggal; ?></td>
              <td><?php 
              if($row->tingkat_kebutuhan == '1'){
              echo 'Lower(Rendah)'; 
              }
              if($row->tingkat_kebutuhan == '2'){
              echo 'Medium(Normal)'; 
              }
              if($row->tingkat_kebutuhan == '3'){
              echo 'High(Tinggi)'; 
              }
              if($row->tingkat_kebutuhan == '4'){
              echo 'Very High(Prioritas)'; 
              }
              ?></td>
              <td><?php echo $row->bidang; ?></td>
              <td><?php 
              $nama_user = $this->m_pengembangan->get_nama_user($row->nama_pengaju);
              echo $nama_user; 
              ?></td>
              <td><?php 
                if ($row->status != '1') {
                  echo 'Menunggu Approve';
                }
              ?></td>
            <?php
            if($this->All){
            ?>
              <td>
                <a href="pengembangan/approve_action/<?php echo $row->id; ?>" onclick="return confirm('Apa Anda Yakin Approve permintaan dari <?php echo $row->nama_pengaju; ?>?')">
                <button class="button-wrc">Approve</button></a>
                <a href="pengembangan/reject_text/<?php echo $row->id; ?>" onclick="return confirm('Apa Anda Yakin Reject permintaan dari <?php echo $row->nama_pengaju; ?>?')">
                <button class="button-wrc">Reject</button>
              </a>
              </td>
            <?php
            }
            ?>
            </tr>
          <?php $i++; }
          }
           ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>