<script>
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
        } else {
			if(total == jml || group == 3) {
                document.forms[0].submit.disabled=false;
                $('#coba').html('');
                //$('#test').html('');
            } else {
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
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Data Perizinan</legend>
                <?php
                $attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
                echo form_open('arsip/arsip/save', $attr);
                if ($paralel == "no") {
                    if ($jenis_izin->id) {
                        ?>
                        <div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Id Perusahaan', 'Id'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $id_perusahaan; ?>
                            </div>
                        </div>
						<div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="">
                                <?php echo form_label('Nama Perusahaan', 'Nama Perusahaan'); ?>
                            </div>
                            <div id="rightRail" class="">
                                <?php echo $nama_perusahaan; ?>
                            </div>
                        </div>
                        <div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Nama Izin', 'nama_izin'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $jenis_izin->n_perizinan; ?>
                            </div>
                        </div>
<!--
                        <div id="statusRail" style="font-weight: bold">
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
                        
						<div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Jenis Permohonan', 'jenis_permohonan'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $jenis_permohonan->n_permohonan; ?>
                            </div>
                        </div>
 -->                       
						<?php
                        if ($save_method == "update") {
                        ?>
                            <div id="statusRail" style="font-weight: bold">
                                <div id="leftRail">
                                    <?php echo form_label('No / Tgl Pendaftaran', 'no_daftar'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php echo $list_daftar->pendaftaran_id .' / '. $this->lib_date->mysql_to_human($tgl_daftar); ?>
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
// hitung durasi sedangg customm
    //  $tgl_selesai = $tgl_sk;
	//	$tgl_entry = $tgl_daftar;
	//	$libur = new tmholiday();
	//	$hari_libur = $libur->where("date >= '$tgl_entry' AND date <= '$tgl_selesai'")->count();
//		$hari_libur = $libur->where('date <=', $tgl_selesai)->count();//where('date <=', '2014-03-24')->count();
//		$hari = $libur->where("date >= '$tgl_entry' and date <= '$tgl_selesai'")->count();
	//	$lama_hari = $tgl_selesai - $tgl_entry;
	//	$durasi = $lama_hari - $hari_libur;
							    ?>
							
							<div id="statusRail" style="font-weight: bold">
                                <div id="leftRail" class="bg-grid">
                                    <?php echo form_label('Status Permohonan', 'no_sk'); ?>
                                </div>
                                <div id="rightRail" class="bg-grid">
                                    <?php echo $n_status; ?>
                                </div>
                            </div>

							<div id="statusRail" style="font-weight: bold">
                                <div id="leftRail">
                                    <?php echo form_label('Nomor SK', 'no_sk'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php
                                    if($edit){
                                        $sk_input = array(
                                            'name' => 'no_sk',
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
                                <div id="leftRail" class="bg-grid">
                                    <?php echo form_label('Tanggal SK', 'tgl_sk'); ?>
                                </div>
                                <div id="rightRail" class="bg-grid">
                                    <?php
								    if($edit){
								        $tgl_sk_in = array(
                                            'name' => 'tgl_sk',
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
                                <div id="leftRail">
                                    <?php echo form_label('Durasi Penyelesaian', 'durasi'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php echo $this->lib_date->lama_durasi($tgl_daftar, $tgl_sk).' Hari'; ?>
									<?php //echo $hari_libur; ?>
									<?php //echo $tgl_entry; ?>
                                </div>
                            </div>
							<?php
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
                                    'onclick' => 'parent.location=\'' . site_url('arsip/arsip/list_index') . '\''
//						            'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
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
//                                    'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
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
        if ($eror) {
            echo (" <p id='eror'>$eror</p>");
        }

        ?>
        <p id='eror'><span id="test"></span></p>

        <?php
        //$attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
        //echo form_open('arsip/arsip/save', $attr);
		if ($paralel == "yes") {
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
        if ($paralel == "yes")
            echo form_hidden('jenis_paralel', $jenis_paralel->id);
        ?>
        <div class="entry">

            <div id="tabs">
                <ul>
                    <!--<li><a href="#tabs-1"><b>DATA PEMOHON & PERMOHONAN</b></a></li>
                    <li><a href="#tabs-2"><b>DATA PERUSAHAAN</b></a></li>
					<li><a href="#tabs-3"><b>DATA TEKNIS</b></a></li>-->
                    <li><a href="#tabs-4"><b>ARSIP / PERSYARATAN</b></a></li>
					<!--<li><a href="#tabs-5"><b>TRACKING PERIZINAN</b></a></li>
					<li><a href="#tabs-6"><b>BERKAS IZIN</b></a></li>-->
                </ul>
                <?php
                if ($paralel == "yes")
                    $real_id = $list_izin_paralel;
                else
                    $real_id = $jenis_izin->id;
                if ($real_id) {
                    ?>

                    <!-- ---------- TABS 1 ( Data Pemohon ) ----------- -->
                   <!-- <div id="tabs-1">
                        <div id="contentleft">
						    <div class="contentForm">
                                <?php
                             //   echo '<b><H2>' . form_label('DATA PEMOHON ') . '</H2></b>';
                                ?>
                            </div>
							<table cellpadding="0" cellspacing="0" border="0" class="display">
								<?php 
							/*	echo "<tr>";
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
								
								if ($save_method == "update") echo ("<br>");

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

                    <!-- ----------- TABS 2 ( Data Perusahaan ) ----------- -->

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

					<!-- ----------- TABS 3 ( Data Teknis ) ----------- -->

                    <div id="tabs-3">
                    <table cellpadding="0" cellspacing="0" border="0" class="display">
                        <tr>
                            <td align="left" width="4%"></td>
                            <td align="left" width="20%"></td>
                            <td align="left" width="75%"></td>
                        </tr>
                        <?php
if($edit){
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
		                }else {
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
                                $cek_data = substr($data_property,$cek_posisi+1,$hitung);
								if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
								if($property_aktif == 'Ya') {
                                    echo "<tr>";
									echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
									echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property

                                    if($cek_data == '-')
								        $data_property = substr($data_property,0,$cek_posisi);
								    else
								        $data_property = substr($data_property,$cek_posisi+1,$hitung);
								} else {
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
                                            } else {
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
								    $periode = array(
                                        'name' => $nm_var,
										'style'=>'width:10%',
                                        'value' => date("Y-m-d",strtotime($data_property)), //$data_property,
                                        'class' => 'monbulan',
										'readOnly'=>TRUE,
                                    );
									if($property_aktif == 'Ya') {
									    echo "<td ".$bg.">".form_input($periode)."</td>"; 
									}
								}

                                if($property_type == 'TextBox') {
								    $property_input = array(
                                        'name' => $nm_var,
									    'style'=>'width:100%',
                                        'value' => $data_property,
                                        'class' => 'input-wrc',
                                    );
									if($property_aktif == 'Ya') {
									    echo "<td ".$bg.">".form_input($property_input)."</td>";
									}
								}

								if($property_type == 'Integer') {
									$cek_data = (int) $data_property;
									$property_input = array(
                                        'name' => $nm_var,
									    'style'=>'width:10%',
                                        'value' => $data_property,
                                        'class' => 'input-wrc required digits',
                                    );
									if($property_aktif == 'Ya') {
                                        echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
									}
								}
                                
								if($property_aktif == 'Ya') {
								    echo "<td width='80%'".$bg."><b></b></td>";
                                    echo "</b></td>";
                                    echo "</tr>";
						            $i++;
								} else {
									echo form_hidden($nm_var, $data_property);
							    }
                            }
						    if($i == '1') {
							    $stat_property = FALSE;
							    echo "Property Belum diseting";
							}
						}
						//if($d_survey != '0000-00-00') { //jika online dan belum isi peninjauan lapangan
                        ?>
                        <!--<tr>
                            <td></td>
                            <td><b>Upload File Saran</b></td>
                            <td>
                                <input required form="uploadS" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" type="file" class="input-wrc" name="saran">
                                <input form="uploadS" type="hidden" name="zzzz" value="<?=$id_daftar?>">

                                <input form="uploadS" type="submit" name="submittt" class="submit-wrc" value="Upload">
                                <?php $a = $this->db->query("SELECT saran_teknis,file_saran FROM tmpermohonan where id = $id_daftar")->row_array();?>
                    
                                <?php
                                if($a['saran_teknis'] == ""){
								?>
                                    Tidak ada file saran teknis yang diupload
                                <?php }else{ ?>
                                    &emsp;&emsp; [File Tersedia&emsp;
                                    <a class="submit-wrc" href='<?=site_url("$a[file_saran]")?>' download="<?=$a['saran_teknis']?>"><?=$a['saran_teknis']?></a>
                                            ]
                                <?php }
                                ?>
						    </td>
						</tr>-->
                        <?php 
						//}
                        ?>
                    </table>
					<?php
}else{
                        $id_izin = $jenis_izin->id;
                        $jml_property = $this->lib_date->data_property($id_izin,'1');
						if($jml_property == '0') {
							echo "Property Belum Diseting";
                            $stat_property = FALSE;
		                } else {
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
//                                    echo "<td width='20%'".$bg."><b>".$i.' . '. $this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
									echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
									echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
								}
                                $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
								$hitung = strlen($data_property);
                        		$cek_posisi = strpos($data_property,'^'); 
                                $data_property = substr($data_property,0,$cek_posisi);

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
                                            } else {
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
								    } else {
									    if($property_type == 'Tanggal') {
                                            echo "<td ".$bg.">".$this->lib_date->mysql_to_human($data_property)."</td>";
									    } else {
    							            echo "<td ".$bg.">".$data_property."</td>";
							            }
								    }
								    echo "<td width='80%'".$bg."><b></b></td>";
                                    echo "</b></td>";
                                    echo "</tr>";
						            $i++;
								} else {
									echo form_hidden($nm_var, $data_property);
							    }
                            }
						    if($i == '1') {
							    $stat_property = FALSE;
							    echo "Property Belum diseting";
						    }
						}
}*/
                        ?>
                    </table>

                    </div>

                    <!-- ---------- TAB 4 ( Persyaratan ) ---------- -->

                    <div id="tabs-4">
<!--
<form  method="post" name="form_saya" action="<?php echo base_url() . '/main/pendaftaran_online2/save_pendaftaran' ?>" enctype="multipart/form-data" id="formID" class="formular">
-->
                        <table cellpadding="0" cellspacing="0" border="1" class="display">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th width="64%">Syarat Terlampir Dalam Berkas Permohonan</th>
                                    <th width="4%">Status</th>
                                      <!--<th width="5%">Verifikasi ADM</th>
                                  <th width="5%">Terlampir</th>
                                    <!-- <th width="5%">Asli</th>
                                   <th width="15%">Keterangan</th>-->
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
                                        } else {
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
                                        } else {
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
                                ?>

                                <?php
                                $i = 0;
                                if ($paralel == "no") {
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
                                            } else {
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
                                    } else {
										$cek_val_combo = FALSE;
									}

									// merubah data menjadi array keaslian syarat wajib
								/*	if($val_combo_asli){
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
                                            } else {
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
                                    } else {
										$cek_val_combo_asli = FALSE;
									}
                                     */
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
                                            } else {
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
                                    } else {
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
                                            } else {
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
                                    } else {
										$cek_val_combo_asli_lain = FALSE;
									}

                                    // EOF array
                                    for($z=1;$z<=2;$z++) {
                                        foreach ($syarat_izin as $data) {
                                            $show_syarat = new trperizinan_syarat();
                                            $show_syarat
                                                ->where('trsyarat_perizinan_id', $data->id)
                                                ->where('trperizinan_id', $jenis_izin->id)->get();
                                            $var = $show_syarat->c_show_type;
		    								$stat_wajib = $show_syarat->status;
                                            if( (int)$stat_wajib == (int)$z ) {
        										/*
                                                * Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi
                                                * desimal
                                                */

                                                $rule = strval(decbin($var));
                                                if (strlen($rule) < 4) {
                                                    $len = 4 - strlen($rule);
                                                    $rule = str_repeat("0", $len) . $rule;
                                                }
                                                $arr_rule = str_split($rule);

                                                $c_daftar_ulang = $arr_rule[0];
                                                $c_baru = $arr_rule[1];
                                                $c_perpanjangan = $arr_rule[2];
                                                $c_ubah = $arr_rule[3];

                                                $syarat_status = $c_baru;
                                                if ($syarat_status == '1') {
                                                    $i++;
										            echo form_hidden('jumlah_syarat',$i);

                                ?>
                                                    <tr>
                                                        <td width="2%" align="center"><?php echo $i; ?></td>                  <!-- List No Urut -->
                                                        <td width="64%"><?php echo $data->v_syarat; ?></td>                   <!-- List nama persyaratan -->
                                                        <td width="4%" align="center">                                        <!-- List status wajib / tidak sebuah persyaratan -->
                                                            <?php
                                                            //if ($data->status == "1")
												         	if ($stat_wajib == "1")
                                                                $status_data = "Wajib";
                                                            else
                                                                $status_data = "Tidak Wajib";
                                                            echo form_label($status_data);
                                                            ?>
                                                        </td>
         												<!--<td width="5%" align="center">                                        <!-- List ceklist dari FO -->
		        										    <?php
				        								/*	if (isset($check)) {
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
                                                            if($checked)
										        				echo 'V';
												        	else
														        echo '-';*/
													        ?>
												       <!-- </td>   -->  
        												<!--<td width="5%" align="center">                                        <!-- List Input ceklist terpenuhinya persyratan wajib -->
                                                            <?php
        												  /*  $checked = FALSE;
		        									        if($cek_val_combo) { 
     			        									    foreach ($opsi_koefisien_syarat as $cek_syarat) {
						        						            if($data->id == $cek_syarat ) $checked = TRUE;
								        			            }
										        			}
                                                            $set = array(
                                                                'name' => 'pemohon_syarat[]',
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
														            echo '-'; */
													        ?>
												        <!--</td>-->
												        <!--<td width="5%"  align="center">                                   <!-- List input ceklist keaslian sebuah persyratan wajib -->
                                                            <?php
		        										    /*$checked = FALSE;
				        									$coba_cek = '';
						        					        if($cek_val_combo_asli) { 
     							        					    foreach ($opsi_koefisien_asli as $cek_syarat) {
										        		            if($data->id == $cek_syarat ) $checked = TRUE;
											                    }
													        }*/
                                                          /*  $set = array(
                                                                'name' => 'keaslian_syarat_wajib[]',
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
												        		    echo '-';*/
													        ?>
												        <!--</td>-->
        												<!--<td width="15%" >                                                     <!-- List input keterangan persyaratan wajib -->
		        										    <?php /*
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
                                                            $keterangan_input = array(
                                                                'name' => $var_ket,
                                                                'value' => $n_ket,
					                            			    'style'=>'width:99%',
                                                                'class' => 'input-wrc'
                                                            );
												        	if($edit)
                                                                echo form_input($keterangan_input);
                                                            else
                                                                echo $n_ket;
        													echo form_hidden($var_id,$data->id);
                                                            */
		        									        ?>  
				        							  <!--  </td> -->
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    $a = 1;
                                    while ($a < 6) { // input persyaratan lainnya
									   /* $nex_var = $i + $a;
                                        $var_syarat = 'syarat'.$a;
                                        $var_ket = 'ket_lain'.$a;
										if($a == 1 ) { $n_syarat = $syarat1; $n_keterangan = $ket_lain1; }
         		    				    if($a == 2 ) { $n_syarat = $syarat2; $n_keterangan = $ket_lain2; }
	            					    if($a == 3 ) { $n_syarat = $syarat3; $n_keterangan = $ket_lain3; }
    			        			    if($a == 4 ) { $n_syarat = $syarat4; $n_keterangan = $ket_lain4; }
						                if($a == 5 ) { $n_syarat = $syarat5; $n_keterangan = $ket_lain5; }
										         */   ?>
										<!--<tr>
                                            <td align="center"><?php echo $nex_var; ?></td>             <!-- Menampilkan No Urut lainnya  -->
										   <!-- <td>                                                        <!-- Menampilkan nama persyaratan lainnya -->
										        <?php 
                                                /*
                                                    $syarat_input = array(
                                                        'name' => $var_syarat,
                                                        'value' => $n_syarat,
	    				                    			'style'=>'width:100%',
                                                        'class' => 'input-wrc'
                                                    );
													if($edit)
                                                        echo form_input($syarat_input);
													else
														echo $n_syarat;*/
					    						?>
						    				<!--</td>-->
										 <!--   <td align="center"><?php echo 'Berkas lain'; ?></td>        <!-- Menampilkan status berkas lain sebuah persyaratan lainnya -->
										   <!-- <td align="center"><?php echo '-'; ?></td>                  <!-- Menampilkan - pada kolom terlampir persyratan lainnya -->
										   <!-- <td align="center">                                         <!-- Menampilkan input ceklist keaslian sebuah persyratan lainnya -->
                                                <?php /*
											        $checked = FALSE;
											        if($cek_val_combo_asli_lain) { 
     											        foreach ($opsi_koefisien_asli_lain as $cek_syarat) {
											                if($a == $cek_syarat ) $checked = TRUE;
											            }
												    }
                                                    $set = array(
                                                        'name' => 'keaslian_syarat_lainnya[]',
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
														    echo '-';*/
											    ?>
										   <!-- </td>
										    <td align="center">                                         <!-- Menampilkan input keterangan persyaratan lainnya Asli / Tidak -->
											    <?php 
                                                /*
                                                    $keterangan_input = array(
                                                        'name' => $var_ket,
                                                        'value' => $n_keterangan,
					                    			    'style'=>'width:100%',
                                                        'class' => 'input-wrc'
                                                    );
													if($edit)
                                                        echo form_input($keterangan_input);
													else
                                                        echo $n_keterangan;*/
											    ?>
										    </td>
											<!--<td>                                                        <!-- Menampilkan input keterangan persyaratan lainnya -->
											    <?php 
                                             //   echo '-';
											    ?>
										    <!--</td>-->
										</tr>
                                        <?php
                                        $a++;
                                    }
                                } else { // belum di gunakan
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
                                            $show_syarat
                                                    ->where('trsyarat_perizinan_id', $rows['trsyarat_perizinan_id'])->get();
                                            $var = $show_syarat->c_show_type;

                                            $rule = strval(decbin($var));
                                            if (strlen($rule) < 4) {
                                                $len = 4 - strlen($rule);
                                                $rule = str_repeat("0", $len) . $rule;
                                            }
                                            $arr_rule = str_split($rule);

                                            $c_daftar_ulang = $arr_rule[0];
                                            $c_baru = $arr_rule[1];
                                            $c_perpanjangan = $arr_rule[2];
                                            $c_ubah = $arr_rule[3];

                                            $syarat_status = $c_baru;
                                            if ($syarat_status == '1') {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td align="center"><?php echo $i; ?></td>
                                                    <td><?php echo $syarat_daftar->v_syarat; ?></td>
                                                    <!--<td align="center">
                                                        <?php
                                                        $set = array(
                                                            'name' => 'pemohon_syarat[]',
                                                            'value' => $syarat_daftar->id,
                                                            'onClick' => 'cheker()'
                                                        );
                                                        echo form_checkbox($set);
                                                        ?></td>-->
                                                    <td align="center">
                                                        <?php
                                                        if ($syarat_daftar->status == "1")
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

						<div style="clear: both" ></div>
						<div class="contentForm">
                            <?php
                            $tahun_input = array(
                                'name' => 'tahun',
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
                            $jumlah_input = array(
                                'name' => 'jumlah',
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
                            $sampul_input = array(
                                'name' => 'sampul',
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
                            $box_input = array(
                                'name' => 'box',
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
                        </div>-->

						<div style="clear: both" ></div>
					<!--	<div class="contentForm">
                            <?php
                            $rak_input = array(
                                'name' => 'rak',
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
					/*	if($nama_file == '') {
							$stat_berkas = FALSE;
                    	    echo heading('Belum Ada Dokumen Izin',2);
							echo form_label('');
                            echo anchor(site_url('arsip/showform/0'), 'Upload Dokumen', 'class="link-wrc" rel="upload_box"');
						} else {
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
                                if($a == 1) {
							        $opsi_koefisien_name = array($item_combo => $item_combo);
                                } else {
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
                                        $img_info = array(
                                            'src' => base_url().'assets/images/icon/cross.png',
                                            'alt' => 'Hapus Berkas',
                                            'title' => 'Hapus Berkas',
                                            'border' => '0',
						    				'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                        );
					  			    	echo anchor(site_url('arsip/deleteform/'.$no), img($img_info))."&nbsp;";
		    						    echo heading('',3);
									} else {
                                        echo $no.'. '.$cek_name."; ";
									}
								}
							}
							if($edit) {
    							echo anchor(site_url('arsip/showform/999'), 'Tambah Dokumen Baru', 'class="link-wrc" rel="upload_box"');
							}
						}*/
                        ?>
                        <!-- EOF() Upload Area -->
					</div>

                    <!-- ---------- TABS 5 ( Tracking Perizinan ) ----------- -->
                  <!--  <div id="tabs-5">
                        <div style="text-align:right">
                            <?php /*
                            //if($group == 1) {
                                $user = new user();
                                $user->get_by_id(substr($list_daftar->pendaftaran_id,-3));
                                $petugas = $user->oriname;
                                if($petugas == '') $petugas = '-';
                                echo 'Petugas Front Office : '.$petugas . ' ';
                                echo '<br>';
                            //}

                            // EOF() Proses ambil Informasi Petugas Penomoran
                            //if($group == 1) {
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
                            //}
                            // EOF() Proses ambil Informasi Petugas Penomoran

                            //} */
                            ?>
                       <!-- </div>
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
                            <tbody>-->
                                <?php  /*                  
                                $i = 0;
                                $total_awal = NULL;
                                $total_akhir = NULL;
                                $total_hari = NULL;
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
                                    } else {
                                        $showed = FALSE;
                                        $status = '';
                                        $waktu_awal = '';
                                        $waktu_akhir = '';
                                        break;
                                    }
                                    //$sts_track = $data->trstspermohonan->get();
                                    //$sts_name = $sts_track->n_sts_permohonan;
                                    if($showed) {
                                        $i++;
                                        //if($group == 1 ) {
                                            $n_user = $data_track->tr_user .' / '. $data_track->tr_name;
                                        //} else {
                                        //    $n_user = '- err -';
                                        //}
                                            */
                                ?>
                                        <!--<tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data->n_sts_permohonan; ?></td>
                                            <td>-->
                                                <?php /*
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
                                                        } else {
                                                            if($data->id == 13 || $data->id == 15 || $data->id == 16 || $data->id == 17) {
                                                                echo "Selesai";
                                                            } else {
                                                                if($data->id == 12) {
                                                                    echo "Telah dicetak";
                                                                } else {
                                                                    if($time_akhir === $time_awal) {
                                                                        echo "Sedang Diproses";
                                                                    } else {
                                                                        $time_awal = $time_awal + $hari;
                                                                        $total_hari = $total_hari + $hari;
                                                                        echo timespan($time_awal, $time_akhir);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }   */
                                                ?>
                                        <!--    </td>
                                            <td>-->
                                                <?php /*
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
                                                } */
                                                ?>
                                            <!--</td>
                                            <td>-->
                                                <?php /*
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
                                }*/
                                        ?>
                           <!-- </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td><b>Total Pengerjaan</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <b>-->
                                            <?php /*
//                                            echo $total_awal."<br>";
//                                            echo $total_akhir."<br>";
//                                            echo $total_hari."<br>";
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
                            echo '<b><H3>' . form_label('ALASAN PENOLAKAN ') . '</H3></b>';*/
                        ?>
                            <!--<table cellpadding="0" cellspacing="0" border="0" class="display">
                            <?php
                               /* $list = "SELECT * FROM alasan_penolakan WHERE id_permohonan = '$id_daftar'";
                                $results = mysql_query($list);
                                $no=0;
                                while ($rows = mysql_fetch_assoc(@$results)){
                                    $no++;
                                    echo "<tr>";
                                    echo "<td align='right'   valign='top' width='2%'>".$no.'.'."</td>"."";
                                    echo "<td align='Justify' valign='top' width='50%'>".$rows['alasan']."</td>"."";
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
                        }    */
                            ?>
                     <!--   <br style="clear: both;" />
                    </div>-->

                    <!-- ---------- TABS 6 ( Berkas Izin ) ----------- -->
                   <!-- <div id="tabs-6">
                        <!--<div style="text-align:center">-->
                    
                        <?php /* if($n_status=="Izin Disetujui"){ ?>
                            <br>
                            <center>
                                
                                <?php if($jenis_izin->template_gub!=""){ ?>
                                    <a class="submit-wrc" href="<?php echo site_url('arsip/berkascetak/')."/".$list_daftar->id."/2"; ?>" target="_blank" style="padding: 10px 30px">Download Berkas Gubernur</a>
                                <?php }else{ ?>
                                    <a class="submit-wrc"  onClick="notif()" style="padding: 10px 30px">Download Berkas Gubernur</a>
                                <?php } ?>
                                
                                <?php if($jenis_izin->template!=""){ ?>
                                    <a class="submit-wrc" href="<?php echo site_url('arsip/berkascetak/')."/".$list_daftar->id."/1"; ?>" target="_blank" style="padding: 10px 30px">Download Berkas Kabad</a></center>
                                <?php }else{ ?>
                                    <a class="submit-wrc" onClick="notif2()" style="padding: 10px 30px">Download Berkas Kabad</a></center>
                                <?php } ?>
                            
                            <br>
                            <script>
                                function notif(){
                                    alert("Izin ini belum memiliki template Gubernur !");
                                }
                                function notif2(){
                                    alert("Izin ini belum memiliki template Kabad !");
                                }
                            </script>
                        <?php }
                            if($n_status=="Izin Ditolak"){
                        ?>
                        
                            Ditolak
                        
                        <?php } ?>
                        
                        <?php
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
//                                       $filename = 'tmp_filesaya.pdf';
//  header('Content-type: application/pdf');
//  header('Content-Disposition: inline; filename="' . $filename . '"');
//  header('Content-Disposition: inline; filename="$file"');
//  header('Content-Transfer-Encoding: binary');
//  header('Accept-Ranges: bytes');
//  @readfile($file);
                                            }else{
                                                $image_properties = array(
                                                    'src' => base_url().'doc-izin/'.$cek_name,
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
                        } else {
                            echo 'DOKUMEN BELUM DIARSIPKAN';
                        }*/
                                    ?>
                  
                    <!--</div>-->
                    
                    <?php
                }else {
                    ?>
                   <!-- <div id="tabs-1" ></div>
                    <div id="tabs-2" ></div>
                    <div id="tabs-3" ></div>-->
					<div id="tabs-4" ></div>
                   <!-- <div id="tabs-5" ></div>
					<div id="tabs-6" ></div>-->
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="entry" style="text-align: center;">
            <?php
            $add_daftar = array(
                'name' => 'submit',
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
				    $link = site_url('permohonan/penetapan/index_next');
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
				case 13; // belum dipakai {buat case berurutan}
                    break;
            }

            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => $text,
                'onclick' => 'parent.location=\'' . $link . '\''
            );
            
            if ($edit) {
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
			} else {
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
<!--<script type="text/javascript">
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
        }
    });
    <?php } ?>
</script>