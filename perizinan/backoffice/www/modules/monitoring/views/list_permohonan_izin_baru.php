
<script type="text/javascript">
//      function validasi() {
//		var	first=document.forms[0].first_date.value;
//		var	second=document.forms[0].second_date.value;
//			
//		if(first.length==0)	{
//		document.forms[0].first_date.focus();
//		alert("Periode awal mohon diisi");
//		return false;
//		}
//		
//		else if(second.length==0) {
//		document.forms[0].second_date.focus();
//		alert("Periode akhir mohon diisi");
//		return false;
//		}
//		
//		else {
//			window.location =  "monitoringbulan/cetak_monitoring_bulan/<?php echo ($list_state."/".$first_date."/".$second_date);?>"
//			return true;
//		}
//	  }
//
</script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <?php
                $jumlah = 1;   // Harus Lebih Fleksibel
                $attr = array(
                    'class' => 'searchForm',
                    'id' => 'searchForm'
                );
                echo form_open("monitoring/cetak_izin_baru", $attr);

	            $periodeawal_input = array(
                    'name'  => 'tgla',
                    'value' => $tgla,
                    'class' => 'input-wrc',
                    'readOnly'=>TRUE,
                    'class' => 'monbulan'
                );

                $periodeakhir_input = array(
                    'name'  => 'tglb',
                    'value' => $tglb,
                    'class' => 'input-wrc',
                    'class' => 'monbulan'
                );

		        $cari = array(
                    'name' => 'submit',
                    'value'=>'Cari',
                    'class' => 'button-wrc',
                    'content' => 'Cari',
                    'type' => 'submit',
                );

	            $cetak = array(
                    'name' => 'cetak',
                    'class' => 'button-wrc',
                    'id' => 'cetak',
                    'content' => 'Cetak',
                    'type' => 'button',
                    'onclick' => 'parent.location=\''. site_url('monitoring/monitoringbulan/cetak_izin_baru').'/'.$lokasi_user.'/'.$tgla.'/'.$tglb.'/'.$realname.'/1'.'\''
                );

			    $kembali = array(
                    'name' => 'kembali',
                    'class' => 'button-wrc',
                    'id' => 'kembali',
                    'content' => 'Kembali',
                    'type' => 'button',
                    'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
                );
                ?>
                <table>
		            <tr>
		   		        <td> <?php echo form_label('Tgl Permohonan Awal','d_tahun'); ?> </td>
                        <td> <?php echo form_input($periodeawal_input); ?> </td>
                    </tr>
	                <tr>
    		   		    <td> <?php echo form_label('Tgl Permohonan Akhir','d_tahun'); ?> </td>
	    	   		    <td> <?php echo form_input($periodeakhir_input); ?> </td>
		            </tr>
		            <tr>
	    		        <td> <?php echo form_button($cari);
                            if($jumlah > 0){
                                echo form_button($cetak);;
                            }
                            echo form_button($kembali);
                            echo form_close(); 
		    			    ?>
                        </td>
		   		        <td>&nbsp;</td>
		            </tr>
                </table>
            </fieldset>
        </div>
        <div class="entry">
            <?php
			    if (isset($warning)) {
			?>
                    <p align="center" style="font-weight: bold; color: red"><?php echo $warning; ?></p>
                    <br>
                    <?php 
				}   
			        ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                <thead>
                    <tr>
    					<th width="2%">No</th>
                        <th width="10%">No Pendaftaran</th>
                        <th width="10%">Id pemohon</th>
                        <th width="22%">Nama Pemohon / Perusahaan</th>
                        <th width="22%">Jenis Izin</th>
						<th width="17%">Objek Izin</th>
                        <th width="9%">Tanggal / Asal Permohonan</th>
                        <th width="5%">Status</th>
                        <th width="3%">Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
						$permohonan_perusahaan = new tmpermohonan_tmperusahaan();
                        $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
					    $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
						$perusahaan = new tmperusahaan();
						$perusahaan->where('id', $perusahaan_id)->get();
     					$n_perusahaan = $perusahaan->n_perusahaan;
                    ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $rows['pendaftaran_id'];?></td>
                            <td><?php echo $rows['no_referensi'];?></td>
							<td><?php echo $rows['n_pemohon'].' / '.$n_perusahaan;?></td>
                            <td><?php echo $rows['n_perizinan'];?></td>
							<td><?php 
					            if($rows['keterangan'] == '')
						            echo $rows['a_izin'];
					            else
					                echo $rows['a_izin'].' [ Ket : '.$rows['keterangan'].' ]';
					            ?>
							</td>
							<td><?php
                                if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                                if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                                if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                                if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                                if($tgl_permohonan){
                                    if($tgl_permohonan != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_permohonan);
									echo ' / ';
                                    echo $rows['kd_gerai'];
                                }
                                ?>
                            </td>
                            <td><?php echo 'Entri Data'; //$rows['n_permohonan'];?></td>
                            <td><?php
								if($rows['c_cetak'] == $kd_user){  // Akan Dicetak oleh Operator
                                    $confirm_text = 'Apakah Anda Yakin Izin / Berkas Siap Diserahkan?';
                                    $img_aktif = array(
                                        'src' => base_url().'assets/images/icon/tick.png'	,
                                        'alt' => 'Izin / Berkas Siap Diserahkan',
                                        'title' => 'Izin / Berkas Siap Diserahkan',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    echo anchor(site_url('monitoring/monitoring/cetak_of') .'/'. $rows['id'] .'/'. $tgla .'/'. $tglb .'/1', img($img_aktif))."&nbsp;";
								} else {
									$confirm_text = 'Apakah Anda Yakin Izin / Berkas Siap Diserahkan?';
                                    $img_aktif = array(
                                        'src' => base_url().'assets/images/icon/ntick.png'	,
                                        'alt' => 'Izin / Berkas Siap Diserahkan',
                                        'title' => 'Izin / Berkas Siap Diserahkan',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    echo anchor(site_url('monitoring/monitoring/cetak_on') .'/'. $rows['id'] .'/'. $tgla .'/'. $tglb .'/1', img($img_aktif))."&nbsp;";
								}
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
</div