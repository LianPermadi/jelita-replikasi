<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head><body>
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
    <table border="1" width="100%">
<thead>
<tr>
 <th>NO</th>
 <th>NAMA</th>
 <th>INSTANSI</th>
 <th>HANDPHONE</th>
 <th>ACARA</th>
 </tr>
</thead>
<tbody>
<?php $i=1; foreach($data_absen as $row) { ?>
<tr>
 <td><?php echo $i ?></td>
 <td><?php echo $row->nama; ?></td>
 <td><?php echo $row->instansi; ?></td>
 <td><?php echo $row->handphone; ?></td>
<td style=text-align:center;width:auto !important;height:30px !important;>
    <img style='width:100px !important;height:50px !important;' src="<?php echo base_url().'../kehadiran/uploads/'.$row->id.'.png'; ?>"></td>
 </tr>
<?php $i++; } ?>
</tbody>
</table>
</body></html>
