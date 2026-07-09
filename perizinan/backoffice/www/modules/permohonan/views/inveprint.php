<style type="text/css">
    .justify{
        text-align: justify;
    }
    .margin{
        padding-left: 10%;
        padding-right: 10%;
    }
    p{
        margin-bottom: 2px;
        font-size: 22px;
        text-align: justify;
    }
</style>
<?php foreach ($barang as $row) { 
    
$tanggal = $row->timestamp; // Tanggal dalam format YYYY-MM-DD
$tahun = date("Y", strtotime($tanggal)); // Mengambil tahun dari tanggal
// echo "Tahun: " . $tahun; // Output: Tahun: 2023
$bulan = date("m", strtotime($tanggal)); // Mengambil tahun dari tanggal
$day = date("d", strtotime($tanggal)); // Mengambil tahun dari tanggal

$tanggal = "2023-04-03"; // Tanggal dalam format YYYY-MM-DD

// Set bahasa lokal ke Indonesia
setlocale(LC_TIME, 'id_ID');

// Mengambil hari dalam bahasa Indonesia
$hari = strftime("%A", strtotime($tanggal));

// echo "Hari: " . $hari; // Output: Hari: Minggu
 ?>
<div id="content" >
  <div class="post margin">
<center><h1><b>BERITA ACARA SERAH TERIMA (BAST) <br> PENYALURAN BARANG PERSEDIAAN <br> Nomor : RT/ <?php echo $row->id; ?> / Umum / <?php echo $tahun; ?> </b></h1></center>
<p class="justify">Pada <?php echo $hari; ?> tanggal <?php echo $day; ?> Bulan <?php echo $bulan; ?> Tahun <?php echo $tahun; ?> bertempat di Kota Bandung, yang bertandatangan dibawah ini :</p><br><br>
<table>
    <tr>
<td><p>I. </p></td><td><p> Nama </p></td><td>:</td><td><p>	<?php $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->pemberi_barang);
                    // var_dump($pegawai);die();
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                   	} else {
                                    echo $this->m_barang->get_pemberi_barang($row->pemberi_barang);
                    } ?><p></td></tr>
<tr><td></td><td><p>NIP		</p></td><td>:</td><td><p>	<?php 
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_penerima_nip($pegawai);
                   	} else {
                                    echo $this->m_barang->get_penerima_nip($row->pemberi_barang);
                    } ?></p></td></tr>
<tr><td colspan="4"><p class="justify">Dalam hal ini bertindak sebagai Pengelola Barang Milik Negara, selanjutnya disebut sebagai PIHAK PERTAMA</p></td></tr>
    <tr>
<td><p>II. </p></td><td><p> Nama </p></td><td>:</td><td><p>  <?php $user = $this->m_barang->get_pegawai_user_n_pegawai($row->penerima_barang);
                    // var_dump($pegawai);die();
                    if (!empty($user)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($user);
                    } else {
                                    echo $this->m_barang->get_pemberi_barang($row->penerima_barang);
                    } ?><p></td></tr>
<tr><td></td><td><p>NIP     </p></td><td>:</td><td><p>  <?php 
                    if (!empty($user)) {
                                    echo $this->m_barang->get_penerima_nip($user);
                    } else {
                                    echo $this->m_barang->get_penerima_nip($row->penerima_barang);
                    } ?></p></td></tr>
<tr><td></td><td><p>Unit Kerja Bidang    </p></td><td>:</td><td><p>  <?php 
                    if (!empty($user)) {
                                    echo $this->m_barang->get_penerima_jabatans($user);
                    } else {
                                    echo $this->m_barang->get_penerima_jabatans($row->penerima_barang);
                    } ?></p></td></tr>
</table><br><br>
<p>Dalam hal ini bertindak sebagai Penerima BMD berupa barang persediaan, selanjutnya sebagai PIHAK KEDUA
PIHAK PERTAMA telah melakukan serah terima BMD pada PIHAK KEDUA berupa barang persediaan,
berdasarkan Surat Perintah Penyaluran Barang (SPPB), dengan rincian sebagai berikut :</p>
<!-- <center>
<table border="1">
    <tr>
        <td>
No
</td>
<td>
Nama Barang  Spesifikasi  Nama Barang  </td>
<td>                                    
Jumlah</td>
<td>
Satuan Barang</td>
<td>
Ket</td>
</tr>
</table>
</center> -->
<br><p><?php echo $row->nama_barang; ?></p><br>

<p>Demikian berita acara serah terima ini dibuat sebagai bukti pengeluaran barang persediaan.</p><br><br><br>

<table width="100%" style="align-content: center;">
    <tr>
        <th width="50%">
<p style="text-align: center;">PIHAK KEDUA</p>
</td>
<th width="50%">

<p style="text-align: center;">PIHAK PERTAMA</p>

                    <tr>
                        <td><br><br><br><br><p style="text-align: center;">_____________________</p></td>
                        <td><br><br><br><br>

<p style="text-align: center;"><?php $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->pemberi_barang);
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                    } else {
                                    echo $this->m_barang->get_pemberi_barang($row->pemberi_barang);
                    } ?></p>
<p style="text-align: center;"><?php 
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_penerima_nip($pegawai);
                    } else {
                                    echo $this->m_barang->get_penerima_nip($row->pemberi_barang);
                    } ?></p></td>
                    </tr></td>
                    </tr>
                </table>




<?php } ?>

    </div>
    <br style="clear: both;" />
</div>
<script type="text/javascript">
    window.print();
</script>