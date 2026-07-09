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
      if($langkah == 1){
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah Mobil',
                        'value' => 'Tambah Mobil',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/tambahmobil').'\''
                       );
      echo form_button($ctk_list);  
    }
                ?>
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'History User',
                        'value' => 'History User',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/kembali_mobil').'\''
                       );
      echo form_button($ctk_list);
      ?>
      <div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="26%">Nama Mobil<br>Plat Nomor<br>Tahun</th>
            <th width="15%">Jenis<br>Bahan Bakar</th>
            <th width="15%">Tanggal Pinjam</th>
            <th width="15%">Status</th>
            <th width="15%">Kondisi</th>
            <th width="15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
            $no = 1;
            foreach ($peminjamanmobil as $row) {
          ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $row->mobil.' <br> '.$row->mobil.' <br> '.$row->mobil; ?></td>
              <td><?php echo $row->jenis.' <br> '.$row->bahan_bakar; ?></td>
              <td><?php echo $row->kapasitas; ?></td>
              <td><?php 
                      $status = $row->status; 
                      if($status == '1'):
                        echo $akf.'Mobil Tersedia'.$ttp;
                      else :
                        echo $dgr.'Mobil Sedang Digunakan'.$ttp;
                      endif;
                  ?>
              </td>
              <td>
                <?php 
                  $kondisi = $row->kondisi; 
                  if($kondisi == '1'):
                    echo $akf.'Mobil Dalam Kondisi Baik'.$ttp;
                  else:
                    echo $dgr.'Mobil Dalam Perbaikan'.$ttp;
                  endif;
                ?>
              </td>
              <td>
                <?php
              if($langkah == 1){ 
                ?>
                <a href="peminjamanmobil/edit_mobil/<?php echo $row->id; ?>">
                  <img src="https://cdn-icons-png.flaticon.com/512/3597/3597075.png" width="20px" height="20px">
                </a><span> </span>
                <a href="peminjamanmobil/hapus_mobil/<?php echo $row->id; ?>">
                  <img src="https://cdn-icons-png.flaticon.com/512/3687/3687412.png" width="20px" height="20px">
                </a>
                <?php
              }else{
                if($status == '1'){
                ?>
                <a href="peminjamanmobil/pinjam_mobil/<?php echo $row->id; ?>">
                  <button class="button-wrc">
                  Pinjam
                  </button>
                </a>
                <?php
              }
              }
              ?>
              </td>
            </tr>
          <?php
          $no++;
            }
          ?>
        </tbody>
      </table>
      </div>
      <br style="clear: both;" />
    </div>
  </div>
</div>