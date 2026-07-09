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
                        'content' => 'Tambah Program',
                        'value' => 'Tambah Program',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/program_add').'\''
                       );
      echo form_button($ctk_list);  
      ?>

      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="18%">Nama Tim Of Tim<br>Pengampu<br>Ketua</th>
            <th width="18%">Sasaran Program/ Kegiatan/ Sub Kegiatan (TOT)</th>
            <th width="19%">Indikator Kinerja</th>
            <th width="8%">Target Tahunan (Satuan)</th>
            <th width="25%">Target Kinerja Bulanan<br>Realisasi Kinerja Bulanan</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($program as $row) { 
          	
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo "<b>".$row->nama_tim."</b><br>- ".$this->m_renaksi->get_pengampu($row->pengampu)."<br>- ".$this->m_renaksi->get_ketua($row->ketua);?></td>
            <td><?php echo $row->sasaran_program;?></td>
            <td><?php echo $row->indikator_program;?></td>
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
                           <tr span style="color: green;">
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
                // echo '<a href="'.base_url().'kegiatandpa/add_realisasi_anggaran/'.$row->id.'"><img src="'.base_url().'assets/images/icon/money_flow.png" alt="Realisasi Anggaran" title="Realisasi Anggaran" border="0" height="23%" width="23%"></a>&nbsp;';
                echo '<a href="'.base_url().'kegiatandpa/program_ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/buat_renaksi_tes/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_icon.png" alt="Teruskan ke Anggota" title="Buat Renaksi" border="0"></a>&nbsp;';
              ?>
              <?php if($admin) { ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_program/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
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