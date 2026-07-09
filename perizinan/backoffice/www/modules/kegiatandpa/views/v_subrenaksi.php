<?php 
  if (!empty($renaksi)) {
    $id_tim = $renaksi->kd_tim;
    $id = $renaksi->id;
    $aktivitas = $renaksi->sasaran_renaksi;
    $indikator = $renaksi->indikator_renaksi;
    $target_tahun = $renaksi->target_tahun;
    $satuan = $renaksi->satuan;
    $t1 = $renaksi->t1;
    $t2 = $renaksi->t2;
    $t3 = $renaksi->t3;
    $t4 = $renaksi->t4;
    $t5 = $renaksi->t5;
    $t6 = $renaksi->t6;
    $t7 = $renaksi->t7;
    $t8 = $renaksi->t8;
    $t9 = $renaksi->t9;
    $t10 = $renaksi->t10;
    $t11 = $renaksi->t11;
    $t12 = $renaksi->t12;
    $r1 = $renaksi->r1;
    $r2 = $renaksi->r2;
    $r3 = $renaksi->r3;
    $r4 = $renaksi->r4;
    $r5 = $renaksi->r5;
    $r6 = $renaksi->r6;
    $r7 = $renaksi->r7;
    $r8 = $renaksi->r8;
    $r9 = $renaksi->r9;
    $r10 = $renaksi->r10;
    $r11 = $renaksi->r11;
    $r12 = $renaksi->r12;

  } else {
    $id_tim = "";
    $id = "";
    $aktivitas = "";
    $indikator = "";
    $target_tahun = "";
    $satuan = "";
    $t1 = "";
    $t2 = "";
    $t3 = "";
    $t4 = "";
    $t5 = "";
    $t6 = "";
    $t7 = "";
    $t8 = "";
    $t9 = "";
    $t10 = "";
    $t11 = "";
    $t12 = "";
    $r1 = "";
    $r2 = "";
    $r3 = "";
    $r4 = "";
    $r5 = "";
    $r6 = "";
    $r7 = "";
    $r8 = "";
    $r9 = "";
    $r10 = "";
    $r11 = "";
    $r12 = "";
  }
 ?>
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
    <h3> <?php echo $id_tim; ?></h3>
    <div class="entry">
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah Sub Rencana Aksi',
                        'value' => 'Tambah Sub Rencana Aksi',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/add_subrenaksi').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Nama Tim Of Tim<br>Sasaran Program/ Kegiatan/ Sub Kegiatan (TOT)<br>Pengampu<br>Ketua</></th>
            <th width="20%">Aktivitas / Rencana Aksi<br>Indikator Aktivitas</th>
            <th width="8%">Target Rencana Aksi Per-Tahun</th>
            <th width="25%">Target Kinerja Bulanan<br>Realisasi Kinerja Bulanan</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($subrenaksi as $row) { 
            
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo "<b>".$row->nama_tim."</b><br>- ".$row->sasaran_program."<br>- ".$this->m_renaksi->get_pengampu($row->pengampu)."<br>- ".$this->m_renaksi->get_ketua($row->ketua);?></td>
            <td><?php echo "- ".$row->sasaran_renaksi."<br>- ".$row->indikator_renaksi;?></td>
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
                echo '<a href="'.base_url().'kegiatandpa/subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_biru.png" alt="Teruskan ke Anggota" title="Teruskan ke Anggota" border="0" height="15%" width="15%"></a>&nbsp;';
              ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_renkasi/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>