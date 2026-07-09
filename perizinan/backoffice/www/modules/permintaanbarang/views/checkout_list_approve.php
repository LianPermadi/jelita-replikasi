  
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
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/barang').'\''
                       );
      echo form_button($ctk_list);  
      ?> 
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'List Permintaan barang',
                        'value' => 'List Permintaan barang',
                        'style' => 'background:#B0C4DE; color:black;',
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
      $ctk_list = array('name' => 'button',
                        'content' => 'Barang Keluar',
                        'value' => 'Barang Keluar',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/').'\''
                       );
      echo form_button($ctk_list);  
      
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
      ?>   
    <div id="barang">
      <a href="/<?= $routees ?>permintaanbarang/pengajuan"><button class="button-wrc">< back</button></a>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="1%">No</th>
            <th width="20%">Nama Barang</th>
            <th width="10%">Merk</th>
            <th width="10%">Jumlah</th>
            <th width="10%">satuan</th>
            <th width="10%">Status</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($barang as $row) { 
              if($row->status == '2' ||$row->status == '3' || $row->status == '4' || $row->status == '5' || $row->status == '6' || $row->status == '7' ||  $row->status == '8'||  $row->status == '9'){
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->nama_barang; ?></td>
              <td><?php 
                                                  $options = array(
                                                                        '<p>
                        <img src="'.$master_url.'/'.$routees.'www/modules/permintaanbarang/views/barang/'.$row->foto.'" width="100px" height="100px">
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
                                                </div></td>
              <td><?php echo $row->jumlah_barang; ?></td>
              <td><?php echo $row->satuan; ?></td>
              <td><?php 
              $url = $id;
              // var_dump($url);die();
              if($row->status == '2'){
                echo '<span style="color:blue;;">Menunggu Approve</span>';
              }elseif($row->status == '3'){
                echo '<span style="color:orange;">Barang sedang disiapkan</span>';
              }elseif($row->status == '4'){
                echo '<span style="color:green;">Barang sudah siap dikirim</span>';
              }elseif($row->status == '5') {
                echo '<span style="color:black;">Menunggu Konfirmasi Pemohon</span>';
              }elseif($row->status == '6') {
                echo '<span style="color:green;">Barang Di terima</span>';
              }elseif($row->status == '8') {
                echo '<span style="color:red;">Pengajuan Pengembalian/Kurang</span>';
              }elseif($row->status == '7') {
                echo '<span style="color:red;">Barang Tidak ada</span>';
              }  ?></td>
              <td>
                <?php 
              if($row->status == '2'){
                echo '<a href="/'.$routees.'permintaanbarang/acc/'.$row->no_id.'/'.$url.'" title="Approve"><img src="https://static.vecteezy.com/system/resources/previews/011/858/559/original/green-check-mark-icon-with-circle-tick-box-check-list-circle-frame-checkbox-symbol-sign-png.png" width="35px" height="25px" style="margin:2px;"></a>
                <a href="/'.$routees.'permintaanbarang/hapus_checkout/'.$row->no_id.'/'.$row->jumlah_barang.'/'.$row->id_barang.'/'.$langkah.'" title="Reject"><img src="https://cdn.pixabay.com/photo/2014/04/02/10/44/cross-mark-304374_960_720.png" width="25px" height="20px" style="margin:2px;"></a> 
                <a href="/'.$routees.'permintaanbarang/edit_checkout/'.$row->no_id.'/'.$row->jumlah_barang.'/'.$row->id_barang.'/'.$langkah.'/'.$url.'" title="kurang Tambah"><img src="https://static.thenounproject.com/png/29629-200.png" width="25px" height="20px" style="margin:2px;"></a> ';
              }elseif($row->status == '3'){
                echo '<a href="/'.$routees.'permintaanbarang/acc/'.$row->no_id.'/'.$url.'"><img src="https://img.freepik.com/free-icon/box_318-381422.jpg" width="25px" height="25px"></a>';
              }elseif($row->status == '4'){
                echo '<a href="/'.$routees.'permintaanbarang/kirim/'.$row->no_id.'/'.$url.'"><button class="button-wrc">Barang Diserahkan</button></a>';
              }elseif($row->status == '5') {
                echo '<span style="color:black;">-</span>';
              }elseif($row->status == '6') {
                echo '-';
              }elseif($row->status == '7') {
                echo '<span style="color:orange;">-</span>';
              }elseif($row->status == '8') {
                echo '<span style="color:red;">Barang Tidak Diterima</span>';
              }  
              ?>
              </td>
            </tr>
          <?php $i++; }
          } ?>
        </tbody>
      </table>
      <?php
// // contoh array
// foreach($barang as $row){
//   $data1 = $row->status.', ';
// };
// // var_dump($data1);die();
// $data = array(
//   // 6, 6, 6, 6,
//   $data1
// );

// // cek apakah semua data dalam array bernilai 6
// if (array_count_values(6)[6] == count(6)) {
//     // jika ya, tampilkan tombol
//     echo '<button>Button</button>';
// }
?>
  </div>
</div>
</div>
  <br style="clear: both;" />
</div>