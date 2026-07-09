<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAA.xls");
ob_start();
?>
<h2>MUTASI PERSEDIAAN TAHUN ANGGARAN <?php echo $tahun; ?></h2>
<h2>SKPD : DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI JAWA BARAT</h2><br>
<br>
NO      TANGGAL PEMINJAMAN            

<table border="1">
  <tr>
    <td>
      No
    </td>
    <td>
      NO. POLISI
    </td>
    <td>
      MERK KENDARAAN
    </td>
    <td>
      TANGGAL PEMINJAMAN
    </td>
    <td>
      HARI PINJAMAN
    </td>
    <td>
      TUJUAN 
    </td>
    <td>
      PEMINJAM
    </td>
    <td>
      BAGIAN
    </td>
    <td>
      DRIVER
    </td>
  </tr>
  <?php
  $no = 1;
  foreach ($mobil as $row) {
      if($row->status == 3){
  ?>
  <tr>
    <td>
      <?php echo $no; ?>
    </td>
    <td>
      <?php echo $this->m_mobil->get_platnomor_id($row->mobil); ?>
    </td>
    <td>
      <?php echo $this->m_mobil->get_nama_mobil_id($row->mobil); ?>
    </td>
    <td>
      <?php echo $row->tanggal_pinjam; ?>
    </td>
    <td>
      <?php 
            setlocale(LC_TIME, 'id_ID');
            $haristart = strftime('%A', strtotime($row->tanggal_pinjam));
            echo $haristart; 
      ?>
    </td>
    <td>
      <?php echo $row->tujuan; ?>
    </td>
    <td>
      <?php echo $this->m_mobil->get_nama_user($row->peminjam); ?>
    </td>
    <td>
      <?php echo $row->bagian; ?>
    </td>
    <td>
      <?php echo $row->driver; ?>
    </td>
  </tr>
  <?php
}
  }
  ?>
</table>
<?php
ob_end_flush();
exit;
?>