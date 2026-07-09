<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
                        'content' => 'Log Barang',
                        'value' => 'Log Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/').'\''
                       );
      echo form_button($ctk_list);  
      ?>   
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
                        'content' => 'checkout Barang',
                        'value' => 'checkout Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/checkout').'\''
                       );
      echo form_button($ctk_list);  
      ?>  
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Activity Barang',
                        'value' => 'Activity Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                       );
      echo form_button($ctk_list);  
      ?>  
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Barang</th>
            <th width="10%">Merk</th>
            <th width="2%">Jumlah</th>
            <th width="10%">satuan</th>
            <th width="10%">Penyimpanan</th>
            <th width="10%">Penerima</th>
            <th width="10%">CreatedAt</th>
            <th width="50%">Tambah Stok</th>
            <th width="10%" colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($barang as $row) { 
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->nama_barang;  ?> </td>
              <td><?php 
              if(!empty($row->merk)){
                  echo $row->merk;
                }else{
                  echo '-';
                }?></td>
              <td><?php echo $row->jumlah; ?></td>
              <td><?php echo $row->satuan; ?></td>
              <td><?php echo $row->simpan; ?></td>
              <td><?php echo $this->m_barang->get_penerima_barang($row->penerima); ?></td>
              <td><?php echo $row->date; ?></td>
              <td><?php 
              if($row->tambah == NULL){
                echo '-';
              }else if($row->tambah == '0'){
                echo '-';
              }else{
                echo $row->tambah;
              // var_dump($row->tambah);die();
              } 
              ?>
              </td>
              <td><?php if($row->jumlah == '0'){ ?>
                -
              <?php }else{ ?>
                <a href="pinjam/<?php echo $row->id; ?>"><button class="button-wrc">Add</button></a>
              <?php } ?>
              </td>
              <td>
                <a href="tambah/<?php echo $row->id; ?>"><center><img src="https://cdn-icons-png.flaticon.com/512/148/148764.png" width="25px" height="25px"></center></a>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>