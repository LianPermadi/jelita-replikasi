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
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="15%">Nama Ruangan<br>Status Ruangan</></th>
            <th width="20%">Lokasi<br>Kapasitas<br>Fasilitas</th>
            <th width="7%">Jumlah Pemakaian</th>
            <th width="20%">Kelengkapan<br>Eviden</th>
            <th width="20%">Mekanisme Presensi</th>
            <th width="5%">Aksi</th>
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
          	//Rekapitulasi Eviden
          	$dalam_pelaksanaan = $this->m_ruangan->count_dalam_pelaksanaan($row->id);
            $eviden = $this->m_ruangan->count_ruangan_eviden($row->id);
          	$pembatalan = $this->m_ruangan->count_ruangan_batal($row->id);
          	//EOF() Rekapitulasi Eviden
          	
          	//Rekapitulasi Mekanisme Presensi
          	$id_card =     $this->m_ruangan->count_presensi_idcard($row->id);
            $euis_cantik = $this->m_ruangan->count_presensi_euis($row->id);
          	$agenda =      $this->m_ruangan->count_presensi_agenda($row->id);
          	//EOF() Rekapitulasi Mekanisme Presensi
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td>
                <?php
                echo $b.$row->nama_ruangan.$be.'<br>';
                echo $b.$dipakai.$be;
                ?>
              </td>
              <td>
                <?php
                echo $b."Lantai ".$row->lantai.$be.'<br>';
                echo $b.$row->kapasitas." Orang".$be.'<br>';
                echo $b.$row->fasilitas.$be;
                ?>
              </td>
              <td style="text-align: right;"><?php echo $jum_ruangan; ?></td>
              <td>
                <?php
                $a = $eviden[1]-$dalam_pelaksanaan;
                echo $b;
                echo 'Belum/Masih Dilaksanakan : '.$dalam_pelaksanaan.'<br>';
                echo 'Belum Ada Notulen : '.$a.'<br>';
                echo 'Lengkap : '.$eviden[0].'<br>';          
                echo 'Dibatalkan : '.$pembatalan.'<br>';
                echo $be;
                ?>
              </td>
              <td>
                <?php
                $a = $eviden[1]-$dalam_pelaksanaan;
                echo $b;
                echo 'Scanning ID Card : '.$id_card.'<br>';
                echo 'APK EuIS Cantik : '.$euis_cantik.'<br>';
                echo 'Scanning Kegiatan : '.$agenda.'<br>';
                echo $be;
                ?>
              </td>
              <td>
                <?php 
                $img_parent = array('src' => base_url().'assets/images/icon/information.png',
                                      'alt' => 'Informasi Detail',
                                      'title' => 'Informasi Detail',
                                      'border' => '0',
                                     );
                echo anchor(site_url('ruangan/detail_list') .'/'. $row->id.'/0/0', img($img_parent))."&nbsp;";                     
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