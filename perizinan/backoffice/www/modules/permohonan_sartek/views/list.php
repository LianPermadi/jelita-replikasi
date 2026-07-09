<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="permohonan_sartek">
                <thead>
                    <tr>
                        <th>No</th>
						<th>Kode Izin</th>
                        <th>Jenis Perizinan</th>
                        <th>Bidang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = null;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
                        $i++;
						$perizinan_sektor = new trperizinan_trsektor();
                        $perizinan_sektor->where('trperizinan_id', $rows['id'])->get();
					    $sektor_id = $perizinan_sektor->trsektor_id;
						$sektor = new trsektor();
						$sektor->where('id', $sektor_id)->get();
     					$sektor = $sektor->n_sektor;
						if($rows['sartek_alenia1'] == '' && $rows['sartek_alenia2'] == '' && $rows['sartek_alenia3'] == '' && $rows['sartek_alenia4'] == '' ) {
							$konfig = TRUE;
							$text = 'Konfigurasi';
						    $b = '<span style="color: Red">';
						    $be = '</span>';
                        } else {
							$konfig = FALSE;
							$text = 'Edit';
						    $b = '';
						    $be = '';
						}
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
						    <td><?php echo $b.$rows['kd_izin'].$be; ?></td>
                            <td><?php echo $b.$rows['n_perizinan'].$be; ?></td>
                            <td><?php echo $b.$sektor.$be; ?></td>
                            <td width="50">
                                <center>
                                    <?php
                                    $img_edit = array(
                                        'src' => 'assets/images/icon/property.png',
                                        'alt' => $text,
                                        'title' => $text,
                                        'border' => '0',
                                    );
                					$img_konfig = array(
                                        'src' => 'assets/images/icon/property.png',
                                        'alt' => 'Relasi Data',
                                        'title' => 'Relasi Data',
                                        'border' => '0',
                                    );
                                    ?>
                                    <a class="page-help" href="<?php echo site_url('permohonan_sartek/edit'."/1/".$rows['id']) ?>"><?php echo img($img_edit); ?></a>
									<!--<a class="page-help" href="<?php echo site_url('permohonan_sartek/edit'."/2/".$rows['id']) ?>"><?php echo img($img_konfig); ?></a>-->
                                </center>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
						<th>Kode Izin</th>
                        <th>Jenis Perizinan</th>
                        <th>Bidang</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>