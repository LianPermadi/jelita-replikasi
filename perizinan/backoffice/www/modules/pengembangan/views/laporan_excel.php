<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

echo "<table width='100%' border='0' font-size:16px;'>";
    echo $jdl_laporan;
    echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
    echo "</table>";
?>

<table border="1" width="100%">

<thead>

<tr>

 <th>No</th>
 
 <th>Nama Ruangan</th>

 <th>Username</th>

 <th>Password</th>

 <th>Tanggal</th>

 </tr>

</thead>

<tbody>

<?php $i=1; foreach($pakai as $pakai) { ?>

<tr>

 <td><?php echo $i ?></td>

 <td><?php echo $pakai->id_ruangan ?></td>

 <td><?php echo $pakai->user_id ?></td>

 <td><?php echo $pakai->seksi ?></td>

 <td><?php echo $this->lib_date->mysql_to_human($pakai->tanggal) ?></td>

 </tr>

<?php $i++; } ?>

</tbody>

</table>