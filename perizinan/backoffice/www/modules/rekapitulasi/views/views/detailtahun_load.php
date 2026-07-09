<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#reportgrid').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });

    } );
</script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
		    <?php 
			    if($gerai=='0') $n_gerai = 'SELURUHNYA'; else $n_gerai = $gerai; 
			?>
            <h2 align="center">
			    <?php echo $list->n_perizinan; ?>
			</h2>
			<h3 align="center">
				<?php echo 'PERIODE : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);?>
			</h3>
			<h3 align="center">
				<?php echo 'ASAL PERMOHONAN : '. $n_gerai;?>
			</h3>
			<table align="left">
                <tr>
                    <td align="center">
                        <?php
                        $Back_data = array(
                            'src' => base_url().'assets/images/icon/back_alt.png',
                            'alt' => 'Lihat di HTML to Openoffice',
                            'title' => 'Kembali',
                            'onclick' => 'parent.location=\''. site_url('rekapitulasi/view_next').'\''
                        );
                        echo img($Back_data);
                        $img_cetak = array(
                            'src' => base_url().'assets/images/icon/print.png',
                            'alt' => 'Selesai',
                            'title' => 'View Report with OpenOffice',
                            'onclick' => 'parent.location=\''.site_url('rekapitulasi/realisasi/cetak_report').'/'.$tgla.'/'.$tglb.'\''
                        );
                        echo img($img_cetak);
                        $img_cetak = array(
                            'src' => base_url().'assets/images/icon/clipboard-2.png',
                            'alt' => 'Cetak',
                            'title' => 'Cetak Ke Mode Excel',
                            'onclick' => 'parent.location=\''.site_url('rekapitulasi/cetak_excel_perizin').'/'.$izin_id.'\''
//                          'onclick' => 'parent.location=\''.site_url('rekapitulasi/cetak_excel_perizin').'/'.$izin_id.'/'.$tgla.'/'.$tglb.'\''
                        );
                        echo img($img_cetak);
                        //echo anchor(site_url('rekapitulasi/realisasi/cetak_report') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
                        ?>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="reportgrid">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="9%">Nomor Pendaftaran / Asal Permohonan</th>
                        <th width="50%">Nama Pemohon / Perusahaan</th>
                        <th width="10%">Tanggal Pendaftaran</th>
						<th width="12%">Objek Ijin</th>
                        <th width="10%">Status</th>
						<th width="5%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = NULL;
                    $izin = new trperizinan();
                    $izin->get_by_id($izin_id);
                    $permohonan = new tmpermohonan();
					if ($gerai === '0') {
						$data_pendaftaran = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas between '$tgla' and '$tglb'")->where_related($izin)->get();
					} else {
    				    $data_pendaftaran = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$gerai' AND d_terima_berkas between '$tgla' and '$tglb'")->where_related($izin)->get();
					}
                    foreach ($data_pendaftaran as $row){
                        $i++;
                        $row->tmpemohon->get();
                        $row->trstspermohonan->get();
                        $row->tmperusahaan->get();
						if($row->status_berkas == "proses")
            				$n_status = $row->trstspermohonan->n_sts_permohonan;
                        else
				            $n_status = $row->status_berkas;
                    ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $row->pendaftaran_id ." / " . $row->kd_gerai; ?></td>
							<td>
							    <?php 
						            if($row->tmperusahaan->n_perusahaan == "")
    						            echo $row->tmpemohon->n_pemohon; 
					                else
					                    echo $row->tmpemohon->n_pemohon ." / " . $row->tmperusahaan->n_perusahaan; 
					            ?>
							</td>
                            <td><?php echo $this->lib_date->mysql_to_human($row->d_terima_berkas); ?></td>
							<td><?php echo $row->a_izin; ?></td>
                            <td><?php echo $n_status; ?></td>
							<td align="center">
							    <?php
                                $img_edit = array(
                                    'src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Lihat Detail',
                                    'title' => 'Lihat Detail',
                                    'border' => '0',
//                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                );
                                echo anchor(site_url('arsip/edit') .'/L/'. $row->id.'/1', img($img_edit))."&nbsp;"; 
                                ?>
							</td>
                        </tr>
                        <?php
                    }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>