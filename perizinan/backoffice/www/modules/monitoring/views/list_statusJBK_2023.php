<script type="text/javascript">
    function validasi() {
	    var	first=document.forms[0].first_date.value;
    	var	second=document.forms[0].second_date.value;
		if(first.length==0) {
	    	document.forms[0].first_date.focus();
		    alert("Periode awal mohon diisi");
		    return false;
	    }else( 
			if(second.length==0) {
		        document.forms[0].second_date.focus();
		        alert("Periode akhir mohon diisi");
		        return false;
	        }else{
			    return true;		
		    }
        }
    }
</script>
	
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <fieldset id="half">
            <?php
            $attr = array(
                'class' => 'searchForm',
                'id' => 'searchForm'
            );
            echo form_open("monitoring/state", $attr);

			$opsi_stat = array('3' => '-------- Seluruhnya --------',
                '0' => 'Belum Jadi',
                '1' => 'Sudah Jadi',
                '2' => 'Kadaluarsa');

			$kirim = array('0' => '-------- Seluruhnya --------',
                '1' => 'Telah Dikirim',
                '2' => 'Belum Dikirim');
			
			//$asal_permohonan = array('0' => '-------- Seluruhnya --------','Pusat' => 'Pusat'); // Untuk daerah lain
			$asal_permohonan = array('0' => '-------- Seluruhnya --------','BPPT Prov. tasikmalaya' => 'BPPT Prov. tasikmalaya','BPMPT Prov. tasikmalaya' => 'BPMPT Prov. tasikmalaya',
			                         'DPMPTSP Prov. tasikmalaya' => 'DPMPTSP Prov. tasikmalaya','Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",
									 'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");

	        $periodeawal_input = array(
                'name' => 'first_date',
                'class' => 'monbulan',
                'id' => 'firstDateInput',
                'readOnly'=>TRUE,
                'value' => $first_date
            );

			$periodeakhir_input = array(
                'name' => 'second_date',
                'class' => 'monbulan',
                'id' => 'secondDateInput',
                'readOnly'=>TRUE,
                'value' => $second_date
            );

			$cari = array(
                'name' => 'submit',
                'class' => 'button-wrc',
                'content' => 'Cari',
                'type' => 'submit',
                'onclick'=>'return validasi()'
            );

         	?>
			<table>
		   	    <tr>
				    <td><?php echo form_label('Jenis Status', 'label_izin'); echo form_hidden('mark','tanda'); ?> </td>
				    <td><?php
                        if ($mark=="tanda") {
                  		    echo form_dropdown('list_status', $opsi_stat, $list_status2,'class = "input-select-wrc" id="selecStatus"');
                        } else {
                            echo form_dropdown('list_status', $opsi_stat,'3','class = "input-select-wrc" id="selecStatus"');
                        }
                        ?>
				    </td>
			    </tr>
				<tr>
                    <td> <?php echo form_label('Status Pengiriman', 'label_kirim');
                        echo form_hidden('mark1', 'tanda1'); ?>
					</td>
                    <td> <?php
                        if ($mark1 == "tanda1") {
                            echo form_dropdown('list_kirim', $kirim, $list_kirim, 'class = "input-select-wrc" id="pilihkirim"');
                        } else {
                            echo form_dropdown('list_kirim', $kirim, '0', 'class = "input-select-wrc" id="pilihkirim"');
                        }
                        ?>
                    </td>
				</tr>
				<tr>
                    <td> <?php echo form_label('Asal Permohonan', 'label_permohonan'); echo form_hidden('mark2', 'tanda2'); ?> </td>
                    <td> <?php
                        if ($mark2 == "tanda2") {
                            echo form_dropdown('list_asal', $asal_permohonan, $list_asal, 'class = "input-select-wrc" id="selecAsal"');
                        } else {
                            echo form_dropdown('list_asal', $asal_permohonan, '0', 'class = "input-select-wrc" id="selecAsal"');
                        }
                        ?>
                    </td>
                </tr>
			    <tr>
				    <td><?php echo form_label('Periode Awal', 'd_tahun'); ?></td>
				    <td><?php echo form_input($periodeawal_input);?></td>
			    </tr>
			    <tr>
				    <td><?php echo form_label('Periode Akhir', 'd_tahun');?></td>
				    <td><?php echo form_input($periodeakhir_input);?></td>
			    </tr>
			</table>
			<table>
			    <tr>
				    <td><?php echo form_button($cari); echo form_close(); ?></td>
                    <?php
                    echo form_open('monitoring/monitoringstatus/cetak_monitoring_ambil');
                    echo form_hidden('list_status',$list_status2);
					echo form_hidden('list_asal',$list_asal);
                    echo form_hidden('first_date',$first_date);
                    echo form_hidden('second_date',$second_date);
                    $cetak = array(
                        'name' => 'cetak',
                        'class' => 'button-wrc',
                        'id' => 'cetak',
                        'content' => 'Cetak',
                        'type' => 'submit',
                        'onclick'=>'return validasi()'                       
                    );
                    ?>
					<td><?php  
                        if ($jumlah > 0){
                            echo form_button($cetak);
                        }
                            echo form_close();
                        ?>
					</td>
			    </tr>	
	        </table>
        </fieldset>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="listdata">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pendaftaran</th>
                        <th>Nama Perizinan</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Nama Pemohon</th>
                        <th>Status Permohonan</th>
                        <th>Alamat Pemohon</th>
                        <th>Asal Permohonan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="dataTables_empty">Tidak ada  data..</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
 </div>