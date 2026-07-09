 <?php

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAA ".$tahun.".xls");
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
  foreach ($barang as $row) {
    
    $tahun_kemarin = $tahun - 1;
    $saldo_awal = $this->m_barang->get_cetak_saldo_awal($tahun_kemarin, $row->nama_barang, $row->satuan);

    // Pastikan $saldo_awal adalah array sebelum mengakses indeksnya
    if (is_array($saldo_awal)) {
        $unit_sa = isset($saldo_awal['unit_sa']) ? $saldo_awal['unit_sa'] : 0;
        $harga_satuan_sa = isset($saldo_awal['harga_satuan_sa']) ? $saldo_awal['harga_satuan_sa'] : 0;
    } else {
        $unit_sa = 0;
        $harga_satuan_sa = 0;
    }

    // Pastikan tidak terjadi error jika salah satu nilai NULL
    $jumlah_sa = $unit_sa * $harga_satuan_sa;

$pembelian = $this->m_barang->get_cetak_pembelian($tahun, $row->nama_barang, $row->satuan);

if (is_array($pembelian)) {
    $unit_beli = isset($pembelian['unit_beli']) ? $pembelian['unit_beli'] : 0;
    $harga_satuan_beli = isset($pembelian['harga_satuan_beli']) ? $pembelian['harga_satuan_beli'] : 0;
} else {
    $unit_beli = 0;
    $harga_satuan_beli = 0;
}

$jumlah_beli = $unit_beli * $harga_satuan_beli;

    $unit_keluar = preg_replace('/\D/', '', $row->unit_keluar) ?: 0;
    $harga_satuan_keluar = preg_replace('/\D/', '', $row->harga_satuan_sa) ?: 0;
    $jumlah_keluar = $unit_keluar*$harga_satuan_keluar;

    $unit_sak = preg_replace('/\D/', '', $row->unit_sak) ?: 0;
    $harga_satuan_sak = preg_replace('/\D/', '', $row->harga_satuan_sa) ?: 0;
    $jumlah_sak = $unit_sak*$harga_satuan_sak;
    ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $row->nama_barang; ?></td>
            <td><?php echo $unit_sa; ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td><?php echo 'Rp. '.number_format((float) $harga_satuan_sa, 0, ',', '.'); ?></td>
            <td><?php echo 'Rp. '.number_format((float) $jumlah_sa, 0, ',', '.'); ?></td>
            <td><?php echo $unit_beli; ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td><?php echo 'Rp. '.number_format((float) $harga_satuan_beli, 0, ',', '.'); ?></td>
            <td><?php echo 'Rp. '.number_format((float) $jumlah_beli, 0, ',', '.'); ?></td>
            <td><?php echo $unit_keluar; ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td><?php echo 'Rp. '.number_format((float) $harga_satuan_keluar, 0, ',', '.'); ?></td>
            <td><?php echo 'Rp. '.number_format((float) $jumlah_keluar, 0, ',', '.'); ?></td>
            <td><?php echo $unit_sak; ?></td>
            <td><?php echo $row->satuan; ?></td>
            <td><?php echo 'Rp. '.number_format((float) $harga_satuan_sak, 0, ',', '.'); ?></td>
            <td><?php echo 'Rp. '.number_format((float) $jumlah_sak, 0, ',', '.'); ?></td>
          </tr>
  <?php       
    $no++;
  }
  ?>
</table>
<?php
// ob_end_flush();
// exit;
?>