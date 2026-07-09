<div class="isi">
    <div id="entry">
        <h2>Pengaduan Online</h2>
        <div class="kiri">
            <p style="margin-left: 15px; font-size: 12px; line-height: 20px;">Data Pengaduan yang anda laporkan akan segera kami proses di BPMPT Provinsi Jawa Barat <br>
               Berikut Data Pengaduan: <br/> <br/></p>
            <table style="margin-left: 20px; font-size: 12px;">
                <tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Jenis Pengaduan </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $status?></td>
                </tr>
				<tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Nomor Pendaftaran </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $pendaftaran_id?></td>
                </tr>
				<tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Tanggal Pengaduan </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $tanggal_input?></td>
                </tr>
				<tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Nama </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $nama?></td>
                </tr>
                <tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Nomor Kontak </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $no_hp?></td>
                </tr>
                <tr>
                    <td  style="width: 200px; padding-bottom: 10px;">e-Mail  </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $email?></td>
                </tr>
                <tr>
                    <td  style="width: 200px; padding-bottom: 10px;">Deskripsi  </td>
                    <td  style="width: 10px;" >:</td>
                    <td><?php echo $e_pesan?></td>
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