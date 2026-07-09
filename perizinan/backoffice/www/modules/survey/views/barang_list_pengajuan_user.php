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
                        'content' => 'List Pengajuan',
                        'value' => 'List Pengajuan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/pengajuan').'\''
                       );
      echo form_button($ctk_list);  
      ?>   
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Checkout',
                        'value' => 'Checkout',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/checkout_barang').'\''
                       );
      echo form_button($ctk_list);  
      ?>   

    <div id="barang">
      <table><tr>
        <td>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="1%">No</th>
            <th width="60%">Nama Barang</th>
            <th width="10%">Merk</th>
            <th width="2%">Jumlah</th>
            <th width="2%">satuan</th>
            <th width="1%">Action</th>
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
              <td><?php if($row->jumlah == '0'){ ?>
                -
              <?php }else{ ?>
                <a href="pinjam/<?php echo $row->id; ?>"><img src="https://i.pinimg.com/originals/4a/38/7b/4a387bda853bca3782d73234c786a150.png" width="35px" height="35px"></a>
              <?php } ?>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </td>
    <td>
      <table>
        <tr>
          <td>test table</td>
        </tr>
      </table>
    </td>
      </tr></table>
  </div>
</div>
  <br style="clear: both;" />
</div>