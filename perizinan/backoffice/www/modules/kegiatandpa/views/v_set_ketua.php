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
                        'content' => 'Tambah Ketua',
                        'value' => 'Tambah Ketua',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/add_ketua').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Koordinator</></th>
            <th width="15%">Nama Ketua</></th>
            <th width="25%">Nama Tim</th>
            <th width="10%">Tahun Anggaran</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ketua as $row) { 
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td>
              <?php 
              $n_koor = $this->m_renaksi->get_nama_tim_koor($row->id_koor); 
              echo $this->m_renaksi->get_n_pegawai($n_koor);
              ?>
            </td>
            <td><?php echo $this->m_renaksi->get_n_pegawai($row->id_pegawai); ?></td>
            <td><?php echo $row->nama_tim.' ('.$row->kode_tim.')'; ?></td>
            <td><?php echo $row->thn_anggaran; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/ubah_ketua/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <?php if($admin) { ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_ketua/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
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