
<script type="text/javascript" src="<?php echo base_url();?>assets/dt/media/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/dt/media/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/media/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/css/dataTables.bootstrap.css">
  <br>
  <div class="container">
<?php
$i=1;
  foreach($bb_izintrayek as $u2){
$jenis =$u2->n_perizinan; 
  }
?>

<table class="table table-striped data" style="font-size:12px;">
                <thead>
                    <tr>
                         <th width=""><center>No</center></th>
                        <th ><center><?php echo 'DAFTAR SYARAT UNTUK'.$jenis;?></center></th>
                      
                        <th width=""><center>AKSI</center></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($bb_izintrayek as $u2){
                  ?>
                  <tr>
<td><center><?php echo $i++ ?></center></td>
<td><?php echo $u2->v_syarat; ?></td>
<?php
 $a = $u2->formulir;
if($a == 1)
{
?>
<td><!--<center> <a href=<?php echo base_url()."jenisizin/c_jenisizin/download_izin/".$u2->id; ?> class= 'button-wrc' style="text-decoration: none;">Download</a></center>-->
<a href="../../../../assets/userassets/formulir/<?php echo $u2->nama_formulir;?>" class= 'button-wrc' style="text-decoration: none;" target="_blank">Download</a>

</td>
<?php
}else{
    echo '<td></td>';
}
?>

</td>
                  </tr>
  <?php
}
 ?>

        </tbody>
                </table>
                </div>

<br style="clear: both" />

<center><a href="http://spekta.tasikmalayakab.go.id/spekta/backoffice/jenisizin/c_jenisizin/" style="color:red;"><b>Kembali / Back</b></a></center>
<script type="text/javascript">
  $(document).ready(function(){
    $('.data').DataTable();
  });
</script>
      