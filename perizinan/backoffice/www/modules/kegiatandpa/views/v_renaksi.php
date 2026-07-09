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
                        'content' => 'Tambah Rencana Aksi',
                        'value' => 'Tambah Rencana Aksi',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/renaksi_add').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="18%">Nama Tim Of Tim<br>Sasaran Program/ Kegiatan/ Sub Kegiatan (TOT)<br>Pengampu<br>Ketua</></th>
            <th width="18%">Aktivitas / Rencana Aksi</th>
            <th width="19%">Indikator Aktivitas</th>
            <th width="10%">Target Rencana Aksi Per-Tahun</th>
            <th width="25%">Target Kinerja Bulanan<br>Realisasi Kinerja Bulanan</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($renaksi as $row) { 
          $ketua_tim = $this->m_renaksi->get_id_ketua($row->kd_tim);
          $pengampu_tim = $this->m_renaksi->get_id_pengampu($row->kd_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $pengampu = $this->m_renaksi->get_pengampu($pengampu_tim);
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo "<b>".$this->m_renaksi->get_nama_tim($row->kd_tim)."</b><br>- ".$this->m_renaksi->get_sasaran_program($row->kd_tim)." <br>- ".$pengampu." <br>- ".$ketua;?></td>
            <td><?php echo $row->sasaran_renaksi;?></td>
            <td><?php echo $row->indikator_renaksi;?></td>
            <td><?php echo $row->target_tahun." ".$row->satuan; ?></td>
            <td>
                        <table border='1'>
                          <tr>
                            <th>B1</th>
                            <th>B2</th>
                            <th>B3</th>
                            <th>B4</th>
                            <th>B5</th>
                            <th>B6</th>
                            <th>B7</th>
                            <th>B8</th>
                            <th>B9</th>
                            <th>B10</th>
                            <th>B11</th>
                            <th>B12</th>
                          </tr>
                           <tr span style="color: orange">
                             <td><?php echo $row->t1; ?></td>
                             <td><?php echo $row->t2; ?></td>
                             <td><?php echo $row->t3; ?></td>
                             <td><?php echo $row->t4; ?></td>
                             <td><?php echo $row->t5; ?></td>
                             <td><?php echo $row->t6; ?></td>
                             <td><?php echo $row->t7; ?></td>
                             <td><?php echo $row->t8; ?></td>
                             <td><?php echo $row->t9; ?></td>
                             <td><?php echo $row->t10; ?></td>
                             <td><?php echo $row->t11; ?></td>
                             <td><?php echo $row->t12; ?></td>
                           </tr>
                           <tr>
                             <td colspan="12"></td>
                           </tr>
                           <tr span style="color: green">
                             <td><?php echo $row->r1; ?></td>
                             <td><?php echo $row->r2; ?></td>
                             <td><?php echo $row->r3; ?></td>
                             <td><?php echo $row->r4; ?></td>
                             <td><?php echo $row->r5; ?></td>
                             <td><?php echo $row->r6; ?></td>
                             <td><?php echo $row->r7; ?></td>
                             <td><?php echo $row->r8; ?></td>
                             <td><?php echo $row->r9; ?></td>
                             <td><?php echo $row->r10; ?></td>
                             <td><?php echo $row->r11; ?></td>
                             <td><?php echo $row->r12; ?></td>
                           </tr>

                        </table>
                      </td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/renaksi_ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/add_subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_biru.png" alt="Teruskan ke Anggota" title="Teruskan ke Anggota" border="0" height="10%" width="10%"></a>&nbsp;';
              ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_renaksi/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>