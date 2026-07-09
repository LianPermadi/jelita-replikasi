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
    ?>

    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    <div class="entry">
    	<b>
    	<font size="5"><center>DAFTAR KEHADIRAN</center></font> 
    	</b>
      <?php
      $ket = $data_acara->keterangan;
      if($ket == ''){
        $lantai = "Lantai ".$this->m_ruangan->get_lantai($data_acara->id_ruangan);
      }else{
      	$lantai = $ket;
      }  
      echo '<font size="4"><center>'.
              $data_acara->acara.'<br>'.
              $this->m_ruangan->get_nama($data_acara->id_ruangan).", ".$lantai.' <br>'.
              $this->lib_date->mysql_to_human($data_acara->tanggal)."; ".$data_acara->waktu_awal." - ".$data_acara->waktu_akhir.'</center></font>';
      
      $back_data = array('name' => 'button',
                         'content' => 'Kembali',
                         'value' => 'Kembali',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\''. site_url('ruangan/index') . '\''
                        );
      echo form_button($back_data);
      
      $ctk_list = array('name' => 'button',
                        'content' => 'Cetak PDF',
                        'value' => 'Cetak PDF',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('ruangan/cetak'). '/' . $id_kegiatan .'\')'
                       );
      //if($this->All){
      echo form_button($ctk_list);

      $ctk_absen_excel = array('name' => 'button',
                        'content' => 'Cetak Excel',
                        'value' => 'Cetak Excel',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('ruangan/cetak_absen_excel'). '/' . $id_kegiatan .'\')'
                       );
      //if($this->All){
      echo form_button($ctk_absen_excel);
      //}
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="23%">Nama Peserta<br>Jenis Kelamin</th>
            <th width="30%">Instansi<br>Jabatan</th>
            <th width="22%">Asal Peserta<br>Media Presensi</th>
            <th width="15%">Nomor Kontak<br>e-Mail</th>
            <th width="6%">Tandatangan</th>
            <?php if($this->All){ ?> 
            <th width="4%">Aksi</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          $routees        = str_replace('index.php', '', $_SERVER['PHP_SELF']); 
          $root           = $_SERVER['DOCUMENT_ROOT'];
          $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['PHP_SELF']); 
          $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
          foreach ($data_absen as $row) { 
          
          	if($row->gender == 0){
          	  $jns_Kel = 'Pria';
          	}else{
          	  $jns_Kel = 'Wanita';
          	}
          	$n_ttd = $root.$routees_portal.'kehadiran/uploads/'.$row->id.'.png';
          	if(file_exists($n_ttd)){
              // echo $master_url.$routees_portal.'kehadiran/uploads/'.$row->id.'.png';	
          	  $n_ttd = $master_url.$routees_portal.'/kehadiran/uploads/'.$row->id.'.png';	
            }else{	
              if($row->id_pegawai == '0'){
                $n_ttd = $master_url.$routees_portal.'kehadiran/uploads/blank.png';
              }else{
          		  $n_ttd = $master_url.$routees.'uploads/logo/'.$this->m_ruangan->get_nippegawai($row->id_pegawai).'.png';
              }
          	}	
          	switch ($row->sys_absen) {
              case 1:  $sys_absen = 'EuIS Cantik';      break;
              case 2:  $sys_absen = 'Scanning ID Card'; break;
              default: $sys_absen = 'Scanning Agenda';
            }
            // var_dump($n_ttd);
          	?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->nama.'<br>'.$jns_Kel; ?></td>
              <td><?php echo $row->instansi.'<br>'.$row->jabatan; ?></td>
              <td><?php echo $row->kabupaten.'<br>'.$sys_absen; ?></td>
              <td><?php echo $row->handphone.'<br>'.$row->email;?></td>
              <td style='text-align:center;width:auto !important;height:30px !important;'>
                <!--<img style='width:100px !important;height:50px !important;' src='https://dpmptsp.jabarprov.go.id/kehadiran/uploads/<?php echo $row->id; ?>.png'>-->
                <?php //if(){ ?>
                <img style='width:100px !important;height:50px !important;' src='<?php echo $n_ttd; ?>'>
                <?php //} ?>
              </td>
            <?php if($this->All){ ?>
            <td>
              <!-- http://dpmptsp.jabarprov.go.id/jelita/backoffice/ruangan/hapus_absen/ -->
              <a href="/jelita/backoffice/ruangan/hapus_absen/<?php echo $row->id; ?>/<?php echo $id_kegiatan; ?>" onclick="return confirm('Yakin Hapus?')"> <img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"> </a>
            </td>
            <?php } ?>
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