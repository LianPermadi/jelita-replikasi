<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <?php //if($kd_auth != 2){ ?>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('permohonan/penetapan/'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php echo form_label('Nomor Pendaftaran', 'kt_cari');?>
            </div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
              <?php
              $cari_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Cari Data',
                                 'value' => 'Cari Data');
              echo form_submit($cari_data);
              ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '1');
        echo form_close();
        ?>
      </fieldset>
    </div>
    <?php //} ?>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('permohonan/penetapan/'); ?>
        <div id="statusRail">
          <div id="leftRail">
	   		    <?php
            $status1 = array('name' => "sts_pil",
                             'value' => "1",
                             'id'=>'sts_pil',
                             'checked' => $cek1,
                             'onclick' => 'gantiStatus(this.value)');
            echo form_radio($status1) . " PERMOHONAN";
            ?>
          </div>
          <div id="rightRail">
            <?php 
            $status2 = array('name' => "sts_pil",
                             'value' => "2",
                             'id'=>'sts_pil',
                             'checked' => $cek2,
                             'onclick' => 'gantiStatus(this.value)');
            echo form_radio($status2) . " PENETAPAN";
            ?>
          </div>
        </div>

        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan');
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            echo ' ';

            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div>
    <div class="entry">
      <div class="spacer"></div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="9%">Nomor Pendaftaran<br>Tanggal Daftar<br>Asal Permohonan</th>
            <th width="19%">Nama Pemohon<br>Nama Perusahaan</th>
            <th width="19%">Jenis Izin</th>
            <th width="19%">Objek Izin</th>
		        <th width="9%">Status</th>
		      	<th width="17%">Tanggal Penetapan<br>Nomor Surat Keputusan<br>Tanggal Surat Keputusan</th>
		        <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          $permohonan_sk = new tmpermohonan_tmsk();
          $bap = new tmbap();
          $sk = new tmsk();
          while ($rows = mysql_fetch_assoc(@$results)){
           	$klmk_izin = new trkelompok_perizinan_trperizinan();
            $klmk_izin->where('trperizinan_id', $rows['idizin'])->get();
            $kd_klmk = $klmk_izin->trkelompok_perizinan_id;
						
		        $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
		        $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;

            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
	          $n_perusahaan = $perusahaan->n_perusahaan;
                       
            $detail_gis = new dpmptsp_detail_data();
            $detail_gis->where('id_data', $rows['pendaftaran_id'])->get();       // ambil key permohonan

            $permohonan_id = $rows['id'];
            $hit_relasi = $bap->where('pendaftaran_id', $rows['pendaftaran_id'])->count();
            $bap = $bap->where('pendaftaran_id', $rows['pendaftaran_id'])->get();
            $id_bap = $bap->id;
            $del = FALSE;
            if($kd_auth == '1') { // jika penomoran saja
              //$bap->where('pendaftaran_id', $rows['pendaftaran_id'])->get();
              //$survey_id = $bap->bap_id;
              $c_penetapan = "1";
              $id_bap = '';
              $status_bap = "1";
              $c_pesan = "1";
	          }else{
	            if($hit_relasi > 1) $del = TRUE;
	            $c_penetapan = $rows['c_penetapan'];
              $id_bap = $rows['id_bap'];
	            $status_bap = $rows['status_bap'];
              $c_pesan = $rows['c_pesan'];
            }
            if($rows['keterangan'] == '')
              $survey_id = $rows['a_izin'];
            else
              $survey_id = $rows['a_izin'].'<br> [ Ket : '.$rows['keterangan'].' ]';

            $permohonan_sk->where('tmpermohonan_id', $permohonan_id)->get();
            $sk->where('id', $permohonan_sk->tmsk_id)->get();
            $dtrev = $sk->pesan_revisi;
            if($sk->no_surat_edit == "") {
              $no_sk = $sk->no_surat;
            }else{
              $no_sk = $sk->no_surat_edit;
            }
            if($sk->tgl_surat_edit == '0000-00-00'){
              $tgl_sk = $sk->tgl_surat;
            }else{
              $tgl_sk = $sk->tgl_surat_edit;
            }
            $tgl_penetapan = $sk->tgl_penetapan;
            if($tgl_penetapan == ''){
              // $sk->tgl_penetapan = $tgl_sk; //disable karna bikin error
              // $sk->save();
            }
                        
            $penomoran = FALSE;
	          if($c_penetapan === "1") {
              $del = FALSE;
              $b = '';
              $be = '';
              if($sk->no_surat != $sk->no_surat_edit && $status_bap != "2"){
                $penomoran = TRUE;
                $b = '<span style="color: Blue">';
                $be = '</span>';
              }
            }else{
              $b = '<span style="color: Red">';
              $be = '</span>';
            }

            if($c_pesan){         // agar tampil maka c_pesan <> null
            	switch($rows['e_sertifikat']){
	              case 0 : $SE = " 'non SE'"; break;
                case 1 : $SE = " 'SE BSrE'"; break;
              }
              switch($rows['e_ttd']){
                case 0 :  // Manual
                  $mode = 'ttd Manual'; break;
                case 1 :  // Elektronik
                  $mode = 'e-sign Templete'.$SE; break;
                case 2 :  // Upload
                  $mode = 'e-sign Upload'.$SE; break;
              }
          ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'>
                  <?php 
	                echo $b.$rows['pendaftaran_id'].'<br>'.$be;
	                if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                  else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                       else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                            else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                  if($tgl_permohonan){
                    if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$be;
                  }
	                echo $b.$rows['kd_gerai'].$be;
	                ?>
	              </td>
	              <td valign='top'><?php echo $b.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be; ?></td>
                <td valign='top'>
                	<?php 
                	echo $b.$rows['n_perizinan'].' <br><b>[ '.strtoupper($rows['n_permohonan']).' ('.$mode.') ]</b>'.$be;
                	?>
                </td>
                <td valign='top'><?php echo $b.$survey_id.$be;?> </td>
	              <td valign='top'>
                  <?php
                  $terkunci=FALSE;
                  if($c_penetapan === "1") {
                    if($status_bap === "1") {
                      echo $b."<b>Izin Disetujui</b>".$be;
                      $cek_naskah = FALSE;
                      $cek_upload = FALSE;
                      if(!$penomoran || $rows['e_sertifikat'] == 0){ // menunggu penomoran jika esign BSrE
                      if($rows['e_ttd'] != 0){        // Bukan Manual
                        if($rows['e_ttd'] == 2){    // mode Upload
                          if(file_exists('naskah_izin/'.$rows['pendaftaran_id'].'.docx')){
	                          $cek_upload = TRUE;
                            $ket = $b.'Upload Berhasil'.$be;
                            if($rows['approve'] == 0){
	                            $cek_upload = FALSE;
                              $ket = $b.'<span style="color: Red">'.'Revisi Naskah'.'</span>'.$be;
	                            $revisi_naskah = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                     'alt' => 'Upload Naskah, Pesan: '.$dtrev,
                                                     'title' => 'Upload Naskah, Pesan: '.$dtrev,
                                                     'border' => '0');
	                            if($rows['e_ttd'] == 2)    // mode Upload
	                              echo "<br>".$ket.'&nbsp';
	  
	                            echo anchor(site_url('permohonan/penetapan/showform/1/'.$rows['id'].'/'.$rows['idizin'].'/'.
		                          $rows['pendaftaran_id']), img($revisi_naskah), 'rel="upload_box"');
                            }else{
		                          echo "<br>".$ket.'&nbsp';
		                        }
                          }else{
                            $ket = '<span style="color: Red">'.'Upload Gagal'.'</span>';
		                        echo "<br>".$ket;
		                      }
                        }
				                if($cek_upload || $rows['e_ttd'] == 1){
                          if(file_exists('assets/download/SK_'.$rows['pendaftaran_id'].'.docx')){
    	                  	  if($rows['approve'] == 0) $terkunci=TRUE;
		                          $cek_upload = TRUE;
			                      echo $b."<br>".'Naskah Siap'.$be;
			                      $create_pdf = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                'alt' => 'Coba2 PDF',
                                                'title' => 'Coba2 PDF',
                                                'border' => '0');
                            if($admin){ // aktif hanya untuk percobaan saja
                              //echo anchor(site_url('permohonan/penetapan/create_pdf/'.$rows['id']), img($create_pdf));
                              $ambil_naskah = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                  'alt' => 'Create Naskah',
                                                  'title' => 'Create Naskah',
                                                  'border' => '0');
                              if($rows['e_ttd'] == 1)    // mode ttd Elektronik
                              echo anchor(site_url('permohonan/sk/cetak_sk/'.$rows['id'].'/1'.'/'.'permohonan/penetapan'), img($ambil_naskah));
                            if($rows['e_ttd'] == 2)    // mode Upload
                              echo anchor(site_url('permohonan/sk/cetak_sk/'.$rows['id'].'/3'.'/'.'permohonan/penetapan'), img($ambil_naskah));                   
                            }
		                      }else{
		                        $ambil_naskah = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                  'alt' => 'Create Naskah',
                                                  'title' => 'Create Naskah',
                                                  'border' => '0');
		                        echo "<br>".'<span style="color: Red">'.'Naskah Kosong'.'</span>&nbsp';
		                        if($rows['e_ttd'] == 1)    // mode ttd Elektronik
                              echo anchor(site_url('permohonan/sk/cetak_sk/'.$rows['id'].'/1'.'/'.'permohonan/penetapan'), img($ambil_naskah));
                            if($rows['e_ttd'] == 2)    // mode Upload
		                          echo anchor(site_url('permohonan/sk/cetak_sk/'.$rows['id'].'/3'.'/'.'permohonan/penetapan'), img($ambil_naskah));
			                    }
				                }     
                      }}
					            $stat = $no_sk;
                      $status = "1";
                      if($rows['status_berkas']=='proses'){
                        $permohonan_cek = new tmpermohonan();
                        $permohonan_cek->get_by_id($rows['id']);
                        $permohonan_cek->status_berkas = 'Izin Disetujui'; $permohonan_cek->save();
                        $permohonan_sk_1 = new tmpermohonan_tmsk();
                        $permohonan_sk_1->where('tmpermohonan_id',$rows['id']);
                        if(!$permohonan_sk_1->tmpermohonan_id){
                          $sk_1 = new tmsk();
                          $sk_1->tgl_surat = $this->lib_date->get_date_now();
                          $sk_1->tgl_penetapan = $this->lib_date->get_date_now();
                          $sk_1->no_surat = 'Belum Penomoran';
                          $sk_1->c_status = 1;
                          $sk_1->save($permohonan_cek);
                        }
                      }
                    } else {  // $status_bap === "2"
                      echo $b."<b>Izin Ditolak</b>".$be;
                      $stat = $sk->no_surat_edit;
                      if($stat != '') $stat = $awal_notolak.$sk->no_surat_edit.$akhir_notolak;
                      $tgl_sk = $sk->tgl_surat_edit;
                      $status = "2";
                      if($rows['status_berkas']=='proses'){
                        $permohonan_cek = new tmpermohonan();
                        $permohonan_cek->get_by_id($rows['id']);
                        $permohonan_cek->status_berkas = 'Izin Ditolak'; $permohonan_cek->save();
                        $permohonan_sk_1 = new tmpermohonan_tmsk();
                        $permohonan_sk_1->where('tmpermohonan_id',$rows['id']);
                        if(!$permohonan_sk_1->tmpermohonan_id){
                          $sk_1 = new tmsk();
                          $sk_1->tgl_surat = $this->lib_date->get_date_now();
                          $sk_1->tgl_penetapan = $this->lib_date->get_date_now();
                          $sk_1->no_surat = 'Ditolak';
                          $sk_1->c_status = 1;
                          $sk_1->save($permohonan_cek);
                        }
                      }
                    }
                  } else {
                    echo $b."Belum ditetapkan".$be;
                    $stat = "-";
	                  $status = "3";
                  }
	                $open_back = FALSE;
	                if($rows['back_proses'] == 'ReOpen'){
	                  $open_back = TRUE;
	                  echo $b.'<br>'.$rows['back_proses'].$be;
	                }
	                
	                //cek AKDP
	                // $akdp_cetak = new akdp_cetak();
	                // $akdp_cetak->where('pendaftaran_id', $rows['pendaftaran_id'])->get();
	                // if($akdp_cetak->no_kp){ //jika ditemukan No KP
	                // 	$stat   = $akdp_cetak->no_kp;                    // nomor KP
	                // 	$tgl_sk = $akdp_cetak->tgl_kp_awal;              // tanggal KP
	                // 	$tgl_penetapan = $akdp_cetak->tgl_penetapan_kp;  // tanggal Penetapan KP
	                //   echo $b.'<br>'.$akdp_cetak->no_kend.$be;
	                  /* Mati karna di pindah ke proses Approve di cetakizin.php
	                  if($c_penetapan == 0){   // harus 0 belum ditetapkan
                      //redirect('permohonan/penetapan/auto_save/'.$rows['id']);
                      $id_pemohon = $rows['id'];
                      $u_ser = 'ADMIN';
                      $r_name = 'AUTO SISTEM';
                      $user = new user();
                      $user->where('username', $u_ser)->get();
                      $id_user = $user->id;
                      $permohonan = new tmpermohonan();
                      $permohonan->get_by_id($id_pemohon);
                      $perizinan = $permohonan->trperizinan->get();
                      $e_sertifikat = $perizinan->e_sertifikat;
                      $cek = $permohonan->tmbap->get()->id;
                      $bap = new tmbap();
                      $bap->get_by_id($cek);
                      $kelompok = $perizinan->trkelompok_perizinan->get();
                      $no_pendaftaran = $permohonan->pendaftaran_id;
                      $pemohon = $permohonan->tmpemohon->get();
                      $tgl_skr = $this->lib_date->get_date_now();
                      $idjenis = $perizinan->id;
                      if($bap->c_penetapan !== "1"){   // jika belum ditetapkan != 1
                      	//$akdp_cetak = new akdp_cetak();
                        //$akdp_cetak->where('pendaftaran_id', $no_pendaftaran)->get();
                        $tgl_awal = $this->lib_date->get_date_now();
                        $status_izin = $permohonan->trstspermohonan->get();
                        $status_skr = "8";                     //Penetapan/Penyusunan/Pencetakan Naskah Perizinan [Lihat Tabel trstspermohonan()]  => Kominfo Old 7
                      	$id_status = "13";                     //Surat Diizinkan [Lihat Tabel trstspermohonan()]                                   => Kominfo Old 8
                        $n_status = 'Izin Disetujui';
                      	if($status_izin->id == $status_skr || $bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
                          // Input Data Tracking Progress 
                          if($bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
                      	    $tracking_izin = new tmtrackingperizinan();
                            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                                          ->where('tr_activiti', 'Pertimbangan Teknis')->get();
                            if($tracking_izin->pendaftaran_id){
                              $tracking_izin->tr_activiti = 'Penyusunan Berkas';
                      	      $tracking_izin->status = 'Update';
                      	      $tracking_izin->tr_name = $r_name;
                              $tracking_izin->tr_user = $u_ser;
                      	      $tracking_izin->d_entry = $akdp_cetak->tgl_penetapan_kp;
                      	      $hit_ubah = $tracking_izin->hit_ubah + 1;
                       	      $his_ubah = $tracking_izin->his_ubah;
                       	      $tracking_izin->hit_ubah = $hit_ubah;
                              $tracking_izin->his_ubah = $his_ubah.$n_status.'^'.$r_name.'^'.$this->lib_date->get_date_now().';';
                              $tracking_izin->save();
                            }
                          }
                          
                      	  // Memesan tempat untuk penyerahan izin
                      	  $tracking_izin2 = new tmtrackingperizinan();
                          $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                                         ->where('tr_activiti', 'Penyerahan Izin')->get();
                          if(!$tracking_izin2->pendaftaran_id){
                            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                            $tracking_izin2->status = 'Insert';
                            $tracking_izin2->tr_activiti = 'Penyerahan Izin';
                            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
                            $sts_izin2 = new trstspermohonan();
                       	    $sts_izin2->get_by_id($status_skr); //[Lihat Tabel trstspermohonan()]   => edit PBS
                            $sts_izin2->save($permohonan);
                            $tracking_izin2->save($permohonan);
                            $tracking_izin2->save($sts_izin2);
                      	  }
                                    
                      	  $tracking_izin2 = new tmtrackingperizinan();
                          $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                                         ->where('tr_activiti', 'Arsip')->get();
                          if(!$tracking_izin2->pendaftaran_id){
                            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                            $tracking_izin2->status = 'Insert';
                            $tracking_izin2->tr_activiti = 'Arsip';
                            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
                            $sts_izin2 = new trstspermohonan();
                       	    $sts_izin2->get_by_id('16'); //[Lihat Tabel trstspermohonan()]   => edit PBS
                            $sts_izin2->save($permohonan);
                            $tracking_izin2->save($permohonan);
                            $tracking_izin2->save($sts_izin2);
                      	  }
                      	  
                          $petugas = 1; //1 -> Jabatan Penandatangan
                          $tgl_skr = $this->lib_date->get_date_now();
                          $data_tahun = date("Y");
                          if($id_status == "13"){              //Surat Diizinkan [Lihat Tabel trstspermohonan()] => Kominfo Old 8
                            // Input Data 
                            $data_id = new tmsk();
                            $data_id->select_max('id')->get();
                            $data_id->get_by_id($data_id->id);
                           
                            $no_surat = 'No.SK '.$akdp_cetak->no_sk.' No.KP '.$akdp_cetak->no_kp;
                      	    $tgl_surat = $akdp_cetak->tgl_penetapan_kp;
                      	    
                            $surat_sk = new tmsk();
                            $surat_sk->c_status = 1;
                            $surat_sk->i_urut = 0;                   //$data_urut;
                            $surat_sk->no_surat = $no_surat;
                            $surat_sk->no_surat_edit = $no_surat;
                      	    $surat_sk->tgl_surat = $tgl_surat;
                      	    $surat_sk->tgl_surat_edit = $tgl_surat;
                      	    $surat_sk->tgl_penetapan = $tgl_surat;
                      	    $surat_sk->id_user_penetapan = $id_user;
                            
                            // Input Relasi Tabel
                            $pegawai = new tmpegawai();
                            $pegawai->where('status', $petugas)->get();
                            $permohonan->d_berlaku_izin = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+$perizinan->v_berlaku_tahun));
                            $permohonan->nip_ttd = $pegawai->nip;
                            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
                            $permohonan->d_berlaku_keputusan = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+1));
                      	    
                      	    // PBS Create
                            $permohonan->status_berkas = $n_status;
                            if($e_sertifikat == 0){
                      	      $permohonan->approve = 1;       // posisi di approve pengolah ptsp
                      	    }
                      	    if($permohonan->kd_status < 6){ // ubah kd_status menjadi 6 (Penetapan, lihat status_berkas) untuk proses selanjutnya (Pencetakkan naskah izin)
                              $permohonan->kd_status = 6;
                      	    }
                            // EOF PBS Create
                              
                            $permohonan->save();
                            $surat_sk->save(array($permohonan, $pegawai));
                          }
                        }
                        $bap->status_bap = 1;
                        $bap->c_penetapan = 1;
                        $bap->save();
                      }
	                  }
	                  */
	                //}
	                //EOF() cek AKDP
	                
                  ?>
                </td>
                <td valign='top'>
	                <?php
                  echo $b.$this->lib_date->mysql_to_human($tgl_penetapan).'<br>'.$be;
	                echo $b.$stat.'<br>'.$be;
                  if($tgl_sk != '')
                    echo $b.$this->lib_date->mysql_to_human($tgl_sk).$be;
                  else
                    echo $b.'-'.$be;
                  ?> 
                </td>
                <td valign='top'>
                  <?php
                  $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
                  echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/10', img($img_lihat))."&nbsp;";
                  
                  
                  if(file_exists('assets/pertekSE/PT_'.$rows['pendaftaran_id'].'.pdf') || file_exists('assets/pertek/PT_'.$rows['pendaftaran_id'].'.pdf')) {
                    $unduh_pertek = array('src' => base_url().'assets/images/icon/download.png',
                                          'alt' => 'Download Pertek',
                                          'title' => 'Download Pertek',
                                          'border' => '0');
                    echo anchor(site_url('permohonan/penetapan/download_pertek') .'/'.$rows['pendaftaran_id'], img($unduh_pertek))."&nbsp;";
                  }
                  
                  $img_nomor = array('src' => base_url().'assets/images/icon/clipboard.png',
                                     'alt' => 'Penomoran SK',   // (System)
                                     'title' => 'Penomoran SK', // (System)
                                     'border' => '0');

                  $img_nomor1 = array('src' => base_url().'assets/images/icon/clipboard-doc.png',
                                      'alt' => 'Penomoran SK Manual (Admin)',   // (Manual)
                                      'title' => 'Penomoran SK Manual (Admin)', // (Manual)
                                      'border' => '0');

                  $img_penetapan = array('src' => base_url().'assets/images/icon/property.png',
                                         'alt' => 'Proses Penetapan SK',
                                         'title' => 'Proses Penetapan SK',
                                         'border' => '0');

                  $img_edit = array('src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Edit Alasan Penolakan Permohonan',
                                    'title' => 'Edit Alasan Penolakan Permohonan',
                                    'border' => '0');

                  $img_ctk_kembali = array('src' => base_url().'assets/images/icon/print1.png',
                                           'alt' => 'Cetak Surat Pengembalian / Penolakan',
                                           'title' => 'Cetak Surat Pengembalian / Penolakan',
                                           'border' => '0');

                  $img_kirim_tolak = array('src' => base_url().'assets/images/icon/navigation.png',
                                           'alt' => 'Kirim Surat Penolakan untuk Approval',
                                           'title' => 'Kirim Surat Penolakan untuk Approval',
                                           'border' => '0');

                  $img_backOP = array('src' => base_url().'assets/images/icon/minus.png',
                                      'alt' => 'Kembalikan Ke Proses Sebelum (Admin)',
                                      'title' => 'Kembalikan Ke Proses Sebelum (Admin)',
                                      'border' => '0');

                  $img_backClr = array('src' => base_url().'assets/images/icon/alert-icon.png',
                                       'alt' => 'Batal Kembalikan Ke Proses Sebelum (Admin)',
                                       'title' => 'Batal Kembalikan Ke Proses Sebelum (Admin)',
                                       'border' => '0');

                  $img_back = array('src' => base_url().'assets/images/icon/minus.png',
                                    'alt' => 'Kembalikan Ke Proses Sebelum',
                                    'title' => 'Kembalikan Ke Proses Sebelum',
                                    'border' => '0',
                                   );

                  $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                      'alt' => 'Hapus Data',
                                      'title' => 'Hapus Data',
                                      'border' => '0');

                  $img_download = array('src' => base_url().'assets/images/icon/print1.png',
                                      'alt' => 'Download SK Docx',
                                      'title' => 'Download SK Docx',
                                      'border' => '0');

                  $img_upload = array('src' => base_url().'assets/images/icon/navigation.png',
                                      'alt' => 'Upload SK PDF',
                                      'title' => 'Upload SK PDF',
                                      'border' => '0');

                  $img_prevtolak = array('src' => base_url().'assets/images/icon/print_off.png',
                                      'alt' => 'Preview Naskah Tolak',
                                      'title' => 'Preview Naskah Tolak',
                                      'border' => '0');

                  if($status === "3"){      // jika belum ditetapkan
                    if($kd_auth == '2' || $kd_auth == '3') { 
                      // jika role penetapan ( penetapan / penetapan dan penomoran )
                      if($rows['indeks'] != 'AKDP'){
                        if($rows['kd_status'] == '5') {
                           echo anchor(site_url('permohonan/penetapan/viewSK') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_penetapan));
                        }else{
                          if($kd_klmk == '1' || $kd_klmk == '3' || $kd_klmk == '5') { // kelompok perizinan 1,3 dan 5
                             echo anchor(site_url('permohonan/penetapan/viewSK') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_penetapan));
                          }
                        }
                      }
                    }
                  }else{
                    if($status !== "2") {
                      if($rows['indeks'] != 'AKDP'){
                        if($kd_auth == '1' || $kd_auth == '3') { // jika role penetapan ( penetapan / penetapan dan penomoran )
                          if($penomoran){
                            echo anchor(site_url('permohonan/penetapan/penomoran').'/'.$rows['id'].'/'.$rows['idizin'], img($img_nomor));
                            if($admin){
                              //echo anchor(site_url('permohonan/penetapan/penomoran').'/'.$rows['id'].'/'.$rows['idizin'].'/0/4', img($img_nomor1));
                            }
                          }
                        }  
                      }
                    }else{
                      echo anchor(site_url('permohonan/penetapan/viewSK2') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_edit));  // jika ditolak
                      echo anchor(site_url('permohonan/penetapan/ctk_pengembalian') .'/'. $rows['id'].'/'.$rows['idizin'].'/1', img($img_prevtolak));
                      //if ($this->All) {
                        if (!$this->m_penolakan->get_status_tolak($rows['id'])) {
                          echo anchor(site_url('permohonan/penetapan/tolak_surat') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_kirim_tolak));
                        }
                      //}
                      
                    }
                    if(file_exists('assets/pertek/PT_'.$rows['pendaftaran_id'].'.pdf') || ($kd_klmk == '1' || $kd_klmk == '3' || $kd_klmk == '5')) {
                      if ($cek_upload && !$penomoran && $stat != "Belum Penomoran") {
                        echo anchor(site_url('permohonan/penetapan/download_docx') .'/'. $rows['pendaftaran_id'], img($img_download));
                        echo "&nbsp;";
                        echo anchor(site_url('permohonan/penetapan/showform_pdf') .'/'. $rows['id'].'/'. $rows['idizin'].'/'.$rows['pendaftaran_id'], img($img_upload), 'rel="upload_box"');
                      }
                    }

                    if($admin && !$open_back && $rows['kd_status'] < 9){ // Khusus Admin
                      echo "&nbsp;";
                     echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_backOP));
                     if($status_bap == "1") {
                        echo "&nbsp;".$rows['i_urut'];
                      }
                    }
                    if($admin && $open_back && $rows['kd_status'] < 9){ // Khusus Admin
                      echo "&nbsp;";
                      echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_backClr));
                      if($status_bap == "1") {
                        echo "&nbsp;".$rows['i_urut'];
                      }
                    }
                    if(!$admin && $open_back){ // utk Pengolah dg status ReOpen
                      echo "&nbsp;";
                     echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_back));
                    }
                  }
                  if($del) echo anchor(site_url('permohonan/penetapan/delete_bap') .'/'. $id_bap, img($img_delete));

                  $ctk_gis = array('src' => 'assets/images/icon/look.png',
                                   'alt' => 'Lihat Lokasi Visitasi',
                                   'title' => 'Lihat Lokasi Visitasi',
                                   'border' => '0');
                  if($detail_gis->id_data){
                    echo anchor(site_url('survey/view_visit') .'/'.$detail_gis->id_data.'/2', img($ctk_gis));
                  }
                  if ($cek_upload && !$penomoran && $stat != "Belum Penomoran" && $rows['e_ttd'] != '1') {
                    if(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                      $img_chk = array('src' => base_url().'assets/images/icon/chk.png',
                                                  'alt' => 'Berhasil Upload PDF',
                                                  'title' => 'Berhasil Upload PDF',
                                                  'border' => '0');
                      echo '<br>'.img($img_chk)."&nbsp;";
                    } else {
                      $img_warning = array('src' => base_url().'assets/images/icon/wrn.png',
                                                  'alt' => 'File PDF Belum Ditemukan',
                                                  'title' => 'File PDF Belum Ditemukan',
                                                  'border' => '0');
                      echo '<br>'.img($img_warning)."&nbsp;";
                    }
                  }

                  if($terkunci){
                    $look_dt = array('src' => 'assets/images/icon/pengolahmrh.png',
                                     'alt' => 'Kunci Data Sekarang',
                                     'title' => 'Kunci Data Sekarang',
                                     'border' => '0');
                    // belum diamankan utk hanya pengolah yang bisa memprosesnya
                    if($admin || $eselon == 9){
                      echo anchor(site_url('permohonan/penetapan/kunci_data') .'/'.$rows['id'], img($look_dt));
                    }
                  }
                  ?>
                  <!-- <?php
                  $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
                  echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/10', img($img_lihat))."&nbsp;";

                  $img_nomor = array('src' => base_url().'assets/images/icon/clipboard.png',
                                     'alt' => 'Penomoran SK',   // (System)
                                     'title' => 'Penomoran SK', // (System)
                                     'border' => '0');

                  $img_nomor1 = array('src' => base_url().'assets/images/icon/clipboard-doc.png',
                                      'alt' => 'Penomoran SK Manual (Admin)',   // (Manual)
                                      'title' => 'Penomoran SK Manual (Admin)', // (Manual)
                                      'border' => '0');

                  $img_penetapan = array('src' => base_url().'assets/images/icon/property.png',
                                         'alt' => 'Proses Penetapan SK',
                                         'title' => 'Proses Penetapan SK',
                                         'border' => '0');

                  $img_edit = array('src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Edit Alasan Penolakan Permohonan',
                                    'title' => 'Edit Alasan Penolakan Permohonan',
                                    'border' => '0');

                  $img_ctk_kembali = array('src' => base_url().'assets/images/icon/print1.png',
                                           'alt' => 'Cetak Surat Pengembalian / Penolakan',
                                           'title' => 'Cetak Surat Pengembalian / Penolakan',
                                           'border' => '0');

                  $img_backOP = array('src' => base_url().'assets/images/icon/minus.png',
                                      'alt' => 'Kembalikan Ke Proses Sebelum (Admin)',
                                      'title' => 'Kembalikan Ke Proses Sebelum (Admin)',
                                      'border' => '0');

                  $img_backClr = array('src' => base_url().'assets/images/icon/alert-icon.png',
                                       'alt' => 'Batal Kembalikan Ke Proses Sebelum (Admin)',
                                       'title' => 'Batal Kembalikan Ke Proses Sebelum (Admin)',
                                       'border' => '0');

                  $img_back = array('src' => base_url().'assets/images/icon/minus.png',
                                    'alt' => 'Kembalikan Ke Proses Sebelum',
                                    'title' => 'Kembalikan Ke Proses Sebelum',
                                    'border' => '0',
                                   );

                  $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                      'alt' => 'Hapus Data',
                                      'title' => 'Hapus Data',
                                      'border' => '0');

                  if($status === "3"){      // jika belum ditetapkan
                    if($kd_auth == '2' || $kd_auth == '3') { 
                      // jika role penetapan ( penetapan / penetapan dan penomoran )
                      if($rows['indeks'] != 'AKDP'){
                        if($rows['kd_status'] == '5') {
                           echo anchor(site_url('permohonan/penetapan/viewSK') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_penetapan));
                        }else{
                          if($kd_klmk == '1' || $kd_klmk == '3' || $kd_klmk == '5') { // kelompok perizinan 1,3 dan 5
                             echo anchor(site_url('permohonan/penetapan/viewSK') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_penetapan));
                          }
                        }
                      }
	                  }
                  }else{
                    if($status !== "2") {
                    	if($rows['indeks'] != 'AKDP'){
                        if($kd_auth == '1' || $kd_auth == '3') { // jika role penetapan ( penetapan / penetapan dan penomoran )
                          if($penomoran){
                            echo anchor(site_url('permohonan/penetapan/penomoran').'/'.$rows['id'].'/'.$rows['idizin'], img($img_nomor));
                            if($admin)
                              echo anchor(site_url('permohonan/penetapan/penomoran').'/'.$rows['id'].'/'.$rows['idizin'].'/0/4', img($img_nomor1));
                          }
                        }  
                      }
                    }else{
                      echo anchor(site_url('permohonan/penetapan/viewSK2') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_edit));  // jika ditolak
                      echo anchor(site_url('permohonan/penetapan/ctk_pengembalian') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_ctk_kembali));
                    }
                    if($admin && !$open_back && $rows['kd_status'] < 9){ // Khusus Admin
                     echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_backOP));
                    }
                    if($admin && $open_back && $rows['kd_status'] < 9){ // Khusus Admin
                      echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_backClr));
                    }
                    if(!$admin && $open_back){ // utk Pengolah dg status ReOpen
                     echo anchor(site_url('permohonan/penetapan/save') .'/'. $rows['id'], img($img_back));
                    }
                  }
                  if($del) echo anchor(site_url('permohonan/penetapan/delete_bap') .'/'. $id_bap, img($img_delete));

                  $ctk_gis = array('src' => 'assets/images/icon/look.png',
                                   'alt' => 'Lihat Lokasi Visitasi',
                                   'title' => 'Lihat Lokasi Visitasi',
                                   'border' => '0');
                  if($detail_gis->id_data){
                    echo anchor(site_url('survey/view_visit') .'/'.$detail_gis->id_data.'/2', img($ctk_gis));
                  }
                  if($terkunci){
                  	$look_dt = array('src' => 'assets/images/icon/pengolahmrh.png',
                                     'alt' => 'Kunci Data Sekarang',
                                     'title' => 'Kunci Data Sekarang',
                                     'border' => '0');
                    // belum diamankan utk hanya pengolah yang bisa memprosesnya
                    if($admin || $eselon == 9){
                      echo anchor(site_url('permohonan/penetapan/kunci_data') .'/'.$rows['id'], img($look_dt));
                    }
                  }
                  ?> -->
                </td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>