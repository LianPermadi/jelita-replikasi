<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Booking Ruangan',
                        'value' => 'Booking Ruangan',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('pengembangan/add').'\')'
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">Nama Ruangan</th>
            <th width="23%">Seksi</th>
            <th width="20%">Acara<br>Kegiatan</th>
            <th width="18%">Tanggal<br>Waktu Awal - Waktu Akhir</th>
            <th width="16%">Snack - Mamin<br>Keterangan</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ruangan as $row) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->m_pengembangan->get_nama($row->id_ruangan); ?></td>
              <td><?php echo $this->m_pengembangan->get_seksi($row->seksi); ?></td>
              <td><?php echo $row->acara."<br>".$this->m_pengembangan->get_kegiatan($row->kegiatan); ?></td>
              <td><?php echo $this->lib_date->mysql_to_human($row->tanggal)."<br>".$row->waktu_awal." - ".$row->waktu_akhir; ?></td>
              <td><?php echo $row->snack." - ".$row->mamin."<br>".$row->keterangan; ?></td>
              <td>
                <?php 
                if (file_exists('assets/ruangan/notdin/NOTDIN_'.$row->id.'.pdf')) {
                  echo '<a href="'.base_url().'pengembangan/unduh_naskah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Unduh Notdin" title="Unduh Notdin" border="0"></a>
                 &nbsp;';
               }
                echo '<a href="'.base_url().'pengembangan/ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('pengembangan/hapus/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
              </td>
            </tr>
          <?php $i++; }
           ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>