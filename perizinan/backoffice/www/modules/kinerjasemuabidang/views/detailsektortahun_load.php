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
            <div class="title" align="center">
		<h2><b><?php echo $page_name; echo br();echo 'BIDANG : '.$sektor; ?><b></h2>
		</div>
		 <form name="form1" method="post">

				<div class="entry">
            			<fieldset>
                                <legend style="color: #045000" align="center">
			  
		
			
				<?php echo 'Periode : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);?>
		
			</legend>
			<table align="left">
			<tr align="left">
			<td align="left">
			<?php
			$Back_data = array(
                                                'src' => base_url().'assets/images/icon/back_alt.png',
                                                'alt' => 'Lihat di HTML to Openoffice',
                                                'title' => 'Kembali',
                                                'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang'). '\''
                                            );
                                            echo img($Back_data);
           $img_word= array(
                                                'src' => base_url().'assets/images/icon/word.png',
                                                'alt' => 'Cetak Ke word',
                                                'title' => 'Cetak Ke word',
                                                 'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/lwpemohon').'/'.$sektor_id .'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($img_word);
											  $img_excel = array(
                                                'src' => base_url().'assets/images/icon/excel.png',
                                                'alt' => 'Cetak ke Excel',
                                                'title' => 'Cetak Ke Excel',
                                               'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/lepemohon').'/'.$sektor_id .'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($img_excel);
                                            
		 ?>
			</td>
			</tr>
			</table>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="reportgrid">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pendaftaran</th>
                        <th>Nama Pemohon / Perusahaan</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Status</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = NULL;
                    $izin = new trperizinan();
                    $izin->get_by_id($sektor_id);
                    $permohonan = new tmpermohonan();
//                    $data_pendaftaran = $permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->where_related($izin)->get();
					$data_pendaftaran = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$sektor_id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
                    foreach ($data_pendaftaran as $row){
                        $i++;
                        $row->tmpemohon->get();
                        $row->trstspermohonan->get();
                        $row->tmperusahaan->get();
                    ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $row->pendaftaran_id; ?></td>
							<td><?php echo $row->tmpemohon->n_pemohon ." / " . $row->tmperusahaan->n_perusahaan; ?></td>
                            <td><?php echo $this->lib_date->mysql_to_human($row->d_entry); ?></td>
                            <td><?php echo $row->trstspermohonan->n_sts_permohonan; ?></td>
                        </tr>
                        <?php
                    }
                        ?>
                </tbody>
				              
               
            </table>
		 </fieldset>             
                </div>
            </form>
        </div>
    </div>

</body>
</html>
