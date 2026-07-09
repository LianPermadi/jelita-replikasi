<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinaninfo">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="50%">Jenis Kegiatan</th>
            <th width="25%">Nomor SOP</th>
            <th width="20%">Informasi SOP</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          foreach ($list as $data){
          	$i++;
          	//if($cek1) {
            //  $b = '<span style="color: Red">'; $be = '</span>';
            //}else{
              $b = ''; $be = ''; 
            //}
            $file_link = "https://dpmptsp.jabarprov.go.id/web/application/modules/arsip/files/bahan_publikasi_sop/" . $data->Nama_File .".pdf";
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b . $data->Nama_kegiatan . $be; ?></td>
              <td><?php echo $b . $data->Nomor_Sop . $be; ?></td>
              <td><?php echo $b . "<a href='".$file_link."' target='_blank'>".$data->Nama_File."</a>". $be; ?></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>