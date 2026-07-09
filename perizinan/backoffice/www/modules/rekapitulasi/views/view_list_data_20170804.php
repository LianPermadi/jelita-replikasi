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
                    'sAjaxSource'    : '<?php echo base_url(); ?>rekapitulasi/izin/datatables_viewdata',
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
                    'fnServerData'   : function(sSource, aoData, fnCallback) {
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
		    <?php 
			    if($gerai=='0') $n_gerai = 'SELURUHNYA'; else $n_gerai = $gerai; 
			?>
            <h2 align="center">
			    <?php 
				    echo 'DATA PERMOHONAN SEKTOR ' . $bidang;
					if($izin != '')
					    echo '<br>'.'JENIS ' . $izin;
			
				    echo '<br>'.$n_menu . ', PERIODE : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
					echo '<br>'.'ASAL PERMOHONAN : '. $n_gerai;
				?>
			</h2>
			<table align=left>
                <tr>
                    <td align="center">
                        <?php
                        $Back_data = array(
                            'src' => base_url().'assets/images/icon/back_alt.png',
                            'alt' => 'Lihat di HTML to Openoffice',
                            'title' => 'Kembali'
                        );
                        echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                                 
	 		    		$img_cetak_pdf = array(
                             'src' => base_url().'assets/images/icon/pdf.png',
                             'alt' => 'Cetak PDF',
                             'title' => 'Cetak Detail ke PDF'
                        );
						echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak_pdf));

						$img_cetak_excel = array(
                             'src' => base_url().'assets/images/icon/excel.png',
                             'alt' => 'Cetak Excel',
                             'title' => 'Cetak Detail ke Excel'
                        );
						echo anchor(site_url('rekapitulasi/izin/cetak_list_excel') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak_excel));
                        ?>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" border="1" class="display" id="info_list">
                <thead>
                    <tr bgcolor="#809FFE">
                        <th width="3%">No</th>
                        <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
						<th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
                        <th width="22%">Jenis Izin</th>
                        <th width="21%">Objek Izin</th>
						<th width="9%">Masa Berlaku<br>Retribusi</th>
                        <th width="12%">Status Terakhir</th>
                        <th width="3%">Aksi</th>
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
                        echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                                 
	 		    		$img_cetak = array(
                             'src' => base_url().'assets/images/icon/pdf.png',
                             'alt' => 'Cetak',
                             'title' => 'CetaK Detail ke PDF'
                        );
						echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak));

						$img_cetak_excel = array(
                             'src' => base_url().'assets/images/icon/excel.png',
                             'alt' => 'Cetak Excel',
                             'title' => 'Cetak Detail ke Excel'
                        );
						echo anchor(site_url('rekapitulasi/izin/cetak_list_excel') .'/'. $tgla.'/'.$tglb.'/'.$n_gerai, img($img_cetak_excel));
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>