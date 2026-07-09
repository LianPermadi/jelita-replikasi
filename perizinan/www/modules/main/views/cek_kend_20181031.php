<style>
    table th tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
    em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
    <div id="entry">
        <h2>Cek Nomor Kendaraan</h2>
        <div class="kiri">
            <h3 align=center style='font-size:12px;'><b><p>Data Hasil Pencarian</p></b></h3> <hr/>
            <?php if (empty($list)) {
            	echo "Data AKDP Tidak Ditemukan";
            } else {
            	?>
                <?php foreach ($list as $kend) { ?>
                <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
                    <tr>
                        <td>No Kendaraan</td>
                        <td> : </td>
                        <td><b><?php echo $kend['no_kend']; ?><b></td>
                    </tr>
                    <tr>
                        <td>Nomor Uji</td>
                        <td> : </td>
                        <td><?php echo $kend['no_uji']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pemilik</td>
                        <td> : </td>
                        <td><?php echo $kend['nama_pemilik']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Perusahaan</td>
                        <td> : </td>
                        <td><?php echo $kend['nama_perusahaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Pembuatan - Merk</td>
                        <td> : </td>
                        <td><?php echo $kend['tahun_pembuatan'] . " - " . $kend['merk']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kendaraan</td>
                        <td> : </td>
                        <td><?php echo $kend['jenis_kendaraan']; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor SK</td>
                        <td> : </td>
                        <td><?php echo $kend['no_sk']; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor KP</td>
                        <td> : </td>
                        <td><?php echo $kend['no_kp']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Penetapan SK</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['tgl_penetapan_sk'])); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Penetapan KP</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['tgl_penetapan_kp'])); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal SK</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['tgl_sk'])); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal KP</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['tgl_kp'])); ?></td>
                    </tr>
                    <tr>
                        <td>Masa Berlaku SK</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['masa_berlaku_sk'])); ?></td>
                    </tr>
                    <tr>
                        <td>Masa Berlaku KP</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($kend['masa_berlaku_kp'])); ?></td>
                    </tr>
                </table>
                <?php } ?>
                <?php } ?>
                <hr>
                <h3 align=center style='font-size:12px;'><b><p>Informasi Masa Laku Sumbangan Wajib Dana Kecelakaan Lalu Lintas Jalan (SWDKLLJ)</p></b></h3>
                <hr>
                <?php if (empty($listdishub)) {
                    echo "Data SWDKLLJ tidak ditemukan";
                } else { ?>
                <?php foreach ($listdishub as $dishub) { ?>
                    <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
                    <tr>
                        <td>Tanggal Transaksi</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($dishub['tgl_transaksi'])); ?></td>
                    </tr>
                    <tr>
                        <td>Masa Berlaku Akhir</td>
                        <td> : </td>
                        <td><?php echo date('d F Y', strtotime($dishub['tgl_mati_yad'])); ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Rangka</td>
                        <td> : </td>
                        <td><?php echo $dishub['no_rangka']; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Mesin</td>
                        <td> : </td>
                        <td><?php echo $dishub['no_mesin']; ?></td>
                    </tr>
                </table>
                <?php } ?>
            	<!-- <table border="2" style="width:100%">
            		<tr>
            			<th style="text-align:center;">No Kendaraan<br>
            				Nomor Uji</th>
            				<th style="text-align:center;">Nama Pemilik<br>
            					Nama Perusahaan</th>
            					<th style="text-align:center;">Tahun Pembuatan : Merk<br>
            						Jenis Kendaraan</th>
            						<th style="text-align:center;">Nomor SK<br>
            							Nomor KP</th>
            							<th style="text-align:center;">Tanggal Penetapan SK<br>
            								Tanggal Penetapan KP</th>
            								<th style="text-align:center;">Tanggal SK<br>
            									Tanggal KP</th>
            									<th style="text-align:center;">Masa Berlaku SK<br>
            										Masa Berlaku KP</th>
            		</tr>
            		<tr>
            			<?php foreach ($list as $kend) { ?>
            				<td><?php echo $kend['no_kend'].'<br>'.$kend['no_uji']; ?></td>
            				<td><?php echo $kend['nama_pemilik'].'<br>'.$kend['nama_perusahaan']; ?></td>
            				<td><?php echo $kend['tahun_pembuatan'].' : '.$kend['merk'].'<br>'.$kend['jenis_kendaraan']; ?></td>
            				<td><?php echo $kend['no_sk'].'<br>'.$kend['no_kp']; ?></td>
            				<td><?php echo $kend['tgl_penetapan_sk'].'<br>'.$kend['tgl_penetapan_kp']; ?></td>
            				<td><?php echo $kend['tgl_sk'].'<br>'.$kend['tgl_kp']; ?></td>
            				<td><?php echo $kend['masa_berlaku_sk'].'<br>'.$kend['masa_berlaku_kp']; ?></td>
            			<?php } ?>
            		</tr>
            	</table> -->
            <?php	
            } ?>


        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>