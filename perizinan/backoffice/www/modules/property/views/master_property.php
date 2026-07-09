<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php
      $add_role = array('name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'List Status Property',
                        'onclick' => 'parent.location=\''. site_url('property/master/propertieslist') . '\'');
      echo form_button($add_role);
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="property">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="6%">Kode Izin - ID</th>
            <th width="41%">Jenis Perizinan</th>
            <th width="18%">Kelompok Perizinan</th>
            <th width="5%">Data<br>Pemohon</th>
            <th width="3%">Jumlah<br>Property</th>
            <th width="7%">Template<br>SK</th>
            <th width="7%">Template<br>Pertek</th>
            <th width="7%">Template<br>Pencabutan</th>
            <th width="4%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ok=array();
          if($list_izin){
            foreach($list_izin as $dt_urg) {
              $ok[]=$dt_urg->trperizinan_id;
            }
          }
          $i = null;
          foreach ($list as $data){
            $n_var = $this->lib_date->data_property($data->id,'1');  // ambil jumlah properti
            $data->trkelompok_perizinan->get();
            $data->tralur_perizinan->get();
            $data->trproperty->get();
            $i++;
            if(in_array($data->id, $ok)){
              $aktif = 'Ada';
              $cek = TRUE;
            }else {
              $aktif = 'Kosong';
              $cek = FALSE;
            }
            if($n_var !== 0){
              $cek1 = FALSE;
            }else{
              $cek1 = TRUE;
            }
            if($cek && $cek1) {
              $b = '<span style="color: Red">';
              $be = '</span>';
            }else{
              $b = '';
              $be = '';
            }

            $e_sertifikat = $data->e_sertifikat;
            switch($e_sertifikat){
              case 0 : $SE = ' (non SE)'; break;
              case 1 : $SE = ' (SE BSrE)'; break;
            }
            $ttd_elektonik = $data->e_ttd;
            switch($ttd_elektonik){
              case 0 : $metode = ' Tandatangan Manual'; break;
              case 1 : $metode = ' Tandatangan Elektronik'.$SE; break;
              case 2 : $metode = ' Upload Dokumen'.$SE; break;
            }
            
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b . $data->kd_izin .' - '. $data->id . $be; ?></td>
              <td><?php echo $b . $data->n_perizinan . $be; ?></td>
              <td><?php echo $b . $data->trkelompok_perizinan->n_kelompok .'<br>'. $metode . $be; ?></td>
              <td><?php echo $b . "<center>" . $aktif . "</center>" . $be; ?></td>
              <td><?php
                if($n_var !== 0){
                  echo $b . "<center>" . $n_var . "</center>" . $be;
                  $title = 'Edit Property';
                }else{
                  echo $b . "<center> Belum ada property </center>" . $be;
                  $title = 'Menambah Property';
                }
                ?>
              </td>
              <td>
              	<center>
                  <?php
                  if($data->template != ""){
                    ?>
                    <a href="<?php echo base_url().'assets/template-baru/'.$data->template.'?q='.microtime(true);?>">Sudah Diupload</a>
                    <?php
                  }else{
                    ?>
                    <span style="color:red">Belum Diupload</span>
                    <?php
                  }
                  ?>
                </center>
              </td>
              <td>
              	<center>
                  <?php
                  if($data->template_gub != ""){
                    ?>
                    <a href="<?php echo base_url().'assets/template-baru/'.$data->template_gub.'?q='.microtime(true);?>">Sudah Diupload</a>
                    <?php
                  }else{
                    ?>
                    <span style="color:red">Belum Diupload</span>
                    <?php
                  }
                  ?>
                </center>
              </td>
              <td>
                <center>
                  <?php
                  if($data->template_cabut != ""){
                    ?>
                    <a href="<?php echo base_url().'assets/template-baru/'.$data->template_cabut.'?q='.microtime(true);?>">Sudah Diupload</a>
                    <?php
                  }else{
                    ?>
                    <span style="color:red">Belum Diupload</span>
                    <?php
                  }
                  ?>
                </center>
              </td>
              <td>
                <center>
                  <?php
                  $img_edit = array('src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => $title,
                                    'border' => '0');
                  if($n_var !== 0){
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/detail'."/".$data->id) ?>">
                      <?php
                      echo img($img_edit);
                      ?>
                    </a>
                    <?php
                  }else{
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/add/' . $data->id); ?>">
                      <?php
                      echo img($img_edit);
                      ?>
                    </a>
                    <?php
                  }

                  $img_preview = array('src' => 'assets/images/icon/preview.png',
                                    'alt' => 'Proses Preview Dokumen SK',
                                    'title' => 'Proses Preview Dokumen SK',
                                    'border' => '0');
                  
                  if ($data->template != "") { ?>
                  <a class="page-help" href="<?php echo site_url('property/master/input_preview/' . $data->id); ?>">
                      <?php
                        echo img($img_preview);
                       } ?>
                    </a>
                </center>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
      	    <th>Kode Izin - ID</th>
            <th>Jenis Perizinan</th>
            <th>Kelompok Perizinan</th>
      	    <th>Data Pemohon</th>
            <th>Jumlah Property</th>
            <th>Template SK</th>
            <th>Template Pertek</th>
            <th>Template Pencabutan</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>