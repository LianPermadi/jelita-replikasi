<style type="text/css">

button{
  color: blue;
}

.dropbtn {
  background-color: #4CAF50;
  color: blue;
  font-size: 12px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
/*  color: blue;*/
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  color: #3e8e41;
}

.text{
  color: navy;
}

.text:hover{
  'test';
}
</style>
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
                        'style' => 'background:#B0C4DE; color:black;',
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
    <div id="barang">
      <?php
            // var_dump($ss);die();
            if($ss == '2' ||$ss == '1'){
      $ctk_list = array('name' => 'button',
                        'content' => '<< Back',
                        'value' => '<< Back',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/barang').'\''
                       );
      echo form_button($ctk_list); 
      } else {

      }
      ?>   
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Barang</th>
            <th width="8%">Merk</th>
            <th width="5%">Jumlah</th>
            <th width="10%">Kategory</th>
            <th width="5%">Penyimpanan</th>
            <th width="10%">Di Input</th>
            <th width="8%">CreatedAt</th>
            <th width="12%">Info</th>
            <!-- <th width="8%">harga</th> -->
            <th width="3%">Keranjang</th>
            <th width="12%" colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($barang as $row) { 
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php 
              if ($ss == '0' || $ss == '1') { ?>
                                      <a href="/jelita/backoffice/permintaanbarang/search_barang/<?php echo $row->nama_barang; ?>/0"><?php echo $row->nama_barang; ?></a>
                                    <?php }else{ 
                                      echo $row->nama_barang;
                                    } 
                                    ?>

                                </td>
              <td><center><?php 
              if(!empty($row->merk)){ ?>

                                      <?php 
                                                  $options = array(
                                                                        '<p>
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/permintaanbarang/views/barang/'.$row->foto.'" style="max-width: 300px; max-height: 200px;">
                    </p>
                    <p>Nama Barang : '.$row->nama_barang.'</p>
                    <p>Merk : '.$row->merk.'</p>
                    <p>Stok : '.$row->jumlah.'</p>'
                                                  );
                                                  ?><center>
                                                  <div class="dropdown">
                                                      <button class="dropbtn" style="background: transparent; border-color: transparent;" disable><?php echo $row->merk; ?></button>
                                                      <div class="dropdown-content">
                                                  <?php
                                                  foreach($options as $option) {
                                                      echo '<p><center>' . $option . '</center></p>';
                                                    }
                                                    ?>
                                                </div>
              <?php  }else{
                  echo '-';
                }?></center></td>
              <td><center><span><?php echo $row->jumlah; ?> <?php echo $row->satuan; ?></span></center></td>
              <td><center><span><?php 
              $kategori = $this->m_barang->get_kategori($row->kategori); 
              echo '<a href="/jelita/backoffice/permintaanbarang/search/'.$row->kategori.'/0">'.$kategori.'</a>';
              ?></span></center></td>
              <td><center><?php echo $row->simpan; ?></center></td>
              <td><center><?php echo $this->m_barang->get_penerima_barang($row->penerima); ?></center></td>
              <td><center><?php
                $tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->date)));
          	    $jam = date("H:i:s a", strtotime($row->date));
                echo $tgl.' , '.$jam;
              	?></center>
              </td>
              <td><center><?php 
              if($row->tambah == NULL){
                echo '-';
              }else if($row->tambah == '0'){
                echo '-';
              }else{
                echo $row->tambah;
              // var_dump($row->tambah);die();
              } 
              ?></center>
              </td>
              <!-- <td><?php echo $row->harga; ?></td> -->
              <td><center><?php if($row->jumlah == '0'){ ?>
                -
              <?php }else{ ?>
                <a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/permintaanbarang/pinjam/<?php echo $row->id; ?>" title="add to cart"><img src="https://cdn.pixabay.com/photo/2014/06/19/00/59/shopping-cart-371979_960_720.png" width="25px" height="25px" style="margin: 3px;"></a>
              <?php } ?></center>
              </td>
              <td>
                <center>
                  <a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/permintaanbarang/tambah/<?php echo $row->id; ?>" title="tambah stok barang"><img src="https://cdn-icons-png.flaticon.com/512/148/148764.png" width="25px" height="25px" style="margin: 3px;"></a>
                  <a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/permintaanbarang/hapus/<?php echo $row->id; ?>" title="Hapus Barang" onclick="return confirm('Yakin Hapus?')"><img src="https://i.pinimg.com/originals/de/fc/85/defc85467e160fa5e1fb24f89a623bcc.png" width="25px" height="25px" style="margin: 3px;"></a>
                  <a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/permintaanbarang/edit/<?php echo $row->id; ?>" title="Edit Barang"><img src="https://cdn.onlinewebfonts.com/svg/img_354025.png" width="25px" height="25px" style="margin: 3px;"></a></center>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>