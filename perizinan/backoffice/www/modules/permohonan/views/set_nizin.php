<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name ?></h2>
        </div>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1"><b>Data Jenis Perizinan</b></a></li>
                </ul>
                <div id="tabs-1">
                    <?php
					    echo form_open('permohonan/penetapan/simpan_seting/');
                        echo form_hidden('id_izin', $id);
                        echo form_hidden('id_pemohon', $id_pemohon);
					    $n_open = '';
						$n_foto = '';
						$n_keputusan = '';
						$n_aktif = '';
						$n_berlaku = '';
                        $attr = array('id' => 'form');
						if($v_berlaku_tahun == 1000) $v_berlaku_tahun = 'Selama Perusahaan Berdiri'; else $v_berlaku_tahun = $v_berlaku_tahun.' Bulan';
						if($is_open == 1) $n_open = 'YA';
						if($is_open == 2) $n_open = 'TIDAK';
						if($c_foto == 1) $n_foto = 'YA';
						if($c_foto == 0) $n_foto = 'TIDAK';
						if($c_keputusan == 1) $n_keputusan = 'IZIN';
						if($c_keputusan == 0) $n_keputusan = 'NON IZIN';
						if($c_aktif == 1) $n_aktif = 'TIDAK AKTIF';
						if($c_aktif == 0) $n_aktif = 'AKTIF';
						if($c_berlaku == 1) $n_berlaku = 'YA';
						if($c_berlaku == 0) $n_berlaku = 'TIDAK';
                    ?>
    
				    <label>Kode Izin</label>                 <?php echo ': '.$kd_izin; ?>            <br style="clear: both" />
                    <label>Jenis perizinan</label>           <?php echo ': '.$n_perizinan;?>         <br style="clear: both" />
					<label>Jenis perizinan (Cetak)</label>   <?php echo ': '.$n_perizinan_cetak?>    <br style="clear: both" />
                    <label>Indeks</label>                    <?php echo ': '.$indeks?>               <br style="clear: both" />
                    <label>Kode Indeks</label>               <?php echo ': '.$kd_indeks?>            <br style="clear: both" />
                    <label>Durasi Lama Pengerjaan</label>    <?php echo ': '.$v_hari.' Hari Kerja'?> <br style="clear: both" />
                    <label>Lama Berlaku Izin (Bulan)</label> <?php echo ': '.$v_berlaku_tahun?>      <br style="clear: both" />
                    <label>Target Anggaran</label>           <?php echo ': '.$v_perizinan?>          <br style="clear: both" />
                    <label>Unit Kerja</label>                <?php echo ': '.$dtunitkerja?>          <br style="clear: both" />
					<label>Bidang Pengelola Teknis</label>   <?php echo ': '.$bid_teknis?>           <br style="clear: both" />
                    <label>Sektor Perizinan</label>          <?php echo ': '.$n_sektor?>             <br style="clear: both" />
                    <label>Jenis Izin Terbuka</label>        <?php echo ': '.$n_open?>               <br style="clear: both" />
                    <label>Tandatangan Pemohon</label>       <?php echo ': '.$n_foto?>               <br style="clear: both" />
                    <label>Izin / Non Izin</label>           <?php echo ': '.$n_keputusan?>          <br style="clear: both" />
                    <label>Status Aktifasi </label>          <?php echo ': '.$n_aktif?>              <br style="clear: both" />
                    <label>Kelompok</label>                  <?php echo ': '.$n_klp?>                <br style="clear: both" /> 
                    <label>Tampilkan Masa Berlaku</label>    <?php echo ': '.$n_berlaku?>            <br style="clear: both" />

					<label>Format Nomor Izin</label>
                    <?php
                        $no_awal_input = array(
                            'name' => 'no_sk_awal',
                            'value' => $no_sk_awal,
							'style'=>'width:5%'
                        );
                        echo form_input($no_awal_input)." ";
                    
						$no_tengah_input = array(
                            'name' => 'no_sk_tengah',
                            'value' => $no_sk_tengah,
							'class' => 'input-wrc required digits',
							'style'=>'width:2%'
							//,
							//'readOnly'=>TRUE
                        );
                        echo form_input($no_tengah_input)." ";
                        
						$no_akhir_input = array(
                            'name' => 'no_sk_akhir',
                            'value' => $no_sk_akhir,
							'style'=>'width:10%'
                        );
                        echo form_input($no_akhir_input)." ";
                        
						$no_akhir_tahun = array(
                            'name' => 'no_sk_tahun',
                            'value' => date("Y"),
							'style'=>'width:3%',
							'readOnly'=>TRUE
                        );
                        echo form_input($no_akhir_tahun);
						echo ' ketik kd_bln untuk Kode Bulan dalam Romawi';
                    ?>
                    <br style="clear: both" />

					<?php
                        if($c_in_nomor == 1){
                            $select = "";
                            $selecte = "selected='selected'";
                            $selectf = "";
                        } else 
							if ($c_in_nomor == 0) {
                                $select = "";
                                $selecte = "";
                                $selectf = "selected='selected'";
                            } else  
							    if ($c_in_nomor == 2) {
                                    $select = "selected='selected'";
                                    $selecte = "";
                                    $selectf = "";
                                }
                    ?>
                    <label>Metoda Penomoran</label>
                    <select name="c_in_nomor" class="input-select-wrc">
                        <!--option value="xx" <?php echo $select; ?>> ------Pilih salah satu------ </option-->
                        <option value="0" <?php echo $selectf; ?>>Dari System Ke Berkas</option>
						<option value="1" <?php echo $selecte; ?>>Dari Berkas Ke System</option>
                    </select>
                    <br style="clear: both" />

                </div>
            </div>
            <br>
            <?php
            $add_ijin = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            echo form_submit($add_ijin);
            echo "<span></span>";

            $cancel_ijin = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/penomoran') .'/'. $id_pemohon.'/'.$id . '\''
            );
            echo form_button($cancel_ijin);
            echo form_close();
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>