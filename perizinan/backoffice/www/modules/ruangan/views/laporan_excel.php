 <?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

// echo "<table width='100%' border='0' font-size:16px;'>";
//     echo $jdl_laporan;
//     echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
//     echo "</table>";
?>

<table border="1" width="100%">

<thead>

<tr>

 <th>NO</th>

 <th>RUANGAN</th>
 <th>PEMINJAM</th>
 <th>SEKSI</th>
 <th>ACARA</th>
 <th>TANGGAL</th>
 <th>WAKTU ACARA</th>
 <th>KETERANGAN</th>

 </tr>

</thead>

<tbody>

<?php $i=1; foreach($pakai as $pakai) { ?>

<tr>

 <td><?php echo $i ?></td>

 <td><?php echo $this->m_ruangan->get_ruang($pakai->id_ruangan); ?></td>

 <td><?php echo $this->m_ruangan->get_n_user($pakai->user_id) ?></td>

 <td><?php echo $this->m_ruangan->get_seksi($pakai->seksi) ?></td>

 <td><?php echo $pakai->acara ?></td>

 <td><?php echo $pakai->tanggal ?></td>
 
 <td><?php echo $pakai->waktu_awal .'-'. $pakai->waktu_akhir ?></td>

 <td><?php echo $pakai->keterangan ?></td>
 


 </tr>

<?php $i++; } ?>

</tbody>

</table>