<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="holiday">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="25%">Nomor Daftar</th>
            <th width="30%">Pemohon</th>
            <th width="30%">Jenis Integrasi</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no=0;
          foreach ($list as $data){
          	$no++;
            ?>
            <tr>
            	<td><?php echo $no ?></td>
              <td><?php echo $data->no_pendaftaran ?></td>
              <td><?php echo $data->pemohon; ?></td>
              <td><?php echo $data->jenis; ?></td>
              <td>
                <center>
                  <?php
                  $img_edit = array('src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0'
                                   );
                  $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                  $img_delete = array('src' => 'assets/images/icon/cross.png',
                                      'alt' => 'Delete',
                                      'title' => 'Delete',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                     );
                  ?>
                  <a class="page-help" href="<?php echo site_url('holiday/edit'."/".$data->id) ?>" ><?php //echo img($img_edit); ?></a>
                  <a class="page-help" href="<?php echo site_url('holiday/delete'."/".$data->id) ?>" ><?php //echo img($img_delete); ?></a>
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
            <th>Nomor Daftar</th>
            <th>Pemohon</th>
            <th>Jenis Integrasi</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>
