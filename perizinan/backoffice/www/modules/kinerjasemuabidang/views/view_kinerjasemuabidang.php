<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#roygrid').dataTable({
                 "bJQueryUI": true,
                 "bDestroy": true,
                 "sPaginationType": "full_numbers"
        });
    } );
</script>

<html>
    <head>
        <title>Tingkat Penyelesaian Semua Bidang</title>
    </head>
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
                                echo 'Rekap Permohonan izin Semua Bidang ';echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
                                ?>
                            </legend>
                            <table align="left">
                                <tr>
                                    <td align="center">
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
                                            'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/lwview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                        );
                                        echo img($img_word);
										
										$img_excel = array(
                                            'src' => base_url().'assets/images/icon/excel.png',
                                            'alt' => 'Cetak ke Excel',
                                            'title' => 'Cetak Ke Excel',
                                            'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/leview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                        );
                                        echo img($img_excel);
                                        //echo anchor(site_url('rekapitulasi/realisasi/cetak_report') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
                                        ?>
                                    </td>
                                </tr>
                            </table>

                            <table align="center" width="" border="1" class="display" cellpadding="0" cellspacing="0" id="roygridx">
                                <thead>
								    <tr class="title">
                                        <th rowspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>No</b></font></th>
                                        <th rowspan="2" width="35%" align="center" ><font  size="2" color="#1A1A1A"><b>Bidang Perizinan</b></font></th>
                                        <th rowspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Jenis Perizinan</b></font></th>
										<th rowspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?> Pemohon</b></font></th>
                                        <th colspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>Izin Selesai</b></font></th>
                                        <th rowspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>Izin Proses</b></font></th>
										<th rowspan="2" align="center" ><font  size="2" color="#1A1A1A"><b>Persen <?echo br();?>Selesai</b></font></th>
                                    </tr>
									<tr>
										<th align="center" ><font  size="2" color="#1A1A1A"><b>Izin Terbit</b></font></th>
										<th align="center" ><font  size="2" color="#1A1A1A"><b>Izin Ditolak</font></th>
                                    </tr>
								</thead>
                                <?php
								$qstatus="select n_sts_permohonan from trstspermohonan";
								$qditerima="where id=13";
								$querystatus="$qstatus $qditerima";
								$hasilstatus=mysql_query($querystatus);
								while($status = mysql_fetch_assoc(@$hasilstatus)){
								    $hasilditerima = $status['n_sts_permohonan'];
								}
								$qditolak="where id=14";
								$querystatus2="$qstatus $qditolak";
								$hasilstatus2=mysql_query($querystatus2);
								while($status2 = mysql_fetch_assoc(@$hasilstatus2)){
								    $hasilditolak= $status2['n_sts_permohonan'];
								}
								$qdiproses="where id=13";
								$querystatus3="$qstatus $qdiproses";
								$hasilstatus3=mysql_query($querystatus3);
								while($status3 = mysql_fetch_assoc(@$hasilstatus3)){
								    $hasilproses1= $status3['n_sts_permohonan'];
								}
								$qdiproses2="where id=14";
								$querystatus4="$qstatus $qdiproses2";
								$hasilstatus4=mysql_query($querystatus4);
								while($status4 = mysql_fetch_assoc(@$hasilstatus4)){
								    $hasilproses2= $status3['n_sts_permohonan'];
								}
                                $i = NULL;
								$query_data = "select id, n_sektor from trsektor order by urutan ASC";
                                $hasil_data = mysql_query($query_data);
                                $total = 0;
								$total10 = 0;
								$totalterima=0;
								$totaltolak=0;
								$totalproses=0;
								$totjml=0;
								if($lokasi == 'OPD Teknis')
									$hitung = FALSE;
								else
                                    $hitung = TRUE;
                                while ($data = mysql_fetch_assoc(@$hasil_data)){
									if(substr($data['n_sektor'], 0, 1) != '*') {
if(($cek_sektor == $data['id'] && !$hitung) || $hitung){
                                    $i++;
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
                                        <td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $i; ?></font> </td>
                                        <td > <font  size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
										<?php
										$idsektor=$data['id'];
										$query_data3 = "select count(a.id) hitung from trperizinan a
										                inner join trperizinan_trsektor b on a.id= b.trperizinan_id
												        where b.trsektor_id='$idsektor'";
										$hasil_data3 = mysql_query($query_data3);
										while ($data3 = mysql_fetch_assoc(@$hasil_data3)){
										    $jumlah2=$data3['hitung'];
											$total10 = $total10 + $jumlah2;
                                            $f_jumlah2 = intval($jumlah2);
                                            $f_total2 = intval($total10);
										
										?>
										    <td align="center" >
										        <font  size="2" ="#1A1A1A" color="grey"><b>
										            <?php 
    												if(intval($data3['hitung'])==0){
	    									            echo intval($data3['hitung']);
		    								        }else{
			    							            echo anchor(site_url('kinerjasemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,   intval($data3['hitung']),  'class="link2-wrc"');
    										        }
	    									        ?>
		    									</font></b>
			    							</td>
				    						<?php
										}
                                            ?>
										<td align="center">
										    <font  size="2" ="#1A1A1A" color="grey"><b>
                                                <?php 
    											if(intval($f_jumlah==0)){
	    										    echo $f_jumlah;
		    									}else{
                                                    echo anchor(site_url('kinerjasemuabidang/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,    $f_jumlah,  'class="link2-wrc"'); 
                                                }
	        									?>
                                            </font></b>
                                        </td>
										<?php	
                                        $query_datastatus = "select count(a.id) jumlahizin, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                                                             inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                                             inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                                             inner join tmbap d on d.id = c.tmbap_id
                                                             inner join trperizinan e on e.id = b.trperizinan_id
                                                             inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
                                                             inner join tmsk i on h.tmsk_id = i.id
                                                             LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                                             LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                                             where a.trsektor_id = '$idsektor' and d.c_penetapan = 1
                                                             and t7.id <> 1 and
                                                             a.d_terima_berkas between '$tgla' and '$tglb' and a.trsektor_id='$idsektor'
                                                             AND a.status_berkas != 'Izin Ditolak FO'";

                                        $querytolakfo = "select count(a.id) jumlah from tmpermohonan a
                                                         inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                                         inner join trperizinan e on e.id = b.trperizinan_id
                                                         LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                                         LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                                         where a.trsektor_id = '$idsektor' 
                                                         and t7.id <> 1 and
                                                         a.d_terima_berkas between '$tgla' and '$tglb' and a.trsektor_id='$idsektor'
                                                         and a.status_berkas='Izin Ditolak FO'";
                                        $htolakfo = mysql_query($querytolakfo);
                                        while ($dttolakfo = mysql_fetch_assoc(@$htolakfo)){
                                            $tolakfo=$dttolakfo['jumlah'];
                                        }
                                        //echo $tolakfo;
                                        $h = mysql_query($query_datastatus);
                                        while ($dta = mysql_fetch_assoc(@$h)){
                                        }
                                        $query_data4="$query_datastatus and d.status_bap='1'";
										$hasil_data4 = mysql_query($query_data4);
										while ($data4 = mysql_fetch_assoc(@$hasil_data4)){
										    $terima4=$data4['jumlahizin'];
											$totalterima=$totalterima+$data4['jumlahizin'];
										?>
										    <td  align="center"> <font  size="2" color="grey"><b>
    										<?php 
	    									if(intval( $data4['jumlahizin'])==0){
                                                echo intval( $data4['jumlahizin']);
                                            }else{
                                                echo anchor(site_url('kinerjasemuabidang/izinterbit').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , intval( $data4['jumlahizin']),  'class="link2-wrc"');
                                            }
       										?>
        									</b></font> </td>
		    								<?
										}
										$query_data5="$query_datastatus and d.status_bap='2'";
										$hasil_data5 = mysql_query($query_data5);
                                        while ($data5 = mysql_fetch_assoc(@$hasil_data5)){
											$tolak5=$data5['jumlahizin'];
											$totaltolak=$totaltolak+($data5['jumlahizin']+$tolakfo);
										    ?>
										    <td  align="center"> <font  size="2" color="grey"><b>
											<?php 
										 	if(intval( $data5['jumlahizin'])==0 and $tolakfo==0){
										    	echo intval(( $data5['jumlahizin'])+$tolakfo);
											}else{
											    echo anchor(site_url('kinerjasemuabidang/izintolak').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , intval( ($data5['jumlahizin'])+$tolakfo),  'class="link2-wrc" ');
											}
										    ?>
											</b></font></td>
										    <?
										    $jumlah_proses = intval($f_jumlah) - ($terima4 + $tolak5+$tolakfo);
										    $totjml=$totjml + $jumlah_proses;	
										    ?>
										    <td  align="center"> <font  size="2" color="grey"><b>
											<?php 
										    if(intval( $jumlah_proses )==0){
										        echo intval($jumlah_proses);
										    }else{
										        echo anchor(site_url('kinerjasemuabidang/izinproses').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , intval($jumlah_proses),  'class="link2-wrc" ');
										    }
										    ?>
											</b></font> </td>
										    <?
										}
										if ( $jumlah==0) {
										    $persentase=0;
										    ?>
										    <td align="center"><font  size="2" color="#1A1A1A"><?php echo '0.00 %'; ?></font></td>
										    <?
										}else{
										    $persentase=($terima4 + $tolak5+$tolakfo)/intval($f_jumlah)*100;
										    ?>
										    <td  align="center"><font  size="2" color="#1A1A1A"><?php echo number_format($persentase,2);echo ' %'; ?></font></td>
										    <?
                                        }
										if($f_total==0){
										    $totalpersen=0.00;
										}else{
										    $totalpersen=($totalterima +$totaltolak)/$f_total*100;
										}
									}
									}
								}?>
								</tr> 	
								    <tr bgcolor="#d5dffe">
										<td><??></td>
										<td><??></td>
										<td><??></td>
										<td><??></td>
										<td><??></td>
										<td><??></td>
										<td><??></td>
										<td><??></td>
									</tr>											 
                                    <tr>
                                        <td  align="center"><?php  //echo $i+1; ?></td>
                                        <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
                                        <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total2; ?></b></font></td>
									    <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totalterima; ?></b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totaltolak; ?></b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totjml; ?></b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo number_format($totalpersen,2); echo ' %' ?></b></font></td>
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