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
            echo form_open('permohonan/sk/ctk_np', $attr);
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
				'onclick' => 'parent.location=\''. site_url('permohonan/sk/index_next') . '/T\''
            );

			if($lihat) echo form_submit($add_daftar);
			echo form_button($kembali);
		    ?>
		</div>

        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="cetakizin">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <!--<th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
	     	            <th width="15%">Pemohon</th>-->

						<th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
                        <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>

                        <th width="35%">Jenis Izin</th>
                        <th width="20%">No Surat<br>Tanggal Surat</th>
			            <th width="8%">Status Cetak Berkas</th>
			            <th width="6%">Pilih Cetak</th>
                    </tr>
                </thead>
                <tbody>
				    
                    <?php
					$i = 0;
                    
					//if($lihat) {
                        foreach ($list as $data) {
							$permohonan = new tmpermohonan();
                            $permohonan->where('id', $data->id)->get();
				    	    $d_selesai_proses = $permohonan->d_selesai_proses;
                            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
                            $permohonan_perusahaan->where('tmpermohonan_id', $data->id)->get();
				    	    $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
			    			$perusahaan = new tmperusahaan();
		    				$perusahaan->where('id', $perusahaan_id)->get();
         					$n_perusahaan = $perusahaan->n_perusahaan;
    						$a_perusahaan = $perusahaan->a_perusahaan;

							if($data->c_cetak == '0'){
								$ctk=FALSE;
							}else{
                                $ctk=TRUE;
                                $i++;
							}
                            $b = ''; $be = '';
							if($ctk){
                    ?>
                            <tr>
                                <td valign='top'><?php echo $i; ?></td>
								<td valign='top'><?php echo $b.$data->pendaftaran_id.'<br>'.$data->n_pemohon.'<br>'.$n_perusahaan.$be; ?>
								<td valign='top'>
							        <?php 
						            //echo $b.$rows['pendaftaran_id'].'<br>'.$be;
					                echo $b.$data->kd_gerai.'<br>'.$be;
                                    if($data->idjenis == '1') $tgl_permohonan = $data->d_terima_berkas;
                                    if($data->idjenis == '2') $tgl_permohonan = $data->d_perubahan;
                                    if($data->idjenis == '3') $tgl_permohonan = $data->d_perpanjangan;
                                    if($data->idjenis == '4') $tgl_permohonan = $data->d_daftarulang;
                                    if($tgl_permohonan){
                                        if($tgl_permohonan != '0000-00-00') 
											echo  $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$this->lib_date->mysql_to_human($d_selesai_proses).$be;
                                    }
					                ?>
							    </td>
       							<td valign='top'><?php echo $b . $data->n_perizinan .$be; ?></td>
			        			<td valign='top'>
								    <?php 
									echo $data->no_surat."<br>";
								    echo $this->lib_date->mysql_to_human($data->tgl_surat);
									?>
								</td>
					        	<td valign='top'>
								    <?php
								    if(!$ctk){
                                        if($data->c_status_bayar === '1' && $data->trkelompok_perizinan_id === '4' || $data->trkelompok_perizinan_id != '4'  )
                                            echo "Belum di-cetak";
                                        else
                                            echo "Belum Bayar Retribusi";
                                        } else {
                                            echo "<b>Dicetak ".$data->c_cetak." kali</b>";
                                    }				 
                                    ?>
								</td>

								<td valign='top'><?php
								    $set = array(
                                        'name' => 'pilih_cetak[]',
                                        'id' => 'chek',
                                        'value' => $data->id,
                                        'checked' => $checked,
                                        'onClick' => 'cheker()'
                                    );
									echo "<center>".form_checkbox($set)."</center>";
								?></td>

                            </tr>
                            <?php
						    }
                        }
					//}
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
				'onclick' => 'parent.location=\''. site_url('permohonan/sk/index_next') . '/T\''
            );
			if($lihat) echo form_submit($add_daftar);
			echo form_button($kembali);
		    ?>
		</div>
    </div>
    <br style="clear: both;" />
</div>