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
                        'content' => 'List Persediaan',
                        'value' => 'List Persediaan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/barang').'\''
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
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Permintaan Barang',
                        'value' => 'Activity Barang',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/pengajuan').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Barang</th>
            <th width="15%">Pemberi Barang</th>
            <th width="15%">Penerima Barang</th>
            <th width="12%">Tanggal Pengambilan<br>Barang</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($barang as $row) { 
            // $stat_tolak = $this->m_persuratan->get_data_tolak($row->id);
          	// if($row->hapus == 1) {
            //   $b = '<span style="color: Red">';
            //   $be = '</span>';
            // }else{
            //   $b = '';
            //   $be = '';
            // }
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->nama_barang; ?></td>
              <td><?php echo $this->m_barang->get_pemberi_barang($row->pemberi_barang); ?></td>
              <td><?php echo $this->m_barang->get_penerima_barang($row->penerima_barang); ?></td>
              <td><?php echo $row->date; ?></td>
              <td>-</td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>