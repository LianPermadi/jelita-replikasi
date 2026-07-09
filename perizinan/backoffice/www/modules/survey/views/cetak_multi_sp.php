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
        var a = document.getElementsByName("pilih_cetak[]");
		//var b = document.getElementsByName("keaslian_syarat_wajib[]");
		//var c = document.getElementsByName("keaslian_syarat_lainnya[]");
		//var d = document.getElementsByName("kode_keterangan_wajib[]");
        //var jml ='<?php echo $jml_syarat; ?>';
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
        <?php
            $attr = array(
                'class' => 'searchForm',
                'id' => 'searchForm'
            );
    		$attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
            echo form_open('survey/cetak', $attr);
//			'survey/cetak/' . $rows['id'] . "/" . $rows['idizin']
		    if($lokasi == 'OPD Teknis') {
			    $lihat = FALSE;
    		}else{
                $lihat = TRUE;
	    	}
		?>

		<div style="text-align:right">
		    <?php
            
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'CETAK',
                'type' => 'submit',
                'value' => 'CETAK'
            );

            $kembali = array(
                'name' => 'button',
				'class' => 'submit-wrc',
                'content' => 'Kembali',
                'value' => 'Kembali',
				'onclick' => 'parent.location=\''. site_url('survey/index_next') . '\''
            );

			if($lihat) echo form_submit($add_daftar);
			echo form_button($kembali);
		    ?>
		</div>

        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="cetakizin1">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
	     	            <th width="27%">Nama Pemohon (CP)<br>Alamat Pemohon</th>
						<th width="27%">Nama Perusahaan (CP)<br>Alamat Perusahaan</th>
                        <th width="30%">Tanggal Survay<br>Jenis Izin</th>
			            <th width="5%">Cetak</th>
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
			    		$a_perusahaan = $perusahaan->a_perusahaan;
						$tlp_perusahaan = $perusahaan->i_telp_perusahaan;

                        $showed = FALSE;
                        $idkelompok = NULL;
                        $query_data = "SELECT trkelompok_perizinan_id idkelompok
                                       FROM trkelompok_perizinan_trperizinan
                                       WHERE trperizinan_id = '".$rows['idizin']."'";
                        $hasil_data = mysql_query($query_data);
                        $rows_data = mysql_fetch_object(@$hasil_data);
                        $idkelompok = $rows_data->idkelompok;
					
    				    $b = '<span style="color: Red">';
	    			    $be = '</span>';
		    			$url = NULL;
                        $survey_id = NULL;
                        $query_survey = "SELECT b.no_surat, b.id
                                         FROM tmpermohonan_trtanggal_survey a, trtanggal_survey b
                                         WHERE a.tmpermohonan_id = '".$rows['id']."'
                                         AND a.trtanggal_survey_id = b.id";
                        $hsl_survey = mysql_query($query_survey);
                        $url = site_url('survey/edit/' . $rows['id']);
                        while ($rows_data = mysql_fetch_assoc(@$hsl_survey)){
                            if($rows_data['no_surat']) {
                                $survey_id = $rows_data['id'];
                                $url = site_url('survey/edit/' . $rows['id'] . "/update");
                                $showed = TRUE;
                                $b = ''; $be = '';
    							if($rows_data['no_surat'] == 'Tidak Ditinjau'){
	    							$showed = FALSE;
		    						$b = '<span style="color: Blue">';
                				    $be = '</span>';
				    			}
                            }
                        }

                        if($idkelompok == '2' || $idkelompok == '4'){ // Khusus tinjauan atau tidak ditolak di FO
		        			if($rows['status_berkas'] != 'Izin Ditolak FO'){ // Khusus tidak ditolak di FO
            					if($showed){
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
                                                if($tgl_permohonan != '0000-00-00')
													echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$be;
                                            }
											echo $b.$rows['kd_gerai'].'<br>'.$be;
                                            ?>
                                        </td>
										<td valign='top'><?php echo $b.$rows['n_pemohon'].' ( '.$rows['telp_pemohon'].' )'.'<br>'.$rows['a_pemohon'].$be;?></td>
                                        <td valign='top'><?php echo $b.$n_perusahaan.' ( '.$tlp_perusahaan.' )'.' <br>'.$a_perusahaan.$be;?></td>
                                        <td valign='top'>
                                            <?php
											$tgl_survay = $this->lib_date->mysql_to_human($rows['d_survey']);
											if($rows['survey_sd'] != $rows['d_survey'])
												$tgl_survay .= ' s/d '.$this->lib_date->mysql_to_human($rows['survey_sd']);
                                            echo $b.$tgl_survay.' <br>'.$rows['n_perizinan'].$be;
                                            ?>
                                        </td>
                                        <td valign='top'>
                                            <?php
								            $set = array(
                                                'name' => 'pilih_cetak[]',
                                                'id' => 'chek',
                                                'value' => $rows['id'],
                                                'checked' => $checked,
                                                'onClick' => 'cheker()'
                                           );
									       echo "<center>".form_checkbox($set)."</center>";
								           ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
					        }
					    }
                    }
                                    ?>
                </tbody>
               
            </table>
        </div>
		<div style="text-align:right">
		    <?php
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'CETAK',
                'type' => 'submit',
                'value' => 'CETAK'
            );
			$kembali = array(
                'name' => 'button',
				'class' => 'submit-wrc',
                'content' => 'Kembali',
                'value' => 'Kembali',
				'onclick' => 'parent.location=\''. site_url('pendataan/index_next') . '\''
            );
			if($lihat) echo form_submit($add_daftar);
			echo form_button($kembali);
		    ?>
		</div>
    </div>
    <br style="clear: both;" />
</div>