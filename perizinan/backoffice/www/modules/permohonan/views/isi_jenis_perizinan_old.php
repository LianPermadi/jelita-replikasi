<div class="isi">
    <div id="entry">
        <h2><?php echo "$title" ?></h2>

        <div class="kiri">
            <div class="izin">
                <br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
                        <tr style="background:#E0E0E0">
						    <td style="width:5%; border: none;"><b style="color:black; text-align: center; display: block;">NO </b>  </td>
                            <td style="width:90%; border: none;"><b style="color:black; text-align: center; display: block;">DAFTAR JENIS PERIZINAN </b>  </td>
                            <td style="width:5% ; border: none;"><b style="color:black; text-align: center; display: block;">DURASI </b> </td>
                            <td style="width:5% ; border: none;"><b style="color:black; text-align: right ; display: block;"> </b></td>
							<td style="width:5%; border: none;"><b style="color:black; text-align: left  ; display: block;"> </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $n=1;
                            foreach ($list as $row) {
                                $x = str_replace(' ', "_", $row['jenis_perizinan']);
                                $link = anchor('main/jenis_perizinan/syarat/' . $row['id'], 'Lihat Persyaratan');
								$link2 = anchor('main/jenis_perizinan/cetak_syarat/' . $row['id'], 'Cetak Persyaratan');
								if($row['c_aktif'] == '1') $nn = '|'; else $nn = '||';
								if($row['jenis_perizinan'] <> 'IZIN LAIN-LAIN'){
									if($row['c_aktif'] == '0'){
                                        echo "
                                            <tr>
											    <td style='color:black;'>".$n."</td>
											    <td style='color:black;'>".$row['jenis_perizinan']."</td>
                                                <td style='color:black; text-align: center;'> ".$row['v_hari']." hari </td>
                                                <td>$link</td>
                                                <td>$link2</td>
                                            </tr>
                                        ";
                                    $n++;
								    }
								}
                            }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>

        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>

    </div>

    <div class="clear"></div>

</div>
