 <?php

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAA.xls");
// ob_start();
?>
<h2>MUTASI PERSEDIAAN TAHUN ANGGARAN <?php echo $tahun; ?></h2>
<h2>SKPD : DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI JAWA BARAT</h2><br>
<br>

<table border="1">
  <tr>
    <td rowspan="2">
      No
    </td>
    <td rowspan="2">
      Nama Barang
    </td>
    <td colspan="4">
      Saldo Awal
    </td>
    <td colspan="4">
      Pembelian
    </td>
    <td colspan="4">
      Pengeluaran
    </td>
    <td colspan="4">
      Saldo Akhir
    </td>
  </tr>
  <tr>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan (Rp)
    </td>
    <td>
      Jumlah
    </td>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan (Rp)
    </td>
    <td>
      Jumlah
    </td>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan (Rp)
    </td>
    <td>
      Jumlah
    </td>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan (Rp)
    </td>
    <td>
      Jumlah
    </td>
  </tr>
  <?php
  $no = 1;
$tahun_sekarang = $tahun;
$tahun_kemarin = $tahun - 1;
// $tahun_besok = $tahun + 1;
$barang_sekarang = NULL;
$barang_kemarin = NULL;
$barang_besok = NULL;
$jumlah_keluar_barang = 0;
$nama_barang = NULL;
$jumlah_barang_tahun_lalu = 0;
$jumlah_saldo_awal = 0;
$kategori = 0;
  foreach ($barang as $row) {
    $nama_sama = FALSE;
    if($nama_barang == $row["nama_barang"]){
      $nama_sama = TRUE;
    }
    $nama_barang        = $row["nama_barang"];
    $satuan             = $row["satuan"];
    $harga              = $row["harga"];
    $tahun_data         = date('Y', strtotime($row["date"]));

    // Saldo Awal
    if($nama_sama){
      $jumlah_barang_tahun_lalu     = $jumlah_barang_tahun_lalu - $jumlah_saldo_awal;
    }else{
      $cek_tahun_barang_lalu        = $this->m_barang->data_cek_lalu($nama_barang, $harga, $satuan, $tahun_kemarin);
      $jumlah_barang_tahun_lalu     = 0;
      foreach ($cek_tahun_barang_lalu as $key) {
        $jumlah_barang_tahun_lalu   = $jumlah_barang_tahun_lalu + $key->jumlah;
      }
    }
    $cek_pengeluaran_barang_lalu  = $this->m_barang->get_jumlah_pengeluaran($nama_barang, $harga, $satuan, $tahun_kemarin);
    $jumlah_saldo_awal            = $jumlah_barang_tahun_lalu - $cek_pengeluaran_barang_lalu;

    // Saldo Beli
    $cek_pembelian = $this->m_barang->get_pembelian_barang($nama_barang, $harga, $satuan, $tahun);

    $jumlah_beli = 0;
    foreach ($cek_pembelian as $data_beli) {
        $jumlah_beli += $data_beli['jumlah_barang']; // Menjumlahkan semua jumlah_barang
    }
    // $jumlah_beli        = $row["jumlah"];
    $jumlah_beli        = $jumlah_beli;

    // Saldo Keluar
    $cek_pengeluaran      = $this->m_barang->get_jumlah_pengeluaran_tahun_ini($nama_barang, $harga, $satuan, $tahun);
    $jumlah_pengeluaran   = $cek_pengeluaran;

    // var_dump($row["kategori"]);die();
    if($kategori != $row["kategori"]){
      $kategori = $row["kategori"];
      $kategori_baru = TRUE;
    }else{
      $kategori = $kategori;
      $kategori_baru = FALSE;
    }
    if($kategori_baru){ 
      $no = 1;
      $nama_kategori = $this->m_barang->get_kategori($kategori);
      ?>
          <tr>
            <td></td>
            <td colspan="5">
              <?php echo $nama_kategori; ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
<?php
    }
  ?>
          <tr>
            <td>
              <?php echo $no; ?>
            </td>
            <td>
              <?php
              echo $nama_barang;
              ?>
            </td>
            <td>
              <?php 
              $jumlah_saldo_awal = max(0,$jumlah_saldo_awal);
              echo $jumlah_saldo_awal;
              ?>
            </td>
            <td>
              <?php
              echo $row["satuan"];
              ?>
            </td>
            <td>
                <?php
                $harga_asli = $row["harga"];
                $result_kemarin = preg_replace("/[^0-9]/", "", $harga_asli);

                // Jika angka hanya 1 atau 2 digit, tambahkan tiga nol di belakangnya
                if (strlen($result_kemarin) <= 2 && $result_kemarin != '0') {
                    $result_kemarin .= "000";
                }

                $harga_kemarin = "IDR " . number_format($result_kemarin, 0, ',', ',');
                echo $harga_kemarin;
                ?>
            </td>
            <td>
                <?php
                $total_harga_kemarin = $jumlah_saldo_awal * $result_kemarin;
                $harga_total_kemarin = "IDR " . number_format($total_harga_kemarin, 0, ',', ',');
                echo $harga_total_kemarin;
                ?>
            </td>
            <td>
              <?php
              $jumlah_beli = max(0,$jumlah_beli);
              echo $jumlah_beli;
              ?>
            </td>
            <td>
              <?php
              echo $row["satuan"];
              ?>
            </td>
            <td>
              <?php
              // if($nama_barang == 'Oli Mobil Non Matic'){
              //   var_dump($row->harga);die();
              // }
              $harga_asli = $row["harga"];
              $result_sekarang = preg_replace("/[^0-9]/", "", $harga_asli);
              if($result_sekarang){
                                // Jika angka hanya 1 atau 2 digit, tambahkan tiga nol di belakangnya
                if (strlen($result_sekarang) <= 2) {
                    $result_sekarang .= "000";
                }
              $harga_sekarang = "IDR " . number_format($result_sekarang, 0, ',', ',');
              echo $harga_sekarang;
              }else{
                echo 'IDR 0';
              }
              ?>
            </td>
            <td>
              <?php
              // $total_harga_sekarang = $jumlah_sekarang * $result_sekarang;
              // $harga_total_sekarang = "IDR " . number_format($total_harga_sekarang, 0, ',', ',');
              // echo $harga_total_sekarang;
              ?>
            </td>
            <td>
              <?php
              $jumlah_pengeluaran = max(0,$jumlah_pengeluaran);
              echo $jumlah_pengeluaran;
              ?>
            </td>
            <td>
              <?php
              echo $row["satuan"];
              ?>
            </td>
            <td>
              <?php
              $harga_asli = $row["harga"];
              $result_besok = preg_replace("/[^0-9]/", "", $harga_asli);
              if($result_besok){                                // Jika angka hanya 1 atau 2 digit, tambahkan tiga nol di belakangnya
                if (strlen($result_besok) <= 2) {
                    $result_besok .= "000";
                }
              $harga_besok = "IDR " . number_format($result_besok, 0, ',', ',');
              echo $harga_besok;
              }else{
                echo 'IDR 0';
              }
              ?>
            </td>
            <td>
              <?php
              $total_harga_besok = $jumlah_pengeluaran * $result_besok;
              $harga_total_besok = "IDR " . number_format($total_harga_besok, 0, ',', ',');
              echo $harga_total_besok;
              ?>
            </td>
            <td>
              <?php
              $jumlah_saldo_akhir = max(0, $jumlah_saldo_awal + $jumlah_beli - $jumlah_pengeluaran);
              echo $jumlah_saldo_akhir;
              ?>
            </td>
            <td>
              <?php
              echo $row["satuan"];
              ?>
            </td>
            <td>
              <?php
              $harga_asli = $row["harga"];
              $result_besok = preg_replace("/[^0-9]/", "", $harga_asli);
              if($result_besok){                                // Jika angka hanya 1 atau 2 digit, tambahkan tiga nol di belakangnya
                if (strlen($result_besok) <= 2) {
                    $result_besok .= "000";
                }
              $harga_besok = "IDR " . number_format($result_besok, 0, ',', ',');
              echo $harga_besok;
              }else{
                echo 'IDR 0';
              }
              ?>
            </td>
            <td>
              <?php
              $total_harga_besok = $jumlah_saldo_akhir * $result_besok;
              $harga_total_besok = "IDR " . number_format($total_harga_besok, 0, ',', ',');
              echo $harga_total_besok;
              ?>
            </td>
          </tr>
  <?php       
          // echo 'Nama : '.$nama_barang.' == '.$nama_barangss.'<br>';
          // echo 'merk : '.$merk.' == '.$merkss.'<br>';
          // echo 'harga_asli : '.$harga_asli.' == '.$harga_asliss.'<br>';
          // echo 'satuan : '.$satuan.' == '.$satuanss.'<br>';
          // $jumlah = $jumlah_barang + $jumlah_barangss - $jumlah_barang;
          // echo $nama_barangss.' - '.$nama_barang.' yang if '.$jumlah_barangss.' + '.$jumlah_barang.' = '.$jumlah.'<br><br>';
      
    $no++;
  }
  ?>
</table>
<?php
// ob_end_flush();
// exit;
?>