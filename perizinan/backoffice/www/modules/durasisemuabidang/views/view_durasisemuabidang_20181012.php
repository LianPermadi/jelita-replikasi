<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#reportgridroyan').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });
    } );
</script>

<html>
    <head></head>
    <!--<body onLoad="window.print()">-->
    <body>
        <div id="content">
            <div class="post">
                <div class="title">
                    <h2><?php echo $page_name; ?></h2>
                </div>
                <form name="form1" method="post">
    				<div class="entry">
                        <fieldset>
                            <legend style="color: #045000" align="center">
                                <?php
                                echo 'Ketepatan Waktu Penyelesaian Perizinan ';echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
//                                echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                ?>
                            </legend>
                            <table align="left" >
                                <tr>
                                    <td align="center" >
                                        <?php
                                        $Back_data = array(
                                            'src' => base_url().'assets/images/icon/back_alt.png',
                                            'alt' => 'Lihat di HTML to Openoffice',
                                            'title' => 'Kembali',
                                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/durasisemuabidang'). '\''
                                        );
                                        echo img($Back_data);

                                        $word = array(
                                            'src' => base_url().'assets/images/icon/word.png',
                                            'alt' => 'Selesai',
                                            'title' => 'Cetak ke word',
                                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/lwview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                        );
                                        echo img($word);

 						                $excel = array(
                                            'src' => base_url().'assets/images/icon/excel.png',
                                            'alt' => 'Selesai',
                                            'title' => 'Cetak ke excel',
                                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/leview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                        );
                                        echo img($excel);                                            
										?>
                                    </td>
                                </tr>
                            </table>

							<table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgridoyan">
                                <thead> 
								    <tr class="title">
                                        <th align="center" ><font  size="2" color="#1A1A1A">No</font></th>
                                        <th width="35%" align="center" ><font  size="2" color="#1A1A1A">Bidang Perizinan</font></th>
										<th width="17%" align="center" ><font  size="2" color="#1A1A1A">Permohonan</font></th>
                                        <th width="17%" align="center" ><font  size="2" color="#1A1A1A">Jumlah <?echo br();?>Selesai</font></th>
										<th width="17%" align="center" ><font  size="2" color="#1A1A1A">Jumlah <?echo br();?>Selesai Sesuai Durasi</font></th>
										<th width="17%" align="center" ><font  size="2" color="#1A1A1A">Jumlah <?echo br();?>Tidak Sesuai Durasi</font></th>
										<th width="17%"align="center" ><font  size="2" color="#1A1A1A">Tingkat Ketepatan</font></th>
                                    </tr>
								</thead>
                                <?php
								if($lokasi == 'OPD Teknis')
									$hitung = FALSE;
								else
                                    $hitung = TRUE;
								$i=1;
                                $total_selesai=0;
								$totalselesai=0;
								$total_tepat=0;
								$total_telat=0;
								$total=0;
								$tidaksesuai=0;

                                $query_data = "select id, n_sektor from trsektor order by urutan ASC";
                                $hasil_data = mysql_query($query_data);
                                while ($data = mysql_fetch_assoc(@$hasil_data)){
									if(substr($data['n_sektor'], 0, 1) != '*') {
                                    if(($cek_sektor == $data['id'] && !$hitung) || $hitung){
                                        //$i++;
    									$jumlah = 0;
                                        $izin = new trperizinan();
                                        $izin->get_by_id($data['id']);
			    						$kd_sektor = $izin->id;
                                        $sektor = new trsektor();
                                        $sektor->get_by_id($data['id']);
                                        $list_sektor = $sektor->id;

                                        $permohonan = new tmpermohonan();
								    	$jumlah = $permohonan->where_related("trstspermohonan", 'id <>1' )
											                 ->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb'
										                              AND status_berkas != 'Izin Ditolak FO'")->count();
                                        $total = $total + $jumlah;
                                        $f_jumlah = intval($jumlah);
		    							$f_total = intval($total);
								?>
                                        <tr>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><?php echo $i++; ?></font> </td>
										    <td> 
										        <font  size="2" color="grey"><b><?php //echo $data['n_sektor']; ?>
										            <?php 
										            echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $data['n_sektor'],  'class="link2-wrc" '); 
												    ?>
                                                </font></b> 
										    </td>
    										<td  align="center" width="20%">
	    									    <font  size="2" color="grey"><b>
                                                    <?php 
			    									if(intval($f_jumlah==0)){
                                                        echo $f_jumlah;
                                                    }else{
                                                        echo anchor(site_url('kinerjasemuabidang/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" '); 
                                                        // echo $f_jumlah;
												    }
												    ?>
                                                </font></b>
                                            </td>
										    <?php
                                            $idsektor=$data['id'];
										    $query = "select  count(a.id) jumlah, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,
										              a.d_terima_berkas from tmpermohonan a
                                                      inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                                      inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                                      inner join tmbap d on d.id = c.tmbap_id
                                                      inner join trperizinan e on e.id = b.trperizinan_id
                                                      inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
                                                      inner join tmsk i on h.tmsk_id = i.id
                                                      LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                                      LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                                      where a.trsektor_id='$idsektor' and d.c_penetapan = 1
                                                      and t7.id <> 1 
                                                      and a.d_terima_berkas between '$tgla' and '$tglb'
    												  AND a.status_berkas != 'Izin Ditolak FO'";
										    $hasil_dataselesai = mysql_query($query);
                                            while ($dataselesai = mysql_fetch_assoc(@$hasil_dataselesai)){
	    									    $jumlah_selesai=$dataselesai['jumlah'];
		    									$total_selesai=$total_selesai+$jumlah_selesai;
											
			    							    //jumlah selesai
				    						?>
											    <td align="center"><b> 
											        <font  size="2" color="grey">
												        <?php 
										                if(intval($dataselesai['jumlah']==0)){
										                    echo $dataselesai['jumlah'];
										                }else{
										                    //echo $dataselesai['jumlah'];
										                    echo anchor(site_url('durasisemuabidang/perbidangselesai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" '); 
										                }
										                //echo $dataselesai['jumlah']; ?>
												    </font></b>
											    </td>
										        <?php
										    }
										
//----------------------------------sesuai durasi----------------------------------
                                            $jumlah=0;
                                            $tt=0;
                                            $totalselesaitepat=0;
                                            $bidangizin=$idsektor;
                                            $qizin = "select  a.pendaftaran_id no,e.n_perizinan jenis,a.trsektor_id,a.d_terima_berkas terima,
			    							          a.d_selesai_proses selesai,i.tgl_surat,i.tgl_surat_edit,e.v_hari durasi,a.a_izin, a.keterangan,
				    								  g.n_pemohon nama from tmpermohonan a
                                                      inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                                      inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                                      inner join tmbap d on d.id = c.tmbap_id
                                                      inner join trperizinan e on e.id = b.trperizinan_id
                                                      inner join tmpemohon_tmpermohonan f on f.tmpermohonan_id = a.id
                                                      inner join tmpemohon g on f.tmpemohon_id=g.id
                                                      inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
                                                      inner join tmsk i on h.tmsk_id = i.id
                                                      LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                                      LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                                      where d.c_penetapan = 1 and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'
													  AND a.status_berkas != 'Izin Ditolak FO'";
                                            $exeizin = mysql_query($qizin);
                                            while($rowizin = mysql_fetch_assoc($exeizin)){
	    				                        if($rowizin >0){
                                                    $trsektorid=$rowizin['trsektor_id'];
                                                    $tanggalterima=$rowizin['terima'];
                                                    $surat=$rowizin['tgl_surat'];
                                                    $suratedit=$rowizin['tgl_surat_edit'];
                                                    $waktu=$rowizin['durasi'];
                                                    if ($suratedit=='0000-00-00'){
                                                        $tanggalselesai=$surat;
                                                    }else{
                                                        $tanggalselesai=$suratedit;
                                                    }
                                                    $qholiday="select count(date) libur from tmholiday where date between '$tanggalterima' and '$tanggalselesai'";
                                                    $exeholiday = mysql_query($qholiday);
                                                    while($rowholiday = mysql_fetch_assoc($exeholiday)){
                                                        $holidayperizin = $rowholiday['libur'];
                                                        $date1 = new DateTime($tanggalselesai); 
                                                        $date2 = new DateTime($tanggalterima); 
                                                        $interval = $date2->diff($date1);
                                                        $selisihhari = $interval->format('%R%a');
                                                        $shari = substr($selisihhari, 1,5);
                                                        $realisasi = $shari - $holidayperizin;
                                                        if($realisasi <= $waktu ){
                                                            $sesuai = $realisasi <= $waktu;
                                                            //echo $sesuai;
                                                            $tot=count($sesuai);
                                                            $tt +=$tot;
                                                        }else{
                                                            $sesuai = $realisasi > $waktu;
                                                        }
                                                    }
                                                }
                                            }
                                                ?>
					
                                            <td align="center"><b><font size="2" color="grey">
											    <?php 
                                                if($tt==0){
                                                    echo $tt;
                                                }else{
                                    				echo anchor(site_url('durasisemuabidang/perbidangsesuai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor']  ,intval($tt),  'class="link2-wrc"');
                                                }
                                                //echo $tt;
                                                $telat=$jumlah_selesai - $tt;	
                                                if ($tt == 0 or $jumlah_selesai==0){
                                                    $persen=0;
                                                }else{
                                                    $persen = $tt / $jumlah_selesai *100;		
                                                }		
                                                ?>
								    		</td>
					
    				                        <td align="center"><b> <font  size="2" color="grey">
	    			                            <?php 
                                                if($telat==0){
                                                    echo $telat;
                                                }else{
                                                    echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($telat),  'class="link2-wrc" '); 
                                                }
                                                ?>
                                            </td>
                                        
											<td align="center"><b> 
                                                <? if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persen < 87){ ?>        <font size="2" color="red">
    				                            <? }else if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persen >= 87){ ?> <font  size="2" color="green">
	    			                            <? }else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persen < 87){ ?>  <font  size="2" color="red">
		    		                            <? }else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persen >= 87){ ?> <font  size="2" color="green">
                                                <? }else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persen < 91){ ?>  <font  size="2" color="red">
                                                <? }else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persen >= 91){ ?> <font  size="2" color="green">
                                                <? }else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persen < 92){ ?>  <font  size="2" color="red">
                                                <? }else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persen >= 92){ ?> <font  size="2" color="green">
                                                <? }else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persen < 93){ ?>  <font  size="2" color="red">
                                                <? }else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persen >= 93){ ?> <font  size="2" color="green">
                                                <? }else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persen < 94){ ?>  <font  size="2" color="red">
                                                <? }else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persen >= 94){ ?> <font  size="2" color="green">
                                                <? }else{ ?>                                                                               <font  size="2" color="grey">
                                                <? }
                                                echo number_format($persen,2);echo ' %'; 
                                                ?>
                                            </td>
					                        <? 
                                            $totalselesai=$totalselesai +$tt;
                                            $totalselesaitepat = $totalselesai;
                                            $totalselesaitelat=$total_selesai-$totalselesaitepat;
                                            //echo $totalselesaitepat;
                                            if ($total_selesai==0 or $totalselesaitepat==0){
                                                $persentotal=0.00;
                                            }else{
                                                $persentotal = $totalselesaitepat / $total_selesai *100;		
                                            }
                                            $tt=0;
										    ?>
                                        </tr> 	
								        <?php
                                    } // eof cek
									}
								}									
								        ?>
                                
								<tr bgcolor="#d5dffe">
                                    <td  align="center">
									    <?php  //echo $i; 
									    $i++;
										?>
									</td>
                                    <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
									<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
                                    <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_selesai; ?></b></font></td>
									<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totalselesaitepat; ?></b></font></td>
									<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totalselesaitelat ?></b></font></td>
									<td  align="center"><font  size="2" color="#1A1A1A"><b>
									    <? if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persentotal < 87){ ?>        <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persentotal >= 87){ ?> <font  size="2" color="green">
                                        <? }else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persentotal < 87){ ?>  <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persentotal >= 87){ ?> <font  size="2" color="green">
                                        <? }else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persentotal < 91){ ?>  <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persentotal >= 91){ ?> <font  size="2" color="green">
                                        <? }else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persentotal < 92){ ?>  <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persentotal >= 92){ ?> <font  size="2" color="green">
                                        <? }else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persentotal < 93){ ?>  <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persentotal >= 93){ ?> <font  size="2" color="green">
                                        <? }else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persentotal < 94){ ?>  <font  size="2" color="red">
                                        <? }else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persentotal >= 94){ ?> <font  size="2" color="green">
                                        <? }else{ ?>                                                                                    <font  size="2" color="grey">
				                        <? }
										echo number_format($persentotal,2); echo ' %' ?></b></font>
									</td>
								</tr>
                              </tr>
                            </table>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
