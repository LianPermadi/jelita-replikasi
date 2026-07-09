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
                        'content' => 'Tambah Barang Baru',
                        'value' => 'Tambah Barang Baru',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/addbarang').'\''
                       );
      echo form_button($ctk_list);  
      ?>     
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'List Persediaan',
                        'value' => '',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/barang').'\''
                       );
      echo form_button($ctk_list);  
      ?>    
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'List Permintaan barang',
                        'value' => 'List Permintaan barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/pengajuan').'\''
                       );
      echo form_button($ctk_list);  
      ?>    
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'checkout Barang',
                        'value' => 'checkout Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/checkout').'\''
                       );
      echo form_button($ctk_list);  
      ?>  
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Barang Masuk',
                        'value' => 'Barang Masuk',
                        'style' => 'background:#B0C4DE; color:black;',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                       );
      echo form_button($ctk_list);  
      ?>  

            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Barang Keluar',
                'value' => 'Barang Keluar',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
            );
            echo form_button($ctk_list);
?>
<div>
            <?php
            // $ctk_list = array(
            //     'name' => 'button',
            //     'content' => 'Print',
            //     'value' => 'Barang Kels',
            //     'class' => 'button-wrc',
            //     'onclick' => 'parent.location=\'' . site_url('permintaanbarang/cetak_pengeluaran') . '\''
            // );
            // echo form_button($ctk_list);
            ?>
            <form action="permintaanbarang/cetak_pengeluaran" method="post">
<!--             <select name="bulan">
              <option value="1">Januari</option>
              <option value="2">Februari</option>
              <option value="3">Maret</option>
              <option value="4">April</option>
              <option value="5">Mei</option>
              <option value="6">Juni</option>
              <option value="7">Juli</option>
              <option value="8">Agustus</option>
              <option value="9">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select> -->
            <input type="hidden" name="bulan" value="2023">
              <select name="tahun">
              <?php
              $tahun = date('Y');
                for ($i = 2023; $i <= $tahun; $i++) {
                  ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php
                }
              ?>
              </select>
              <input type="submit" name="simpan" value="Print" class="button-wrc">
            </form>
            <?php
            $tahun_sekarang = date('Y');
            $tahun_depan    = $tahun_sekarang + 1;
            ?>

            <select id="tahunDropdown" onchange="updateData()">
                <option value="">Pilih Tahun</option>
                <?php
                for ($tahun = 2025; $tahun <= $tahun_depan; $tahun++) {
                    echo '<option value="permintaanbarang/update_data/' . $tahun . '">' . $tahun . '</option>';
                }
                ?>
            </select>

            <script>
            function updateData() {
                var url = document.getElementById("tahunDropdown").value;
                if (url) {
                    window.location.href = url;
                }
            }
            </script>
      </div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="46%" colspan="2">Aktivitas</th>
            <th width="15%">Date</th>
            <th width="15%">Sisa Barang</th>
            <th width="15%">Barang Keluar</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $jumlah = 30;
        ?>
          <?php 
          $i = 1;
          $jumlahpermintaan = $jumlah;
          foreach ($barang as $row) { 

            $jumlah_asli = $row->jumlah_asli;
            if($row->merk == 'test 1' && $jumlahpermintaan != 0){
            if($jumlah_asli <= $jumlah){
              $jumlah = $jumlah - $jumlah_asli;
              $jumlahpermintaan = $jumlahpermintaan - $jumlah_asli;
              $jumlah_asli = 0;
            }else{
              $jumlah_asli = $jumlah_asli - $jumlah;
              $jumlahpermintaan = $jumlah - $jumlahpermintaan ;
              if($jumlahpermintaan == 0){
                $jumlah = 0;
            }else{
              $jumlah = $jumlah - $jumlahpermintaan;
              }
              // $jumlah = 0;
            }
          }

            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php 
              $result = preg_replace("/[^0-9]/", "", $row->harga);
              $hasil = $row->jumlah_barang * $result;
              $hasil_rupiah = "IDR " . number_format($hasil,0,',',',');
              echo '<h3>'.$row->log.'</h3>Nama Barang : '.$row->nama_barang.'<br>Merk : '. $row->merk.'<br>Penginput Barang : '.$row->input; ?></td>
              <td><?php echo ' Jumlah : '.$row->jumlah_barang.' '.$row->satuan.'<br> Harga satuan : '.$row->harga.'<br>Harga total : '. $hasil_rupiah ; ?></td>
              <td><center><?php
              	$tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->date)));
          	    $jam = date("H:i:s a", strtotime($row->date));
                echo $row->date;
              	?></center>
              </td>
              <!-- <td><?php echo $jumlah_barang . '<br>'; ?></td> -->
              <td><center><?php 
            echo $row->jumlah_asli.' '.$row->satuan.'<br>';
              // echo $row->jumlah_asli;
            ?></center></td>
            <td><center><?php $jumlah2 = $row->jumlah_barang - $row->jumlah_asli;
            echo $jumlah2.' '.$row->satuan;
            // echo $row->jumlah_asli.'<br>';
            // echo 'JP '.$jumlahpermintaan; 
          ?></center></td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>