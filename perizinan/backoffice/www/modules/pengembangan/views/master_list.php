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
                        'content' => 'Tambah Ruangan',
                        'value' => 'Tambah Ruangan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('ruangan/master_add').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="31%">Nama Ruangan</th>
            <th width="23%">Lantai</th>
            <th width="15%">Kapasitas</th>
            <th width="23%">Fasilitas</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ruangan as $row) { 
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->nama_ruangan; ?></td>
            <td><?php echo "Lantai ".$row->lantai; ?></td>
            <td><?php echo $row->kapasitas." Orang"; ?></td>
            <td><?php echo $row->fasilitas; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'ruangan/master_ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('ruangan/hapus_master/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>