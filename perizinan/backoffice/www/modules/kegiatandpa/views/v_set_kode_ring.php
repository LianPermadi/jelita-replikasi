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
                        'content' => 'Tambah Kode Ring',
                        'value' => 'Tambah Kode Ring',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/add_kode_ring').'\''
                       );
      echo form_button($ctk_list);

       $ctk_list = array('name' => 'button',
                        'content' => 'Kode Ring Sub Kegiatan',
                        'value' => 'Kode Ring Sub Kegiatan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/kode_ring_subkeg').'\''
                       );
      echo form_button($ctk_list);


      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Kode Ring</></th>
            <th width="40%">Uraian Kegiatan</th>
            <th width="15%">Anggaran</th>
            <th width="15%">Tahun</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($kode_ring as $row) { 
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->kode_ring; ?></td>
            <td><?php echo $row->uraian_kegiatan; ?></td>
            <td>Rp.<?php echo number_format($row->anggaran,0,',','.');?></td>
            <td><?php echo $row->tahun; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/ubah_kode_ring/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <?php if($admin) { ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_kodering/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
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