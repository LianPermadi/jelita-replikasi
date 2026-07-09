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
                        'content' => 'Tambah Tim',
                        'value' => 'Tambah Tim',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('kegiatandpa/tim_add').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="22%">Nama Tim Of Tim</></th>
            <th width="20%">Pengampu</th>
            <th width="17%">Ketua</th>
            <th width="19%">Anggota</th>
            <th width="10%">Anggaran<br>Realisasi</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($tim as $row) { 
          	$double = doubleval($row->realisasi_anggaran);
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->nama_tim; ?></td>
            <td><?php echo $this->m_renaksi->get_pengampu($row->pengampu); ?></td>
            <td><?php echo $this->m_renaksi->get_ketua($row->ketua); ?></td>
            <td><?php
            $no = 1;
            $nono = 1;
            // $anggota1 = explode('^', $row->anggota);
            // foreach ($anggota1 as $data1){
            //   echo $nono.'. '.$this->m_renaksi->get_n_pegawai($data1).'<br>';
            //       $nono++; 
            // }
            $anggota = $this->m_renaksi->get_anggota_tim2($row->id);
                foreach ($anggota as $data){
                  echo $no.'. '.$this->m_renaksi->get_n_pegawai($data->id_pegawai).'<br>';
                  $no++; 
                }
              ?>
            </td>
            <td>Rp.<?php echo number_format($row->anggaran,0,',','.').'<br> Rp. '.number_format($double,0,',','.');?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/tot_ubah/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <?php if($admin) { ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_tot/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
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