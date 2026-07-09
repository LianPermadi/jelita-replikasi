<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Add Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Add jQuery (required for Select2) -->
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

  <!-- Add Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

  <style>
    /* Additional styles if needed */
  </style>
</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
      
      
    <?php
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
        <center>
          <?php echo $alert; ?>
        </center>
      </div>
      <?php
    }

    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
        <center>
          <?php echo $alert; ?>
        </center>
      </div>
      <?php
    }
    ?>
    
    <div class="entry">
      <?php
      if($langkah == '1'){
        $ctk_list = array('name' => 'button',
                          'content' => 'Daftar Barang',
                          'value' => 'Daftar Barang',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan_barang') . '\''
                         );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                          'content' => 'Checkout Barang',
                          'value' => 'Checkout Barang',
                          'class' => 'button-wrc',
                          'style' => 'background:#B0C4DE; color:black;',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout_barang') . '\''
                         );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                         'content' => 'List Permintaan Barang',
                         'value' => 'List Permintaan Barang',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\'' . site_url('permintaanbarang/list_permintaan') . '\''
                        );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                          'content' => 'History Permintaan barang',
                          'value' => 'History Permintaan barang',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/log_permintaan') . '\''
                         );
        echo form_button($ctk_list);
      }elseif ($langkah == '0') {    
        $ctk_list = array('name' => 'button',
                         'content' => 'Tambah Barang Baru',
                         'value' => 'Tambah Barang Baru',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\'' . site_url('permintaanbarang/addbarang') . '\''
                        );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                          'content' => 'List Persediaan',
                          'value' => '',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/barang') . '\''
                         );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                          'content' => 'List Permintaan barang',
                          'value' => 'List Permintaan barang',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan') . '\''
                         );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                          'content' => 'checkout Barang',
                          'value' => 'checkout Barang',
                          'style' => 'background:#B0C4DE; color:black;',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout') . '\''
                         );
        echo form_button($ctk_list);
        $ctk_list = array('name' => 'button',
                         'content' => 'Barang Masuk',
                         'value' => 'Barang Masuk',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                        );
        echo form_button($ctk_list);  
        $ctk_list = array('name' => 'button',
                          'content' => 'Barang Keluar',
                          'value' => 'Barang Keluar',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
                         );
        echo form_button($ctk_list);
      }
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="50%">Nama Barang</th>
            <th width="10%">Merk</th>
            <th width="17%">Jumlah</th>
            <th width="13%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach($barang as $row){
            if($row->status == '2' || $row->status == '3' || $row->status == '4' || $row->status == '5' || $row->status == '6' || $row->status == '7'){
            }else{
              ?>
              <tr>
                <td>
                  <?php echo $i; ?>
                </td>
                <td>
                  <?php echo $row->nama_barang; ?>
                </td>
                <td><center>
                  <?php echo $row->merk; ?></center>
                </td>
                <td><center>
                  <?php $jumlah = $row->jumlah_barang;
                  echo $jumlah; ?> <span> </span> <?php echo $row->satuan; ?></center>
                </td>
                <td><center>
                  <a
                  href="hapus_checkout/<?php echo $row->no_id; ?>/<?php echo $row->jumlah_barang; ?>/<?php echo $row->id_barang; ?>/<?php echo $langkah; ?>"><button
                        class="button-wrc"  onclick="return confirm('Yakin Hapus?')" style="background: red;">Hapus</button></a></center>
                </td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
      <div style="">
        <table>
          <tr>
            <td></td>
            <td width="10%" style="text-align: right;">
              <?php
              if($langkah == '0'): ?>
                <b>Penerima</b>
                <?php
              else: ?>
                <!-- <b>Yang Mengajukan</b> -->
                <?php
              endif
              ?>
            </td>
            <td width="1%">
            <!-- : -->
          </td>
          <td width="25%">
            <?php 
            if($langkah == '0'){
              ?>
              <form method="post" action="<?php echo site_url() . 'permintaanbarang/accept' ?>" enctype="multipart/form-data">
              <input type="hidden" name="langkah" value="0">
              <select class="input-wrc" name="penerima" style="width:100%; background-color:white; border: 2px solid greenyellow;">
                <option value="-">-</option>
                <?php
                foreach ($user as $row) { ?>
                  <option value="<?php echo $row->id; ?>">
                    <?php echo $row->n_pegawai; ?>
                  </option>
                  <?php
                }
                ?>
              </select>
              <?php
            }elseif ($langkah == '1') { ?>
              <form method="post" action="<?php echo site_url() . 'permintaanbarang/accept_barang' ?>" enctype="multipart/form-data">
              <input type="hidden" name="langkah" value="1"><?php 
                // var_dump($pemberi);
                // if ($pemberi->status == '2' || $pemberi->status == '3' || $pemberi->status == '4' || $pemberi->status == '5' || $pemberi->status == '6' || $pemberi->status == '7') {
                // } else { 
                ?>
                <b>
                  <?php echo $pemberi->n_pegawai; ?>
                </b>
                <input type="hidden" name="penerima" value="<?php echo $pemberi->id; ?>">
                <?php 
                // }
            }
            ?>
            <input type="hidden" name="nama_barang" value="<?php
              $no = 1;
              foreach ($barang as $row) {
                echo $no. '. <b>' . ($row->nama_barang . '</b> Merk <b>' . $row->merk . '</b> Dengan Jumlah <b>' . $row->jumlah_barang . ' - ' . $row->satuan . '; </b><br>');
                $no++;
              }
              ?>"
            >
            <input type="hidden" name="loop" value=" <?php
              $no = 1;
              foreach ($barang as $row) {
                echo $no.'^'.$row->nama_barang . '^' . $row->merk . '^' . $row->jumlah_barang . '^' . $row->satuan . '^' . $row->harga;
                $no++;
              }
              ?>"
            >
            <input type="hidden" name="barang" value="
              <?php
              foreach ($barang as $row) {
                // echo $no.'^'.$row->nama_barang . '^' . $row->merk . '^' . $row->jumlah_barang . '^' . $row->satuan . '^' . $row->harga;
                echo $row->nama_barang;
              }
              ?>"
            >                            
            <input type="hidden" name="merk" value=" <?php
              foreach ($barang as $row) {
                echo $row->merk;
              }
              ?>"
            >
                
            <input type="hidden" name="data_barang" value=" <?php
              $no = 1; 
              echo "
              <table border='1' width='100%' style='border-collapse: collapse;'>
              <tr>
              <th>NO</th>
              <th>Nama Barang Spesifikasi</th>
              <th>Jumlah</th>
              <th>Satuan Barang</th>
              <th>Ket</th>
              </tr>
              ";
              foreach ($barang as $row) { 
                echo "
                <tr>
                <td><center>$no</center></td>
                <td><b>$row->nama_barang</b> Dengan Merk <b>$row->merk</b></td>
                <td><center>$row->jumlah_barang</center></td>
                <td><center>$row->satuan</center></td>
                <td></td>
                </tr>
                ";
              } 
              echo "</table>"; 
              $no++; 
              ?>"
            >
                                            
            <input type="hidden" name="jumlah1" value="<?php
              foreach ($barang as $row) {
                echo $row->jumlah_barang;
              }
              ?>"
            >
            <?php
            foreach($barang as $row){
              if($row->status == '2' || $row->status == '3' || $row->status == '4' || $row->status == '5' || $row->status == '6' || $row->status == '7') {
                echo '<input type="hidden" name="null" value="0">';
              }else{
                // var_dump($row->jumlah_barang);die();
                ?>
                <input type="hidden" name="id_barang[]" value="<?php echo $row->id; ?>">
                <input type="hidden" name="jumlah[]" value="<?php echo $row->jumlah_barang; ?>">
                <input type="hidden" name="merkloop[]" value="<?php echo $row->merk; ?>">
                <input type="hidden" name="null" value="1">
                <?php
              }
            }
            // var_dump($pemberi);die();
            echo '<input type="hidden" name="pemberi" value="' . $pemberi->id . '">'; ?>
          </td>
          <td width="10%" style="align-items: center;justify-content: center;">
            <input type="submit" class="button-wrc"
              style="background: greenyellow; color:black; font-size:12px; text-align: left;"
              value=">>> Ajukan Permintaan">
            <?php // echo $langkah; ?>
          </td>
          </form>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<script>
  $(document).ready(function () {
    $('.input-wrc').select2({
      width: '100%',
      theme: 'classic', // or 'bootstrap' or 'default' based on your preference
    });
  });
</script>