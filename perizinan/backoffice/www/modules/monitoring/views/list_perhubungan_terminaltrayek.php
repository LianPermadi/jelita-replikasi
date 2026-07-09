<?php 
    if (empty($first_date)) {
        $first_date = 0;
    }

    if (empty($second_date)) {
        $second_date = 0;
    }
 ?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Filter Data</legend>
                <?php
                $attr = array(
                    'class' => 'searchForm',
                    'id' => 'searchForm'
                );
                echo form_open("monitoring/perhubungan_terminaltrayek", $attr);

                $periodeawal_input = array(
                        'name' => 'first_date',
                        'class' => 'monbulan',
                        'id' => 'firstDateInput',
                        'readOnly'=>TRUE,
                        'value' => ($first_date == 0 ? date('Y-m-d') : $first_date)
                    );
                $periodeakhir_input = array(
                        'name' => 'second_date',
                        'class' => 'monbulan',
                        'id' => 'secondDateInput',
                        'readOnly'=>TRUE,
                        'value' => ($second_date == 0 ? date('Y-m-d') : $second_date)
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
                        <td> <?php echo form_label('Tanggal Penetapan Awal', 'd_tahun'); ?> </td>
                        <td> <?php echo form_input($periodeawal_input); ?> </td>
                    </tr>
                    <tr>
                        <td> <?php echo form_label('Tanggal Penetapan Akhir', 'd_tahun'); ?> </td>
                        <td> <?php echo form_input($periodeakhir_input); ?> </td>
                        <td> <?php echo form_button($cari);
                            echo form_close(); 
                            ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </fieldset>
        </div>
        

        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="monitoring">
                <thead>
                    <tr>
						<th width="1%">No</th>
                        <th width="5%">Kode Trayek</th>
						<th width="55%">Nama Trayek</th>
						<th width="5%">Jumlah</th>
						<th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $sum = 0;
                    if($lokasi == 'OPD Teknis') {
                        if($cek_sektor == '10') // khususu Perhubungan
						    $lihat = TRUE;
						else
						    $lihat = FALSE;
					}else{
                            $lihat = TRUE;
					}
					if($lihat) {
                        $img_parent = array('src' => base_url().'assets/images/icon/information.png',
                                      'alt' => 'Detail',
                                      'title' => 'Detail',
                                      'border' => '0',
                                     );
                        foreach ($list_data as $data) {
                            $i++;
                            $sum+=$data->jml;
                    ?>
                            <tr>
								<td align="center"><?php echo $i; ?></td>
       							<td align="center"><?php echo $data->kode_trayek; ?></td>
			        			<td><?php echo $data->trayek; ?></td>
	        					<td align="center"><?php echo $data->jml; ?></td>
								<td align="center"><?php echo anchor(site_url('monitoring/terminaltrayek_detail') .'/'. $data->id .'/'. $first_date .'/'. $second_date, img($img_parent), array('target' => '_blank'))."&nbsp;"; ?></td>
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
    <?php echo $sum; ?>
</div>
