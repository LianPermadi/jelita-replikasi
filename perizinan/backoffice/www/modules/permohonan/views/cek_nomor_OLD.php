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
                        $id = $row['id'];
                        $no_pendaftaran = $row['no_pendaftaran'];
						$sts_berkas = Strtoupper($row['sts_berkas']);
                        $nama = $row['nama'];
                        $permohonan = $row['permohonan'];
                        $tracking = $row['tracking'];
						$n_kelompok_izin = $row['n_kelompok_izin'];
//                        echo "<table border=1 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
                        if($n==1){
						    $status_akhir = $row['tracking'];
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

							//echo     "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                            //echo         "<td>Status Permohonan</td>";
                            //echo         "<td>:</td>";
                            //echo         "<td>$sts_berkas</td>";
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
                        } else {
							$kodetext = substr($tracking, 0, 1);
						    if ( $status_akhir == $tracking ){
							    if ( $n < 12) echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
                                         else echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
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
							    if ( $n < 12) echo "<table border=1 style='font-size:12px; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
                                         else echo "<table border=1 style='font-size:12px; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
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
						}
                        $n++;
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