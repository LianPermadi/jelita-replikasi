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
                        'content' => 'Ajukan Permintaan Barang',
                        'value' => 'Ajukan Permintaan Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/pengajuan_barang').'\''
                       );
      echo form_button($ctk_list);  
      ?>   
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="1%">No</th>
            <th width="20%">Nama Barang</th>
            <th width="20%">Nama Permintaan</th>
            <th width="20%">Status</th>
            <th width="10%">Keterangan</th>
            <th width="10%">Tanggal</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($barang as $row) { 
            // $a = $this->m_barang->get_pegawai_user($row->id_user); 
            // var_dump($a);die();
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->m_barang->get_data_barang_nama_barang($row->id_barang);  ?> </td>
              <td><?php 
              $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->id_user); 
              echo $this->m_barang->get_data_user_n_pegawai($pegawai); 
              ?></td>
              <td><?php if($row->status == '1'){
                  echo '<b>Barang Sedang Di siapkan</b>';
              }else{
                echo '<b style="color:#FF0000;">Kalem santuy teu acan di approve</b>';
              } ?></td>
              <td><?php echo $row->keterangan; ?></td>
              <td><?php echo $row->date; ?></td>
              <td><?php if($row->status == '0'){ ?>
                <a href="approve_barang"><button class="button-wrc">Approve</button></a>
              <?php }else{ ?>
                <h4 style="color:#0000FF;">Selesai</h4>
                <?php ?>
              <?php } ?>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>