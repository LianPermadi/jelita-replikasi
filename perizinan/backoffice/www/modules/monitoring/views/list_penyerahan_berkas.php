<script type="text/javascript">
//    function validasi() {
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
                        <th>No</th>
                        <th>No Pendaftaran</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Izin</th>
                        <th>Tanggal Permohonan</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
						<th>Status Permohonan</th>
                        <th>Asal Permohonan</th>
                        <th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
						$status_bap = $rows['status_bap'];
                        $no_surat = $rows['no_surat'];
                        $tgl_surat = $rows['tgl_surat'];
                        $c_cetak = $rows['c_cetak'];
                        $idkelompok = $rows['idkelompok'];
						$s_serah = $rows['siap_serah'];
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $rows['pendaftaran_id'];?></td>
                            <td><?php echo $rows['n_pemohon'];?></td>
							<td><?php echo $rows['n_perizinan'];?></td>
                            <td>
                                <?php
                                if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                                else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                                else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                                else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                                if($tgl_permohonan){
                                    if($tgl_permohonan != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_permohonan);
                                }
                                ?>
                            </td>
                            <td><?php echo $no_surat;?></td>
                            <td><?php
                                if($tgl_surat){
                                if($tgl_surat != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_surat);
                                }
                                ?>
							<td><?php echo $rows['status_berkas']; //echo $rows['n_sts_permohonan'];?></td>
                            <td><?php echo $rows['kd_gerai'];?></td>

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
                                    echo anchor(site_url('monitoring/monitoring/cetak_of') .'/'. $rows['id'] .'/'. $tgla .'/'. $tglb .'/2', img($img_aktif))."&nbsp;";
								} else {
									$confirm_text = 'Apakah Anda Yakin Izin / Berkas Siap Diserahkan?';
                                    $img_aktif = array(
                                        'src' => base_url().'assets/images/icon/ntick.png'	,
                                        'alt' => 'Izin / Berkas Siap Diserahkan',
                                        'title' => 'Izin / Berkas Siap Diserahkan',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    echo anchor(site_url('monitoring/monitoring/cetak_on') .'/'. $rows['id'] .'/'. $tgla .'/'. $tglb .'/2', img($img_aktif))."&nbsp;";
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

		<div class="title">
            <?php
            $jumlah = 1;   // Harus Lebih Fleksibel
            $attr = array(
                'class' => 'searchForm',
                'id' => 'searchForm'
            );
            echo form_open("monitoring/cetak_penyerahan_izin", $attr);

	        $cetak = array(
                'name' => 'cetak',
                'class' => 'button-wrc',
                'id' => 'cetak',
                'content' => 'Cetak',
                'type' => 'button',
                'onclick' => 'parent.location=\''. site_url('monitoring/monitoringbulan/cetak_izin_baru').'/'.$lokasi_user.'/'.$tgla.'/'.$tglb.'/'.$realname.'/2'.'\''
            );

			$kembali = array(
                'name' => 'kembali',
                'class' => 'button-wrc',
                'id' => 'kembali',
                'content' => 'Kembali',
                'type' => 'button',
                'onclick' => 'parent.location=\'' . site_url('pelayanan/ambilsk') . '\''
            );
            ?>
            <table ALIGN="right">
	            <td><?php 
                    if($jumlah > 0){
                        echo form_button($cetak);
                    }
                    echo form_button($kembali);
                    echo form_close(); 
		    	    ?>
                </td>
            </table>
        </div>

    </div>
    <br style="clear: both;" />
</div