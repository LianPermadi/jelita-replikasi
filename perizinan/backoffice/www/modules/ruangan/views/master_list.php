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
      <?php
    }
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <div class="entry">
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah Ruangan',
                        'value' => 'Tambah Ruangan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('ruangan/master_add').'\''
                       );
      echo form_button($ctk_list);
      $add_token = array('name' => 'button',
                         'content' => 'Buat Token',
                         'value' => 'Buat Token',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\''.site_url('ruangan/buat_token').'\''
                        );
      //if($this->All){
        echo form_button($add_token);
      //}
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="21%">Nama Ruangan</></th>
            <th width="10%">Lantai</th>
            <th width="10%">Kapasitas</th>
            <th width="30%">Fasilitas</th>
            <th width="10%">Status Ruangan</th>
            <th width="8%">Jumlah Pemakaian</th>
            <th width="8%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ruangan as $row) {
          	$jum_ruangan = $this->m_ruangan->count_ruangan($row->id);
          	if($row->status == 1){
          	  $dipakai = 'Dapat Digunakan';
          	  $b = '';
              $be = '';
          	}else{
          	  $dipakai = 'Tidak Dapat Digunakan';
          	  $b = '<span style="color: Red">';
              $be = '</span>';
          	}
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$row->nama_ruangan.$be; ?></td>
              <td><?php echo $b."Lantai ".$row->lantai.$be; ?></td>
              <td><?php echo $b.$row->kapasitas." Orang".$be; ?></td>
              <td><?php echo $b.$row->fasilitas.$be; ?></td>
              <td><?php echo $b.$dipakai.$be; ?></td>
              <td style="text-align: right;"><?php echo $jum_ruangan; ?></td>
              <td>
                <?php 
                echo '<a href="'.base_url().'ruangan/master_ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp; ';
                if($jum_ruangan == 0){ 
                  ?>
                  <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('ruangan/hapus_master/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
                  <?php 
                }
                if($row->foto != NULL){ 
                  $foto = array('src' => base_url().'assets/images/icon/look.png',
                                'title' => 'Telah dilengkapi Foto',
                                'border' => '0');
                  //echo img($foto);
                  echo anchor(site_url('ruangan/master_ubah').'/'.$row->id, img($foto))."&nbsp;";
                }
                ?>
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>