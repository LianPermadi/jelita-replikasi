<script>function printPDF() {
  var originalContents = document.body.innerHTML;

  // Mengganti konten halaman dengan konten PDF yang akan dicetak
  var printContents = document.getElementById("pdfContent").innerHTML;
  document.body.innerHTML = printContents;

  // Mengatur media print ke PDF
  var printWindow = window.open('', '', 'height=400,width=800');
  printWindow.document.write('<html><head><title>PDF Print</title>');
  printWindow.document.write('</head><body >');
  printWindow.document.write(printContents);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.print();

  // Mengembalikan kembali konten halaman asli
  document.body.innerHTML = originalContents;
} 
</script>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
/* Aturan untuk margin cetak */
@page {
  margin: 5cm; /* Ukuran margin dalam satuan yang Anda inginkan, seperti cm, mm, in, atau px */
}

/* Aturan untuk tampilan cetak */
@media print {
  /* Pengaturan margin pada elemen-elemen yang akan dicetak */
  body {
    margin: 25; /* Menghapus margin pada badan dokumen */
  }
  /* Aturan lainnya untuk tampilan cetak */
}
</style>
</head>
<body>
<?php
// $barang = $this->m_barang->get_barang_master($id);
?>
<style type="text/css">
    .justify{
        text-align: justify;
    }
    .margin{
        padding-left: 20%;
        padding-right: 20%;
    }
    p{
        margin-bottom: 2px;
        font-size: 23px;
        text-align: justify;
    }
</style>
<?php foreach ($barang as $row) { 
    

setlocale(LC_TIME, 'id_ID');
$tanggal = $row->timestamp; // Tanggal dalam format YYYY-MM-DD
$tahun = date("Y", strtotime($tanggal)); // Mengambil tahun dari tanggal
// echo "Tahun: " . $tahun; // Output: Tahun: 2023
$bulan = strftime("%B", strtotime($tanggal)); // Mengambil tahun dari tanggal
$day = date("d", strtotime($tanggal)); // Mengambil tahun dari tanggal

// $tanggal = "2023-04-03"; // Tanggal dalam format YYYY-MM-DD

// Set bahasa lokal ke Indonesia

// Mengambil hari dalam bahasa Indonesia
$hari = strftime("%A", strtotime($tanggal));
// var_dump($hari);die();

// echo "Hari: " . $hari; // Output: Hari: Minggu
 ?>
<div id="content">
    <div class="title">
      <h2><span style="font-family: Cursive; color: navy;"><b><?php 
      echo $page_name; 
    ?></b></span></h2>
    </div>
  <div class="post">
    <br>
    <br>
    <center>
    <button onclick="printDiv('tag-id')" target="_blank" class="submit-wrc">Cetak Surat</button>
    </center>
<div id="tag-id" style="margin: 16%;">
<div class="post margin">
    <br>
<center><h3><b>BERITA ACARA SERAH TERIMA (BAST) <br> PENYALURAN BARANG PERSEDIAAN <br> Nomor : RT/ <?php if($row->no_ba) { echo $row->no_ba; }else{ echo $row->id; } ?> / Umum / <?php echo $tahun; ?> </b></h3></center><br><br>
<p class="justify">Pada hari <?php echo $hari; ?> tanggal <?php echo $day; ?> Bulan <?php echo $bulan; ?> Tahun <?php echo $tahun; ?> bertempat di Kota Bandung, yang bertandatangan dibawah ini :</p><br><br>
<table>
    <tr>
<td><p>I. </p></td><td><p> Nama </p></td><td>:</td><td><p>  <?php $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->pemberi_barang);
                    // var_dump($pegawai);die();
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                    } else {
                                    echo $this->m_barang->get_pemberi_barang($row->pemberi_barang);
                    } ?><p></td></tr>
<tr><td></td><td><p>NIP     </p></td><td>:</td><td><p>  <?php 
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_penerima_nip($pegawai);
                    } else {
                                    echo $this->m_barang->get_penerima_nip($row->pemberi_barang);
                    } ?></p></td></tr>
<tr><td colspan="4"><p class="justify">Dalam hal ini bertindak sebagai Pengelola Barang Milik Negara, selanjutnya disebut sebagai PIHAK PERTAMA</p><br><br></td></tr>
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
</table><br>
<p>Dalam hal ini bertindak sebagai Penerima BMD berupa barang persediaan, selanjutnya sebagai PIHAK KEDUA
PIHAK PERTAMA telah melakukan serah terima BMD pada PIHAK KEDUA berupa barang persediaan,
berdasarkan Surat Perintah Penyaluran Barang (SPPB), dengan rincian sebagai berikut :</p>

<br><p><?php echo $row->data_barang; ?></p><br>
<p>Demikian berita acara serah terima ini dibuat sebagai bukti pengeluaran barang persediaan.</p><br><br><br>

<br><br><br>
<table width="100%" style="align-content: center;">
    <tr>
        <th width="50%">
<p style="text-align: center;">PIHAK KEDUA</p>
</th>
<th width="50%">

<p style="text-align: center;">PIHAK PERTAMA</p></th>

                    <tr>
                        <td><br><br><br><br><br><br>

<p style="text-align: center;"><?php $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->penerima_barang);
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                    } else {
                                    echo $this->m_barang->get_pemberi_barang($row->penerima_barang);
                    } ?></p>
<p style="text-align: center;"><?php 
                    if (!empty($pegawai)) {
                                    echo $this->m_barang->get_penerima_nip($pegawai);
                    } else {
                                    echo $this->m_barang->get_penerima_nip($row->pemberi_barang);
                    } ?></p></td>
                        <td><br><br><br><br><br><br>

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
                </table><br><br><br><br><br><br><br><br><br><br>




<?php } ?>

    </div>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
 function printDiv(divId) {
  var divToPrint = document.getElementById(divId);
  var originalContents = document.body.innerHTML;
  var printContents = '<html><head><title>Cetak Tag</title></head><body>' + divToPrint.innerHTML + '</body></html>';
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>