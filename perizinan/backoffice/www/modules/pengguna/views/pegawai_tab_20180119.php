<style>
    .read_only{
        border: 1px solid black;
    }
    #no_refer1{
        background: #DDDFFD;
    }
    #namapemohon_input{
        background: #DDDFFD;
    }
    #cmbsource{
        background: #DDDFFD;
    }
</style>

<script language="javascript" type="text/javascript">
    $(document).ready(function() {
        $('a[rel*=pemohon_box]').facebox();
        $('a[rel*=daftar_box]').facebox();
    } );

    $(function() {
        $("#inputTanggal1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            closeText: 'X'
        });
        $("#inputTanggal2").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            closeText: 'X'
        });
    });

    function show_ktp() {
        $.post('<?php echo base_url(); ?>pelayanan/pendaftaran/pick_penduduk_data', {
            data_no_refer: $('#no_refer1').val()
        }, function(response){
            setTimeout("finishAjax('tabs-1', '"+escape(response)+"')", 400);
        });
        return false;
    }

    function clear_data() {
        $.post('<?php echo base_url(); ?>pelayanan/pendaftaran/pick_penduduk_data', {
            data_no_refer: $('#clear_id').val()
        }, function(response){
            setTimeout("finishAjax('tabs-1', '"+escape(response)+"')", 400);
        });
        return false;
    }

    $(document).ready(function() {
        $('#propinsi_pemohon_id').change(function(){
            $.post('<?php echo base_url(); ?>pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
            function(data) {
                $('#show_kabupaten_pemohon').html(data);
                $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
            });
        }); 
    });

    function finishAjax(id, response){
        $('#'+id).html(unescape(response));
        $('#'+id).fadeIn();
    }

    function Check(){
        if(document.form.Check_ctr.checked == true){
            document.form.propinsi_pemohon.disabled = false ;
            document.form.kabupaten_pemohon.disabled = false ;
            document.form.kecamatan_pemohon.disabled = false ;
            document.form.kelurahan_pemohon.disabled = false ;
        }else{
            document.form.propinsi_pemohon.disabled = true ;
            document.form.kabupaten_pemohon.disabled = true ;
            document.form.kecamatan_pemohon.disabled = true ;
            document.form.kelurahan_pemohon.disabled = true ;
        }
    }
</script>

<div id="tabs-1">   <!-- menapilkan setelah Proses Ambil Data Pemohon Izin -->
<!--    <div id="contentleft">
        <?php
        if ($status == "pemohon")
            echo form_hidden('id_pemohon', $id_pemohon);
        ?>
        
		<div class="contentForm">
            <?php 
            echo form_label('');
            echo anchor(site_url('pelayanan/pendaftaran/daftar_izin_list'), 'Ambil Data Pemohon Izin', 'class="link-wrc" rel="daftar_box"');
            ?>
        </div>
		
		<br  style="clear: both" />
        <div class="contentForm">
            <?php
            $antrian_input = array(
                'name' => 'no_antri',
     			'class' => 'input-wrc required digits',
                'value' => $no_antri
            );
            echo '<b>' . form_label('Nomor Antrian ') . '</b>';
            echo form_input($antrian_input);
//            echo form_error('nama_pemohon', '<div class="field_error">', '</div>');
            ?>
        </div>
        
		<div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $data = array('KTP' => 'KTP','SIM' => "SIM",'PASSPORT' => 'PASSPORT');
            echo '<b>' .form_label('Sumber Identitas') . '</b>';
            if($cmbsource!=NULL) {
                echo form_dropdown('cmbsource',$data,$cmbsource,'class = "input-select-wrc" id="cmbsource" readonly => "readonly"  onChange=" ceksumber(this.value);return false;" ');
            } else {
                echo form_dropdown('cmbsource',$data,'0','class = "input-select-wrc" id="cmbsource" readonly => "readonly" onChange=" ceksumber(this.value);return false;" ');
            }
            ?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $norefer_input = array(
                'name' => 'no_refer',
                'value' => $no_refer,
                'class' => 'input-wrc required digits',
                'onkeyup'=>'ceksumber(this.form.cmbsource.value);return false;',
                'id' => 'no_refer1',
                'readonly' => "readonly"
            );
            echo '<b>' . form_label('NO ID') . '</b>';
            echo form_input($norefer_input);
            //echo form_hidden('no_refer', $no_refer);
            echo form_error('no_refer', '<div class="field_error">', '</div>');
            if ($statusOnline2 == "1") {
                ?>
				<p id='eror1'><span id="error_id"></span></p>
                <br>
                   <input type="hidden" id="clear_id" name="clear_id" value="wrc">
				<!--   <input type="button" onclick="show_ktp()" value="Cek Id/KTP" class="button-wrc" > -->
<!--                   <input type="button" onclick="clear_data()" value="Clear Data" class="button-wrc">
           <?php } ?>
        </div>

		<div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $namapemohon_input = array(
                'name' => 'nama_pemohon',
                'value' => $nama_pemohon,
                'class' => 'input-wrc required',
                'disabled' => true,
                'id' =>"namapemohon_input"
            );
            echo '<b>' .form_label('Nama Pemohon ').'<b>';
            echo form_input($namapemohon_input);
            echo form_hidden('nama_pemohon', $nama_pemohon);
            echo form_error('nama_pemohon', '<div class="field_error">', '</div>');
            ?>
        </div>

        <div class="contentForm">
            <?php
            $notelp_input = array(
                'name' => 'no_telp',
                'value' => $no_telp,
                'class' => 'input-wrc required digits'
            );
            echo '<b>' .form_label('No Telp/HP ').'<b>';
            echo form_input($notelp_input);
            echo form_error('no_telp', '<div class="field_error">', '</div>');
            ?>
        </div>

        <div class="contentForm">
            <?php
            $alamatdata_input = array(
                'name' => 'alamat_pemohon',
                'value' => $alamat_pemohon,
                'class' => 'input-area-wrc'
            );
            echo form_label('Alamat Pemohon ');
            echo form_textarea($alamatdata_input);
            echo form_error('alamat_pemohon', '<div class="field_error">', '</div>');
            ?>
        </div>

        <div class="contentForm">
            <?php
            $alamatdataluar_input = array(
                'name' => 'alamat_pemohon_luar',
                'value' => $alamat_pemohon_luar,
                'class' => 'input-area-wrc'
            );
            echo form_label('Alamat Pemohon<br />di Luar Negeri<br />(Iisikan jika ada)');
            echo form_textarea($alamatdataluar_input);
            ?>
        </div>

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

      </div>
    <div id="contentright">
		
		<div class="contentForm">
            <b><?php echo form_label('Provinsi '); ?> </b>
            <?php
            $opsi_propinsi = array('0' => '-------Pilih data-------');
            foreach ($list_propinsi as $row) {
                $opsi_propinsi[$row->id] = $row->n_propinsi;
            }
            if ($propinsi_pemohon == " ") {
                echo form_dropdown('propinsi_pemohon', $opsi_propinsi, '0', 'class = "input-select-wrc notSelect" id="propinsi_pemohon_id"');
            } else {
                echo form_dropdown('propinsi_pemohon', $opsi_propinsi, $propinsi_pemohon, 'class = "input-select-wrc" id="propinsi_pemohon_id"');
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
                echo "<div id='show_kabupaten_pemohon'><input type='hidden' value='" . $kabupaten_pemohon . "' name='kabupaten_pemohon' />" . $opsi_kabupaten[$kabupaten_pemohon] . "</div>";
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
                    echo "<div id='show_kecamatan_pemohon'><input type='hidden' value='" . $kecamatan_pemohon . "' name='kecamatan_pemohon' />" . $opsi_kecamatan[$kecamatan_pemohon] . "</div>";
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
                    echo "<div id='show_kelurahan_pemohon'><input type='hidden' value='" . $kelurahan_pemohon . "' name='kelurahan_pemohon' />" . $opsi_kelurahan[$kelurahan_pemohon] . "</div>";
                }
            ?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $tgldaftar_input = array(
                'name' => 'tgl_daftar',
                'value' => $tgl_daftar,
                'class' => 'input-wrc required',
                'id' => 'inputTanggal1'
            );
            echo '<b>' .form_label('Tgl Terima Berkas ').'<b>';
            echo form_input($tgldaftar_input);
            echo form_error('tgl_daftar', '<div class="field_error">', '</div>');
            ?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $tglsurvey_input = array(
                'name' => 'tgl_survey',
                'value' => $tgl_survey,
                'class' => 'input-wrc',
                'id' => 'inputTanggal2'
            );
            echo '<b>' .form_label('Tgl Peninjauan').'<b>';
            echo form_input($tglsurvey_input);
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
            echo '<b>' .form_label('Lokasi / Objek Izin').'<b>';
            echo form_textarea($lokasi_input);
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
            echo '<b>' .form_label('Keterangan').'<b>';
            echo form_textarea($ket_input);
            ?>
        </div>
		
		<!-- Rev. Budi -->
<!--		<div style="clear: both" ></div>
        <div class="contentForm">
            <?php 
            //$tempat_daftar = array('Pusat' => 'Pusat');  // Untuk daerah lain
			$tempat_daftar = array('BPMPT Prov. tasikmalaya' => 'BPMPT Prov. tasikmalaya','Gerai Bogor' => "Gerai Bogor",
			                       'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",'Gerai Cirebon' => "Gerai Cirebon",
								   'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");
            echo '<b>' .form_label('Tempat Pendaftaran') . '</b>';
            if($cmbgerai!=NULL) {
                echo form_dropdown('cmbgerai',$tempat_daftar,$cmbgerai,'class = "input-select-wrc" id="cmbgerai"  onChange=" ceksumber(this.value);return false;" ');
            } else {
                echo form_dropdown('cmbgerai',$tempat_daftar,'0','class = "input-select-wrc" id="cmbgerai" onChange=" ceksumber(this.value);return false;" ');
            }
            ?>
        </div>
        <!-- Rev. Budi -->
<!--    </div>
    <br style="clear: both;" /> -->
    
	<div id="contentleft">
        <div class="contentForm">
            <?php
		    echo form_hidden('ambil_data', $ambil_data);
			echo form_hidden('id_pemohon', $id_pemohon);
			echo '<b><H2>' . form_label('DATA PEMOHON') . '</H2></b>';
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
				echo anchor(site_url('pelayanan/pendaftaran/daftar_izin_list'), 'Ambil Data Pemohon Izin', 'class="link-wrc" rel="daftar_box"');
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
                'id' => 'inputTanggal1'
            );
            echo '<b>' . form_label('Tgl Terima Berkas ') . '</b>';
            echo form_input($tgldaftar_input);
            echo form_error('tgl_daftar', '<div class="field_error">', '</div>');
            ?>
        </div>

		<div style="clear: both" ></div>
        <div class="contentForm">
            <?php
			echo '<b>' .form_label('Tempat Pendaftaran') . '</b>';
            if ($cmbgerai == 'OnLine'){
                echo $cmbgerai;
                echo form_hidden('cmbgerai', 'OnLine');
			} else {
			    $tempat_daftar = array('DPMPTSP Prov. tasikmalaya' => 'DPMPTSP Prov. tasikmalaya','Gerai Bogor' => "Gerai Bogor",
                                       'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",'Gerai Cirebon' => "Gerai Cirebon",
								       'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");
				if($cmbgerai!=NULL) {
                    echo form_dropdown('cmbgerai',$tempat_daftar,$cmbgerai,'class = "input-select-wrc" id="cmbgerai"  onChange=" ceksumber(this.value);return false;"');
				} else {
                    echo form_dropdown('cmbgerai',$tempat_daftar,'0','class = "input-select-wrc" id="cmbgerai" onChange=" ceksumber(this.value);return false;" ');
                }
			}
            ?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm"> 
            <?php
			$sumberID_input = array(
                'name' => 'cmbsource',
                'value' => $cmbsource,
                'class' => 'input-wrc required',
				'readonly' => "readonly"
            );
            echo '<b>' . form_label('Sumber Identitas') . '</b>';
            echo form_input($sumberID_input);
            ?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $norefer_input = array(
                'name' => 'no_refer',
                'value' => $no_refer,
                'class' => 'input-wrc required digits',
                'onkeyup'=>'ceksumber(this.form.cmbsource.value);return false;',
                'id' => 'no_refer1',
                'readonly' => "readonly"
            );
            echo '<b>' . form_label('NO ID') . '</b>';
            echo form_input($norefer_input);
			?>
        </div>

        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $namapemohon_input = array(
                'name' => 'nama_pemohon',
                'value' => $nama_pemohon,
                'class' => 'input-wrc required',
				'readonly' => "readonly"
            );
            echo '<b>' . form_label('Nama Pemohon ') . '</b>';
            echo form_input($namapemohon_input);
            ?>
        </div>

        <div style="clear: both" ></div>
		<div class="contentForm">
            <?php
            $notelp_input = array(
                'name' => 'no_telp',
                'value' => $no_telp,
                'class' => 'input-wrc digits required',
                'readonly' => "readonly"
            );
            echo '<b>' . form_label('No Telp/HP') . '</b>';
            echo form_input($notelp_input);
            ?>
        </div>

        <div style="clear: both" ></div>
		<div class="contentForm">
            <?php
            $alamatdata_input = array(
                'name' => 'alamat_pemohon',
                'value' => $alamat_pemohon,
                'class' => 'input-area-wrc required',
				'readonly' => "readonly"
            );
            echo '<b>' . form_label('Alamat Pemohon ') . '</b>';
            echo form_textarea($alamatdata_input);
            ?>
        </div>

        <div style="clear: both" ></div>
		<div class="contentForm">
            <b><?php echo form_label('Provinsi '); ?> </b>
            <?php
            foreach ($list_propinsi as $row) {
				if($row->id == $propinsi_pemohon) echo '<b>'.$row->n_propinsi.'</b>';
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
                echo "<div id='show_kabupaten_pemohon'><input type='hidden' value='" . $kabupaten_pemohon . "' name='kabupaten_pemohon' />" . $opsi_kabupaten[$kabupaten_pemohon] . "</div>";
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
                echo "<div id='show_kecamatan_pemohon'><input type='hidden' value='" . $kecamatan_pemohon . "' name='kecamatan_pemohon' />" . $opsi_kecamatan[$kecamatan_pemohon] . "</div>";
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
                echo "<div id='show_kelurahan_pemohon'><input type='hidden' value='" . $kelurahan_pemohon . "' name='kelurahan_pemohon' />" . $opsi_kelurahan[$kelurahan_pemohon] . "</div>";
            }
            ?>
        </div>
                            
        <div style="clear: both" ></div>
        <div class="contentForm">
            <?php
            $alamatdataluar_input = array(
                'name' => 'alamat_pemohon_luar',
                'value' => $alamat_pemohon_luar,
                'class' => 'input-area-wrc',
				'readonly' => "readonly"
            );
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
				<b><?php echo form_label('PROVINSI TASIKMALAYA'); ?> </b>
            </div>

            <div style="clear: both" ></div>
            <div class="contentForm">
                <b><?php
                echo form_label('Kabupaten/Kota ');
                $opsi_kabupaten_lok = array('0' => '-------Pilih data-------');
                foreach ($list_kabupaten_lok as $row) {
                    $opsi_kabupaten_lok[$row->id] = $row->n_kabupaten;
                }
				if ($kabupaten_lok == " ") {
                    echo form_dropdown('kabupaten_lok', $opsi_kabupaten, '0', 'class = "input-select-wrc" id="kabupaten_lok_id"');
                } else {
                    echo form_dropdown('kabupaten_lok', $opsi_kabupaten, $kabupaten_lok, 'class = "input-select-wrc" id="kabupaten_lok_id"');
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

			<div style="clear: both" ></div>
                            <div class="contentForm">
							<table width=100% border=1>
                                <tr>
                                    <td width="25%" align="center"><?php echo 'SATU'; ?></td>
									<td width="25%" align="center"><?php echo 'DUA'; ?></td>
									<td width="25%" align="center"><?php echo 'TIGA'; ?></td>
									<td width="25%" align="center"><?php echo 'EMPAT'; ?></td>
                                <tr>
							</table>
                            </div>
        </div>
        <br style="clear: both;" />
    </div>
</div>