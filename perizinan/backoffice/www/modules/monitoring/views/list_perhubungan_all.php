<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#info_list').dataTable ( {
                    'bServerSide'    : true,
                    'bAutoWidth'     : false,
                    'sPaginationType': 'full_numbers',
                    'sAjaxSource'    : '<?php echo base_url(); ?>monitoring/monitoring/datatables_viewdata',
                    'aoColumns'      : [ {
                                           'bSearchable': false,
                                           'bVisible'   : true,
                                           'bSortable'  : false
                                         },
                                         null,
										 null,
										 null,
										 null,
										 null,
										 null,
                                         {
                                           'bSearchable': false,
                                           'bVisible'   : true,
                                           'bSortable'  : false
                                         }
                                       ],
                    'fnServerData': function(sSource, aoData, fnCallback) {
                                       $.ajax ({
                                           'dataType': 'json',
                                           'type'    : 'POST',
                                           'url'     : sSource,
                                           'data'    : aoData,
                                           'success' : fnCallback
                                       });
                                    }
                });
            });
        </script>

        <div class="entry">
		<!--
		    <?php 
			    if($gerai=='0') $n_gerai = 'SELURUHNYA'; else $n_gerai = $gerai; 
			?>
            <h2 align="center">
			    <?php echo 'DATA PERMOHONAN BIDANG ' . $bidang; ?>
			</h2>
			<h3 align="center">
				<?php echo $n_menu . ', PERIODE : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);?>
			</h3>
			<h3 align="center">
				<?php echo 'ASAL PERMOHONAN : '. $n_gerai;?>
			</h3>
		-->
			<table align=left>
                <tr>
                    <td align="center">
                        <?php
                        $Back_data = array(
                            'src' => base_url().'assets/images/icon/back_alt.png',
                            'alt' => 'Lihat di HTML to Openoffice',
                            'title' => 'Kembali'
                        );
                        //echo anchor(site_url('monitoring/monitoring/rekap_next'), img($Back_data));
                                 
	 		    		$img_cetak = array(
                             'src' => base_url().'assets/images/icon/pdf.png',
                             'alt' => 'Cetak',
                             'title' => 'Lihat Detail ke PDF'
                        );
						//echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak));
                        ?>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" border="0" class="display" id="info_list">
                <thead>
                    <tr>
					    <!--
						<th width="2%">No</th>
                        <th width="6%">No Kendaraan</th>
						<th width="7%">Nomor Uji</th>
						<th width="17%">Nomor SK</th>
						<th width="10%">Tanggal SK</th>
						<th width="10%">Masa Berlaku</th>
                        <th width="16%">Nomor KP</th>
                        <th width="10%">Tanggal KP Awal</th>
						<th width="10%">Tanggal KP Akhir</th>
						<th width="10%">Nama Pemilik</th>
						<th width="2%">Aksi</th>
                        -->
						<th width="3%">No</th>
                        <th width="7%">No Kendaraan<br>Nomor Uji</th>
						<th width="24%">Nomor SK</th>
						<th width="10%">Tanggal SK<br>Masa Berlaku SK</th>
                        <th width="24%">Nomor KP</th>
                        <th width="10%">Tanggal KP<br>Masa Berlaku KP</th>
						<th width="17%">Nama Pemilik</th>
						<th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" align="center">Loading data from server.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="entry">
		    <table align=left>
                <tr>
                    <td align="left">
                        <?php
                        $Back_data = array(
                            'src' => base_url().'assets/images/icon/back_alt.png',
                            'alt' => 'Lihat di HTML to Openoffice',
                            'title' => 'Kembali'
                        );
                        //echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                                 
	 		    		$img_cetak = array(
                             'src' => base_url().'assets/images/icon/pdf.png',
                             'alt' => 'Cetak',
                             'title' => 'Lihat Detail ke PDF'
                        );
						//echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak));
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>