<?php 
    function tanggal_indo($tanggal)
    {
      $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
          );
      $split = explode('-', $tanggal);
      return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

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
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                            echo form_label('POSISI BULAN/TAHUN');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                            echo ((!empty($first_date) || $first_date != 0) && (!empty($second_date) || $second_date != 0) ? ' : '.tanggal_indo($first_date). ' - '.tanggal_indo($second_date) : ' : KESELURUHAN');
                    ?>
                  </div>
                </div>
                <div style="clear: both" ></div>
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                            echo form_label('KODE TRAYEK');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                            echo form_label(' : '.(!empty($list_data[0]->kode_trayek) ? $list_data[0]->kode_trayek : ''));
                    ?>
                  </div>
                </div>
                <div style="clear: both" ></div>
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                            echo form_label('LINTASAN TRAYEK');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                            echo form_label(' : '.(!empty($list_data[0]->trayek) ? $list_data[0]->trayek : ''));
                    ?>
                  </div>
                </div>


            </fieldset>
        </div>
        

        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="monitoring">
                <thead>
                    <tr>
						<th rowspan="3">No</th>
                        <th colspan="2" class="ui-state-default">Surat Keputusan</th>
						<th rowspan="3">NIP</th>
						<th rowspan="3">Nama Perusahaan</th>
						<th colspan="5" class="ui-state-default">Kartu Pengawasan</th>
                        <th colspan="4" class="ui-state-default">Data Kendaraan</th>
                    </tr>
                    <tr>
                        <th rowspan="2" width="18%">No. SK</th>
                        <th rowspan="2">Tgl. SK</th>
                        <th rowspan="2">No KP</th>
                        <th colspan="2" class="ui-state-default">Seat</th>
                        <th colspan="2" class="ui-state-default">Berlaku</th>
                        <th rowspan="2">No. Mobil</th>
                        <th rowspan="2">No. Uji</th>
                        <th rowspan="2">Merk</th>
                        <th rowspan="2">No. Tahun</th>
                    </tr>
                    <tr>
                        <th>&lt; 24</th>
                        <th>&gt; 24</th>
                        <th>Mulai</th>
                        <th>Akhir</th>
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
                        $img_parent = array('src' => base_url().'assets/images/icon/information.png',
                                      'alt' => 'Detail',
                                      'title' => 'Detail',
                                      'border' => '0',
                                     );
                        foreach ($list_data as $data) {
                            $i++;
                    ?>
                            <tr>
								<td align="center"><?php echo $i; ?></td>
       							<td align="center"><?php echo $data->no_sk; ?></td>
			        			<td><?php echo date('d-m-Y', strtotime($data->tgl_sk)); ?></td>
                                <td><?php echo $data->no_induk; ?></td>
                                <td><?php echo $data->nama_perusahaan; ?></td>
                                <td><?php echo $data->no_kp; ?></td>
                                <td><?php echo ($data->daya_angkut_org <= 24 ? $data->daya_angkut_org : ''); ?></td>
                                <td><?php echo ($data->daya_angkut_org > 24 ? $data->daya_angkut_org : ''); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data->tgl_kp_awal)); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data->tgl_kp_akhir)); ?></td>
                                <td><?php echo $data->no_kend; ?></td>
                                <td><?php echo $data->no_uji; ?></td>
                                <td><?php echo $data->merek; ?></td>
                                <td><?php echo $data->tahun; ?></td>
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
