 
  <br>

  <?php

  // header("Content-type: application/vnd-ms-excel");
  // header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
  // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  // header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAA.xls");

  ob_start();
  ?>
<h2>MUTASI PERSEDIAAN TAHUN ANGGARAN <?php echo date('Y'); ?></h2>
<h2>SKPD : DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI JAWA BARAT</h2><br>
<br>
<!-- <table border="1">
  <tr>
  <td rowspan="2">No</td>
  <td colspan="2">No</td>
  </tr>
  <tr>
    <td>sss</td>
    <td rowspan="2">aaaa</td>
  </tr>
  <tr>
    <td>sss</td>
    <td>aaaa</td>
  </tr>
</table> -->

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
  </tr>
  <tr>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan
    </td>
    <td>
      Jumlah
    </td>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan
    </td>
    <td>
      Jumlah
    </td>
    <td colspan="2">
      unit
    </td>
    <td>
      Harga Satuan
    </td>
    <td>
      Jumlah
    </td>
  </tr>
  <?php
  $roman = 1;
  $no = 1;
  $k = '';
  function toRoman($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 
                 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 
                 'IV' => 4, 'I' => 1);
    $result = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $result .= $roman;
                break;
            }
        }
    }
    return $result;
}
  $nama_barang = '';
  $jumlah = '';
  $satuan = '';
  $result = '';
  foreach($barang as $row){
    // var_dump($nama, $merk, $hasil_rupiah, $satuan);die();
    // $sum = array_sum($jumlah_pembelian);
    $kategori = $this->m_barang->get_kategori_nama($row->nama_barang);

    $nama = $row->nama_barang;
    $merk = $row->merk;
    $harga = preg_replace("/[^0-9]/", "", $row->harga);
    $satuan = $row->satuan;
    $hasil_rupiah = number_format($harga,0,',',',');
    $jumlah_pembelian = $this->m_barang->jumlah_pembelian($nama, $merk, $hasil_rupiah, $satuan);
    // var_dump($jumlah_pembelian);die();


    $result = preg_replace("/[^0-9]/", "", $row->harga);
    // var_dump($row->total_jumlah);die();
    $total = $result * $row->total_jumlah_asli;
    $hasil_rupiah = "IDR " . number_format($total,0,',',',');


    $jumlah = $row->total_jumlah; 
    $p = $jumlah - $jumlah_pembelian;

  if($p != 0){
  $uang = preg_replace("/[^0-9]/", "", $row->harga);
  if($nama_barang == $row->nama_barang && $satuan == $row->satuan && $result == $uang){
  }else{
    if ($kategori == $k) {
    if($row->total_jumlah != 0){
  ?>
  <tr>
    <td>
      <?php echo $no; ?>
    </td>
    <td>
      <?php 
      $nama_barang = $row->nama_barang;
      echo $nama_barang; 
      ?>
    </td>
    <td>
      <?php 
    // echo $jumlah_pembelian;
      echo $row->total_jumlah;
      ?>
    </td>
    <td>
      <?php 
      $satuan = $row->satuan;
      echo $satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
      echo $hasil_rupiah; 
      ?>
    </td>
    <td>
      <?php 
      echo $p;
      ?>
    </td>
    <td>
      <?php 
      $satuan = $row->satuan;
      echo $satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
        $result = preg_replace("/[^0-9]/", "", $row->harga);
        $total_pembeli = $p * $result;
        echo "IDR " . number_format($total_pembeli,0,',',',');
      ?>
    </td>
    <td>
      <?php 
      $jumlah = $row->total_jumlah; 
      $c = $jumlah - $row->total_jumlah_asli;
      echo $c;
      ?>
    </td>
    <td>
      <?php 
      $satuan = $row->satuan;
      echo $satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
        $result = preg_replace("/[^0-9]/", "", $row->harga);
        $total_pembeli = $c * $result;
        echo "IDR " . number_format($total_pembeli,0,',',',');
      ?>
    </td>
  </tr>
  <?php
      
    }
    }else{
      ?> 
    <tr bgcolor="#00bfff">
      <td><?php   
      echo toRoman($roman);
      $roman++;
       ?></td>
      <td colspan="14"> 
        <?php 
          $k = $kategori;
          $kategori = $this->m_barang->get_kategori($kategori); 
          echo $kategori;
        ?> 
      </td>
    </tr>
    <tr>
          <td>
      <?php echo $no; ?>
    </td>
    <td>
      <?php echo $row->nama_barang; ?>
    </td>
    <td>
      <?php
    $nama = $row->nama_barang;
    $merk = $row->merk;
    $harga = preg_replace("/[^0-9]/", "", $row->harga);
    $satuan = $row->satuan;
    $hasil_rupiah = number_format($harga,0,',',',');
    $jumlah_pembelian = $this->m_barang->jumlah_pembelian($nama, $merk, $hasil_rupiah, $satuan);
    echo $jumlah_pembelian;
      ?>
    </td>
    <td>
      <?php echo $row->satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
      $hasil_rupiah = "IDR " . number_format($total,0,',',',');
      echo $hasil_rupiah; 
      ?>
    </td>
    <td>
      <?php 
      $jumlah = $row->total_jumlah; 
      $p = $jumlah - $jumlah_pembelian;
      echo $p;
      ?>
    </td>
    <td>
      <?php 
      $satuan = $row->satuan;
      echo $satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
        $result = preg_replace("/[^0-9]/", "", $row->harga);
        $total_pembeli = $p * $result;
        // var_dump($total_pembeli);die();
        echo "IDR " . number_format($total_pembeli,0,',',',');
      ?>
    </td>
    <td>
      <?php 
      $jumlah = $row->total_jumlah; 
      $c = $jumlah - $row->total_jumlah_asli;
      echo $c;
      ?>
    </td>
    <td>
      <?php 
      $satuan = $row->satuan;
      echo $satuan; ?>
    </td>
    <td>
      <?php echo $row->harga; ?>
    </td>
    <td>
      <?php
        $result = preg_replace("/[^0-9]/", "", $row->harga);
        $total_pembeli = $c * $result;
        // var_dump($total_pembeli);die();
        echo "IDR " . number_format($total_pembeli,0,',',',');
      ?>
    </td>
    </tr>

    <?php 
      }
    $no++;
    }
  }
}
  ?>
</table>
<?php
  ob_end_flush();
  exit;
?>
