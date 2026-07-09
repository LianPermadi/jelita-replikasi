<script type="text/javascript">
    function validasi() {
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
		    } else {
			    window.location =  "monitoringbulan/cetak_monitoring_sektor/<?php echo ($sektor."/".$first_date."/".$second_date);?>"
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
            echo form_open("monitoring/persektor", $attr);

			if ($list_data) {
                foreach ($list_data as $row) {
                    $opsi_sektor['0'] = "------Pilih salah satu------";
                    $opsi_sektor[$row->id] = $row->n_sektor;
                }
            } else {
                $opsi_sektor[0] = "";
            }

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
                <?php
				if($lokasi != 'OPD Teknis'){
                ?>
		            <tr>
                        <td> <?php echo form_label('Bidang Perizinan', 'label_permohonan');
                            echo form_hidden('mark', 'tanda'); ?>
	    	            </td>
                        <td> <?php
                            if ($mark == "tanda") {
                                echo form_dropdown('list_sektor', $opsi_sektor, $sektor, 'class = "input-select-wrc" id="selector"');
                            } else {
                                echo form_dropdown('list_sektor', $opsi_sektor, '0', 'class = "input-select-wrc" id="selector"');
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                    ?>
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
                        <th width="9%">No Pendaftaran / Asal Permohonan</th>
						<th width="10%">Nama Pemohon / Perusahaan</th>
                        <th width="29%">Permohonan Izin</th>
						<th width="20%">Objek Izin</th>
						<th width="10%">Bidang</th>
                        <th width="10%">Tanggal Daftar - Tanggal Selesai</th>
                        <th width="10%">Status Permohonan</th>
                        <th width="9%">Aksi</th>

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
						$data->tmsk->get();
						$data->trperizinan->trsektor->get();
						$data->tmperusahaan->get();

						$tg_surat = $this->lib_date->mysql_to_human($data->tmsk->tgl_surat);
				        if($tg_surat == "Tanggal belum diset."){
                            $tg_surat = "Dalam Proses";
				        }
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data->pendaftaran_id . " " . $data->kd_gerai; ?></td>
							<td><?php echo $data->tmpemohon->n_pemohon . " / " . $data->tmperusahaan->n_perusahaan; ?></td>
                            <td><?php echo $data->trperizinan->n_perizinan; ?></td>
							<td><?php echo $data->a_izin; ?></td>
							<td><?php echo $data->trperizinan->trsektor->n_sektor; ?></td>
                            <td><?php echo $this->lib_date->mysql_to_human($data->d_terima_berkas). " - " .$tg_surat; ?></td>
                            <td><?php echo $data->trstspermohonan->n_sts_permohonan; ?></td>
                            <td><?php $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                       'alt' => 'Lihat Detail',
                                       'title' => 'Lihat Detail',
                                       'border' => '0',
                                      );
                    echo anchor(site_url('arsip/edit') .'/L/'.$data->id.'/7', img($img_lihat))."&nbsp;"; ?></td>

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
