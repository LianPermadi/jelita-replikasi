<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal Kedatangan Tamu</legend>
        <?php
        echo form_open('bukutamu/index');
        
        //$asal_permohonan = array('0' => '------ Seluruhnya ------','Pusat' => 'Pusat'); // Untuk daerah lain
        $esselon_id = array('0' => '-------- Seluruhnya --------','1' => 'Esselon 4','4' => 'Esselon 3',
                            '3' => 'Esselon 2','2' => "Selesai Jelita",'9' => 'Selesai OSS RBA','10' => 'Belum Approve Ess.3 di OSSRBA');
        ?>

        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Periode Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan'
                                      );
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
              
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Periode Akhir','d_tahun'); ?> 
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan'
                                       );
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
        
        <?php
        $filter_data = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Cari Data',
                             'value' => 'Cari Data'
                            );
        ?>
        <div id="statusRail">
          <div id="rightRail">
            <?php
            echo form_submit($filter_data);
            // echo form_hidden('kd_filter', '2');
            echo form_close();
            ?>
          </div>
        </div>
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
      $tipe_rekap = "";
      $id = "";
      $jenis_jumlah="";
      $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                               'alt' => 'Cetak Excel',
                               'title' => 'Cetak Detail ke Excel'
                              );
      echo "Export Data Tamu (Excel) <br>";
      echo anchor(site_url('bukutamu/cetak_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
           
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="18%">Tanggal / Jam <br> Nama Tamu <br> Email <br> Handphone</th>
            <th width="17%">Sektor <br> Jenis Izin<br>Jabatan</th>
            <th width="15%">Nama Perusahaan/Instansi<br> NIB  <br> NIK </th>
            <th width="20%">Informasi/ Permasalahan<br>FO / MPP/ Gerai</th>
            <th width="18%">Nama Petugas <br>Solusi <br> Keterangan</th>
            <th width="10%">Aksi</th>
            
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($search as $row) {
          	$tgl = $row->waktu;
          	$jam = $row->waktu;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $tgl.' / '.$jam."<br>".$row->nama."<br>".$row->email."<br>".$row->telepon; ?></td>
              <td><?php echo $this->m_bukutamu->get_n_sektor($row->bidang)."<br>".$row->jenis_izin."<br>".$row->esselon;  ?></td>
              <td><?php echo $row->instansi."<br>".$row->nib."<br>".$row->nik; ?></td>
              <td><?php echo $row->keperluan." <br> ".$row->lokasi; ?></td>
              <td><?php echo $this->m_bukutamu->get_n_user($row->nama_petugas)." <br> ".$row->solusi." <br> ".$row->Keterangan;; ?></td>
              <td>
                <?php 
                echo '<a href="'.base_url().'bukutamu/ubah/'.$row->id.'"><img src="'.
                      base_url().'assets/images/icon/property.png" alt="Edit BukuTamu" title="Edit BukuTamu" border="0"></a>
                      &nbsp;'; 
      
                if ($admin == 1) {
                  $confirm_text = $this->session->userdata('username').', Apakah Anda yakin menghapus data '.'?';
                  $img_delete = array('src' => 'assets/images/icon/cross.png',
                                      'alt' => 'Hapus Data',
                                      'title' => 'Hapus Data',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                     );
                  echo anchor(site_url('bukutamu/hapus/')."/".$row->id, img($img_delete))."&nbsp;";
                }
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