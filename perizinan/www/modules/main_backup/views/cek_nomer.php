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
				         Berikut ini status terakhir permohonan izin yang Anda ajukan. Untuk keterangan lebih lengkap silakan datang ke Badan Penanaman Modal dan Perizinan Terpadu Provinsi Jawa Barat.
                         </p> <br/>";
			        $status_akhir = '';
                    foreach ($list as $row) {
                        $tracking = $row['tracking'];
//                        echo "<table border=1 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
                        if($n == 1){
							$id = $row['id'];
                            $no_pendaftaran = $row['no_pendaftaran'];
		    				$sts_berkas = Strtoupper($row['sts_berkas']);
                            $nama = $row['nama'];
                            $permohonan = $row['permohonan'];
						    $status_akhir = $row['tracking'];
							$n_kelompok_izin = $row['n_kelompok_izin'];
    						$kd_status = $row['kd_status'];
						    echo "<table border=1 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";

                            echo     "<tr>";
                            echo         "<td>No Pendaftaran</td>";
                            echo         "<td>:</td>";
                            echo         "<td>$no_pendaftaran</td>";
							echo     "</tr>";

                            echo     "<tr>";
                            echo         "<td>Nama Pemohon</td>";
                            echo         "<td>:</td>";
                            echo         "<td>$nama</td>";
                            echo     "</tr>";
                    
                            echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td>Nama Perizinan</td>";
                            echo         "<td>:</td>";
                            echo         "<td>$permohonan</td>";
                            echo     "</tr>";

                            //echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            //echo         "<td>Kelompok Perizinan</td>";
                            //echo         "<td>:</td>";
                            //echo         "<td>$n_kelompok_izin</td>";
                            //echo     "</tr>";

							echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td>Status Permohonan</td>";
                            echo         "<td>:</td>";
                            echo         "<td>$sts_berkas</td>";
                            echo     "</tr>";

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
						        echo "<table border=1 style='font-size:17px; margin-left:10px; ' cellpadding='0' cellspacing='0' width=95%>";
                                echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
						        echo         "<td>$tracking</td>"; 
                                echo     "</tr>";
                                echo "</table>";
                        } 
						
							$tracking = 'percobaan';
							$clr1=''; $clr2=''; $clr3=''; $clr4=''; $clr5='';
							switch ($kd_status) {
                                case 0 : $clr1='#CC0000'; break;
								case 1 : $clr1='#CC0000'; break;
								case 2 : $clr1='#CC0000'; break;
                                case 3 : $clr2='#CC0000'; break;
								case 4 : $clr2='#CC0000'; break;
                                case 5 : $clr3='#CC0000'; break;
								case 6 : $clr3='#CC0000'; break;
								case 7 : $clr3='#CC0000'; break;
                                case 8 : $clr4='#CC0000'; break;
								case 9 : $clr5='#CC0000'; break;
                            }
							echo "<table border=1 style='font-size:13px; color:$clr1; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
                            echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
				            echo         "<td>1 . Dalam Proses Administrasi</td>"; 
                            echo     "</tr>"; 
							echo "</table>";
							echo "</table>";

							echo "<table border=1 style='font-size:13px; color:$clr2; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
				            echo         "<td>2 . Dalam Proses Kajian Teknis</td>"; 
                            echo     "</tr>"; 
							echo "</table>";
                            
							echo "<table border=1 style='font-size:13px; color:$clr3; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
                            echo         "<td>3 . Dalam Proses Penerbitan (Diizinkan/Ditolak)</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=1 style='font-size:13px; color:$clr4; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
				            echo         "<td>4 . Izin Siap Diserahkan</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

							echo "<table border=1 style='font-size:13px; color:$clr5; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
							echo     "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
				            echo         "<td>5 . Izin Selesai</td>"; 
                            echo     "</tr>"; 
							echo "</table>";

//							$kodetext = substr($tracking, 0, 1);
//						    if ( $status_akhir == $tracking ){
//							    if ( $n < 12) echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
//                                         else echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
//								if ( $kodetext == '-'){
//						            $n--;
//							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
//						            echo     "<td><b>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking (Status Saat Ini)</b></td>"; 
//                                    echo "</tr>";
//						        } else {
//							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
//						            echo     "<td><b>$no . $tracking (Status Saat Ini)</b></td>"; 
//                                    echo "</tr>";
//						        }
//                                echo "</table>";
//						    } else {
//							    if ( $n < 12) echo "<table border=1 style='font-size:12px; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
//                                         else echo "<table border=1 style='font-size:12px; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
//								if ( $kodetext == '-'){
//						            $n--;
//                                    echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
//	                                echo     "<td>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking</td>"; 
//                                    echo "</tr>";
//						        } else {
//							        echo "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
//						            echo     "<td>$no . $tracking</td>"; 
//                                    echo "</tr>";
//						        }
//                                echo "</table>";
//						    }
						
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

