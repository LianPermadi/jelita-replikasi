<script type="text/javascript">
    function validasi()	{
		var	first=document.forms[0].first_date.value;
		var	second=document.forms[0].second_date.value;
		if(first.length==0) {
            document.forms[0].first_date.focus();
            alert("Periode awal mohon diisi");
            return false;
		}else{ 
			if(second.length==0) {
		        document.forms[0].second_date.focus();
                alert("Periode akhir mohon diisi");
                return false;
            }else{
                window.location =  "monitoringbulan/cetak_monitoring_bulan/<?php echo ($list_state."/".$first_date."/".$second_date);?>"
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
            echo form_open("monitoring/perwaktu", $attr);
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
                'value'=>'Cari',
                'class' => 'button-wrc',
                'content' => 'Cari',
                'type' => 'submit',
                'onclick' => 'return validasi()'
            );
			$cetak = array(
                'name' => 'cetak',
                'class' => 'button-wrc',
                'id' => 'cetak',
                'content' => 'Cetak',
                'type' => 'button',
                'onclick' => 'return validasi()'
            );

            ?>
		    <table>
		        <tr>
                    <td> <?php echo form_label('Asal Permohonan', 'label_permohonan');
                        echo form_hidden('mark', 'tanda'); ?>
		            </td>
                    <td> <?php
                        if ($mark == "tanda") {
                            echo form_dropdown('list_state', $asal_permohonan, $list_state, 'class = "input-select-wrc" id="selector"');
                        } else {
                            echo form_dropdown('list_state', $asal_permohonan, '0', 'class = "input-select-wrc" id="selector"');
                        }
                        ?>
                    </td>
                </tr>
		        <tr>
		   		    <td> <?php echo form_label('Periode Awal', 'd_tahun'); ?> </td>
			    	<td> <?php echo form_input($periodeawal_input); ?> </td>
                </tr>
		        <tr>
		   		     <td> <?php echo form_label('Periode Akhir', 'd_tahun'); ?> </td>
		   		     <td><?php echo form_input($periodeakhir_input); ?> </td>
		        </tr>
		        <tr>
	    			<td><?php echo form_button($cari);
                        if($jumlah > 0){
                            echo form_button($cetak);
                        }
                        echo form_close(); 
		    			?>
       				</td>
		   		    <td>&nbsp;</td>
		        </tr>
            </table>
        </fieldset>

        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="monitoring">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th width="10%">No Pendaftaran</th>
                        <th width="10%">Tanggal Pendaftaran</th>
						<th width="20%">Nama Pemohon / Perusahaan</th>
						<th width="20%">Permohonan Perizinan</th>
                        <th width="20%">Objek Izin</th>
						<th width="10%">Status Permohonan</th>
                        <th width="8%">Asal Permohonan</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = NULL;
                    foreach ($listpermohonan as $data) {

                        $i++;
                        $data->tmpemohon->get();
                        $data->trperizinan->get();
                        $data->trstspermohonan->get();
                        $data->tmpemohon->trkelurahan->get();
						$data->tmperusahaan->get();
                    ?>
                        <tr>
                            <td width="2%"><?php echo $i; ?></td>
                            <td width="10%"><?php echo $data->pendaftaran_id; ?></td>
                            <td width="10%"><?php echo $this->lib_date->mysql_to_human($data->d_terima_berkas) ?></td>
							<td width="20%">
							    <?php 
						            if($data->tmperusahaan->n_perusahaan == '')
						                echo $data->tmpemohon->n_pemohon;
					                else
					                    echo $data->tmpemohon->n_pemohon.' / '.$data->tmperusahaan->n_perusahaan;
					            ?>
							</td>
							<td width="20%"><?php echo $data->trperizinan->n_perizinan; ?></td>
                            <td width="20%"><?php echo $data->a_izin; ?></td>
							<td width="10%"><?php echo $data->trstspermohonan->n_sts_permohonan; ?></td>
                            <td width="8%"><?php echo $data->kd_gerai; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
               
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>