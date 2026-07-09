<!-- Ubah Juga di file pemohon_tab.php -->
<script>
    var nonpwp = "";
    var namanpwp = "";
    var statnpwp = "";

    $(document).ready(function() {
                
    });
function validasi() {
    var tgl1 = document.getElementById('inputTanggal1').value;
    var tgl2 = document.getElementById('inputTanggal2').value;
        
//       if(tgl2 < tgl1 && tgl2!=='')
//        {
//            //alert('Tanggal Peninjauan tidak boleh lebih kecil dari\ntanggal terima berkas');
//            $('#coba').html("<p id='eror'>Tanggal Peninjauan tidakan boleh lebih kecil dari tanggal terima berkas</p>");
//           return false;
//        }
//        else
//        {
            return true;
//        }
   
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
        var jml ='<?php echo $jml_syarat; ?>';
		var group ='<?php echo $group; ?>';
        var kembali ='<?php echo $id_link; ?>';
        var total=0;
        for(var i=0; i < jml; i++){
            if(a[i].checked) {
                total++;
            }
        }
        if(validasi()==false) {
            document.forms[0].submit.disabled=true;
        } else if(total == jml || group == 3 || kembali == 'Pengembalian') {
            document.forms[0].submit.disabled=false;
            $('#coba').html('');
            //$('#test').html('');
        } else {
            document.forms[0].submit.disabled=true;
            $('#coba').html("<p id='eror'>* Lengkapi Persyaratan Untuk Mengaktifkan Tombol Simpan</p>");
        }        
		document.forms[0].submit.disabled=false;
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
                    if (!validator.element(this) && valid){
                        valid = false;     
                    }
                });
                if (valid == false){
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
                if ($paralel == "no") {
                    if ($jenis_izin->id) {
                        ?>
                        
						<div id="statusRail">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Nama Izin', 'nama_izin'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $jenis_izin->n_perizinan; ?>
								<input type="hidden" name="n_perizinan" value="<?php echo $jenis_izin->n_perizinan; ?>">
                            </div>
                        </div>

                        <div id="statusRail">
                            <div id="leftRail">
                                <?php echo form_label('Kelompok Izin', 'kelompok_izin'); ?>
                            </div>
                            <div id="rightRail">
                                <?php
                                $jenis_izin->trkelompok_perizinan->get();
                                echo $jenis_izin->trkelompok_perizinan->n_kelompok;
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
						$update = FALSE;
						$readonly = array();
                        if ($save_method == "update") {
							$readonly = array('readonly' => 'readonly');
							$update = TRUE;
                        ?>
                            <div id="statusRail" style="font-weight: bold">
                                <div id="leftRail">
                                    <?php echo form_label('No Pendaftaran', 'no_daftar'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php echo $list_daftar->pendaftaran_id; ?>
                                </div>
                            </div>
                            <?php
                            if ($list_daftar->c_paralel !== '0') {
                            ?>
                                <div id="statusRail">
                                    <div id="leftRail" class="bg-grid">
                                        <?php echo form_label('Jenis Paralel', 'name_paralel'); ?>
                                    </div>
                                    <div id="rightRail" class="bg-grid">
                                        <?php echo $jenis_paralel->n_paralel; ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <div class="ContentForm" style="font-weight: bold;text-align: center"> Jenis Izin belum dipilih
                            <div style="float: right">
                                <?php
                                $kembali = array(
                                    'name' => 'button',
                                    'class' => 'button-wrc',
                                    'content' => '&laquo; back',
                                    'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
                                );
                                echo form_button($kembali);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
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
                    } else {
                        ?>
                        <div class="ContentForm" style="font-weight: bold;text-align: center">
                            Izin Paralel belum dipilih
                            <div style="float: right">
                                <?php
                                $kembali = array(
                                    'name' => 'button',
                                    'class' => 'button-wrc',
                                    'content' => '&laquo; back',
                                    'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
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
        if ($eror) {
            echo (" <p id='eror'>$eror</p>");
        }

        ?>
        <p id='eror'><span id="test"></span></p>

        <?php
        $attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
        echo form_open('pelayanan/pendaftaran/' . $save_method, $attr);
        if ($paralel == "yes") {
            if ($list_izin_paralel) {
                foreach ($list_izin_paralel as $row) {
                    $row_izin = new trperizinan();
                    $row_izin->get_by_id($row);
                    echo form_hidden('list_izin_paralel[]', $row_izin->id);
                }
            }
        }

        echo form_hidden('jenis_permohonan', $mohon);
        echo form_hidden('paralel', $paralel);
        echo form_hidden('jenis_izin', $izin);
        echo form_hidden('jenis_izin_id', $jenis_izin->id);
        echo form_hidden('jenis_permohonan_id', $jenis_permohonan->id);
        echo form_hidden('id_daftar', $id_daftar);
        echo form_hidden('id_link', $id_link);
        echo form_hidden('waktu_awal', $waktu_awal);
		echo form_hidden('syarat_izin', $syarat_izin);
		echo form_hidden('group', $group);
        echo form_hidden('eror', 'halo');
		echo form_hidden('ambil_data', $ambil_data);
        if ($paralel == "yes")
            echo form_hidden('jenis_paralel', $jenis_paralel->id);
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Pemohon & Permohonan</a></li>
                    <li><a href="#tabs-2">Data Perusahaan</a></li>
                    <li><a href="#tabs-3">Persyaratan</a></li>
                </ul>
                <?php
                if ($paralel == "yes")
                    $real_id = $list_izin_paralel;
                else
                    $real_id = $jenis_izin->id;
                if ($real_id) {
                    ?>

                    <!-- ---------- TABS 1 ( Data Pemohon ) ----------- -->
                    <div id="tabs-1">
                        <div id="contentleft">
                            <div class="contentForm">
                                <?php
                                echo '<b><H2>' . form_label('DATA PEMOHON ') . '</H2></b>';
                                ?>
                            </div>

							<div style="clear: both" ></div>
                            <div class="contentForm">
                                <?php
                                $antrian_input = array(
                                    'name' => 'no_antri',
     								'class' => 'input-wrc required digits',
                                    'value' => $no_antri
                                );
                                echo '<b>' . form_label('Nomor Antrian ') . '</b>';
                                echo form_input($antrian_input).' ';
								if ($save_method !== "update") {
									//jika dipilih akan masuk view pemohon_tab.php
								    echo anchor(site_url('pelayanan/pendaftaran/daftar_izin_list'), 'Ambil Data Pemohon Izin', 'class="link-wrc" rel="daftar_box"');
								}
//                                echo form_error('nama_pemohon', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div style="clear: both" ></div>
							<div class="contentForm" >
                                <?php
                                $tgldaftar_input = array(
                                    'name' => 'tgl_daftar',
                                    'value' => $tgl_daftar,
                                    'class' => 'input-wrc required',
                                    'readOnly' => TRUE,
                                    //'id' => 'inputTanggal1'   // nonaktifkan input tanggal
                                );
                                echo '<b>' . form_label('Tgl Terima Berkas ') . '</b>';
                                echo form_input($tgldaftar_input);
                                echo form_error('tgl_daftar', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <!-- Rev. Budi -->	    
							<div style="clear: both" ></div>
                            <div class="contentForm">
                               <?php
							   echo '<b>' .form_label('Tempat Pendaftaran') . '</b>';
                               if ($cmbgerai == 'OnLine'){
                                   echo $cmbgerai;
								   echo form_hidden('cmbgerai', 'OnLine');
							   } else {
                                   if($save_method == "save" || $save_method == "save_paralel") {
                                       //$tempat_daftar = array('Pusat' => 'Pusat');  // Untuk daerah lain
                                       $tempat_daftar = array('DPMPTSP Prov. Jabar' => 'DPMPTSP Prov. Jabar','Gerai Bogor' => "Gerai Bogor",
			                                            'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",'Gerai Cirebon' => "Gerai Cirebon",
								                        'SMS' => "SMS",'Surat' => "Surat");
                                   } else {
								       //$tempat_daftar = array('Pusat' => 'Pusat');  // Untuk daerah lain
                                       $tempat_daftar = array('DPMPTSP Prov. Jabar' => 'DPMPTSP Prov. Jabar','BPMPT Prov. Jabar' => 'BPMPT Prov. Jabar','BPPT Prov. Jabar' => 'BPPT Prov. Jabar','Gerai Bogor' => "Gerai Bogor",
			                                            'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",'Gerai Cirebon' => "Gerai Cirebon",
								                        'SMS' => "SMS",'Surat' => "Surat");
							       }
							  
							       //if ($lokasi_user === 'Pusat') { // Untuk daerah lain
                                   if ($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar') {
                                       echo form_dropdown('cmbgerai',$tempat_daftar,$cmbgerai,'class = "input-select-wrc" id="cmbgerai"  onChange=" ceksumber(this.value);return false;"');
							       } else {
                                       echo form_dropdown('cmbgerai',$tempat_daftar,$lokasi_user,'class = "input-select-wrc" id="cmbgerai" onChange=" ceksumber(this.value);return false;" ');
                                   }
				               }
                               ?>
                            </div>
                            <!-- Rev. Budi -->

                            <div style="clear: both" ></div>
                            <div class="contentForm"> 
                                <?php
								$sumberID_input = array(
                                    'name' => 'cmbsource',
                                    'value' => $cmbsource,
                                    'class' => 'input-wrc required',
                                    'readonly' => "readonly"
                                );
                                $data = array('KTP' => 'KTP','SIM' => "SIM",'PASSPORT' => 'PASSPORT');
                                echo '<b>' .form_label('Sumber Identitas') . '</b>';
								if($update){
									echo form_input($sumberID_input);
								}else{
                                    if($cmbsource!=NULL) {
                                        echo form_dropdown('cmbsource',$data,$cmbsource,'class = "input-select-wrc" id="cmbsource"  onChange=" ceksumber(this.value);return false;" ');
                                    } else {
                                        echo form_dropdown('cmbsource',$data,'0','class = "input-select-wrc" id="cmbsource" onChange=" ceksumber(this.value);return false;" ');
                                    }
								}
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <?php
                                if ($save_method == "save") {
                                    $id = 'no_refer';
                                } else {
                                    $id = 'no_refer2';
                                }
                                $norefer_input = array(
                                    'name' => 'no_refer',
                                    'value' => $no_refer,
                                    'class' => 'input-wrc required digits',
                                    'onkeyup'=>'ceksumber(this.form.cmbsource.value);return false;',
                                    'id' => $id
                                );
								if($update) $norefer_input = array_merge($norefer_input,$readonly);
                                echo '<b>' . form_label('NO ID') . '</b>';
                                echo form_input($norefer_input).'<span id="alert" style="color: red"></span>';
                                
                                if ($statusOnline2 == "1") {
                                ?>
                                    <p id='eror1'><span id="error_id"></span></p>
                                    <br>
                                    <input type="button" onclick="show_ktp(this.form)" value="Cek Id/KTP" class="button-wrc" >
                                    <?php 
								} 
								    ?>
                            </div>

                            <?php
                            if ($save_method == "update") {
                                echo ("<br>");
                            }
                            ?>
           
							<div style="clear: both" ></div>
							<div class="contentForm">
                                <?php
                                $namapemohon_input = array(
                                    'name' => 'nama_pemohon',
                                    'value' => $nama_pemohon,
                                    'class' => 'input-wrc required'
                                );
								if($update) $namapemohon_input = array_merge($namapemohon_input,$readonly);
                                echo '<b>' . form_label('Nama Pemohon ') . '</b>';
                                echo form_input($namapemohon_input);
                                echo form_error('nama_pemohon', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div class="contentForm">
                                <?php
                                $notelp_input = array(
                                    'name' => 'no_telp',
                                    'value' => $no_telp,
                                    'class' => 'input-wrc digits required'
                                );
								if($update) $notelp_input = array_merge($notelp_input,$readonly);
                                echo '<b>' . form_label('No Telp/HP ') . '</b>';
                                echo form_input($notelp_input);
                                echo form_error('no_telp', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div style="clear: both" ></div>
							<div class="contentForm">
                                <?php
                                $alamatdata_input = array(
                                    'name' => 'alamat_pemohon',
                                    'value' => $alamat_pemohon,
                                    'class' => 'input-area-wrc required'
                                );
								if($update) $alamatdata_input = array_merge($alamatdata_input,$readonly);
                                echo '<b>' . form_label('Alamat Pemohon ') . '</b>';
                                echo form_textarea($alamatdata_input);
                                echo form_error('alamat_pemohon', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div style="clear: both" ></div>
							<div class="contentForm">
                                <b><?php echo form_label('Provinsi '); ?> </b>
                                <?php
								if($update){
                                    foreach ($list_propinsi as $row) {
				                        if($row->id == $propinsi_pemohon) echo '<b>'.$row->n_propinsi.'</b>';
                                    }
                                }else{
									$opsi_propinsi = array('0' => '-------Pilih data-------');
								    foreach ($list_propinsi as $row) {
                                        $opsi_propinsi[$row->id] = $row->n_propinsi;
                                    }
				                    if ($propinsi_pemohon == " ") {
                                        echo form_dropdown('propinsi_pemohon', $opsi_propinsi, '0', 'class = "input-select-wrc notSelect" id="propinsi_pemohon_id"');
                                    } else {
                                        echo form_dropdown('propinsi_pemohon', $opsi_propinsi, $propinsi_pemohon, 'class = "input-select-wrc notSelect" id="propinsi_pemohon_id"');
                                    }
								}
                                ?>
                            </div>

							<div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kabupaten/Kota ');
                                $opsi_kabupaten = array('0' => '-------Pilih data-------');
                                foreach ($list_kabupaten as $row) {
                                    $opsi_kabupaten[$row->id] = $row->n_kabupaten;
                                }
                                if ($kabupaten_pemohon == NULL) {
                                    echo "<div id='show_kabupaten_pemohon'>Data Tidak Tersedia</div>";
                                } else {
									if(!isset($opsi_kabupaten[$kabupaten_pemohon])){
										echo $nkab_pemohon;
									}else{
                                        echo "<div id='show_kabupaten_pemohon'><input type='hidden' value='".$kabupaten_pemohon."' name='kabupaten_pemohon' />" . $opsi_kabupaten[$kabupaten_pemohon]."</div>";
                                    }
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kecamatan ');
                                $opsi_kecamatan = array('0' => '-------Pilih data-------');
                                foreach ($list_kecamatan as $row) {
                                    $opsi_kecamatan[$row->id] = $row->n_kecamatan;
                                }
                                if ($kecamatan_pemohon == NULL) {
                                    echo "<div id='show_kecamatan_pemohon'>Data Tidak Tersedia</div>";
                                } else {
									//if($save_method == "update"){
									//	echo $nkec_pemohon;
									//}else{
                                        echo "<div id='show_kecamatan_pemohon'><input type='hidden' value='" . $kecamatan_pemohon . "' name='kecamatan_pemohon' />" . $opsi_kecamatan[$kecamatan_pemohon] . "</div>";
									//}
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kelurahan ');
                                $opsi_kelurahan = array('0' => '-------Pilih data-------');
                                foreach ($list_kelurahan as $row) {
                                    $opsi_kelurahan[$row->id] = $row->n_kelurahan;
                                }
                                if ($kelurahan_pemohon == NULL) {
                                    echo "<div id='show_kelurahan_pemohon'>Data Tidak Tersedia</div>";
                                } else {
									//if($save_method == "update"){
									//	echo $nkel_pemohon;
									//}else{
                                        echo "<div id='show_kelurahan_pemohon'><input type='hidden' value='" . $kelurahan_pemohon . "' name='kelurahan_pemohon' />" . $opsi_kelurahan[$kelurahan_pemohon] . "</div>";
									//}
                                }
                                ?>
                            </div>
                            
                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <?php
                                $alamatdataluar_input = array(
                                    'name' => 'alamat_pemohon_luar',
                                    'value' => $alamat_pemohon_luar,
                                    'class' => 'input-area-wrc'
                                );
								if($update) $alamatdataluar_input = array_merge($alamatdataluar_input,$readonly);
                                echo '<b>' . form_label('Alamat Pemohon<br />di Luar Negeri<br />(isikan jika ada)') . '</b>';
                                echo form_textarea($alamatdataluar_input);
                                ?>
                            </div>

							<!--REV.Sahal-->
							<div class="contentForm">
                                <?php
                                $In_kd_kontak = array(
                                    'name'  => 'kd_kontak',
                                    'value' => $kd_kontak,
                                    'class' => 'input-wrc required'
                                );
                                echo '<b>' . form_label('Nomor Kontak Perantara').'</b>';
                                echo form_input($In_kd_kontak);
                                echo form_error('kd_kontak', '<div class="field_error">', '</div>');
                                ?>
                            </div>
							<!--REV.Sahal-->

                        </div>

                        <div id="contentright">    <!-- Sisi Kanan -->
                            <div class="contentForm">
                                <?php
                                echo '<b><H2>' . form_label('DATA PERMOHONAN') . '</H2></b>';
                                ?>
                            </div>

                            <div style="clear: both" ></div>
							<div class="contentForm">
                                <?php
                                $lokasi_input = array(
                                    'name' => 'lokasi_izin',
                                    'value' => $lokasi_izin,
                                    'class' => 'input-area-wrc'
                                );
                                echo '<b>' . form_label('Lokasi / Objek Izin') . '</b>';
                                echo form_textarea($lokasi_input);
                                ?>
                            </div>

                            <div style="clear: both" ></div>
							<div class="contentForm">
                                <b><?php echo form_label('Provinsi '); ?> </b>
								<b><?php echo form_label('PROVINSI JAWA BARAT'); ?> </b>
                                <?php
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kabupaten/Kota ');
                                $opsi_kabupaten_lok = array('0' => '-------Pilih data-------');
                                foreach ($list_kabupaten_lok as $row) {
                                    $opsi_kabupaten_lok[$row->id] = $row->n_kabupaten;
                                }
								if ($kabupaten_lok == NULL) {
                                    echo form_dropdown('kabupaten_lok', $opsi_kabupaten_lok, '0', 'class = "input-select-wrc notSelect" id="kabupaten_lok_id"');
                                } else {
									echo form_dropdown('kabupaten_lok', $opsi_kabupaten_lok, $kabupaten_lok, 'class = "input-select-wrc notSelect" id="kabupaten_lok_id"');
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kecamatan ');
                                $opsi_kecamatan_lok = array('0' => '-------Pilih data-------');
                                foreach ($list_kecamatan as $row) {
                                    $opsi_kecamatan_lok[$row->id] = $row->n_kecamatan;
                                }
                                if ($kecamatan_lok == NULL) {
                                    echo "<div id='show_kecamatan_lok'>Data Tidak Tersedia</div>";
                                } else {
                                    echo "<div id='show_kecamatan_lok'><input type='hidden' value='" . $kecamatan_lok . "' name='kecamatan_lok' />" . $opsi_kecamatan_lok[$kecamatan_lok] . "</div>";
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kelurahan ');
                                $opsi_kelurahan_lok = array('0' => '-------Pilih data-------');
                                foreach ($list_kelurahan as $row) {
                                    $opsi_kelurahan_lok[$row->id] = $row->n_kelurahan;
                                }
                                if ($kelurahan_lok == NULL) {
                                    echo "<div id='show_kelurahan_lok'>Data Tidak Tersedia</div>";
                                } else {
                                    echo "<div id='show_kelurahan_lok'><input type='hidden' value='" . $kelurahan_lok . "' name='kelurahan_lok' />" . $opsi_kelurahan_lok[$kelurahan_lok] . "</div>";
                                }
                                ?>
                            </div>
                            
                            <div style="clear: both" ></div>
							<div class="contentForm">
                                <?php
                                $ket_input = array(
                                    'name' => 'keterangan',
                                    'value' => $keterangan,
                                    'class' => 'input-area-wrc'
                                );
                                echo '<b>' . form_label('Keterangan') . '</b>';
                                echo form_textarea($ket_input);
                                ?>
                            </div>

							<div style="clear: both" ></div>
                            <div class="contentForm">
                                <?php
                                $tglsurvey_input = array(
                                    'name' => 'tgl_survey',
                                    'value' => $tgl_survey,
                                    'class' => 'input-wrc',
                                    'readOnly' => TRUE,
                                    'id' => 'inputTanggal2'
                                );
                                echo '<b>' . form_label('Tgl Peninjauan') . '</b>';
                                echo form_input($tglsurvey_input);
                                ?>
                            </div>
                            
                        </div>

                        <br style="clear: both;" />
                    </div>

                    <!-- ----------- TABS 2 ( Data Perusahaan ) ----------- -->
                    <div id="tabs-2">
                        <?php
                        if ($save_method !== "update") {
                            ?>
                            <div class="contentForm">
                                <?php
                                echo form_label('');
                              echo anchor(base_url() . 'pelayanan/pendaftaran/daftar_perusahaan_list', 'Ambil Data Perusahaan', 'class="link-wrc" rel="perusahaan_box"');
                                ?>
                                
                            </div>
                            <br style="clear: both" />
                            <?php
                        }
                        ?>
                        <div id="contentleft">
                            <div class="contentForm">
                                <?php
                                if ($save_method == "save") {
                                    $id = 'npwp';
                                } else {
                                    $id = 'npwp2';
                                }
                                $npwp_input = array(
                                    'name' => 'npwp',
                                    'value' => $npwp,
                                    'class' => 'input-wrc',
                                    'id' => 'nonpwp'
                                );
                                echo form_label('NPWP');
                                echo form_input($npwp_input);
                                ?>
                                <button id="ok" onclick="statNpwp()" style="display: none; color: green" align="right">&#10004;</button>
                                <button id="fail" onclick="statNpwp()" style="display: none; color: red" align="right">&#10006;</button>
                                <button id="connect" style="display: none;" align="right">Koneksi Terputus</button>
                            </div>

                            <div class="contentForm">
                                <?php
                                $nodaftar_input = array(
                                    'name' => 'nodaftar',
                                    'id' => 'nodaftar_id',
                                    'value' => $nodaftar,
                                    'class' => 'input-wrc'
                                );
                                echo form_label('No Register ');
                                echo form_input($nodaftar_input);
                                echo form_error('nodaftar', '<div class="field_error">', '</div>');
                                ?>
                                <?php if ($statusOnline == "1") { ?>
                                    <br>
								<?php } ?>
                                <!-- <input style="margin-left: 22%;" type="button" onclick="show_npwp(this.form)" value="Cek NPWP dan No Daftar" class="button-wrc" > -->
                            </div>

                            <div class="contentForm">
                                <?php
                                $namaperusahaan_input = array(
                                    'name' => 'nama_perusahaan',
                                    'value' => $nama_perusahaan,
                                    'class' => 'input-wrc',
                                );
                                echo form_label('Nama Perusahaan ');
                                echo form_input($namaperusahaan_input);
                                echo form_error('nama_perusahaan', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div class="contentForm">
                                <?php
                                $telp_input = array(
                                    'name' => 'telp_perusahaan',
                                    'value' => $telp_perusahaan,
                                    'class' => 'input-wrc',
                                );
                                echo form_label('Telp Perusahaan ');
                                echo form_input($telp_input);
                                echo form_error('telp_perusahaan', '<div class="field_error">', '</div>');
                                ?>
                            </div>

							<div class="contentForm">
                                <?php
                                $fax_input = array(
                                    'name' => 'fax',
                                    'value' => $fax,
                                    'class' => 'input-wrc digits',
                                );
                                echo form_label('Fax');
                                echo form_input($fax_input);
                                ?>
                            </div>

							<div class="contentForm">
                                <?php
                                $email_input = array(
                                    'name' => 'email',
                                    'value' => $email,
                                    'class' => 'input-wrc email',
                                );
                                echo form_label('Email');
                                echo form_input($email_input);
                                ?>
                            </div>

                        </div>
                        <div id="contentright">

                            <div class="contentForm">
                                <b><?php echo form_label('Provinsi '); ?> </b>
                                <?php
                                $opsi_propinsi = array('0' => '-------Pilih data-------');
                                foreach ($list_propinsi as $row) {
                                    $opsi_propinsi[$row->id] = $row->n_propinsi;
                                }

                                if ($propinsi_usaha == " ") {
                                    echo form_dropdown('propinsi_usaha', $opsi_propinsi, '0', 'class = "input-select-wrc" id="propinsi_usaha_id"');
                                } else {
                                    echo form_dropdown('propinsi_usaha', $opsi_propinsi, $propinsi_usaha, 'class = "input-select-wrc" id="propinsi_usaha_id"');
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b>
								<?php
                                echo form_label('Kabupaten/Kota ');
                                $opsi_kabupaten = array('0' => '-------Pilih data-------');
								$list_kabupaten = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
                                foreach ($list_kabupaten as $row) {
                                    $opsi_kabupaten[$row->id] = $row->n_kabupaten;
                                }
                                if ($kabupaten_usaha == NULL) {
                                    echo "<div id='show_kabupaten_usaha'>Data Tidak Tersedia</div>";
                                } else {
									//if(!isset($opsi_kabupaten[$kabupaten_usaha])){
									//	echo $nkab_usaha;
									//}else{
                                        echo "<div id='show_kabupaten_usaha'><input type='hidden' value='" . $kabupaten_usaha . "' name='kabupaten_usaha' />" . $opsi_kabupaten[$kabupaten_usaha] . "</div>";
									//}
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kecamatan ');
                                $opsi_kecamatan = array('0' => '-------Pilih data-------');
                                foreach ($list_kecamatan as $row) {
                                    $opsi_kecamatan[$row->id] = $row->n_kecamatan;
                                }
                                if ($kecamatan_usaha == NULL) {
                                    echo "<div id='show_kecamatan_usaha'>Data Tidak Tersedia</div>";
                                } else {
									//if($save_method == "update"){
									//	echo $nkec_usaha;
									//}else{
                                        echo "<div id='show_kecamatan_usaha'><input type='hidden' value='" . $kecamatan_usaha . "' name='kecamatan_usaha' />" . $opsi_kecamatan[$kecamatan_usaha] . "</div>";
									//}
                                }
                                ?>
                            </div>
                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <b><?php
                                echo form_label('Kelurahan ');
                                $opsi_kelurahan = array('0' => '-------Pilih data-------');
                                foreach ($list_kelurahan as $row) {
                                    $opsi_kelurahan[$row->id] = $row->n_kelurahan;
                                }
                                if ($kelurahan_usaha == NULL) {
                                    echo "<div id='show_kelurahan_usaha'>Data Tidak Tersedia</div>";
                                } else {
									//if($save_method == "update"){
									//	echo $nkel_usaha;
									//}else{
                                        echo "<div id='show_kelurahan_usaha'><input type='hidden' value='" . $kelurahan_usaha . "' name='kelurahan_usaha' />" . $opsi_kelurahan[$kelurahan_usaha] . "</div>";
									//}
                                }
                                ?>
                            </div>

                            <div style="clear: both" ></div>
                            <div class="contentForm">
                                <?php
                                $alamatusaha_input = array(
                                    'name' => 'alamat_usaha',
                                    'value' => $alamat_usaha,
                                    'class' => 'input-area-wrc',
                                );

                                echo form_label('Alamat Perusahaan ');
                                echo form_textarea($alamatusaha_input);
                                echo form_error('alamat_usaha', '<div class="field_error">', '</div>');
                                ?>
                            </div>

                            <div class="contentForm">
                                <?php
                                foreach ($list_kegiatan as $row) {
                                    $opsi_kegiatan[' '] = "------Pilih salah satu------";
                                    $opsi_kegiatan[$row->id] = '['.$row->n_kegiatan.'] '.$row->keterangan;
                                }

                                echo form_label('Jenis Kegiatan [KBLI]');
                                if ($jenis_kegiatan == "ok") {
                                    echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, ' ', 'class = "input-select-wrc" id="jenis_kegiatan"');
                                } else {
                                    echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, $jenis_kegiatan, 'class = "input-select-wrc" id="jenis_kegiatan"');
                                }
                                echo form_error('jenis_kegiatan', '<div class="field_error">', '</div>');
                                ?>
                                <p id="erorJ_kegiatan" align="right" style="visibility: hidden;"></p>
                            </div>

                            <div class="contentForm">
                                <?php
                                foreach ($list_investasi as $row) {
                                    $opsi_investasi[' '] = "------Pilih salah satu------";
                                    $opsi_investasi[$row->id] = $row->keterangan.' ('.$row->n_investasi.')';
                                }

                                echo form_label('Jenis Investasi ');
                                if ($jenis_investasi == "ok") {
                                    echo form_dropdown('jenis_investasi', $opsi_investasi, ' ', 'class = "input-select-wrc" id="jenis_investasi"');
                                } else {
                                    echo form_dropdown('jenis_investasi', $opsi_investasi, $jenis_investasi, 'class = "input-select-wrc" id="jenis_investasi"');
                                }
                                echo form_error('jenis_investasi', '<div class="field_error">', '</div>');
                                ?>
                                <p id="erorJ_investasi" align="right" style="visibility: hidden;"></p>
                            </div>

                        </div>
                        <br style="clear: both;" />
                    </div>

                   <!-- ---------- TAB 3 ( Persyaratan ) ---------- -->

                    <div id="tabs-3">
                        <table cellpadding="0" cellspacing="0" border="1" class="display">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="56%">Syarat</th>
                                    <th width="6%">Terpenuhi</th>
									<th width="5%">Status</th>
                                    <th width="30%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if ($paralel == "no") {
                                    for($z=1;$z<=2;$z++) {
                                        foreach ($syarat_izin as $data) {
                                            $show_syarat = new trperizinan_syarat();
                                            $show_syarat->where('trsyarat_perizinan_id', $data->id)
                                                        ->where('trperizinan_id', $jenis_izin->id)->get();
                                            $var = $show_syarat->c_show_type;
	                                        $stat_wajib = $show_syarat->status;
                                            if((int)$stat_wajib == (int)$z ) {
                                                /* Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi desimal */
                                                //$rule = strval(decbin($var));
                                                //if(strlen($rule) < 4) {
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
                                                if (strlen($rule) < $plv) {
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
                                                        <td> <?php echo $data->v_syarat; ?></td>
                                                        <td align="center">
                                                            <?php
                                                            if($save_method === 'update') {
                                                                if(isset($check)) {
                                                                    foreach($check as $dt) {
                                                                        if($dt == $data->id) {
                                                                            $checked = TRUE;
                                                                            break;
                                                                        }else{
                                                                            $checked = FALSE;
                                                                        }
                                                                    }
                                                                } else {
                                                                    $checked = FALSE;
                                                                    if ($list_daftar) {
                                                                        foreach ($list_daftar as $data_daftar) {
                                                                            $data_syarat = new tmpermohonan_trsyarat_perizinan();
                                                                            $data_syarat->where('tmpermohonan_id', $data_daftar->id)
                                                                                        ->where('trsyarat_perizinan_id', $data->id)->get();
                                                                            if ($data_syarat->trsyarat_perizinan_id) {
                                                                                $checked = TRUE;
                                                                                break;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $checked = FALSE;
                                                                        break;
                                                                    }
                                                                }
                                                            } else {
                                                                if (isset($check) && !empty($check)) {
                                                                    foreach ($check as $dt) {
                                                                        if ($dt == $data->id) {
                                                                            $checked = TRUE;
                                                                            break;
                                                                        } else {
                                                                            $checked = FALSE;
                                                                        }
                                                                    }
                                                                } else {
                                                                    $checked = FALSE;
                                                                }
                                                            }
															$set = array('name' => 'pemohon_syarat[]',
                                                                         'value' => $data->id,
                                                                         'checked' => $checked,
                                                                         'onClick' => 'cheker()',
                                                                         'id' => 'chek'
                                                                        );
                                                            echo form_checkbox($set);
                                                            ?>
												        </td>
														<td align="center">
														    <?php
                                                            if ($stat_wajib == "1")	
                                                                $status_data = "Wajib";
                                                            else
                                                                $status_data = "Tidak Wajib";
                                                            echo $status_data;
                                                            ?>
														</td>
                                                        <td>
                                                            <?php
                                                            //input keterangan
								                            $npwp_in = array('name' => 'npwp',
                                                                             'value' => $npwp,
                                                                             'class' => 'input-wrc',
                                                                             'style' => 'width:100%'
                                                                       );
                                                            echo form_input($npwp_in);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $x = 1;
                                    $data_izin = 0;
                                    if ($list_izin_paralel) {
                                        foreach ($list_izin_paralel as $row) {
                                            $row_izin = new trperizinan();
                                            $row_izin->get_by_id($row);
                                            if ($x == 1)
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
                                                  order by B.status, B.v_syarat ";
                                        $results = mysql_query($query);
                                        while ($rows = mysql_fetch_assoc(@$results)) {
                                            $syarat_daftar = new trsyarat_perizinan();
                                            $syarat_daftar->get_by_id($rows['trsyarat_perizinan_id']);
                                            /*
                                             * Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi
                                             * desimal
                                             */
                                            $show_syarat = new trperizinan_syarat();
                                            $show_syarat
                                                    ->where('trsyarat_perizinan_id', $rows['trsyarat_perizinan_id'])->get();
                                            $var = $show_syarat->c_show_type;
											$stat_wajib = $show_syarat->status;

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
                                            if (strlen($rule) < $plv) {
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
                                            if ($syarat_status == '1') {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td align="center"><?php echo $i; ?></td>
                                                    <td><?php echo $syarat_daftar->v_syarat; ?></td>
                                                    <td align="center">
                                                        <?php
                                                        $set = array(
                                                            'name' => 'pemohon_syarat[]',
                                                            'value' => $syarat_daftar->id,
                                                            'onClick' => 'cheker()'
                                                        );
                                                        echo form_checkbox($set);
                                                        ?>
													</td>
													<td align="center">
														<?php
													    if ($stat_wajib == "1")	
                                                           $status_data = "Wajib";
                                                        else
                                                           $status_data = "Tidak Wajib";
                                                        echo $status_data;
                                                        ?>
													</td>
                                                    <td align="center">
                                                        <?php
                                                        //Input Keterangan
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
						<!-- Create PBS -->
                        <div class="post"  style="color:#0000FF;">
                            <div class="title" style="width:100%;text-align:center;color:#0000FF;">
								<?php
								$img_cetak = array(
                                    'src' => base_url().'assets/images/icon/print.png',
                                    'alt' => 'Cetak Persyaratan Izin',
                                    'title' => 'Cetak Persyaratan Izin',
							        'onclick' => 'parent.location=\'' . site_url('info/infoperizinan/cetak_syarat') .'/'. $jenis_izin->id. '\''
                                );
                                echo img($img_cetak);
								?>
                            </div>
                        </div>
                        <!-- EOF PBS -->
                    </div>

                    <?php
                }else {
                    ?>
                    <div id="tabs-1" ></div>
                    <div id="tabs-2" ></div>
                    <div id="tabs-3" ></div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="entry" style="text-align: center;">
            <?php
			$cnt = "Simpan";
			if ($id_link == "Pengembalian") {
				$link = site_url('pelayanan/pendaftaran');
				$cnt = "Dikembalikan";
			}

			$confirm_text = 'Apakah Anda yakin permohonan izin akan dikembalikan ?';
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => $cnt,
                'type' => 'submit',
                'value' => $cnt,
				'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
            );

            if ($id_link == "1")
                $link = site_url('pendataan/index_next');
            else
                $link = site_url('pelayanan/pendaftaran');

            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\'' . $link . '\''
            );
            
            if ($save_method !== "update") {
                if ($paralel == "no") {
                    if ($jenis_izin->id)
                        echo form_submit($add_daftar);
                    echo "<span></span>";
                    echo form_button($cancel_daftar);
                }else {
                    if ($list_izin_paralel) {
                        echo form_submit($add_daftar);
                        echo "<span></span>";
                        echo form_button($cancel_daftar);
                    }
                }
            } else {
                if ($jenis_izin->id)
                    echo form_submit($add_daftar);
                echo "<span></span>";
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
        }
        ,
        messages:{
            no_refer:{
                remote:'No referensi sudah digunakan!'
            }
//            ,
//            npwp:{
//                remote:'No NPWP sudah digunakan!'
//            }
//        
        }
    });
   <?php } ?>
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#nonpwp").keyup(function(){ // Ketika tombol simpan di klik
    var site = '<?php echo site_url('pelayanan/pendaftaran/cek_status_npwp'); ?>';
    var npwp = $('#nonpwp').val();
    var jenis = '<?php echo $jenis_izin->id; ?>';
            $.ajax({
                url:site,
                type:"POST",
                data:"npwp="+npwp+"&jenis="+jenis,
                dataType: 'json',
                success:function(data) {
                    //console.log('ok');
                    nonpwp = data[1];
                    namanpwp = data[2];
                    statnpwp = data[3];

                    //console.log(data[4]);

                    if(data[0] == 'S'){
                        document.getElementById("connect").style.display = "inline";
                        document.getElementById("fail").style.display = "none";
                        document.getElementById("ok").style.display = "none";
                        }
                    else if(data[0] == 'V'){
                        document.getElementById("ok").style.display = "inline";
                        document.getElementById("fail").style.display = "none";
                        }
                    else{
                        document.getElementById("fail").style.display = "inline";
                        document.getElementById("ok").style.display = "none";
                        }
                    if (npwp == '') {
                            document.getElementById("fail").style.display = "none";
                            document.getElementById("ok").style.display = "none";
                            document.getElementById("connect").style.display = "none";
                        }
                },
                error: function(xhr, textStatus, errorThrown){
                   console.log(errorThrown);
                }
            });
  });
});

function statNpwp() {
                        alert("No NPWP : "+nonpwp+"\n"+
                              "Nama : "+namanpwp+"\n"+
                              "Status : "+statnpwp);
                    }
</script>