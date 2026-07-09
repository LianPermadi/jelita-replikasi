<script>
	var $jnoc = jQuery.noConflict();
	$jnoc(document).ready(function() {
		$jnoc('#dataTables').DataTable();
	} );
	</script>
<div class="isi">
    <div id="entry">
        <h2><?php echo "$title" ?></h2>

        <div class="kiri">
            <div class="izin">
                <br/>
                <table width="100%" cellpadding="0" cellspacing="0" id="dataTables">
                    <thead>
                        <tr style="background:#E0E0E0">
						    <th><b>NO </b>  </th>
                            <th><b >DAFTAR JENIS PERIZINAN </b>  </th>
                            <th><b >DURASI </b> </th>
                            <th><b> </b></th>
							<th><b> </b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $n=1;
							//if (is_array($list))
							//{
                            foreach ($list as $row) {
                                $x = str_replace(' ', "_", $row['jenis_perizinan']);
                                $link = anchor('main/jenis_perizinan/syarat/' . $row['id'], 'Lihat Persyaratan');
								$link2 = anchor('main/jenis_perizinan/cetak_syarat/' . $row['id'], 'Cetak Persyaratan');
								if($row['c_aktif'] == '1') $nn = '|'; else $nn = '||';
								if($row['jenis_perizinan'] <> 'IZIN LAIN-LAIN'){
									if($row['c_aktif'] == '0'){
                                        echo "
                                            <tr>
											    <td style='text-align:center;'>".$n."</td>
											    <td>".$row['jenis_perizinan']."</td>
                                                <td style='text-align: center;'> ".$row['v_hari']." hari </td>
                                                <td>$link</td>
                                                <td>$link2</td>
                                            </tr>
                                        ";
                                    $n++;
								    }
								}
                            }
							//}
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
