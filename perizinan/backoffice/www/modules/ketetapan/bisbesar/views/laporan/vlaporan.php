<!DOCTYPE html>
<html>
<head>

</head>
 
<body>
<div id="content">

    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

        
<div class="entry">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="laporan" >
   <thead>
    <tr>
        <th>No</th>
        <th style="width: 20%">Nama Barang</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>
<p style="text-align: center"><a href="<?php echo base_url();?>bisbesar/claporanpdf/cetakpdf" target="_blank">Cetak PDF </a>  </p>
 </div>
 </div>
 </div>

</body>
</html>