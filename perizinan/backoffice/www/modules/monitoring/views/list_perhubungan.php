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
            echo form_open("monitoring/perhubungan", $attr);
			//$asal_permohonan = array('0' => '-------- Seluruhnya --------','Pusat' => 'Pusat'); // Untuk daerah lain
			//$asal_permohonan = array('0' => '-------- Seluruhnya --------','BPPT Prov. tasikmalaya' => 'BPPT Prov. tasikmalaya','BPMPT Prov. tasikmalaya' => 'BPMPT Prov. tasikmalaya',
			//                         'Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",
			//						 'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");
			$asal_permohonan = array('0' => 'SK','1' => 'KP');

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
                    'content' => 'Cari Data',
                    'type' => 'submit',
                    'onclick' => 'return validasi()'
                );
           ?>
		   <table>
		        <tr>
                    <td> <?php 
					    echo form_label('Permohonan', 'label_permohonan');
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
		   		    <td> <?php echo form_label('Tanggal Cetak Awal', 'd_tahun'); ?> </td>
			    	<td> <?php echo form_input($periodeawal_input); ?> </td>
                </tr>
		        <tr>
		   		    <td> <?php echo form_label('Tanggal Cetak Akhir', 'd_tahun'); ?> </td>
		   		    <td> <?php echo form_input($periodeakhir_input); ?> </td>
					<td> <?php echo form_button($cari);
                        if($jumlah > 0){
                            //echo form_button($cetak);
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
                        <th width="3%">No</th>
                        <th width="7%">No Kendaraan<br>Nomor Uji</th>
						<th width="24%">Nomor SK<br>Nomor KP</th>
						<th width="10%">Tgl Penetapan SK<br>Tgl Penetapan KP</th>
						<th width="10%">Mulai Berlaku SK<br>Mulai Berlaku KP</th>
						<th width="4%"> </th>
                        <th width="10%">Masa Berlaku SK<br>Masa Berlaku KP</th>
						<th width="25%">Nama Pemilik</th>
						<th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if($lokasi == 'OPD Teknis') {
                        if($cek_sektor == '10') // khususu Perhubungan
						    $lihat = TRUE;
						else
						    $lihat = FALSE;
					}else{
                            $lihat = TRUE;
					}
					if($lihat) {
                        foreach ($list_data as $data) {
                            $i++;
                            if($data->masa_berlaku < $sekarang){
                                $cek = TRUE;
                            } else {
                                $cek = FALSE;
	                        }
                            if($data->tgl_kp_akhir < $sekarang){
                                $cek1 = TRUE;
                            } else {
                                $cek1 = FALSE;
                            }
                            //if($list_state == '0'){
                                if($cek) {
                                    $b = '<span style="color: Red">'; $be = '</span>';
                                } else {
                                    $b = ''; $be = '';
	                            //}
                            //} else {
                                if($cek1) {
                                    $b = '<span style="color: Red">'; $be = '</span>';
                                } else {
                                    $b = ''; $be = '';
	                            }
                            }
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
       							<td><?php echo $b . $data->no_kend .'<br>'. $data->no_uji . $be; ?></td>
			        			<td><?php echo $b . $data->no_sk .'<br>'. $data->no_kp . $be; ?></td>
       							<td><?php echo $b . $this->lib_date->mysql_to_human($data->tgl_penetepan).'<br>'.
						                            $this->lib_date->mysql_to_human($data->tgl_penetapan_kp). $be; ?>
								</td>
								<td align=right><?php echo $b . $this->lib_date->mysql_to_human($data->tgl_sk).'<br>'.
						                            $this->lib_date->mysql_to_human($data->tgl_kp_awal).$be; ?>
								</td>
								<td align=center><?php echo $b . 's/d <br> s/d' . $be; ?></td>
					        	<td><?php echo $b . $this->lib_date->mysql_to_human($data->masa_berlaku).'<br>'.$this->lib_date->mysql_to_human($data->tgl_kp_akhir).$be; ?></td>
	        					<td><?php echo $b . $data->nama_pemilik . $be; ?></td>
								<td><?php echo ''; ?></td>
                            </tr>
                            <?php
                        }
					}
                            ?>
                </tbody>
               
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
