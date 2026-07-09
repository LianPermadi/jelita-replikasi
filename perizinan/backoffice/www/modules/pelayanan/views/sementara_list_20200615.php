<script>
  function warning(){
    alert('Data telah lebih dari 10 hari');
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <?php
    echo "<font color='red'><b>" . $this->session->flashdata('warning') . "</b></font>";
    if($ket_syarat) {
      echo "<div class='entry' align=center><b style='color: #FF0000;'>Persyaratan tidak lengkap !!</b></div>";
    }
    ?>

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
	                      'content' => 'Sinkron Data Manual (Admin)',
	                      'value' => 'Sinkron Data Manual (Admin)',
	                      'class' => 'button-wrc',
	                      'onclick' => 'parent.location=\''.site_url('pelayanan/sementara/updatetgl').'\''
	                     );
	  	if($this->All) echo form_button($ctk_list);

	  	$ctk_btn = array('name' => 'button',
	                      'content' => 'View Permohonan Melebihi Masa Verifikasi',
	                      'value' => 'View Permohonan Melebihi Masa Verifikasi',
	                      'class' => 'button-wrc',
	                      'onclick' => 'parent.location=\''.site_url('pelayanan/sementara/listmelebihi').'\''
	                     );
	  	echo form_button($ctk_btn).'<br>';

      $settings = new settings();
      $app_web_service = $settings->where('name', 'web_service_penduduk')->get();
      $url = $app_web_service->value;
      $psn = '<span style="color: Red">Merah: Belum Asistensi</span>'.
             ' &nbsp&nbsp&nbsp Hitam: Sudah Asistensi'.
             ' &nbsp&nbsp&nbsp <span style="color: Blue">Biru: Sudah di Perbaiki</span>';
      echo $psn;
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendaftaran">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="10%">Referensi<br>Tgl Daftar OnLine</th>
            <th width="33%">Nomor Induk Berusaha<br>Nama Pemohon / Perusahaan<br>Alamat Perusahaan</th>
            <th width="30%">Jenis Izin</th>
            <th width="20%">Lokasi / Objek Izin <br> Latitude / Longitude</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          $results = mysql_query($list);
          echo mysql_error();
          while ($rows = mysql_fetch_assoc(@$results)){
            $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $sql1 = "select username from tm_pemohon where id='".$rows['id_pemohon']."'"; // ambil pemohon
            $sql2 = "select id_permohonan from asistensi where id_permohonan='".$rows['id_permohonan_portal']."'"; // ambil asistensi
          	$sql3 = "select tm_pemohon.username from tm_pemohon,tmpermohonan_portal where tmpermohonan_portal.id='".$rows['id_permohonan_portal'].
          	        "' and tmpermohonan_portal.id_pemohon=tm_pemohon.id"; // Ambil permohonan di BO
            
          	$jml_asistensi = count($otherdb->query($sql2)->result()); //jumlah asisteni
          	$usr	= $otherdb->get_where("tm_pemohon",array("id"=>$rows['id_pemohon']))->first_row();
          	$Xusr	= $otherdb->get_where("tm_pemohon",array("id"=>$rows['id_pemohon']))->num_rows();

            if($jml_asistensi == 0){     // jika tidak pernah di asistensi
          		$b = '<span style="color: Red">'; $be = '</span>';
            } else {
              $b = ''; $be = '';
            }
            if($rows['revisi'] == '1') $b = '<span style="color: Blue">'; $be = '</span>';
            if($all_view){
              $tampil = TRUE;
          	}else{
          		if(count($otherdb->query($sql1)->result()) == 0){
          			$tampil = FALSE;
              }else{
          	    $tampil = TRUE;
              }
          	}
          	$valid = FALSE;
          	if(count($otherdb->query($sql3)->result()) != 0)     	   $valid = TRUE;
          	if($this->session->userdata('username') == 'pamudi1694') $valid = TRUE;
          	if($this->session->userdata('username') == 'nirwan')     $valid = TRUE;
            if($this->session->userdata('username') == 'lucky')      $valid = TRUE;
            
          	if($tampil && $valid){
          		$i++;
              $n_perusahaan = $rows['namaPerusahaan'];
          		if($n_perusahaan == '') $n_perusahaan = '-';
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'><?php echo $b. $rows['referensi'].'<br>'.$this->lib_date->mysql_to_human($rows['tglPermohonan']) .$be; ?></td>
                <td valign='top'>
                  <?php
                  if($valid)
                    if($Xusr != 0){
                      echo $b. (isset($rows['nib']) ? $rows['nib'] : '-'). '<br>'. $rows['namaPemohon'].' / '.$n_perusahaan.' ['.$usr->username.']'.'<br>'.$rows['almtPerusahaan'] .$be;
                    }else{
                      echo $b. $rows['namaPemohon'].' / '.$n_perusahaan.' [Ini Hack]'.'<br>'.$rows['almtPerusahaan'] .$be;
                    }
                  else
                    echo $b. $rows['namaPemohon'].' / '.$n_perusahaan.'<br>'.$rows['almtPerusahaan'] .$be;
                  ?>
                </td>
                <td valign='top'><?php echo $b. $rows['isi_izin'].$be; ?></td>
                <?php $longlat = (!empty($rows['lat']) && !empty($rows['lat']) ? " <br> " .$rows['lat']. " / ". $rows['lon'] : ""); ?>
          		  <td valign='top'><?php echo $b. $rows['lokasi_izin']. $longlat .$be; ?></td>
                <td valign='top'>
                  <?php
          		    if($user_lokasi != 'OPD Teknis') $txt='Edit'; else $txt='Lihat';
                  $img_edit = array('src' => base_url() . 'assets/images/icon/property.png',
                                    'alt' => $txt,
                                    'title' => $txt,
                                    'border' => '0',
                                   );

                  $img_gis = array('src' => base_url() . 'assets/images/icon/look.png',
                                    'alt' => 'Tampilkan Titik Lokasi',
                                    'title' => 'Tampilkan Titik Lokasi',
                                    'border' => '0',
                                   );
                                             
          		  	$confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                  $img_delete = array('src' => base_url() . 'assets/images/icon/cross.png',
                                      'alt' => 'Delete',
                                      'title' => 'Delete',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\'' . $confirm_text . '\')',
                                     );
                  if ($this->pendaftaran_online) { 
                    if(count($otherdb->query($sql3)->result()) != 0)
                    echo anchor(site_url('pelayanan/sementara/edit') . '/' . $rows['id'], img($img_edit)) . "&nbsp;";
                    
                  //if($aut_hapus)
                    echo anchor(site_url('pelayanan/sementara/delete') . '/' . $rows['id'], img($img_delete)) . "&nbsp;";
                    if ($this->All) { ?>
                      <a href="http://www.google.com/maps/place/<?php echo $rows['lat']; ?>,<?php echo $rows['lon']; ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/images/icon/look.png"></a>
                    <?php }
                  } ?>
                  <!-- <a href="http://www.google.com/maps/place/<?php echo $rows['lat']; ?>,<?php echo $rows['lon']; ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/images/icon/look.png"></a> -->
          		  </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
      <?php
      echo $psn;
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>