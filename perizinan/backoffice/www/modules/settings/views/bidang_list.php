<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php
      $add_holiday = array('name' => 'button',
                           'class' => 'button-wrc',
                           'content' => 'Tambah Bidang',
                           'onclick' => 'parent.location=\''. site_url('settings/bidang/create') . '\''
                          );
      echo form_button($add_holiday);
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="bidang">
        <thead>
          <tr>
            <th width="5%">NO</th>
            <th width="5%">ID</th>
            <th width="40%">BIDANG</th>
            <th width="5%">URUTAN</th>
            <th width="15%">FORMAT NO PERTEK<br>FORMAT NO SURAT PERINTAH</th>
            <th width="20%">TTD SP<br>TTD S. PENOLAKAN<br>TTD NOTA</th>
            <th width="10%">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = NULL;
          //foreach ($list as $key => $value){
          foreach ($list as $data){
            $i++;
          	$petugas = new tmpegawai(); $petugas->where('id',$data->ttd_sp)->get(); $n_ttd_sp = $petugas->n_pegawai;
          	$petugas = new tmpegawai(); $petugas->where('id',$data->ttd_tolak)->get(); $n_ttd_tolak = $petugas->n_pegawai;
          	$petugas = new tmpegawai(); $petugas->where('id',$data->ttd_nota)->get(); $n_ttd_nota = $petugas->n_pegawai;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data->id; ?></td>
              <td><?php echo $data->n_sektor; ?></td>
          	  <td><?php echo $data->urutan; ?></td>
          	  <td>
          	    <?php
          	    echo $data->no_pertek_awal.' / xxxxx / '.$data->no_pertek_akhir .'<br>'.
          	    $data->no_sp_awal.' / xxxxx / '.$data->no_sp_akhir; 
          	    ?>
          	  </td>
          	  <td><?php echo $n_ttd_sp.'<br>'.$n_ttd_tolak.'<br>'.$n_ttd_nota;?> </td>
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
                  <a class="page-help" href="<?php echo site_url('settings/bidang/edit'."/".$data->id) ?>"
                  ><?php echo img($img_edit); ?></a>
                  <a class="page-help" href="<?php echo site_url('settings/bidang/delete'."/".$data->id) ?>"
                  ><?php echo img($img_delete); ?></a>
                </center>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>NO</th>
            <th>ID</th>
            <th>BIDANG</th>
            <th>URUTAN</th>
            <th>FORMAT NO PERTEK</th>
            <th>TTD SP<br>TTD S. PENOLAKAN<br>TTD NOTA</th>
            <th>AKSI</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>