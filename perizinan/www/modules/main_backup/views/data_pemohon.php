<style>
    table tr td {font-size: 12px; padding-bottom: 5px;}
    p{font-size: 12px;}
</style>

<div class="isi">
    <div class="entry" style="padding-left: 1px;"s>
	    <br/><br/><h2>Pendaftaran Izin Online Berhasil</h2><br/>
	    <div class="kiri" style="padding-left: 10px;"s>
            <p><h1>Terima kasih telah mengajukan pendaftaran secara online</h1> </p><br/>
            <p>Data Izin yang Anda ajukan</p>
            <br/>
            <table width="100%">
			    <tr>
				    <td width="20%">Tanggal Pendaftaran </td>
                    <td>:</td>
                    <td><b><?php $tgl=substr($dt->tglPermohonan,8,2).' - '; echo $tgl ?>
					       <?php $bln=substr($dt->tglPermohonan,5,2).' - '; echo $bln ?>
						   <?php $thn=substr($dt->tglPermohonan,0,4); echo $thn ?>
						</b>
					</td>
                </tr>
                <tr>
                    <td width="20%">No Pendaftaran </td>
                    <td>:</td>
                    <td><b><?php echo $dt_pemohon ?></b></td>
                </tr>
                <tr>
                    <td>Nama Pemohon  </td>
                    <td>:</td>
                    <td><b><?php echo $dt->namaPemohon ?></b></td>
                </tr>
                <tr>
                    <td>Permohonan Izin  </td>
                    <td>:</td>
                    <td><b><?php echo $dt->isi_izin ?></b></td>
                </tr>
            </table>
        </div>
		<div class="kiri" style="padding-left: 10px;">
            <br/>
            <table width="100%">
				<tr>
                    <td>Catatan:</td> <td>*</td>
                    <td> Harap simpan Nomor Pendaftaran, nomor pendaftaran dapat digunakan untuk melakukan pengecekan status. </td>
                </tr>

				<tr>
                    <td> </td> <td>*</td>
                    <?php
					$datang = date($dt->tglPermohonan);
					//$next = $this->lib_date->set_date($datang, +3);
					$text = 'Guna verifikasi data, kami tunggu kedatangan pemohon di BPMPT Provinsi Jawa Barat atau Gerai terdekat untuk 
					memberikan persyaratannya paling lambat 3 (tiga) hari kerja setelah tanggal pendaftaran secara online berhasil.';
					?>
                    <td><?php echo $text ?></td>
                </tr>

				<tr>
                    <td></td> <td>*</td>
                    <td> Apabila dalam waktu yang telah ditentukan tidak menyerahkan data persayaratan maka kami menganggap permohonan anda batal. </td>
                </tr>
            </table>
        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
