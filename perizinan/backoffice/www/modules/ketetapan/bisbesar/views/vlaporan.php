<!DOCTYPE html>
<html>
<head>
  <title><?=$title?></title>
  <style>
  table{
      border-collapse: collapse;
      width: 70%;
      margin: 0 auto;
  }
  table th{
      border:1px solid #000;
      padding: 3px;
      font-weight: bold;
      text-align: center;
  }
  table td{
      border:1px solid #000;
      padding: 3px;
      vertical-align: top;
  }
 
  </style>
</head>
 
<body>
<p style="text-align: center">Tabel Barang</p>
<table>
    <tr>
        <th>No</th>
        <th style="width: 20%">Nama Barang</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Keterangan</th>
    </tr>
    <?php $no=0; foreach($qbarang as $rbarang){
    $no++;
    ?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $rbarang->nama_brg;?></td>
        <td><?php echo $rbarang->jenis;?></td>
        <td><?php echo $rbarang->harga_brg;?></td>
        <td><?php echo $rbarang->stok_brg;?></td>
        <td><?php echo $rbarang->satuan;?></td>
        <td><?php echo $rbarang->keterangan;?></td>
    </tr>
    <?php }?>
</table>
<p style="text-align: center"><a href="<?php echo base_url();?>bisbesar/claporanpdf/cetakpdf" target="_blank">Cetak PDF </a>  </p>
 
</body>
</html>