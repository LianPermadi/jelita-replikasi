 <?php
 if(!$this->All){

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAA ".$tahun.".xls");
ob_start();
 }
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
$total_unit = $total_harga_satuan_sa = $total_jumlah_sa = [];
$total_unit_beli = $total_harga_satuan_beli = $total_jumlah_beli = [];
$total_unit_keluar = $total_harga_satuan_keluar = $total_jumlah_keluar = [];
$total_unit_sak = $total_harga_satuan_sak = $total_jumlah_sak = [];

foreach ($barang as $row) {
    $tahun_kemarin = $tahun - 1;
    $saldo_awal = $this->m_barang->get_cetak_saldo_awal($tahun_kemarin, $row->nama_barang, $row->satuan);
    
    $unit_sa = isset($row->unit_sa) ? (int) $row->unit_sa : 0;
    $harga_satuan_sa = isset($row->harga_satuan_sa) ? (int) $row->harga_satuan_sa : 0;
    $jumlah_sa = $unit_sa * $harga_satuan_sa;

    $pembelian = $this->m_barang->get_cetak_pembelian($tahun, $row->nama_barang, $row->satuan);
    $unit_beli = isset($pembelian['unit_beli']) ? (int) $pembelian['unit_beli'] : 0;
    $harga_satuan_beli = isset($pembelian['harga_satuan_beli']) ? (int) $pembelian['harga_satuan_beli'] : 0;
    $jumlah_beli = $unit_beli * $harga_satuan_beli;

    $unit_keluar = isset($row->unit_keluar) ? (int) $row->unit_keluar : 0;
    $harga_satuan_keluar = isset($row->harga_satuan_sa) ? (int) $row->harga_satuan_sa : 0;
    $jumlah_keluar = $unit_keluar * $harga_satuan_keluar;

    $unit_sak = isset($row->unit_sak) ? (int) $row->unit_sak : 0;
    $harga_satuan_sak = isset($row->harga_satuan_sa) ? (int) $row->harga_satuan_sa : 0;
    $jumlah_sak = $unit_sak * $harga_satuan_sak;

    // Simpan nilai ke dalam array
    $total_unit[] = $unit_sa;
    $total_harga_satuan_sa[] = $harga_satuan_sa;
    $total_jumlah_sa[] = $jumlah_sa;

    $total_unit_beli[] = $unit_beli;
    $total_harga_satuan_beli[] = $harga_satuan_beli;
    $total_jumlah_beli[] = $jumlah_beli;

    $total_unit_keluar[] = $unit_keluar;
    $total_harga_satuan_keluar[] = $harga_satuan_keluar;
    $total_jumlah_keluar[] = $jumlah_keluar;

    $total_unit_sak[] = $unit_sak;
    $total_harga_satuan_sak[] = $harga_satuan_sak;
    $total_jumlah_sak[] = $jumlah_sak;
?>
<tr>
    <td><?= $no; ?></td>
    <td><?= $row->nama_barang; ?></td>
    <td><?= $unit_sa; ?></td>
    <td><?= $row->satuan; ?></td>
    <td><?= 'Rp. ' . number_format($harga_satuan_sa, 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($jumlah_sa, 0, ',', '.'); ?></td>
    <td><?= $unit_beli; ?></td>
    <td><?= $row->satuan; ?></td>
    <td><?= 'Rp. ' . number_format($harga_satuan_beli, 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($jumlah_beli, 0, ',', '.'); ?></td>
    <td><?= $unit_keluar; ?></td>
    <td><?= $row->satuan; ?></td>
    <td><?= 'Rp. ' . number_format($harga_satuan_keluar, 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($jumlah_keluar, 0, ',', '.'); ?></td>
    <td><?= $unit_sak; ?></td>
    <td><?= $row->satuan; ?></td>
    <td><?= 'Rp. ' . number_format($harga_satuan_sak, 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($jumlah_sak, 0, ',', '.'); ?></td>
</tr>
<?php
    $no++;
}
        $this->db->select('SUM(jumlah_sa) AS total_sa, 
                           SUM(unit_sa) AS unit_sa, 
                           SUM(jumlah_beli) AS total_beli, 
                           SUM(jumlah_keluar) AS total_keluar, 
                           SUM(jumlah_sak) AS total_sak');
        $this->db->from("data_$tahun.laporan_permintaan_barang");
        $query = $this->db->get();
        $data_total = $query->first_row();
        // var_dump($data_total);die();
?>
<tr>
    <td></td>
    <td><strong>Total</strong></td>
    <td></td>
    <td></td>
    <td><?= 'Rp. ' . number_format(array_sum($total_harga_satuan_sa), 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($data_total->total_sa, 0, ',', '.'); ?></td>
    <td></td>
    <td></td>
    <td><?= 'Rp. ' . number_format(array_sum($total_harga_satuan_beli), 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($data_total->total_beli, 0, ',', '.'); ?></td>
    <td></td>
    <td></td>
    <td><?= 'Rp. ' . number_format(array_sum($total_harga_satuan_keluar), 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($data_total->total_keluar, 0, ',', '.'); ?></td>
    <td></td>
    <td></td>
    <td><?= 'Rp. ' . number_format(array_sum($total_harga_satuan_sak), 0, ',', '.'); ?></td>
    <td><?= 'Rp. ' . number_format($data_total->total_sak, 0, ',', '.'); ?></td>
</tr>
</table>


<?php
 if(!$this->All){
ob_end_flush();
exit;
 }
?>