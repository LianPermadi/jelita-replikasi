<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
    em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
    <div id="entry">
        <h2>Cek Status Izin</h2>
        <div class="kiri">
            <h3 align=center style='font-size:12px;'><p>Data Hasil Pencarian</p></h3> <hr/>

            <?php
                $jumlah = count($list);
			    if ($jumlah > 0) {
                    $n=1;
                    echo "<p style = 'margin-left:10px; font-size:12px;'>
				         Berikut ini status terakhir permohonan izin yang Anda ajukan. Untuk keterangan lebih lengkap silakan datang ke Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat.
                         </p> <br/>";
			        $status_akhir = '';
                    foreach ($list as $row) {
                        $tracking = $row['tracking'];
						
//                        echo "<table border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
                        if($n == 1){
							$id = $row['id'];
                            $no_pendaftaran = $row['no_pendaftaran'];
		    				$sts_berkas = Strtoupper($row['sts_berkas']);
                            $nama = $row['nama'];
                            $permohonan = $row['permohonan'];
						    $status_akhir = $row['tracking'];
							$n_kelompok_izin = $row['n_kelompok_izin'];
    						$kd_status = $row['kd_status'];
							$approve = $row['approve'];
							if($row['no_surat'] == 'Tidak Ditinjau')
    							$ditinjau = ' <b>('.strtoupper($row['no_surat']).')</b>';
							else
	    						$ditinjau = '';
						    echo "<table border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";

                            echo     "<tr>";
                            echo         "<td valign='top' width='15%'>No Pendaftaran</td>";
                            echo         "<td valign='top' width='2%'>:</td>";
                            echo         "<td valign='top' width='73%'>$no_pendaftaran</td>";
							echo     "</tr>";

                            echo     "<tr>";
                            echo         "<td valign='top' width='15%'>Nama Pemohon</td>";
                            echo         "<td valign='top' width='2%'>:</td>";
                            echo         "<td valign='top' width='73%'>$nama</td>";
                            echo     "</tr>";
                    
                            echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td valign='top' width='15%'>Nama Perizinan</td>";
                            echo         "<td valign='top' width='2%'>:</td>";
                            echo         "<td valign='top' width='73%'>$permohonan</td>";
                            echo     "</tr>";

                            //echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            //echo         "<td>Kelompok Perizinan</td>";
                            //echo         "<td>:</td>";
                            //echo         "<td>$n_kelompok_izin</td>";
                            //echo     "</tr>";

							//echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            //echo         "<td>Status Permohonan</td>";
                            //echo         "<td>:</td>";
                            //echo         "<td>$sts_berkas</td>";
                            //echo     "</tr>";

							//echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            //echo         "<td>kode status</td>";
                            //echo         "<td>:</td>";
                            //echo         "<td>$kd_status</td>";
                            //echo     "</tr>";

							echo "</table>";
                            $n++;
					    } else {
						    $no=$n-2;

						    if ( $n == 2){ // cetak judul Status Permohonan
						        echo "<table border=0 style='font-size:17px; margin-left:10px; ' cellpadding='0' cellspacing='0' width=95%>";
                                echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
						        echo         "<td>$tracking</td>"; 
                                echo     "</tr>";
                                echo "</table>";
                            } 
						
							$tracking = 'percobaan';
							$clr0=''; $clr1=''; $clr2=''; $clr3=''; $clr4=''; $clr5=''; $clr6=''; $clr7=''; $clr8=''; $clr9=''; $clrApr='';
							$point0 = 'Abu.png'; $point1 = 'Abu.png'; $point2 = 'Abu.png'; $point3 = 'Abu.png'; $point4 = 'Abu.png'; $point5 = 'Abu.png';
							$point6 = 'Abu.png'; $point7 = 'Abu.png'; $point8 = 'Abu.png'; $point9 = 'Abu.png';$pointApr = 'Abu.png';
							switch ($kd_status) {
                                case 0 : $clr0='#CC0000'; $point0 = 'Red.png'; break;
								case 1 : $clr1='#CC0000'; $point1 = 'Red.png'; break;
								case 2 : $clr2='#CC0000'; $point2 = 'Red.png'; break;
                                case 3 : $clr3='#CC0000'; $point3 = 'Red.png'; break;
								case 4 : $clr4='#CC0000'; $point4 = 'Red.png'; break;
                                case 5 : $clr5='#CC0000'; $point5 = 'Red.png'; break;
								case 6 : $clr6='#CC0000'; $point6 = 'Red.png'; break;
								case 7 : $clr7='#CC0000'; $point7 = 'Red.png'; break;
                                case 8 : $clr8='#CC0000'; $point8 = 'Red.png'; break;
								case 9 : $clr9='#CC0000'; $point9 = 'Red.png'; break;
                            }
							if( 0 < $kd_status )  $point0 = 'Green.png';
							if( 1 < $kd_status )  $point1 = 'Green.png';
							if( 2 < $kd_status )  $point2 = 'Green.png';
                            if( 3 < $kd_status )  $point3 = 'Green.png';
							if( 4 < $kd_status )  $point4 = 'Green.png';
                            if( 5 < $kd_status )  $point5 = 'Green.png';
							if( 6 < $kd_status ){ $point6 = 'Green.png';  $pointApr = 'Green.png'; }
							if( 7 < $kd_status )  $point7 = 'Green.png';
                            if( 8 < $kd_status )  $point8 = 'Green.png';
							if( 9 < $kd_status )  $point9 = 'Green.png';

                            $test='A '.$approve.' '.$kd_status;
							if($point6 == 'Abu.png'){ 
								$txt6 = 'PERMOHONAN IZIN DISETUJUI/DITOLAK';
							}else{
								$txt6 = 'PERMOHONAN '.$sts_berkas;
								if($sts_berkas == 'IZIN DISETUJUI'){
								    $txt6 = 'PERMOHONAN '.$sts_berkas;
									if($approve == 2){
										$test='B '.$approve;
										$clr6=''; $point6 = 'Green.png'; $pointApr = 'Green.png'; $point7 = 'Red.png'; $clr7='#CC0000';
                                        if($kd_status >= 8) {$clr7=''; $point7 = 'Green.png';}
									}else{  // Kondisi Menunggu Approve Struktural jika Upload dan Elektronik
										$test='C '.$approve;
                                        $clr6=''; $point6 = 'Green.png'; $pointApr = 'Red.png'; $clrApr='#CC0000';
                                    } 
								}
							}
                            $test='';  // matikan jika ingin test tampil di posisi SELESAI

							echo "<table border=0 style='font-size:13px; color:$clr0; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
                            echo     "<tr style='padding: 10px 15px; border-radius: 2px; margin-top:10px; height=140px;'>";
				            echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point0."></td>";
							echo         "<td width='97%' style='vertical-align:top'>FRONT OFFICE </td>";
                            echo     "</tr>"; 
							echo "</table>";
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr1; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
                            echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point1."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>EVALUASI ADMINISTRASI</td>"; 
                            echo     "</tr>"; 
							echo "</table>";
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr2; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point2."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENJADWALAN TINJAUAN LAPANGAN".$ditinjau."</td>"; 
                            echo     "</tr>"; 
							echo "</table>";
                            
							echo "<table border=0 style='font-size:13px; color:$clr3; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point3."></td>";
                            echo         "<td width='97%' style='vertical-align:top'>EVALUASI DATA HASIL PENINJAUAN LAPANGAN (TIM TEKNIS)</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr4; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point4."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENYUSUNAN PERTIMBANGAN TEKNIS (TIM TEKNIS)</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr5; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point5."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENETAPAN IZIN</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr6; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point6."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>".$txt6."</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clrApr; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$pointApr."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENGESAHAN IZIN</td>";
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr7; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point7."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENCETAKAN NASKAH IZIN</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr8; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
							echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point8."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>PENGAMBILAN NASKAH IZIN</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=0 style='font-size:13px; color:$clr9; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td width='3%'><img width=20px height=20px src=".base_url()."assets/images/".$point9."></td>";
				            echo         "<td width='97%' style='vertical-align:top'>SELESAI ".$test."</td>"; 
                            echo     "</tr>"; 
							echo "</table>";
/*
							$kodetext = substr($tracking, 0, 1);
						    if ( $status_akhir == $tracking ){
							    if ( $n < 12) echo "<table border=0 style='font-size:13px; color:#CC0000; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
                                         else echo "<table border=0 style='font-size:13px; color:#CC0000; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
								if ( $kodetext == '-'){
						            $n--;
							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
						            echo     "<td><b>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking (Status Saat Ini)</b></td>"; 
                                    echo "</tr>";
						        } else {
							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
						            echo     "<td><b>$no . $tracking (Status Saat Ini)</b></td>"; 
                                    echo "</tr>";
						        }
                                echo "</table>";
						    } else {
							    if ( $n < 12) echo "<table border=0 style='font-size:12px; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
                                         else echo "<table border=0 style='font-size:12px; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
								if ( $kodetext == '-'){
						            $n--;
                                    echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
	                                echo     "<td>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking</td>"; 
                                    echo "</tr>";
						        } else {
							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
						            echo     "<td>$no . $tracking</td>"; 
                                    echo "</tr>";
						        }
                                echo "</table>";
						    }
*/						
					}
                }
            } else {
                echo "           <div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>
                Nomer pendaftaran yang anda masukan tidak diketahui,,,
                </div>";
            }
			echo "<br/>";
            ?>           

        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>