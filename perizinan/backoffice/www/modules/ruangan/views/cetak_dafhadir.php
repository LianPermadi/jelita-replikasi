 <?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Daftar Hadir $data_acara->acara.xls");

header("Pragma: no-cache");

header("Expires: 0");

// echo "<table width='100%' border='0' font-size:16px;'>";
//     echo $jdl_laporan;
//     echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
//     echo "</table>";
?>

<table border="0">
    <thead>
        <tr>
        <th colspan="4"><h2>DAFTAR HADIR</h2></th>
        </tr>
    </thead>
    <tbody align="text-left">
        <tr>
        <td>Hari/Tanggal</td>
        <td colspan="2">: <?php echo $data_acara->tanggal; ?></td>
        </tr>
        <tr>
        <td>Acara</td>
        <td colspan="2">: <?php echo $data_acara->acara; ?></td>
        </tr>
        <tr>
        <td>Tempat</td>
        <td colspan="2">: <?php echo $this->m_ruangan->get_nama($data_acara->id_ruangan) ?></td>
        </tr>
    </tbody>
</table>
<!-- <h3 align="align-items-center">DAFTAR HADIR <?php echo $data_acara->acara ;?></h3> -->
<table border="1" width="100%">

<thead>

<tr>

 <th>NO</th>
 <th>NAMA</th>
 <th>INSTANSI</th>
 <th>TANDA TANGAN</th>

 </tr>

</thead>

<tbody>

<?php $i=1; foreach($data_absen as $pakai) { ?>

<tr>

 <td><?php echo $i ?></td>

 <td><?php echo $pakai->nama ?></td>

 <td><?php echo $pakai->instansi ?></td>
 <td><img src="<?php echo base_url().'../kehadiran/uploads/'.$pakai->id.'.png'; ?>"></td>
 
 <!-- <td style='text-align:center;width:auto !important;height:30px !important;'><img src="<?php echo base_url().'../kehadiran/uploads/'.$pakai->id.'.png'; ?>" width="100" height="50"></td> -->

 </tr>


<!-- <img style='width:100px !important;height:50px !important;' src='https://dpmptsp.jabarprov.go.id/kehadiran/uploads/".$row->id.".png'> -->
<?php $i++; } ?>

</tbody>

</table>