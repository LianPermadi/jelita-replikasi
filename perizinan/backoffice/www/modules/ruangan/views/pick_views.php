 <center>
  <table border="0" width="400px">
    <tr>
      <th width="400px"><h4>Dinas PMPTSP Prov Jabar</h4>
        <img src="<?php echo base_url().'uploads/data_qrcode_absen/Abs_'.$id.'.png'; ?>" width="400" height="400">
        <h4>
          <?php 
            echo 'LINK ABSENSI ( '.$this->lib_date->mysql_to_human($pakai->tanggal).' )'.'<br>'.
                  $pakai->acara;
          ?>
      
        </h4>	      
      </th>
    </tr>
  </table>
</center>