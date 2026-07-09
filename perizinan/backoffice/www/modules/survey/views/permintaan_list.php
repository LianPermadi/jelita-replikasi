<div id="content">
  <div class="post"> 
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

<!--     <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Pemakaian</legend>
        <?php
        echo form_open('barang');
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
                                     // 'onclick' => 'window.open(\''.site_url('persuratan/cetak_excel').'\')'
                                    );
      
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Pakai Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Pakai Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();

     

        // Cetak excel
        $iduser = $this->session->userdata('id_auth');
        if ($iduser == 553 || $iduser == 114 || $iduser == 54 || $iduser == 64 ||  $iduser == 563 ||  $iduser == 266 || $iduser == 626) { //
           
            // echo anchor(site_url('persuratan/cetak_excel'),img($img_cetak_excel));
            echo anchor(site_url('barang/print_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
        }


        echo form_close();

        ?>
      </fieldset>
    </div> -->
    
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
                        'content' => 'Booking barang',
                        'value' => 'Booking barang',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('permintaanbarang/add').'\')'
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Nama Label barang</th>
            <th width="20%">Jenis Barang</th>
            <th width="14%">Status</th>
            <th width="15%">Nama<br>Peminjam Barang</th>
            <th width="25%" rowspan="2">Tanggal Peminjam</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $iduser = $this->session->userdata('id_auth');
          $i = 1;
          
          //$now = $this->lib_date->get_date_now();
          $hari_ini = date('Y-m-d');//$this->lib_date->set_date($now, -1); //date('Y-m-d');
          foreach ($permintaan as $row) { 
            // $tgl = $row->tgl_req.' '.$row->req_acc;
            // $tanggal = $row->tgl_req;
            // $waktu_akhir = $row->req_acc;
            // $waktu_sekarang = date("G:i:s");
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->m_permintaan->get_nama($row->label_laptop); ?></td>
              <td><?php echo $this->m_permintaan->get_jenis($row->jenis_laptop); ?></td>
              <td><?php 
              // echo $this->m_permintaan->get_kegiatan($row->status);
              if($row->status == 0){
                echo 'Ready';
              }else{
                echo 'Not Ready';
              }
              ?></td>
              <td><?php echo $this->m_permintaan->get_user($row->user_id); ?></td>
              <td><?php echo $this->lib_date->mysql_to_human($row->tgl_req)."<br>".$row->req_acc." - ".$row->req_acc; ?></td>
              <td>
                <?php
                if(file_exists('assets/barang/notdin/NOTAMAMIN_'.$row->id.'.pdf')) {
                  echo '<a href="'.base_url().'barang/unduh_naskah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Unduh Notdin" title="Unduh Notdin" border="0"></a>
                  &nbsp;';
                }
                $isFile = False;
                if (file_exists('assets/barang/notulen/NOTULEN_'.$row->id.'.pdf')) {
                  $isFile = True;
                  echo '<a href="'.base_url().'barang/unduh_notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh Notulensi" title="Unduh Notulensi" border="0"></a>
                  &nbsp;';
                } 
                if($tanggal >= $hari_ini) {
                  if(intval(str_replace(":","",$waktu_akhir)) <= intval(date("Gis"))) {
                    if(!$isFile) echo '<a href="'.base_url().'barang/notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation.png" alt="Upload Notulensi" title="Upload Notulensi" border="0"></a>&nbsp;'; 
                  }else{
                    echo '<a href="'.base_url().'barang/ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';                   
                    if($this->All) { // posisi tampilkan QRCode
                      echo anchor_popup(site_url('barang/QRview/'.$row->id), '<img src="'.base_url().'assets/images/icon/qrcode2.png" alt="View Link Absen" title="View Link Absen" border="0">', 'rel="daftar_box"');
                    } 
                  } 
                }else{
                  if(!$isFile) echo '<a href="'.base_url().'barang/notulen/'.$row->id.'"><img src="'.base_url().'assets/images/icon/navigation.png" alt="Upload Notulensi" title="Upload Notulensi" border="0"></a>&nbsp;';
                }

                 
                echo '<a href="'.base_url().'barang/cetak_excel/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print.png" alt="Cetak Daftar Hadir" title="Cetak Daftar Hadir" border="0" width="20px" height="20px"></a>&nbsp;';
                
                
                if($tanggal >= $hari_ini || $this->All) {
                  ?>
                  <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('barang/hapus/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
                  <?php
                }
                
                ?>
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