
<style type="text/css">
    .gambar {
        -webkit-transform: scale(0.5);
        /* Saf3.1+, Chrome */
        -moz-transform: scale(0.5);
        /* FF3.5+ */
        -ms-transform: scale(0.5);
        /* IE9 */
        -o-transform: scale(0.5);
        /* Opera 10.5+ */
        transform: scale(0.5);
        /* IE6–IE9 */
        filter: progid:DXImageTransform.Microsoft.Matrix(M11=0.9999619230641713, M12=-0.008726535498373935, M21=0.008726535498373935, M22=0.9999619230641713, SizingMethod='auto expand');
    }
</style>
<script>
  $(document).ready(function() { 
  });

  function validasi() {
    var tgl1 = document.getElementById('inputTanggal1').value;
    var tgl2 = document.getElementById('inputTanggal2').value;
	  return true;
  }

  function ceksumber(sumber) {
    if(sumber=='PASSPORT') {
      $("input[name=no_refer]").attr("class", 'input-wrc required');
    } else {
      $("input[name=no_refer]").attr("class", 'input-wrc required digits');
    }
  }

  function cheker() { 
    $('#form').validate();
    var a = document.getElementsByName("pemohon_syarat[]");
	  var b = document.getElementsByName("keaslian_syarat_wajib[]");
	  var c = document.getElementsByName("keaslian_syarat_lainnya[]");
	  var d = document.getElementsByName("kode_keterangan_wajib[]");
    var jml ='<?php echo $jml_syarat; ?>';
	  var group ='<?php echo $group; ?>';
    var total=0;
    for(var i=0; i < jml; i++){
      if(a[i].checked) {
        total++;
      }
    }
    if(validasi()==false) {
      document.forms[0].submit.disabled=true;
    }else{
      if(total == jml || group == 3) {
        document.forms[0].submit.disabled=false;
        $('#coba').html('');
        //$('#test').html('');
      }else{
        document.forms[0].submit.disabled=true;
        $('#coba').html("<p id='eror'>* Lengkapi Persyaratan Untuk Mengaktifkan Tombol Simpan</p>");
      }
  	}
  }

  window.onload = cheker;
  $(function() {
    var validator = $('#form').validate();
    var tabs = $( "#tabs" ).tabs({
      select: function(event, ui){
        var valid = true;
        var current = $(this).tabs("option","selected");
        $('#form').find(':input.required, select.notSelect').each(function(){
          console.log(valid);
          if(!validator.element(this) && valid){
            valid = false;     
          }
        });
        if(valid == false){
          $('#test').html('Data Belum Lengkap, Silahkah Diisi');
        }else{
          $('#test').html('');
        }               
      }
    });
  });
</script>

<style>
  #eror {
    color:#FF0000;
    font-weight:bold;
    text-align:center;
  }

	#eror1 {
    color:#FF0000;
    font-weight:bold;
  }

  .field_error {
    color:#FF0000;
    position:relative;
    font-size: 9px;
    margin: -4% 0 0 74%;
    padding: 0 0 2% 0 ;
  }
</style>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Data Perizinan</legend>
        <?php
        $attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
        //cek Mengisi SKM
	      $isi_skm = new skm_data_skm();
	      $isi_skm->where('permohonan_id', $list_daftar->id)->get();
	      $skm = FALSE;
        $ket_skm = 'Pemohon Belum Mengisi Survay';
	      if($isi_skm->permohonan_id){ //jika ditemukan No id
	        $skm = TRUE;
          $ket_skm = 'Pemohon Sudah Mengisi Survay';
	      } 
        switch($list_daftar->approve){
          case 1 : $vaprove = FALSE; $ket_skm = 'Naskah Dalam Proses Paraf JF'; break;
          case 4 : $vaprove = FALSE; $ket_skm = 'Naskah Dalam Proses Paraf ESL III'; break;
			    case 3 : $vaprove = FALSE; $ket_skm = 'Naskah Dalam Proses Penandatanganan Kepala Dinas'; break;
			    case 2 : $vaprove = TRUE ; break;
			    default: $vaprove = FALSE; $ket_skm = 'Naskah Dalam Proses Penandatanganan'; break;
        }
        //EOF()cek Mengisi SKM  
        
        //Status Pencabutan Izin
        switch($c_izin_dicabut) {
					case 0: $sts_izin = ''; break;
					case 1: $sts_izin = 'Izin Dalam Proses Pencabutan '.$this->lib_date->mysql_to_human($d_ajuan_cabut); break;
          case 2: $sts_izin = 'Izin Dicabut '.$this->lib_date->mysql_to_human($d_izin_dicabut); break;
          case 3: $sts_izin = 'Mencabut Izin No Resi '.$id_lama; break;
        }
        //EOF() Status Pencabutan Izin
            
        echo form_open('arsip/arsip/save', $attr);
        if($paralel == "no") {
          if($jenis_izin->id) {
            ?>
                
			      <div id="statusRail" style="font-weight: bold">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('NIB', 'nib'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $nib; ?>
              </div>
            </div>
            <div id="statusRail" style="font-weight: bold"> 
              <div id="leftRail">
                <?php echo form_label('Nama Izin', 'nama_izin'); ?>
              </div>
              <div id="rightRail">
                <?php echo $jenis_izin->n_perizinan; ?>
              </div>
            </div>
						<?php
            if($save_method == "update") {
              ?>
              <div id="statusRail" style="font-weight: bold">
                <div id="leftRail" class="bg-grid">
                  <?php echo form_label('No / Tgl Pendaftaran', 'no_daftar'); ?>
                </div>
                <div id="rightRail" class="bg-grid">
                  <?php echo $list_daftar->pendaftaran_id .' / '. $this->lib_date->mysql_to_human($tgl_daftar); ?>
                </div>
              </div>
              <?php
              if ($list_daftar->c_paralel !== '0') {
                ?>
                <div id="statusRail">
                  <div id="leftRail">
                    <?php echo form_label('Jenis Paralel', 'name_paralel'); ?>
                  </div>
                  <div id="rightRail">
                    <?php echo $jenis_paralel->n_paralel; ?>
                  </div>
                </div>
                <?php
              }
              // hitung durasi sedangg customm
              // $tgl_selesai = $tgl_sk;
              // $tgl_entry = $tgl_daftar;
              // $libur = new tmholiday();
              // $hari_libur = $libur->where("date >= '$tgl_entry' AND date <= '$tgl_selesai'")->count();
              // $hari_libur = $libur->where('date <=', $tgl_selesai)->count();//where('date <=', '2014-03-24')->count();
              // $hari = $libur->where("date >= '$tgl_entry' and date <= '$tgl_selesai'")->count();
              // $lama_hari = $tgl_selesai - $tgl_entry;
              // $durasi = $lama_hari - $hari_libur;
							  ?>
							<div id="statusRail" style="font-weight: bold">
                <div id="leftRail">
                  <?php echo form_label('Status Permohonan', 'no_sk'); ?>
                </div>
                <div id="rightRail">
                  <?php
                    echo $n_status;
                    echo '<br>';
                    echo '<span style="color: Red">'.$sts_izin.'</span>';
                  ?>
                </div>
              </div>

							<div id="statusRail" style="font-weight: bold">
                <div id="leftRail" class="bg-grid">
                  <?php echo form_label('Nomor SK', 'no_sk'); ?>
                </div>
                <div id="rightRail" class="bg-grid">
                  <?php
                  if($edit){
                    $sk_input = array('name' => 'no_sk',
                                      'value' => $no_sk,
                                      'style'=>'width:70%',
                                      'class' => 'input-wrc'
                                     );
                    echo form_input($sk_input);
							    }else{
								    echo $no_sk;
									}
							    ?>
                </div>
              </div>
							
							<div id="statusRail" style="font-weight: bold">
                <div id="leftRail">
                  <?php echo form_label('Tanggal SK', 'tgl_sk'); ?>
                </div>
                <div id="rightRail">
                  <?php
								  if($edit){
								    $tgl_sk_in = array('name' => 'tgl_sk',
                                       'value' => $tgl_sk,
                                       'class' => 'monbulan',
										                   'readOnly'=>TRUE,
                                      );
    								echo form_input($tgl_sk_in);
                  }else{
								    echo $this->lib_date->mysql_to_human($tgl_sk);
                  }
							    ?>
                </div>
              </div>

							<div id="statusRail" style="font-weight: bold">
                <div id="leftRail" class="bg-grid">
                  <?php echo form_label('Target Durasi', 'durasi'); ?>
                </div>
                <div id="rightRail" class="bg-grid">
                  <?php
                  $ldurasi = $this->lib_date->lama_durasi($tgl_daftar, $tgl_sk);
                  $vhari = $jenis_izin->v_hari;
                  if($ldurasi == '-'){
                  	$ldurasi = $this->lib_date->lama_durasi($tgl_daftar, date("Y-m-d"));
                  	$ketdurasi = $vhari.' Hari, ( Izin Dalam Proses '.$ldurasi.' Hari )';
                  }else{
                    $ketdurasi = $vhari.' Hari, ( Selesai Dalam '.$ldurasi.' Hari )';
                  }
                  if($vhari < $ldurasi){
                    $statdurasi = 'Ket. Melebihi Durasi';
                    $b = '<span style="color: Red">';
                    $be = '</span>';
                  }else{
                  	if($vhari > $ldurasi){
                      $statdurasi =  'Ket. Kurang dari Durasi';
                      $b = '<span style="color: Green">';
                      $be = '</span>';
                    }else{
                      $statdurasi =  'Ket. Sesuai Durasi';
                      $b = '<span style="color: Yellow">';
                      $be = '</span>';
                    }  
                  }
                  echo $b;
                  echo $ketdurasi;
                  echo '<br>';
                  echo $statdurasi;
                  echo $be;
                  //echo $hari_libur;
									//echo $tgl_entry;
									?>
                </div>
              </div>
							<?php
            }
          }else{
            ?>
            <div class="ContentForm" style="font-weight: bold;text-align: center"> Jenis Izin belum dipilih
              <div style="float: right">
                <?php
                $kembali = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => '&laquo; back',
                                 'onclick' => 'parent.location=\'' . site_url('arsip/arsip/list_index') . '\''
                                );
                echo form_button($kembali);
                ?>
              </div>
            </div>
            <?php
          }
        }else{
          if ($list_izin_paralel) {
            ?>
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Jenis Paralel', 'name_paralel'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_paralel->n_paralel; ?>
              </div>
            </div>
            <br style="clear: both">
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Jenis Izin yang dipilih', 'name_izin'); ?>
              </div>
              <div id="rightRail">
                <?php
                foreach ($list_izin_paralel as $row) {
                  $row_izin = new trperizinan();
                  $row_izin->get_by_id($row);
                  echo $row_izin->n_perizinan . "<br />";
                }
                ?>
              </div>
            </div>
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Jenis Permohonan', 'jenis_permohonan'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_permohonan->n_permohonan; ?>
              </div>
            </div>
            <?php
          }else{
            ?>
            <div class="ContentForm" style="font-weight: bold;text-align: center">Izin Paralel belum dipilih
              <div style="float: right">
                <?php
                $kembali = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => '&laquo; back',
				                         'onclick' => 'parent.location=\'' . site_url('arsip/arsip/list_index') . '\''
                                );
                echo form_button($kembali);
                ?>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </fieldset>
    </div>
    <?php
    if($eror) {
      echo (" <p id='eror'>$eror</p>");
    }
    ?>
    <p id='eror'><span id="test"></span></p>

    <?php
    $fileName = 'SK_'.$list_daftar->pendaftaran_id.'.pdf';
    $docxName = 'SK_'.$list_daftar->pendaftaran_id.'.docx';
		if($paralel == "yes") {
      if ($list_izin_paralel) {
        foreach ($list_izin_paralel as $row) {
          $row_izin = new trperizinan();
          $row_izin->get_by_id($row);
          echo form_hidden('list_izin_paralel[]', $row_izin->id);
        }
      }
    }
    if(!$edit){
			echo form_hidden('no_sk', $no_sk);
			echo form_hidden('tgl_sk', $tgl_sk);
    }
		echo form_hidden('id_sk', $id_sk);
    echo form_hidden('jenis_permohonan', $mohon);
    echo form_hidden('paralel', $paralel);
    echo form_hidden('jenis_izin', $izin);
    echo form_hidden('jenis_izin_id', $jenis_izin->id);
    echo form_hidden('jenis_permohonan_id', $jenis_permohonan->id);
    echo form_hidden('id_daftar', $id_daftar);
    echo form_hidden('waktu_awal', $waktu_awal);
    echo form_hidden('eror', 'halo');
    if($paralel == "yes")
      echo form_hidden('jenis_paralel', $jenis_paralel->id);
    ?>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1"><b>DATA PEMOHON & PERMOHONAN</b></a></li>
          <li><a href="#tabs-2"><b>DATA PERUSAHAAN</b></a></li>
		    	<li><a href="#tabs-3"><b>DATA TEKNIS</b></a></li>
          <li><a href="#tabs-4"><b>ARSIP / PERSYARATAN</b></a></li>
		    	<li><a href="#tabs-5"><b>TRACKING PERIZINAN</b></a></li>
          <?php if(file_exists('assets/esignfile/SK_'.$list_daftar->pendaftaran_id.'.pdf') || $lokasi_user != "OPD Teknis") { ?>
		    	<li><a href="#tabs-6"><b>BERKAS IZIN</b></a></li>
          <?php } ?>
          <li><a href="#tabs-7"><b>DATA PERSYARATAN</b></a></li>
          <li><a href="#tabs-8"><b>DATA LAPANGAN</b></a></li>
          <li><a href="#tabs-9"><b>DATA IZIN TERKAIT</b></a></li>
        </ul>
        <?php
        if($paralel == "yes")
          $real_id = $list_izin_paralel;
        else
          $real_id = $jenis_izin->id;
        if($real_id) {
          ?>
          <!-- ---------- TABS 1 ( Data Pemohon ) ----------- -->
          <div id="tabs-1">
            <div id="contentleft">
			    	  <div class="contentForm">
                <?php
                echo '<b><H2>' . form_label('DATA PEMOHON ') . '</H2></b>';
                ?>
              </div>
				    	<table cellpadding="0" cellspacing="0" border="0" class="display">
					    	<?php 
						    echo "<tr>";
  					      echo "<td align='left'    valign='top' width='22%'><b>".'Nomor Antrian'."</b></td>"."";
	  				      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		  			      echo "<td align='Justify' valign='top' width='75%'>".$no_antri."</td>"."";
			  			  echo "</tr>";

				  		  echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Tgl Terima Berkas'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$this->lib_date->mysql_to_human($tgl_daftar)."</td>"."";
						    echo "</tr>";

  						  if($admin){
	  					    echo "<tr>";
		  			        echo "<td align='left'    valign='top' width='22%'><b>".'Tanggal Daftar Real'."</b></td>"."";
			  		        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
				  	        echo "<td align='Justify' valign='top' width='75%'>".$this->lib_date->mysql_to_human($tgl_daftar_asli).' (Hanya untuk Admin)'."</td>"."";
					  	    echo "</tr>";
                }

  						  echo "<tr>";
	  				      echo "<td align='left'    valign='top' width='22%'><b>".'Tempat Pendaftaran'."</b></td>"."";
		  			      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
			  		      echo "<td align='Justify' valign='top' width='75%'>".$cmbgerai."</td>"."";
				  		  echo "</tr>";

  						  echo "<tr>";
	  				      echo "<td align='left'    valign='top' width='22%'><b>".'Sumber Identitas'."</b></td>"."";
		  			      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
			  		      echo "<td align='Justify' valign='top' width='75%'>".$cmbsource."</td>"."";
				  		  echo "</tr>";
						
                echo "<tr>";
  					      echo "<td align='left'    valign='top' width='22%'><b>".'NO ID'."</b></td>"."";
	  				      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		  			      echo "<td align='Justify' valign='top' width='75%'>".$no_refer."</td>"."";
			  			  echo "</tr>";
						
				  		  if($save_method == "update") echo ("<br>");

					  	  echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Nama Pemohon'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$nama_pemohon."</td>"."";
						    echo "</tr>";

                echo "<tr>";
	  				      echo "<td align='left'    valign='top' width='22%'><b>".'No Telp/HP'."</b></td>"."";
		  			      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
			  		      echo "<td align='Justify' valign='top' width='75%'>".$no_telp."</td>"."";
				  		  echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Alamat Pemohon'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$alamat_pemohon."</td>"."";
						    echo "</tr>";

                echo "<tr>";
  					      echo "<td align='left'    valign='top' width='22%'><b>".'Provinsi'."</b></td>"."";
	  				      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		  			      echo "<td align='Justify' valign='top' width='75%'>".$propinsi_pemohon."</td>"."";
			  			  echo "</tr>";

				  		  echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Kabupaten/Kota'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kabupaten_pemohon."</td>"."";
						    echo "</tr>";
						
                echo "<tr>";
			  		      echo "<td align='left'    valign='top' width='22%'><b>".'Kecamatan'."</b></td>"."";
			  		      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
			  		      echo "<td align='Justify' valign='top' width='75%'>".$kecamatan_pemohon."</td>"."";
				  		  echo "</tr>";
						
					  	  echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Kelurahan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kelurahan_pemohon."</td>"."";
						    echo "</tr>";

  						  echo "<tr>";
	  				      echo "<td align='left'    valign='top' width='22%'><b>".'Alamat Pemohon/di Luar Negeri'."</b></td>"."";
		  			      echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
			  		      echo "<td align='Justify' valign='top' width='75%'>".$alamat_pemohon_luar."</td>"."";
				  		  echo "</tr>";

					  	  echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'No Kontak Perantara'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kd_kontak."</td>"."";
						    echo "</tr>";
				        ?>
				      </table>
            </div>

            <div id="contentright">
				      <div class="contentForm">
                <?php
                echo '<b><H2>' . form_label('DATA PERMOHONAN') . '</H2></b>';
                ?>
              </div>
				      <table cellpadding="0" cellspacing="0" border="0" class="display">
					  	  <?php 
		    		    echo "<tr>";
		    	        echo "<td align='left'    valign='top' width='22%'><b>".'Lokasi / Objek Izin'."</b></td>"."";
    		    	    echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		        	    echo "<td align='Justify' valign='top' width='75%'>".$lokasi_izin."</td>"."";
		        		echo "</tr>";
        
                echo "<tr>";
		    	        echo "<td align='left'    valign='top' width='22%'><b>".'Provinsi'."</b></td>"."";
    		    	    echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		        	    echo "<td align='Justify' valign='top' width='75%'>".$propinsi_lok."</td>"."";
		        		echo "</tr>";
        
		    		    echo "<tr>";
		    	        echo "<td align='left'    valign='top' width='22%'><b>".'Kabupaten/Kota'."</b></td>"."";
		    	        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		    	        echo "<td align='Justify' valign='top' width='75%'>".$kabupaten_lok."</td>"."";
		    		    echo "</tr>";
		    		
                echo "<tr>";
		    	        echo "<td align='left'    valign='top' width='22%'><b>".'Kecamatan'."</b></td>"."";
		    	        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		    	        echo "<td align='Justify' valign='top' width='75%'>".$kecamatan_lok."</td>"."";
		    		    echo "</tr>";
		    		
		    		    echo "<tr>";
		    	        echo "<td align='left'    valign='top' width='22%'><b>".'Kelurahan'."</b></td>"."";
		    	        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
		    	        echo "<td align='Justify' valign='top' width='75%'>".$kelurahan_lok."</td>"."";
		    	      echo "</tr>";
    
    		    		echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Keterangan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$keterangan."</td>"."";
						    echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Tgl Peninjauan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$this->lib_date->mysql_to_human($tgl_survey)."</td>"."";
						    echo "</tr>";
				        ?>
				      </table>
            </div>
            <br style="clear: both;" />
          </div>

          <!-- ---------- TABS 2 ( Data Perusahaan ) ----------- -->
          <div id="tabs-2">
            <div id="contentleft">
					    <table cellpadding="0" cellspacing="0" border="0" class="display">
						    <?php 
						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'ID Perusahaan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$id_perusahaan."</td>"."";
						    echo "</tr>";

						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'NPWP'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$npwp."</td>"."";
						    echo "</tr>";

						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'No Register'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$nodaftar."</td>"."";
						    echo "</tr>";
						
                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Nama Perusahaan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$nama_perusahaan."</td>"."";
						    echo "</tr>";
						
						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Telp Perusahaan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$telp_perusahaan."</td>"."";
						    echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Faximile'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$fax."</td>"."";
						    echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'E-mail'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$email."</td>"."";
						    echo "</tr>";
				        ?>
  				    </table>
            </div>

            <div id="contentright">
	    				<table cellpadding="0" cellspacing="0" border="0" class="display">
					    	<?php 
						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Provinsi'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$propinsi_usaha."</td>"."";
						    echo "</tr>";

    						echo "<tr>";
		    			    echo "<td align='left'    valign='top' width='22%'><b>".'Kabupaten/Kota'."</b></td>"."";
				    	    echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kabupaten_usaha."</td>"."";
						    echo "</tr>";
						
                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Kecamatan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kecamatan_usaha."</td>"."";
						    echo "</tr>";
						
						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Kelurahan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$kelurahan_usaha."</td>"."";
						    echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Alamat Perusahaan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$alamat_usaha."</td>"."";
						    echo "</tr>";

                echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Jenis Kegiatan'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$jenis_kegiatan."</td>"."";
						    echo "</tr>";

						    echo "<tr>";
					        echo "<td align='left'    valign='top' width='22%'><b>".'Jenis Investasi'."</b></td>"."";
					        echo "<td align='left'    valign='top' width='2%'><b>".': '."</b></td>"."";
					        echo "<td align='Justify' valign='top' width='75%'>".$jenis_investasi."</td>"."";
						    echo "</tr>";
				        ?>
				      </table>
            </div>
            <br style="clear: both;" />
          </div>

			    <!-- ---------- TABS 3 ( Data Teknis ) ----------- -->
          <div id="tabs-3">
            <table cellpadding="0" cellspacing="0" border="0" class="display">
              <tr>
                <td align="left" width="4%"></td>
                <td align="left" width="20%"></td>
                <td align="left" width="75%"></td>
              </tr>
              <?php
              if($edit && $kyStafOPD == ''){   // Jika proses Edit dan data belum di kunci
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tr>
                    <td align="left" width="4%"></td>
                    <td align="left" width="20%"></td>
                    <td align="left" width="75%"></td>
                  </tr>
                  <?php
                  $id_izin = $jenis_izin->id;
                  $jml_property = $this->lib_date->data_property($id_izin,'1');
                  if($jml_property == '0') {
                    echo "Property Belum Diseting";
                    $stat_property = FALSE;
                  }else{
                    $i = 1;
                    $stat_property = TRUE;
                    $text = $this->lib_date->data_property($id_izin,'2');
                    if($jml_property > '1') {
                      $text = $this->lib_date->sort_property($id_izin, $text);
                    }
                    $list1 = explode (",",$text);
                    foreach ($list1 as $data) {
                      $nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data);
                      $property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
                      $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
                      $hitung = strlen($data_property);
                      $cek_posisi = strpos($data_property,'^'); 
                      $cek_data = substr($data_property,$cek_posisi,$hitung);
                      if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                      if($property_aktif == 'Ya') {
                        echo "<tr>";
                        echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                        echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
                        if($cek_data == '-')
                          $data_property = substr($data_property,0,$cek_posisi);
                        else
                          $data_property = substr($data_property,$cek_posisi+1,$hitung);
						          }else{
                        $data_property = substr($data_property,$cek_posisi+1,$hitung);
                      }
                      $property_type = $this->lib_date->array_property('9',$data);     // Type Property
                      if($property_type == 'ComboBox'){
                        // Create PBS
                        $val_combo = $this->lib_date->array_property('10',$data);    // Isi Pilihan ComboBox
                        if($val_combo){
                          $hitung = strlen($val_combo);
                          $cek_posisi = strpos($val_combo,';');
                          $a = 1;
                          while ($a < 50) {
                            $item_combo = substr($val_combo,0,$cek_posisi);
                            $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
                            $hitung = strlen($val_combo);
                            $cek_posisi = strpos($val_combo,';');
                            if($a == 1) {
                              $opsi_koefisien = array($item_combo => $item_combo);
                            }else{
                              $tempArray = array( $item_combo => $item_combo);
                              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                            }
                            if($cek_posisi == "") {
                              $a = $a + 1;
                              $tempArray = array( $val_combo => $val_combo);
                              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                              $a = 51;
                            }
                            $a = $a + 1;
                          }
                        }
                        if($property_aktif == 'Ya') {
                          echo "<td width='20%'".$bg.">".form_dropdown($nm_var, $opsi_koefisien, $data_property, 'class =  "input-select-wrc"')."</td>";
                        }
                        $opsi_koefisien = '';
                      }

                      if($property_type == 'Tanggal') {
                        if($data_property == '1970-01-01') $data_property = $this->lib_date->get_date_now();
                        $periode = array('name' => $nm_var,
                                         'style'=>'width:10%',
                                         'value' => date("Y-m-d",strtotime($data_property)), //$data_property,
                                         'class' => 'monbulan',
                                         'readOnly'=>TRUE);
                        if($property_aktif == 'Ya') {
                          echo "<td ".$bg.">".form_input($periode)."</td>"; 
                        }
                      }

                      if($property_type == 'TextBox') {
                        $property_input = array('name' => $nm_var,
                                                'style'=>'width:100%',
                                                'value' => $data_property,
                                                'class' => 'input-wrc');
                        if($property_aktif == 'Ya') {
                          echo "<td ".$bg.">".form_input($property_input)."</td>";
                        }
                      }

                      if($property_type == 'Integer') {
                        $uuid = $data_property;
                        $angka_saja = preg_replace('/[^0-9]/', '', $uuid);
                        $data_property = $angka_saja;
                        // var_dump($angka_bersih);

                        $cek_data = (int) $data_property;
                        $property_input = array('name' => $nm_var,
                                                'style'=>'width:10%',
                                                'value' => $data_property,
                                                'class' => 'input-wrc required digits');
                        if($property_aktif == 'Ya') {
                          echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
                        }
                      }
                
                      if($property_aktif == 'Ya') {
                        echo "<td width='80%'".$bg."><b></b></td>";
                        echo "</b></td>";
                        echo "</tr>";
                        $i++;
                      }else{
                        echo form_hidden($nm_var, $data_property);
                      }
                    }
                    if($i == '1'){
                      $stat_property = FALSE;
                      echo "Property Belum diseting";
                    }
                  }
                  ?>
                </table>
			          <?php
              }else{   // Lihat Data
                $id_izin = $jenis_izin->id;
                $jml_property = $this->lib_date->data_property($id_izin,'1');
                if($jml_property == '0') {
                  echo "Property Belum Diseting";
                  $stat_property = FALSE;
                }else{
                  $i = 1;
	                $stat_property = TRUE;
                  $text = $this->lib_date->data_property($id_izin,'2');
                  if($jml_property > 1) {
	                  $text = $this->lib_date->sort_property($id_izin, $text);
                  }
                  $list = explode (",",$text);
                  foreach ($list as $data) {
                    $nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data);  // Nomor Variabel
                    $property_aktif = $this->lib_date->array_property('11',$data);      // Aktifasi Property
                    if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                    if($property_aktif == 'Ya') {
                      echo "<tr>";
                      echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                      echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";    //Nama Property
                    }
                    $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '4');     //4 ambil data akhir
								    if($data_property == ''){
								      $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '3'); //4 ambil data akhir
							      }
							      $data_property = str_replace("^", " ",$data_property);
    			          $property_type = $this->lib_date->array_property('9',$data);     // Type Property
                    if($property_type == 'ComboBox'){
	                    // Create PBS
                      $val_combo = $this->lib_date->array_property('10',$data);    // Isi Pilihan ComboBox
                      if($val_combo){
                        $hitung = strlen($val_combo);
                        $cek_posisi = strpos($val_combo,';');
                        $a = 1;
                        while ($a < 50) {
                          $item_combo = substr($val_combo,0,$cek_posisi);
                          $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
                          $hitung = strlen($val_combo);
                          $cek_posisi = strpos($val_combo,';');
                          if($a == 1) {
				                    $opsi_koefisien = array($item_combo => $item_combo);
                          }else{
	                          $tempArray = array( $item_combo => $item_combo);
                            $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                          }
                          if($cek_posisi == "") {
                            $a = $a + 1;
		                        $tempArray = array( $val_combo => $val_combo);
                            $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                            $a = 51;
                          }
                          $a = $a + 1;
                        }
                      }
                      $opsi_koefisien = '';
                    }
                    if($property_aktif == 'Ya') {
                      if($data_property == "") {
                        echo "<td ".$bg.">".'-'."</td>";
                      }else{
                        if($property_type == 'Tanggal') {
                          echo "<td ".$bg.">".$this->lib_date->mysql_to_human(trim($data_property))."</td>";
                        }else{
                          echo "<td ".$bg.">".$data_property."</td>";
                        }
                      }
                      echo "<td width='80%'".$bg."><b></b></td>";
                      echo "</b></td>";
                      echo "</tr>";
                      $i++;
                    }else{
				              echo form_hidden($nm_var, $data_property);
                    }
                  }
	                if($i == '1') {
                    $stat_property = FALSE;
                    echo "Property Belum diseting";
                  }
                }
			      	}
				      ?>
              <tr>
                <td>&nbsp;</td>
                <td><b>File Pertek</b></td>
                <td>
                	<br>
                  <?php
                  if(file_exists('assets/pertekSE/PT_'.$list_daftar->pendaftaran_id.'.pdf') || file_exists('assets/pertek/PT_'.$list_daftar->pendaftaran_id.'.pdf')) {
                    echo 'Di Upload pada Tanggal : '.$this->lib_date->mysql_to_human($tgl_up_pertek).', '.  substr($tgl_up_pertek, 10);
                    //if($admin){
                      echo '<br>';
                      echo 'Oleh : '.$petugas_upload;
                      echo '<br><br>';
                    //}                  	
                  	?>
                    <a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/arsip/download_pertek/<?php echo $list_daftar->pendaftaran_id; ?>" class="link-wrc"> Download Pertek </a>
                    <?php
                  }
                  ?>
                </td>
              </tr>
			      </table>
          </div>

          <!-- ---------- TAB 4 ( Arsip / Persyaratan ) ---------- -->
          <div id="tabs-4">
            <table cellpadding="0" cellspacing="0" border="1" class="display">
              <thead>
                <tr>
                  <th width="2%">No</th>
                  <th width="64%">Syarat Terlampir Dalam Berkas Permohonan</th>
                  <th width="4%">Status</th>
                  <th width="5%">Verifikasi ADM</th>
                  <th width="5%">Terlampir</th>
                  <th width="5%">Asli</th>
                  <th width="15%">Keterangan</th>
                </tr>
              </thead>
              <tbody>
					      <?php
				        // Ambil Nilai Syarat Lainnya 
    						$val_syarat = $syarat_arsip_lain;
		    				$syarat1 = '-';
			        	$syarat2 = '-';
    	    			$syarat3 = '-';
          			$syarat4 = '-';
		        		$syarat5 = '-';
                if($val_syarat){
        					$hitung = strlen($val_syarat);
                  $cek_posisi = strpos($val_syarat,'^');
                  $a = 1;
                  while ($a < 50) {
                    $item_syarat = substr($val_syarat,0,$cek_posisi);
                    $val_syarat = substr($val_syarat,$cek_posisi+1,$hitung);
                    $hitung = strlen($val_syarat);
                    $cek_posisi = strpos($val_syarat,'^');
                    if($a == 1) {
		    					    $opsi_koefisien = array($item_syarat => $item_syarat);
                    } else {
				        	    $tempArray = array( $item_syarat => $item_syarat);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                    }
                    if($cek_posisi == "") {
                      $a = $a + 1;
		  		            $tempArray = array( $val_syarat => $val_syarat);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                      $a = 51;
                    }
                    $a = $a + 1;
                  }
					        $a = 1;
					        foreach ($opsi_koefisien as $cek_syarat) {
    					      if($a == 1 ) $syarat1 = $cek_syarat;
		        				if($a == 2 ) $syarat2 = $cek_syarat;
	  	         			if($a == 3 ) $syarat3 = $cek_syarat;
    			        	if($a == 4 ) $syarat4 = $cek_syarat;
				            if($a == 5 ) $syarat5 = $cek_syarat;
                    $a++;
		    		      }
                }

						    // Ambil Nilai Keterangan Syarat Lainnya
			          $val_ket_syarat = $ket_syarat_arsip_lain;
						    $ket_lain1 = '-';
			        	$ket_lain2 = '-';
    	    			$ket_lain3 = '-';
          			$ket_lain4 = '-';
		        		$ket_lain5 = '-';
						    if($val_ket_syarat){
        					$hitung = strlen($val_ket_syarat);
                  $cek_posisi = strpos($val_ket_syarat,'^');
                  $a = 1;
                  while ($a < 50) {
                    $item_syarat = substr($val_ket_syarat,0,$cek_posisi);
                    $val_ket_syarat = substr($val_ket_syarat,$cek_posisi+1,$hitung);
                    $hitung = strlen($val_ket_syarat);
                    $cek_posisi = strpos($val_ket_syarat,'^');
                    if($a == 1) {
		    					    $opsi_koefisien = array($item_syarat => $item_syarat);
                    }else {
				        	    $tempArray = array( $item_syarat => $item_syarat);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                    }
                    if($cek_posisi == "") {
                      $a = $a + 1;
		  		        	  $tempArray = array( $val_ket_syarat => $val_ket_syarat);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                      $a = 51;
                    }
                    $a = $a + 1;
                  }
					        $a = 1;
					        foreach ($opsi_koefisien as $cek_ket_syarat) {
    					      if($a == 1 ) $ket_lain1 = $cek_ket_syarat;
		        				if($a == 2 ) $ket_lain2 = $cek_ket_syarat;
	  	         			if($a == 3 ) $ket_lain3 = $cek_ket_syarat;
    			        	if($a == 4 ) $ket_lain4 = $cek_ket_syarat;
				            if($a == 5 ) $ket_lain5 = $cek_ket_syarat;
                    $a++;
		    		      }
                }

						    // Ambil Nilai Keterangan Arsip (tahun,jumlah,sampul,box,rak)
			          $val_ket_arsip = $desc_arsip;
						    $tahun = '-';
			        	$jumlah = '-';
    	    			$sampul = '-';
          			$box = '-';
		        		$rak = '-';
						    if($val_ket_arsip){
        					$hitung = strlen($val_ket_arsip);
                  $cek_posisi = strpos($val_ket_arsip,'^');
                  $a = 1;
                  while ($a < 50) {
                    $item_arsip = substr($val_ket_arsip,0,$cek_posisi);
                    $val_ket_arsip = substr($val_ket_arsip,$cek_posisi+1,$hitung);
                    $hitung = strlen($val_ket_arsip);
                    $cek_posisi = strpos($val_ket_arsip,'^');
                    if($a == 1) {
		    					    $opsi_koefisien = array($item_arsip => $item_arsip);
                    }else {
				        	    $tempArray = array( $item_arsip => $item_arsip);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                    }
                    if($cek_posisi == "") {
                      $a = $a + 1;
		  		            $tempArray = array( $val_ket_arsip => $val_ket_arsip);
                      $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                      $a = 51;
                    }
                    $a = $a + 1;
                  }
					        $a = 1;
					        foreach ($opsi_koefisien as $cek_ket_arsip) {
    					      if($a == 1 ) $tahun = $cek_ket_arsip;
		        				if($a == 2 ) $jumlah = $cek_ket_arsip;
	  	         			if($a == 3 ) $sampul = $cek_ket_arsip;
    			        	if($a == 4 ) $box = $cek_ket_arsip;
				            if($a == 5 ) $rak = $cek_ket_arsip;
                    $a++;
		    		      }
                }
                $i = 0;
                if($paralel == "no") {
                	// merubah data menjadi array keberadaan syarat wajib
							    if($val_combo_syarat){
								    $cek_val_combo = TRUE;
    							  $hitung = strlen($val_combo_syarat);
                    $cek_posisi = strpos($val_combo_syarat,'^');
								    if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
                    while ($a < 50) {
                      $item_combo = substr($val_combo_syarat,0,$cek_posisi);
                      $val_combo_syarat = substr($val_combo_syarat,$cek_posisi+1,$hitung);
                      $hitung = strlen($val_combo_syarat);
                      $cek_posisi = strpos($val_combo_syarat,'^');
                      if($a == 1) {
							          $opsi_koefisien_syarat = array($item_combo => $item_combo);
                      }else {
									      $tempArray = array( $item_combo => $item_combo);
                        $opsi_koefisien_syarat = array_merge ($opsi_koefisien_syarat, $tempArray);
                      }
                      if($cek_posisi == "") {
                        $a = $a + 1;
		  							    $tempArray = array( $val_combo_syarat => $val_combo_syarat);
                        $opsi_koefisien_syarat = array_merge ($opsi_koefisien_syarat, $tempArray);
                        $a = 51;
                      }
                      $a = $a + 1;
                    }
                  }else {
								    $cek_val_combo = FALSE;
					    		}

							    // merubah data menjadi array keaslian syarat wajib
							    if($val_combo_asli){
								    $cek_val_combo_asli = TRUE;
    							  $hitung = strlen($val_combo_asli);
                    $cek_posisi = strpos($val_combo_asli,'^');
                    if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
                    while ($a < 50) {
                      $item_combo = substr($val_combo_asli,0,$cek_posisi);
                      $val_combo_asli = substr($val_combo_asli,$cek_posisi+1,$hitung);
                      $hitung = strlen($val_combo_asli);
                      $cek_posisi = strpos($val_combo_asli,'^');
                      if($a == 1) {
							          $opsi_koefisien_asli = array($item_combo => $item_combo);
                      }else {
									      $tempArray = array( $item_combo => $item_combo);
                        $opsi_koefisien_asli = array_merge ($opsi_koefisien_asli, $tempArray);
                      }
                      if($cek_posisi == "") {
                        $a = $a + 1;
		  						      $tempArray = array( $val_combo_asli => $val_combo_asli);
                        $opsi_koefisien_asli = array_merge ($opsi_koefisien_asli, $tempArray);
                        $a = 51;
                      }
                      $a = $a + 1;
                    }
                  }else {
								    $cek_val_combo_asli = FALSE;
						      }
                  
                  // merubah data menjadi array keterangan syarat wajib
						    	if($ket_syarat_arsip){
								    $cek_ket_syarat_arsip = TRUE;
    							  $hitung = strlen($ket_syarat_arsip);
                    $cek_posisi = strpos($ket_syarat_arsip,'^');
                    $a = 1;
                    while ($a < 50) {
                      $item_combo = substr($ket_syarat_arsip,0,$cek_posisi);
                      $ket_syarat_arsip = substr($ket_syarat_arsip,$cek_posisi+1,$hitung);
                      $hitung = strlen($ket_syarat_arsip);
                      $cek_posisi = strpos($ket_syarat_arsip,'^');
                      if($a == 1) {
							          $opsi_koefisien_ket_wajib = array($item_combo => $item_combo);
                      }else {
									      $tempArray = array( $item_combo => $item_combo);
                        $opsi_koefisien_ket_wajib = array_merge ($opsi_koefisien_ket_wajib, $tempArray);
                      }
                      if($cek_posisi == "") {
                        $a = $a + 1;
		  							    $tempArray = array( $ket_syarat_arsip => $ket_syarat_arsip);
                        $opsi_koefisien_ket_wajib = array_merge ($opsi_koefisien_ket_wajib, $tempArray);
                        $a = 51;
                      }
                      $a = $a + 1;
                    }
                  }else {
								    $cek_ket_syarat_arsip = FALSE;
						     	}

							    // merubah data menjadi array keaslian syarat lainnya
							    if($val_combo_asli_lain){
								    $cek_val_combo_asli_lain = TRUE;
    						    $hitung = strlen($val_combo_asli_lain);
                    $cek_posisi = strpos($val_combo_asli_lain,'^');
								    if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
                    while ($a < 50) {
                      $item_combo = substr($val_combo_asli_lain,0,$cek_posisi);
                      $val_combo_asli_lain = substr($val_combo_asli_lain,$cek_posisi+1,$hitung);
                      $hitung = strlen($val_combo_asli_lain);
                      $cek_posisi = strpos($val_combo_asli_lain,'^');
                      if($a == 1) {
							          $opsi_koefisien_asli_lain = array($item_combo => $item_combo);
                      }else{
									      $tempArray = array( $item_combo => $item_combo);
                        $opsi_koefisien_asli_lain = array_merge ($opsi_koefisien_asli_lain, $tempArray);
                      }
                      if($cek_posisi == "") {
                        $a = $a + 1;
		  							    $tempArray = array( $val_combo_asli_lain => $val_combo_asli_lain);
                        $opsi_koefisien_asli_lain = array_merge ($opsi_koefisien_asli_lain, $tempArray);
                        $a = 51;
                      }
                      $a = $a + 1;
                    }
                  }else{
					        	$cek_val_combo_asli_lain = FALSE;
					        }

                  // EOF array
                  for($z=1;$z<=2;$z++) {
                    foreach ($syarat_izin as $data) {
                      $show_syarat = new trperizinan_syarat();
                      $show_syarat->where('trsyarat_perizinan_id', $data->id)
                                  ->where('trperizinan_id', $jenis_izin->id)->get();
                      $var = $show_syarat->c_show_type;
										  $stat_wajib = $show_syarat->status;
                      if( (int)$stat_wajib == (int)$z ) {
    										/*
                         * Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi
                         * desimal
                        */

                        //$rule = strval(decbin($var));
                        //if (strlen($rule) < 4) {
                        //    $len = 4 - strlen($rule);
                        //    $rule = str_repeat("0", $len) . $rule;
                        //}
                        //$arr_rule = str_split($rule);
                        //$c_daftar_ulang = $arr_rule[0];
                        //$c_baru = $arr_rule[1];
                        //$c_perpanjangan = $arr_rule[2];
                        //$c_ubah = $arr_rule[3];

										    $rule = strval(decbin($var));
                        if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                        if(strlen($rule) < $plv) {
                          $len = $plv - strlen($rule);
                          $rule = str_repeat("0", $len) . $rule;
                        }
                        if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                        $arr_rule = str_split($rule);
                        if($plv == 4){
                					$c_baru         = $arr_rule[1];
                          $c_daftar_ulang = $arr_rule[0];
                				}else{
			                    $c_baru         = $arr_rule[0];
                          $c_daftar_ulang = $arr_rule[1];
					              }
                        $c_perpanjangan = $arr_rule[2];
                        $c_ubah         = $arr_rule[3];
                        $c_pencabutan   = $arr_rule[4];
                        $c_penutupan    = $arr_rule[5];

                        $syarat_status = $c_baru;
                        if($syarat_status == '1') {
                          $i++;
								          echo form_hidden('jumlah_syarat',$i);

                          ?>
                          <tr>
                            <td width="2%" align="center"><?php echo $i; ?></td>                  <!-- List No Urut -->
                            <td width="64%"><?php echo $data->v_syarat; ?></td>                   <!-- List nama persyaratan -->
                            <td width="4%" align="center">                                        <!-- List status wajib / tidak sebuah persyaratan -->
                               <?php
                               //if ($data->status == "1")
										           if($stat_wajib == "1")
                                 $status_data = "Wajib";
                               else
                                 $status_data = "Tidak Wajib";
                               echo form_label($status_data);
                               ?>
                            </td>
     												<td width="5%" align="center">                                        <!-- List ceklist dari FO -->
		    										  <?php
		        									if(isset($check)) {
                                foreach ($check as $dt) {
                                  if($dt == $data->id) {
                                    $checked = TRUE;
                                    break;
                                  }else{
                                    $checked = FALSE;
                                  }
                                }
                              }else{
                                $checked = FALSE;
                                if($list_daftar) {
                                  foreach ($list_daftar as $data_daftar) {
                                    $data_syarat = new tmpermohonan_trsyarat_perizinan();
                                    $data_syarat->where('tmpermohonan_id', $data_daftar->id)
                                                ->where('trsyarat_perizinan_id', $data->id)->get();
                                    if($data_syarat->trsyarat_perizinan_id) {
                                      $checked = TRUE;
                                      break;
                                    }
                                  }
                                }else{
                                  $checked = FALSE;
                                  break;
                                }
                              }
                              if($checked)
								        				echo 'V';
										        	else
												        echo '-';
											        ?>
										        </td>     
    												<td width="5%" align="center">                                        <!-- List Input ceklist terpenuhinya persyratan wajib -->
                              <?php
    												  $checked = FALSE;
		    									    if($cek_val_combo) { 
    	        								  foreach ($opsi_koefisien_syarat as $cek_syarat) {
				        						      if($data->id == $cek_syarat ) $checked = TRUE;
						        			      }
								        			}
                              $set = array('name' => 'pemohon_syarat[]',
                                           'id' => 'chek',
                                           'value' => $data->id,
                                           'checked' => $checked,
                                           'onClick' => 'cheker()'
                                          );
								        			if($edit)
                                echo form_checkbox($set);
											        else
												        if($checked)
												          echo 'V';
											          else
												          echo '-'; 
											        ?>
										        </td>
										        <td width="5%"  align="center">                                   <!-- List input ceklist keaslian sebuah persyratan wajib -->
                              <?php
		    										  $checked = FALSE;
		        									$coba_cek = '';
				        					    if($cek_val_combo_asli) { 
    					        				  foreach ($opsi_koefisien_asli as $cek_syarat) {
								        		      if($data->id == $cek_syarat ) $checked = TRUE;
									              }
											        }
                              $set = array('name' => 'keaslian_syarat_wajib[]',
                                           'id' => 'chek',
                                           'value' => $data->id,
                                           'checked' => $checked,
                                           'onClick' => 'cheker()'
                                          );
                              if($edit)
                                echo form_checkbox($set);
		        									else
				        								if($checked)
						        						  echo 'V';
								        			  else
										        		  echo '-';
											        ?>
										        </td>
    												<td width="15%" >                                                     <!-- List input keterangan persyaratan wajib -->
		    										  <?php
		        									$n_ket = '-';
				        							$var_id = 'id_wajib'.$i;
		                          $var_ket = 'ket_wajib'.$i;
								        			$is_ok = TRUE;
									            if($cek_ket_syarat_arsip) {
    										        foreach ($opsi_koefisien_ket_wajib as $cek_syarat) {
    													  	$hitung = strlen($cek_syarat);
                                  $cek_posisi = strpos($cek_syarat,';');
		        											$id_syarat = substr($cek_syarat,0,$cek_posisi);
                                  $ket_syarat = substr($cek_syarat,$cek_posisi+1,$hitung-$cek_posisi);
                                  if($data->id == $id_syarat && $is_ok){
								        				    $is_ok = FALSE;
                                    $n_ket = $ket_syarat;
													        }
									              }
											        }
                              $keterangan_input = array('name' => $var_ket,
                                                        'value' => $n_ket,
			                                                  'style'=>'width:99%',
                                                        'class' => 'input-wrc'
                                                       );
										        	if($edit)
                                echo form_input($keterangan_input);
                              else
                                echo $n_ket;
    													echo form_hidden($var_id,$data->id);
		    									    ?>  
		        							  </td>
                          </tr>
                          <?php
                        }
                      }
                    }
                  }
                  $a = 1;
                  while ($a < 6) { // input persyaratan lainnya
							      $nex_var = $i + $a;
                    $var_syarat = 'syarat'.$a;
                    $var_ket = 'ket_lain'.$a;
								    if($a == 1 ) { $n_syarat = $syarat1; $n_keterangan = $ket_lain1; }
     		    				if($a == 2 ) { $n_syarat = $syarat2; $n_keterangan = $ket_lain2; }
	        					if($a == 3 ) { $n_syarat = $syarat3; $n_keterangan = $ket_lain3; }
    	        			if($a == 4 ) { $n_syarat = $syarat4; $n_keterangan = $ket_lain4; }
				            if($a == 5 ) { $n_syarat = $syarat5; $n_keterangan = $ket_lain5; }
								    ?>
							    	<tr>
                      <td align="center"><?php echo $nex_var; ?></td>             <!-- Menampilkan No Urut lainnya  -->
								      <td>                                                        <!-- Menampilkan nama persyaratan lainnya -->
								        <?php 
                        $syarat_input = array('name' => $var_syarat,
                                              'value' => $n_syarat,
	  			              	                		'style'=>'width:100%',
                                              'class' => 'input-wrc'
                                             );
											if($edit)
                        echo form_input($syarat_input);
											else
												echo $n_syarat;
			    						?>
				    				  </td>
								      <td align="center"><?php echo 'Berkas lain'; ?></td>        <!-- Menampilkan status berkas lain sebuah persyaratan lainnya -->
								      <td align="center"><?php echo '-'; ?></td>                  <!-- Menampilkan - pada kolom terlampir persyratan lainnya -->
								      <td align="center">                                         <!-- Menampilkan input ceklist keaslian sebuah persyratan lainnya -->
                        <?php
									      $checked = FALSE;
									      if($cek_val_combo_asli_lain) { 
    								  	  foreach ($opsi_koefisien_asli_lain as $cek_syarat) {
									          if($a == $cek_syarat ) $checked = TRUE;
									        }
										    }
                        $set = array('name' => 'keaslian_syarat_lainnya[]',
                                     'id' => 'chek',
                                     'value' => $a,
                                     'checked' => $checked,
                                     'onClick' => 'cheker()'
                                    );
										  	if($edit)
                          echo form_checkbox($set);
										  	else
										  		if($checked)
										  		  echo 'V';
										  	  else
										  		  echo '-';
									      ?>
								      </td>
								      <td align="center">                                         <!-- Menampilkan input keterangan persyaratan lainnya Asli / Tidak -->
									      <?php 
                        $keterangan_input = array('name' => $var_ket,
                                                  'value' => $n_keterangan,
			                                  			    'style'=>'width:100%',
                                                  'class' => 'input-wrc'
                                                 );
										  	if($edit)
                          echo form_input($keterangan_input);
										  	else
                          echo $n_keterangan;
									      ?>
								      </td>
								  	  <td>                                                        <!-- Menampilkan input keterangan persyaratan lainnya -->
									      <?php 
                        echo '-';
									      ?>
								      </td>
						    		</tr>
                    <?php
                    $a++;
                  }
                }else{ // belum di gunakan
                  $x = 1;
                  $data_izin = 0;
                  if($list_izin_paralel) {
                    foreach ($list_izin_paralel as $row) {
                      $row_izin = new trperizinan();
                      $row_izin->get_by_id($row);
                      if($x == 1)
                        $data_izin = $row_izin->id;
                      else
                        $data_izin = $data_izin . ", " . $row_izin->id;
                      $x++;
                    }
                    $query = "select distinct(A.trsyarat_perizinan_id), B.v_syarat, B.status
                              from trperizinan_trsyarat_perizinan as A,
                              trsyarat_perizinan as B
                              where A.trperizinan_id IN(" . $data_izin . ")
                              and A.trsyarat_perizinan_id = B.id
                              order by B.status, B.v_syarat 
										         ";
                    $results = mysql_query($query);
                    while ($rows = mysql_fetch_assoc(@$results)) {
                      $syarat_daftar = new trsyarat_perizinan();
                      $syarat_daftar->get_by_id($rows['trsyarat_perizinan_id']);
                      /*
                       * Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi
                       * desimal
                       */
                      $show_syarat = new trperizinan_syarat();
                      $show_syarat->where('trsyarat_perizinan_id', $rows['trsyarat_perizinan_id'])->get();
                      $var = $show_syarat->c_show_type;

                      //$rule = strval(decbin($var));
                      //if (strlen($rule) < 4) {
                      //    $len = 4 - strlen($rule);
                      //    $rule = str_repeat("0", $len) . $rule;
                      //}
                      //$arr_rule = str_split($rule);
                      //$c_daftar_ulang = $arr_rule[0];
                      //$c_baru = $arr_rule[1];
                      //$c_perpanjangan = $arr_rule[2];
                      //$c_ubah = $arr_rule[3];

									    $rule = strval(decbin($var));
                      if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                      if(strlen($rule) < $plv) {
                        $len = $plv - strlen($rule);
                        $rule = str_repeat("0", $len) . $rule;
                      }
                      if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                        $arr_rule = str_split($rule);
                      if($plv == 4){
            						$c_baru         = $arr_rule[1];
                        $c_daftar_ulang = $arr_rule[0];
            					}else{
		                		$c_baru         = $arr_rule[0];
                        $c_daftar_ulang = $arr_rule[1];
            					}
                      $c_perpanjangan = $arr_rule[2];
                      $c_ubah         = $arr_rule[3];
                      $c_pencabutan   = $arr_rule[4];
                      $c_penutupan    = $arr_rule[5];

                      $syarat_status = $c_baru;
                      if($syarat_status == '1') {
                        $i++;
                        ?>
                        <tr>
                          <td align="center"><?php echo $i; ?></td>
                          <td><?php echo $syarat_daftar->v_syarat; ?></td>
                          <td align="center">
                            <?php
                            $set = array('name' => 'pemohon_syarat[]',
                                         'value' => $syarat_daftar->id,
                                         'onClick' => 'cheker()'
                                        );
                            echo form_checkbox($set);
                            ?>
                          </td>
                          <td align="center">
                            <?php
                            if($syarat_daftar->status == "1")
                              $status_data = "Wajib";
                            else
                              $status_data = "Tidak Wajib";
                            echo form_label($status_data);
                            ?>
                          </td>
                        </tr>
                        <?php
                      }
                    }
                  }
                }
                        ?>
              </tbody>
            </table>
                    
				    <!--<div class="contentForm">
              <h2></h2>
            </div>

				    <div style="clear: both" ></div>-->
				    <div class="contentForm">
              <?php
              $tahun_input = array('name' => 'tahun',
                                   'value' => $tahun,
					                         'style'=>'width:15%',
                                   'class' => 'input-wrc'
                                  );
              echo '<b>' . form_label('Tahun ') . '</b>';
              if($edit)
                echo form_input($tahun_input);
					    else
						    echo ': '.$tahun;
              ?>
            </div>

            <div style="clear: both" ></div>
				    <div class="contentForm">
              <?php
              $jumlah_input = array('name' => 'jumlah',
                                    'value' => $jumlah,
					                          'style'=>'width:15%',
                                    'class' => 'input-wrc'
                                    );
              echo '<b>' . form_label('Jumlah ') . '</b>';
			    		if($edit)
                echo form_input($jumlah_input);
	    				else
		  				  echo ': '.$jumlah;
              ?>
            </div>

			      <div style="clear: both" ></div>
			     	<div class="contentForm">
              <?php
              $sampul_input = array('name' => 'sampul',
                                    'value' => $sampul,
					                          'style'=>'width:15%',
                                    'class' => 'input-wrc'
                                   );
              echo '<b>' . form_label('Sampul ') . '</b>';
					    if($edit)
                echo form_input($sampul_input);
					    else
						    echo ': '.$sampul;
              ?>
            </div>

			    	<div style="clear: both" ></div>
				    <div class="contentForm">
              <?php
              $box_input = array('name' => 'box',
                                 'value' => $box,
					                       'style'=>'width:15%',
                                 'class' => 'input-wrc'
                                );
              echo '<b>' . form_label('Box ') . '</b>';
					    if($edit)
                echo form_input($box_input);
					    else
					    	echo ': '.$box;
              ?>
            </div>

				    <div style="clear: both" ></div>
				    <div class="contentForm">
              <?php
              $rak_input = array('name' => 'rak',
                                 'value' => $rak,
					                       'style'=>'width:15%',
                                 'class' => 'input-wrc'
                                 );
              echo '<b>' . form_label('Rak ') . '</b>';
					    if($edit)
                echo form_input($rak_input);
					    else
					    	echo ': '.$rak;
              ?>
            </div>

			    	<!-- Upload Area -->		
            <?php
				    if($nama_file == '') {
				    	$stat_berkas = FALSE;
				    	if($edit){
				    	  if(!file_exists('assets/esignfile/'.$fileName)){
                  echo heading('Belum Ada Dokumen Izin',2);
                }else{
                  echo heading('Tersedia Dokumen Izin Tersertifikasi BSrE',2);
                  echo heading('Ingin Tambah Dokumen ',2);
                }  
				    	  echo form_label('');
                echo anchor(site_url('arsip/showform/0'), 'Upload Dokumen', 'class="link-wrc" rel="upload_box"');
              }
				    }else{
				    	$stat_berkas = TRUE;
				    	echo heading('Nama berkas : ',2);
              $val_combo_name =  $nama_file;
    		    	$hitung = strlen($val_combo_name);
              $cek_posisi = strpos($val_combo_name,'^');
				    	if($cek_posisi == 0) $cek_posisi = $hitung+1;
              $a = 1;
              while ($a < 50) {
                $item_combo = substr($val_combo_name,0,$cek_posisi);
                $val_combo_name = substr($val_combo_name,$cek_posisi+1,$hitung);
                $hitung = strlen($val_combo_name);
                $cek_posisi = strpos($val_combo_name,'^');
                if($a == 1){
                  $opsi_koefisien_name = array($item_combo => $item_combo);
                }else{
							    $tempArray = array( $item_combo => $item_combo);
                  $opsi_koefisien_name = array_merge ($opsi_koefisien_name, $tempArray);
                }  
                if($cek_posisi == "") {
                  $a = $a + 1;
		  				    $tempArray = array( $val_combo_name => $val_combo_name);
                  $opsi_koefisien_name = array_merge ($opsi_koefisien_name, $tempArray);
                  $a = 51;
                }
                $a = $a + 1;
              }
					    $no = 0;
					    $name = "";
              foreach ($opsi_koefisien_name as $cek_name) {
						    if($cek_name != ''){ 
                  $no++;
							    $name = $name . $cek_name . "^";
							    if($edit) {
	  					      echo anchor(site_url('arsip/showform/'.$no), $no.'. '.$cek_name.' ; Klik untuk Perbaharui Dokumen', 'class="link-wrc" rel="upload_box"')."&nbsp;";
    							  $confirm_text = 'Apakah Anda yakin menghapus berkas '.$cek_name.' ini ? ';
                    $img_info = array('src' => base_url().'assets/images/icon/cross.png',
                                      'alt' => 'Hapus Berkas',
                                      'title' => 'Hapus Berkas',
                                      'border' => '0',
				    				                  'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                     );
			  			    	echo anchor(site_url('arsip/deleteform/'.$no), img($img_info))."&nbsp;";
								    echo heading('',3);
						    	}else{
                    echo $no.'. '.$cek_name."; ";
						    	}
			    			}
			    		}
			    		if($edit) {
    	      		echo anchor(site_url('arsip/showform/999'), 'Tambah Dokumen Baru', 'class="link-wrc" rel="upload_box"');
			    		}
			    	}
            ?>
            <!-- EOF() Upload Area -->
		    	</div>

          <!-- ---------- TABS 5 ( Tracking Perizinan ) ----------- -->
    			<div id="tabs-5">
            <div style="text-align:right">
              <?php
              $user = new user();
              // var_dump($user);die();
              $user->get_by_id(substr($list_daftar->pendaftaran_id,-3));
              $petugas = $user->oriname;
              if($petugas == '') $petugas = '-';
              echo 'Petugas Front Office : '.$petugas . ' ';
						  echo '<br>';

		          // EOF() Proses ambil Informasi Petugas Penomoran
						  $tracking_izin = new tmtrackingperizinan();
              $tracking_izin->where('pendaftaran_id', $list_daftar->pendaftaran_id)
                            ->where('tr_activiti', 'Arsip')->get();
						  $kalimat = $tracking_izin->his_ubah;
              $arr_kalimat = explode (";",$kalimat);
						  $gabungan = array();
						  foreach($arr_kalimat as $key){
						    $arr_key = explode ("^",$key);
							  array_push($gabungan,$arr_key);
					  	}

						  foreach($gabungan as $key){
                if($key[0] == 'PENOMORAN'){
						      echo 'Petugas Pemberi Nomor : '.$key[1] . '; Tanggal : '.$key[2];
						  	  echo '<br>';
						    }
						  }
				      // EOF() Proses ambil Informasi Petugas Penomoran
              ?>
            </div>
            
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" id="trackingdetail">
            	<thead>
                <tr>
                  <th width="3%">No</th>
                  <th width="25%">Menu</th>
                  <th width="17%">Durasi Pengerjaan</th>
                  <th width="10%">Waktu Awal</th>
                  <th width="10%">Waktu Akhir</th>
                  <th width="20%">User / Nama</th>
                  <th width="5%">Status</th>
                  <th width="10%">Aktifitas</th>
                </tr>
              </thead>
              <tbody>
                <?php                    
                $i = 0;
                $total_awal = NULL;
                $total_akhir = NULL;
                $total_hari = NULL;
                // var_dump($list_tr);die();
                foreach ($list_tr as $data){
                  $showed = FALSE;
                  if($list_tracking){
                    foreach ($list_tracking as $data_track){
                      $status = '';
                      $waktu_awal = '';
                      $waktu_akhir = '';
                      $data_status = new tmtrackingperizinan_trstspermohonan();
                      $data_status->where('tmtrackingperizinan_id', $data_track->id)
                                  ->where('trstspermohonan_id', $data->id)->get();

                      if($data_status->tmtrackingperizinan_id){
                        $showed = TRUE;
                        $status = $data_track->status;
                        $waktu_awal = $data_track->d_entry_awal;
                        $waktu_akhir = $data_track->d_entry;
                        break;
                      }
                    }
                  }else{
                    $showed = FALSE;
                    $status = '';
                    $waktu_awal = '';
                    $waktu_akhir = '';
                    break;
                  }

                  if($showed) {
                    $i++;
                    $n_user = $data_track->tr_user .' / '. $data_track->tr_name;
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $data->n_sts_permohonan_dashboard; ?></td>
                      <td>
                        <?php
                        $hari = 0;
                        if($waktu_awal && $waktu_akhir) {
                          if($waktu_awal != '0000-00-00 00:00:00' && $waktu_akhir != '0000-00-00 00:00:00') {
                            $libur = new tmholiday();
                            $libur->distinct('date')->where('date >=', $waktu_awal)->where('date <=', $waktu_akhir)->order_by('date', 'ASC')->get();
                            if($libur) {
                              foreach($libur as $data_libur) {
                                $hari = $hari + 86400;
                              }
                            }
                            $time_akhir = strtotime($waktu_akhir);
                            $time_awal = strtotime($waktu_awal);
                            if($data->id == 1) {
				                     echo "Menunggu konfirmasi pemohon";
						       	        }else{
                              if($data->id == 13 || $data->id == 15 || $data->id == 16 || $data->id == 17) {
                                echo "Selesai";
                              }else{
                                if($data->id == 12) {
                                  echo "Telah dicetak";
                                }else{
                                  if($time_akhir === $time_awal) {
                                    echo "Sedang Diproses";
                                  }else{
                                    $time_awal = $time_awal + $hari;
                                    $total_hari = $total_hari + $hari;
                                    echo timespan($time_awal, $time_akhir);
                                  }
                                }
                              }
                            }
                          }
                        }	
                        ?>
                      </td>
                      <td>
                        <?php
                        if($waktu_awal) {
                          if($waktu_awal != '0000-00-00 00:00:00') {
                            if($data->id == "1" || $data->id == "2") {
                              $list_status = new trstspermohonan();
                              $list_status->get();
                              foreach ($list_status as $data_status) {
                                if($data_status->id == $data->id) {
                                  $total_awal = $waktu_awal;
                                  break;
                                } else {
                                  $total_awal = NULL;
                                }
                              }
						              	}
                            echo $this->lib_date->mysql_to_human($waktu_awal, 1).', '.  substr($waktu_awal, 10);
                          }
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if($waktu_akhir) {
                          if($waktu_akhir != '0000-00-00') {
                            echo $this->lib_date->mysql_to_human($waktu_akhir, 1).', '.  substr($waktu_akhir, 10);
                            $total_akhir = $waktu_akhir;
                          }
                        }
                        ?>
                      </td>
                      <td><?php echo $n_user; ?></td>
                      <td><?php echo $data_track->status; ?></td>
                      <td><?php echo $data_track->tr_activiti; ?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td><b>Total Pengerjaan</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
		                <b>
                      <?php
                      if($total_awal && $total_akhir){
                        $time_akhir2 = strtotime($total_akhir);
                        $time_awal2 = strtotime($total_awal);
                        $time_awal2 = $time_awal2 + $total_hari;
                        echo timespan($time_awal2, $time_akhir2);
                      }
                      ?>
                    </b>
				          </td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
				    <?php
            if($n_status=="Izin Ditolak"){
              echo '<b><H3>' . form_label('ALASAN PENOLAKAN ') . '</H3></b>';
              ?>
              <table cellpadding="0" cellspacing="0" border="0" class="display">
				        <?php
				        $list = "SELECT * FROM alasan_penolakan WHERE id_permohonan = ?";
						    $results = $this->db->query($list, $id_daftar)->result();
						    $no=0;
                foreach ($results as $rows) {
							    $no++;
                  echo "<tr>";
					        echo "<td align='right'   valign='top' width='2%'>".$no.'.'."</td>"."";
					        echo "<td align='Justify' valign='top' width='50%'>".$rows->alasan."</td>"."";
						      echo "<td align='Justify' valign='top' width='48%'>".''."</td>"."";
						      echo "</tr>";
					  	  }
						    if($no == 0){
                  echo "<tr>";
					        echo "<td align='right'   valign='top' width='2%'>".'-'."</td>"."";
					        echo "<td align='Justify' valign='top' width='50%'>".'Tidak diberi alasan yang jelas'."</td>"."";
						      echo "<td align='Justify' valign='top' width='48%'>".''."</td>"."";
						      echo "</tr>";
					  	  }
					      ?>
              </table>
				      <?php
            }    
            ?>
			    	<br style="clear: both;" />
          </div>
          
          <!-- ---------- TABS 6 ( Berkas Izin ) ----------- -->
          <div id="tabs-6">
            <!--<div style="text-align:center">-->
            <?php
            $n_esl2 = '';// $this->lib_date->get_esl2_byizin($id_daftar)[3]; //Array(1=id,2=nik,3=n_pegawai,4=n_jabatan,5=nip)
            $n_esl3 = '';
            $n_esl4 = '';
            $tglesl4_ori = $tglesl4;
            $tglesl2 = (empty($tglesl2) || $tglesl2 == "0000-00-00 00:00:00" ? " - " : $this->lib_date->mysql_to_human($tglesl2).' '.date('h:i:sa', strtotime($tglesl2)));
            $tglesl3 = (empty($tglesl3) || $tglesl3 == "0000-00-00 00:00:00" ? " - " : $this->lib_date->mysql_to_human($tglesl3).' '.date('h:i:sa', strtotime($tglesl3)));
            $tglesl4 = (empty($tglesl4) || $tglesl4 == "0000-00-00 00:00:00" ? " - " : $this->lib_date->mysql_to_human($tglesl4).' '.date('h:i:sa', strtotime($tglesl4)));
            $tglstaf = (empty($tglstaf) || $tglstaf == "0000-00-00 00:00:00" ? " - " : $this->lib_date->mysql_to_human($tglstaf).' '.date('h:i:sa', strtotime($tglstaf)));
            $ketesl2 = (empty($ketesl2) ? "-- tidak ada catatan --" : $ketesl2);
            $ketesl3 = (empty($ketesl3) ? "-- tidak ada catatan --" : $ketesl3);
            $ketesl4 = (empty($ketesl4) ? "-- tidak ada catatan --" : $ketesl4);
            $ketstaf = (empty($ketstaf) ? "-- tidak ada catatan --" : $ketstaf);
            if($list_daftar->approve == 1){
              $tglesl2 = "0000-00-00 00:00:00";
              $tglesl3 = "0000-00-00 00:00:00";
              $tglesl4 = "0000-00-00 00:00:00"; 
              $ketesl2 = "-- tidak ada catatan --";
              $ketesl3 = "-- tidak ada catatan --";
              $ketesl4 = "-- tidak ada catatan --";
            }else{
            	if($list_daftar->approve == 4){
                $tglesl2 = "0000-00-00 00:00:00";
                $tglesl3 = "0000-00-00 00:00:00";
                $ketesl2 = "-- tidak ada catatan --";
                $ketesl3 = "-- tidak ada catatan --";
              }else{
              	if($list_daftar->approve == 3){
                  $tglesl2 = "0000-00-00 00:00:00";
                  $ketesl2 = "-- tidak ada catatan --";
                }    
              }
            }
            
            echo '<br>';
            echo '<center>';
            echo $sts_izin;
            echo '<br>';
            echo '<br>';
            echo '<center>';
            echo '<b>'.'Status Penandatanganan'.'</b>';
            echo '<br>';
            echo '<b>'. $ket_skm .'</b><br>';
            echo "<br>";
            echo 'Approve Esl  II  : '.$tglesl2.'<br>';
            echo 'Catatan dari : '.$namesl2.' Adalah : <br>';
            echo $ketesl2.'<br>';
            
            echo '<br>';
            echo 'Approve Esl  III : '.$tglesl3.'<br>';
            echo 'Catatan dari : '.$namesl3.' Adalah : <br>';
            echo $ketesl3.'<br>';
            
            echo '<br>';
            if(date('Y', strtotime($tglesl4_ori)) < 2022){ //perubahan Esl IV menjadi Jafung tahun 2022
              echo 'Approve Esl IV  : '.$tglesl4.'<br>';
            }else{
              echo 'Verifikasi JFAK  : '.$tglesl4.'<br>';
            }
            echo 'Catatan dari : '.$namesl4.' Adalah : <br>';
            echo $ketesl4.'<br>';
            
            echo '<br>';
            echo 'Pengolah Izin  : '.$tglstaf.'<br>';
            echo 'Catatan dari : '.$namstaf.' Adalah : <br>';
            echo $ketstaf.'<br>';
            
            //untuk AKDP
            $statsk = $this->m_akdp->get_stat_sk($list_daftar->pendaftaran_id);
            $statkp = $this->m_akdp->get_stat_kp($list_daftar->pendaftaran_id);
            if($statsk != 0 || $statkp != 0){
            	echo '<br>';
              $row = $this->m_akdp->get_data_SK($list_daftar->pendaftaran_id);
              if(!empty($row)){
              	echo $statsk .' SK didownload oleh:<br>';
		            foreach ($row as $dtSK){
		              $value = $dtSK->user_id;
		              $user = new user();
                  $user->get_by_id($value);
                  $oriname = $user->oriname;
                  if(!$oriname){
                    $oriname = '-- n/a --';
                  }
                  echo $oriname."<br>";
		            }
		          }else{
		            echo 'SK belum didownload<br>';
		          }
		          
              echo '<br>';
              $row = $this->m_akdp->get_data_kp($list_daftar->pendaftaran_id);
              if(!empty($row)){
              	echo $statkp .' KP didownload oleh:<br>';
		            foreach ($row as $dtKP){
		              $value = $dtKP->user_id;
		              $user = new user();
                  $user->get_by_id($value);
                  $oriname = $user->oriname;
                  if(!$oriname){
                    $oriname = '-- n/a --';
                  }
                  echo $oriname."<br>";
		            }
		          }else{
		            echo 'KP belum didownload<br>';
		          }  
            }
            //EOF() untuk AKDP
            
	          if($skm && $vaprove){
              if(file_exists('assets/esignfile/SK_'.$list_daftar->pendaftaran_id.'.pdf') || $lokasi_user != "OPD Teknis") {
                $Ffile = FALSE;
                if($n_status=="Izin Disetujui"){
                	$dsign = array('src' => base_url().'assets/images/icon/dsign.png',
                                 'title' => 'Digital Signature BSrE',
                                 'border' => '0');
                	// Tampilkan Pertek
                  $pertekSE = FALSE;
                  $pertekNSE = FALSE;
                  $vdir = '';
                  if(file_exists('assets/pertekSE/PT_'.$list_daftar->pendaftaran_id.'.pdf')){
                    $pertekSE = TRUE;
                    //$vdir = "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/pertekSE/PT_".$list_daftar->pendaftaran_id.".pdf";
                    $vdir = "Nama File PT_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                  }
                  if(file_exists('assets/pertek/PT_'.$list_daftar->pendaftaran_id.'.pdf')){
                    $pertekNSE = TRUE;
                    //$vdir = "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/pertek/PT_".$list_daftar->pendaftaran_id.".pdf";
                    $vdir = "Nama File PT_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                  }  
                	if($pertekSE || $pertekNSE) {
                		//$tgl_up_pertek = strtotime($tgl_up_pertek);
                		$pertek = array('name' => 'button',
                	                  'class' => 'submit-wrc',
                                    'content' => ' Download Pertimbangan Teknis',
                                    'value' => ' Download Pertimbangan Teknis',
	                                  'onclick' => 'parent.location=\''. site_url('arsip/download_pertek').'/'.$list_daftar->pendaftaran_id.'\''
                                   );
                    
                    echo '<br>';
                    echo '<hr width="75%">';
                    echo form_button($pertek);
                    echo '<br>';
                    if($tgl_up_pertek == NULL){
                      echo 'Tgl Upload : Tanggal Tidak Terdeteksi';
                    }else{
                    	//echo 'Tgl Upload : '.$this->lib_date->mysql_to_human($tgl_up_pertek); 
                    	echo 'Tgl Upload : '.$this->lib_date->mysql_to_human($tgl_up_pertek).', '.  substr($tgl_up_pertek, 10);
                    	if($admin){
                    	  echo '<br>';
                    	  echo 'Upload by : '.$petugas_upload;
                      }
                    }  
                    if($pertekSE){
                      echo img($dsign);
                    }
                    if($lokasi_user != "OPD Teknis"){ 
                      echo "<br>";
                      echo $vdir;
                    }
                    echo '</center>';
                  }
                  // EOF() Tampilkan Pertek
                  
                	if(!file_exists('assets/esignfile/'.$fileName)){
                    ?>
                    <br>
                    <center>
                      <?php 
                     	$link = '/1/1';
                      switch($jenis_izin->e_ttd){ 
                        case 1 : // jika ttd elektronik
                          $link = '/1/1';
                          break;
                        case 2 : // jika ttd Upload berkas
                          $link = '/1/3'; // ada templet '/1/x'
                          break;
                      }
                      
                      $deselect_all = array('name' => 'button',
                	                          'class' => 'submit-wrc',
                                            'content' => ' Download Naskah Izin',
                                            'value' => ' Download Naskah Izin',
	                                          'onclick' => 'parent.location=\''. site_url('permohonan/sk/cetak').'/'.$list_daftar->id.$link.'\''
                                           );
		                  echo '<center>';
		                  if($jenis_izin->e_ttd == 0){ 
		                    echo form_button($deselect_all);
                        echo "<br>";
                        echo "<input type='hidden' id='copydocx' value='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/".$docxName."'>";
                        if ($lokasi_user != "OPD Teknis") {
                          //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/download/".$docxName."";
                          echo "Nama File ".$docxName." Tersedia";
                          echo "<br>";
                        }
                        if(file_exists('assets/skpdf_duplikat/SK_'.$list_daftar->pendaftaran_id.'.pdf')) {
                          ?>
                          <br>
                          <button name="button" type="button" class="submit-wrc" value=" Download Naskah Izin" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_<?php echo $list_daftar->pendaftaran_id; ?>.pdf'"> Download Naskah Duplikat</button>
                          <?php
                          if($lokasi_user != "OPD Teknis") {
                            echo "<br>";
                            //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_".$list_daftar->pendaftaran_id.".pdf";
                            echo "Nama File SK_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                          }
                        }
		                  }else{
		                    if($approve == 2){
		                   	  echo form_button($deselect_all);
                          echo "<br>";
                          echo "<input type='hidden' id='copydocx' value='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/".$docxName."'>";
                          if ($lokasi_user != "OPD Teknis") {
                            //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/download/".$docxName."";
                            echo "Nama File ".$docxName." Tersedia";
                            echo "<br>";
                          }
                          if (file_exists('assets/skpdf_duplikat/SK_'.$list_daftar->pendaftaran_id.'.pdf')) { ?>
                            <br>
                            <button name="button" type="button" class="submit-wrc" value=" Download Naskah Izin" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_<?php echo $list_daftar->pendaftaran_id; ?>.pdf'"> Download Naskah Duplikat</button>
                            <?php
                            if ($lokasi_user != "OPD Teknis") {
                              echo "<br>";
                              //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_".$list_daftar->pendaftaran_id.".pdf";
                              echo "Nama File SK_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                            }
                          }
		                    }else{
		                   	  echo 'Belum di Aprove';
		                    }
		                  }
                      
                      //echo "<button type='button' onClick='copyLinkDocx()' class='submit-wrc'>Copy</button>";
		                  echo '</center>';
                      ?>
                      <br>
                    </center>
                    <script>
                      function notif(){
                        alert("Izin ini belum memiliki template Gubernur !");
                      }
                      function notif2(){
                        alert("Izin ini belum memiliki template Kabad !");
                      }
                    </script>
                    <?php 
                  }else{  // jika e-sign
                  	$Ffile = TRUE;
                  	$deselect_all = array('name' => 'button',
                  	                      'class' => 'submit-wrc',
                                          'content' => 'Download Naskah Izin (SK)',  //.$fileName,
                                          'value' => 'Download Naskah Izin (SK)',    //.$fileName,
			                                    'onclick' => 'parent.location=\''. site_url('arsip/download_pdf') . '/'.$list_daftar->pendaftaran_id.'\''
                                         );
		                echo '<center>';
		                echo "<br>";
                    echo '<hr width="75%">';
		                echo form_button($deselect_all);
		                echo img($dsign);
                    echo "<br>";
                    echo "<input type='hidden' id='copy' value='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/".$fileName."'>";
                    if ($lokasi_user != "OPD Teknis") {
                      //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/".$fileName."";
                      echo "Nama File ".$fileName." Tersedia";
                      echo "<br>";
                    }
                    
                    if (file_exists('assets/skpdf_duplikat/SK_'.$list_daftar->pendaftaran_id.'.pdf')) { ?>
                
                        <br>
                        <button name="button" type="button" class="submit-wrc" value=" Download Naskah Izin" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_<?php echo $list_daftar->pendaftaran_id; ?>.pdf'"> Download Naskah Duplikat</button>
                
                        <?php
                        if ($lokasi_user != "OPD Teknis") { 
                          echo "<br>";
                          //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf_duplikat/SK_".$list_daftar->pendaftaran_id.".pdf";
                          echo "Nama File SK_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                        }
                      }
                    //echo "<button type='button' onClick='copyLink()' class='submit-wrc'>Copy</button>";
                    echo '<br>';
                    if($c_cetak > 0){
                      echo 'Naskah didownload sebanyak '.$c_cetak.' kali, Oleh : <br>';
                      $dt_user = explode(",", $id_user_cetak);
                      foreach ($dt_user as $value) {
                    	  $user = new user();
                        $user->get_by_id($value);
                        $oriname = $user->oriname;
                        if(!$oriname){
                          $oriname = '-- n/a --';
                        }
                        echo $oriname."<br>";
                      }
                    }else{ 
                    	echo 'Naskah belum ada yang download <br>';
                    }
		                echo '</center>';
                  }
                  
                  if(file_exists('assets/esignfile/KP_'.$list_daftar->pendaftaran_id.'.pdf')) {
                    $deselect_all = array('name' => 'button',
                                          'class' => 'submit-wrc',
                                          'content' => 'Download Kartu Pengawasan',
                                          'value' => 'Download Kartu Pengawasan',
			                                    'onclick' => 'parent.location=\''. site_url('arsip/timteknis/cetak') . '/'.$list_daftar->id.'/ke\''
                                         );
                    echo '<center> <hr width="75%">';
		                echo form_button($deselect_all);
		                echo img($dsign);
		                if($lokasi_user != "OPD Teknis") { 
                      echo "<br>";
                      //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/KP_".$list_daftar->pendaftaran_id.".pdf";
                      echo "Nama File KP_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                    }
		                echo '</center>';
                  }else{
                    if(file_exists('assets/skpdf/KP_'.$list_daftar->pendaftaran_id.'.pdf')) {
                    	$deselect_all = array('name' => 'button',
                                            'class' => 'submit-wrc',
                                            'content' => 'Download Kartu Pengawasan',
                                            'value' => 'Download Kartu Pengawasan',
			                                      'onclick' => 'parent.location=\''. site_url('arsip/timteknis/cetak') . '/'.$list_daftar->id.'/kn\''
                                           );
                      echo '<center> <hr width="75%">';
		                  echo form_button($deselect_all);
		                  if($lokasi_user != "OPD Teknis") { 
                        echo "<br>";
                        //echo "https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/skpdf/KP_".$list_daftar->pendaftaran_id.".pdf";
                        echo "Nama File KP_".$list_daftar->pendaftaran_id.".pdf Tersedia";
                      }
		                  echo '</center>';
                    }	
                  }
                  echo "<br>";
                  echo '<center> <hr width="75%"> </center>';
                  echo "<br>";
                }
                if($n_status=="Izin Ditolak"){
                  ?>
                  Ditolak
                  <?php
                }else{           
                  $val_combo_name =  $nama_file;
                  $hitung = strlen($val_combo_name);
                  $cek_posisi = strpos($val_combo_name,'^');
                  $stat_posisi = false;
                  if($cek_posisi == 0) {
                    $stat_posisi = true;
                    $cek_posisi = $hitung+1;
                  }
                  $a = 1;
                  $name = "";
                  while ($a < 50) {
                    $item_combo = substr($val_combo_name,0,$cek_posisi);
                    $val_combo_name = substr($val_combo_name,$cek_posisi+1,$hitung);
                    $hitung = strlen($val_combo_name);
                    $cek_posisi = strpos($val_combo_name,'^');
                    if($cek_posisi == "") { // jika item terakhir
                      $item_combo = $val_combo_name;
                      $a = 51;
                    }
                    $a++;
                  } 
                  
				          if($stat_berkas) {
                    foreach ($opsi_koefisien_name as $cek_name) {
					            if($cek_name != ''){ 
				                ?>
                        <div style="text-align:center">
                          <?php
				                  if(substr($cek_name, -3) == 'pdf'){
                            $file = base_url().'doc-izin/'.$cek_name;
					        			    echo 'File '.$cek_name.' Belum dapat tampil';
					        			  }else{
                            $image_properties = array('src' => base_url().'doc-izin/'.$cek_name,
                                                      'alt' => 'Dokumen Tidak Dapat Ditampilkan',
                                                      'title' => 'Dokumen Izin',
		                    		    	                    'width' => '533',
                                                      'height' => '800',
                                                     );
				                    echo img($image_properties);
    			        				}
                          ?>
                        </div>
                        <?php
					            }
                    }
			            }else{
			            	if(!$Ffile){
                      echo 'NASKAH HARD COPY BELUM DIARSIPKAN';
                    }
			            }
    			      }
              }
            }else{
              //echo "<br>";
              //echo '<center>'. $ket_skm .'</center>';
              //echo "<br>";
            }
            ?>
          </div>        
          
          <!-- ---------- TABS 7 ( Data Persyaratan ) ----------- -->
          <?php 
          if ($peronline == 1) { ?>
            <div id="tabs-7">
              <table cellpadding="0" cellspacing="0" border="1" class="display">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="55%">Syarat</th>
                    <th width="10%">Berkas</th>
                    <th width="10%">Nomor Surat</th>
                    <th width="10%">Tanggal Surat</th>
                    <th width="10%">Masa Berlaku<br>Surat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no=1;
                  $base_url = "../assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_portal."/";
                  foreach($persyaratan as $syarat){
                    ?>
                    <tr>
                      <td style="text-align:center"><?php echo $no; ?></td>
                      <td style="text-align:justify"><?php echo $syarat->v_syarat; ?></td>
                      <td style="text-align:center"><?php 
                      if (file_exists($base_url.$syarat->id.".pdf")) {
                        echo anchor($base_url.$syarat->id.".pdf", "Download",array("target"=>"_blank","style"=>"color:blue")); 
                      } else {
                        echo " - ";
                      }
                      
                      ?></td>
                      <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->nomor_surat : ''); ?></td>
                      <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->tanggal_surat : ''); ?></td>
                      <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->masa_berlaku_surat : ''); ?></td>
                    </tr>
                    <?php
                    $no++;
                  } 
                  ?>
                </tbody>
              </table>
              <br>
              <center>
                <b style="font-size:18px;">
                  Riwayat Dokumen Persyaratan
                </b>
              </center>
              <br>
              <table cellpadding="0" cellspacing="0" border="1" class="display">
                <thead>
                  <tr class="odd">
                    <th width="5%">No</th>
                    <th width="55%">Syarat</th>
                    <th width="10%">Berkas</th>
                    <th width="10%">Nomor Surat</th>
                    <th width="10%">Tanggal Surat</th>
                    <th width="10%">Masa Berlaku<br>Surat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $nos=1;
                  $base_url = "../assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_portal."/";
                  foreach($old_persyaratan as $old){
                    ?>
                    <tr class="odd">
                      <td style="text-align:center"><?php echo $nos; ?></td>
                      <td style="text-align:justify"><?php echo $old->v_syarat; ?></td>
                      <td style="text-align:center"><?php 
                      if (file_exists($base_url.$old->id.".pdf")) {
                        echo anchor($base_url.$old->id.".pdf", "Download",array("target"=>"_blank","style"=>"color:blue")); 
                      } else {
                        echo " - ";
                      }
                      
                      ?></td>
                      <td style="text-align:center"><?php echo $old->nomor_surat; ?></td>
                      <td style="text-align:center"><?php echo $old->tanggal_surat; ?></td>
                      <td style="text-align:center"><?php echo $old->masa_berlaku_surat; ?></td>
                    </tr>
                    <?php
                    $nos++;
                  } 
                  ?>
                </tbody>
              </table>
              <small>*Jika Nama Persyaratan Dan File Persyaratan berbeda, data yang benar adalah File Persyaratan</small>
              <br>
              <center>
                <b style="font-size:18px;">
                  Riwayat Asistensi Persyaratan
                </b>
              </center>
              <br>
              <table cellpadding="0" cellspacing="0" border="1" class="display">
                <thead>
                  <tr  class="odd">
                    <th width="65%">Pesan</th>
                    <th width="10%">Tanggal</th>
                    <th width="5%">Pukul</th>
                    <th width="20%">Oleh</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sho0 = 0; $sho = 0;
                  if (!empty($asistensi)) {
                    foreach($asistensi as $asisten){
                       $sho0 = 1; $sho++;
                       $oleh='Verifikatur';
                       //if($ncek) $oleh = str_replace('*', '', $asisten->oleh);
                       $oleh = str_replace('*', '', $asisten->oleh);
                       ?>
                       <tr class="odd">
                         <td valign="top"><?php echo $asisten->pesan; ?></td>
                         <td valign="top"><?php echo $this->lib_date->mysql_to_human($asisten->tanggal); ?></td>
                         <td valign="top"><?php echo date("H:i:s",strtotime($asisten->tanggal)); ?></td>
                         <td valign="top"><?php echo $oleh; ?></td>
                       </tr>
                       <?php 
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php
          } else {
            echo '<div id="tabs-7" >';
            echo "<br>";
            echo '<center>Izin tidak OnLine</center>';
            echo "<br>";
            echo "</div>";
          }
          ?>
          
          <!-- ---------- TABS 8 ( Data Lapangan ) ----------- -->
          <div id="tabs-8">
            <?php
            echo '<b><H2>' . 'DATA VISITASI LAPANGAN ' . '</H2></b>';
            ?>
            <table cellpadding="0" cellspacing="0" border="1" class="display">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="40%">Foto</th>
                  <th width="25%">Petugas Pengunggah Foto</th>
                  <th width="30%">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 1;
                foreach ($data_survey as $survey) {
                ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td align="center"><?php echo '<img src="../../../../../../gis/android/fileUpload/'.$survey->gambar.'" class="gambar">'; ?></td>
                    <td><?php echo $survey->n_pegawai; ?></td>
                    <td><?php echo $survey->keterangan; ?></td>
                  </tr>
                  <?php 
                  $i++;
                }
                if($i == 1) echo '<center><b> ----- data visitasi tidak ditemukan ----- </b></center>';
                ?>
              </tbody>
            </table>
             
            <br style="clear: both;" />
            <?php
            echo '<tr><b><H2>' . 'DATA PENGAWASAN dan PENGENDALIAN' . '</H2></b></tr>';
            ?>
              
            <div id="contentleft">
				    	<table cellpadding="0" cellspacing="0" border="0" class="display">
					    	<?php 
echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Pembuat Laporan</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($oriname) ? $oriname : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Profile Proyek</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->profil_proyek) ? $pengawasanjelita->profil_proyek : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Nilai Rencana Investasi</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->nilairencanainvestasi) ? $pengawasanjelita->nilairencanainvestasi : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Realisasi LKPM</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->relisasi_lkpm) ? $pengawasanjelita->relisasi_lkpm : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Jenis Produksi</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->jenis_produksi) ? $pengawasanjelita->jenis_produksi : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Kapasitas Produksi</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->kapasitas_produksi) ? $pengawasanjelita->kapasitas_produksi : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Luas Lahan</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->luas_lahan) ? $pengawasanjelita->luas_lahan : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Tanggal Pelaksanaan</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->tgl_pelaksanaan) ? $this->lib_date->mysql_to_human($pengawasanjelita->tgl_pelaksanaan) : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>TIM Pengawas</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->tim_pengawas) ? $pengawasanjelita->tim_pengawas : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Pemberian Fasilitas</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->beri_fasilitas) ? $pengawasanjelita->beri_fasilitas : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Visitasi</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->visitasi) ? $pengawasanjelita->visitasi : "Data tidak tersedia") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left' valign='top' width='22%'><b>Catatan</b></td>";
echo "<td align='left' valign='top' width='2%'><b>: </b></td>";
echo "<td align='Justify' valign='top' width='100%'>" . (!empty($pengawasanjelita->catatan_dal) ? $pengawasanjelita->catatan_dal : "Data tidak tersedia") . "</td>";
echo "</tr>";
				        ?>
				      </table>
            </div>

            <div id="contentright">
            </div>
            <br style="clear: both;" />
          </div>
          
          <!-- ---------- TABS 9 ( Data Izin Terkait ) ----------- -->
          <div id="tabs-9">
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" id="izinlaindioss">
            	<thead>
                <tr>
                  <th width="3%">No</th>
                  <th width="12%">Nomor Permohonan OSS<br>Tanggal Permohonan OSS</th>
                  <th width="75%">Sektor<br>KBLI</th>
                  <th width="10%">Jenis Proyek<br>Skala Usaha<br>Modal Usaha</></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 1;
                foreach ($dtoss as $row) {
                	$trsektor = new trsektor();
                  $trsektor->where('id', $row->sektor)->get();
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php 
                    	  echo $row->nomorpermohonan.'<br>'.$this->lib_date->mysql_to_human($row->tanggalpermohonan); 
                    	  ?>
                    </td>
                    <td><?php echo $trsektor->n_sektor.'<br>'.$row->kbli.' - '.$row->turunan_kbli; ?></td>
                    <td><?php echo $row->jenis_proyek.'<br>'.$row->skala_usaha.'<br>'.
                                   '<p align="right"> '.number_format($row->modal_usaha).' </p>';
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
          <?php
        }else{
          ?>
          <div id="tabs-1" ></div>
          <div id="tabs-2" ></div>
          <div id="tabs-3" ></div>
			    <div id="tabs-4" ></div>
          <div id="tabs-5" ></div>
			    <div id="tabs-6" ></div>
          <div id="tabs-7" ></div>
          <?php
        }
          ?>
      </div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php
      $add_daftar = array('name' => 'submit',
                          'class' => 'submit-wrc',
                          'content' => 'Simpan',
                          'type' => 'submit',
                          'value' => 'Simpan'
                         );

      $link = site_url('arsip/list_index');
			$text = 'Batal';
      switch ($asal_menu) {
        case 1; // dari menu Laporan/Rekapitulasi
          $link = site_url('rekapitulasi/view_next');
    			$text = 'Kembali';
          break;
        case 2; // dari menu Pengaduan
				  $link = site_url('pesan/edit_next');
    			$text = 'Kembali';
          break;
        case 3; // dari menu Laporan/Rekapitulasi Perizinan/List data perizinan
          $link = site_url('rekapitulasi/izin/rekap_next'); //list_data_next');
    			$text = 'Kembali';
          break;
				case 4; // dari menu Permohonan/Views/sk_list
          $link = site_url('permohonan/sk');
    		  $text = 'Kembali';
          break;
				case 6; // dari menu monitoring/Views/list_kategori_cari
				  $link = site_url('monitoring/perketegori_tertentu');
    			$text = 'Kembali';
          break;
				case 7; // dari menu pelayanan/Pendataan/Penjadwalan Tinjauan
				  $link = site_url('survey/index_next');
    			$text = 'Kembali';
          break;
				case 8; // dari menu Pelayana/Tim Teknis/Entri Hasil Tinjauan
				  $link = site_url('survey/result_next');
    			$text = 'Kembali';
          break;
				case 9; // dari menu Pelayana/Tim Teknis/Pembuatan BAP
				  $link = site_url('permohonan/bap/index_next');
    			$text = 'Kembali';
          break;
				case 10; // dari menu Penetapan/Penetapan Izin
				  $link = site_url('permohonan/penetapan/index');     // OLD index_next
    		  $text = 'Kembali';
          break;
        case 11; // dari menu survey/sp_saya
				  $link = site_url('survey/sp_saya');
    		  $text = 'Kembali';
          break;
				case 12; // dari menu settings/surat_keluar
          $link = site_url('settings/surat_keluar');
    			$text = 'Kembali';
          break;
        case 13; // dari menu arsip/timteknis
          $link = site_url('arsip/timteknis');
    			$text = 'Kembali';
          break;
        case 14; // dari menu monitoring/approve_izin
          $link = site_url('monitoring/approve_izin');
    			$text = 'Kembali';
          break;
        case 15; // dari menu permohonan/pencabutan
          $link = site_url('permohonan/pencabutan/index');
    			$text = 'Kembali';
          break;  
        case 16; // dari menu monitoring tte
          $link = site_url('monitoring/monitoring_tte');
          $text = 'Kembali';
          break;    
				case 17; // dari menu pengawasan jelita
          $link = site_url('monitoring/pengawasan_jelita/m');
          $text = 'Kembali';
          break;
        case 18; // dari menu pengawasan jelita
          $link = site_url('monitoring/pengawasan_jelita/l');
          $text = 'Kembali';
          break;
        case 19; // dari menu monitoring data pencabutan
          $link = site_url('monitoring/pencabutan');
          $text = 'Kembali';
          break;
        case 20; // dari menu data entry perizinan
          $link = site_url('pendataan/index');
          $text = 'Kembali';
          break;
        case 21; // belum dipakai {buat case berurutan}
          break;
      }

      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => $text,
                             'onclick' => 'parent.location=\'' . $link . '\''
                            );
            
      if($edit) {
	    	if($save_method !== "update") {
          if($paralel == "no") {
            if($jenis_izin->id)
              echo form_submit($add_daftar);
              echo "<span></span>";
              echo form_button($cancel_daftar);
          }else {
            if($list_izin_paralel) {
              echo form_submit($add_daftar);
              echo "<span></span>";
              echo form_button($cancel_daftar);
            }
          }
        }else{
          if($jenis_izin->id)
            echo form_submit($add_daftar);
          echo "<span></span>";
          echo form_button($cancel_daftar);
        }
			}else{
				echo form_button($cancel_daftar);
			}
      echo form_close();
      ?>

      </br>
      <span id="coba"></span>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<!--validasi-->
<script type="text/javascript">
  $.validator.addMethod('notSelect', function(value, element){
    return (value !=0);
  },'Pilih Opsi Yang Tersedia');
  
  var site = '<?php echo base_url(); ?>';
  <?php
  if ($save_method == "save") {
  ?>
    $("#form").validate({
      onkeyup: false,        
      rules:{
        no_refer:{
          remote:{
            url: site + "pemohon/register_id_exist",
            type:"post",
            data:{
              no_refer: function(){
                return $("#no_refer").val();
              }
            }
          }
        },
        npwp:{
          remote:{
            url: site + "perusahaan/register_npwp_exist",
            type:"post",
            data:{
              npwp: function(){
                return $("#npwp").val();
              }
            }
          }
        }
      },
      messages:{
        no_refer:{
          remote:'No referensi sudah digunakan!'
        }
      }
    });
    <?php
  } 
    ?>
</script>